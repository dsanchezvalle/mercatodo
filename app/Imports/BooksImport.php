<?php

namespace App\Imports;

use App\Book;
use App\Exceptions\ImportValidationException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BooksImport implements ToCollection, WithHeadingRow
{
    use Importable;

    private $errors;
    private $booksCreated;
    private $booksUpdated;

    /**
     * @param Collection $rows
     * @return void
     * @throws ImportValidationException
     */
    public function collection(Collection $rows)
    {
        $this->validateRows($rows);
        foreach ($rows as $row) {
            $existentBook = Book::find($row['id']);
            if (!$existentBook) {
                Book::create([
                    'id' => $row['id'],
                    'isbn' => $row['isbn'],
                    'title' => $row['title'],
                    'author' => $row['author'],
                    'price' => $row['price'],
                    'stock' => $row['stock'],
                    'image_path' => $row['image_path']
                ]);
                ++$this->booksCreated;
            } else {
                $existentBook->update([
                    'isbn' => $row['isbn'],
                    'title' => $row['title'],
                    'author' => $row['author'],
                    'price' => $row['price'],
                    'stock' => $row['stock'],
                    'image_path' => $row['image_path'],
                ]);
                ++$this->booksUpdated;
            }
        }
    }

    /**
     * @param Collection $rows
     * @return void
     * @throws ImportValidationException
     */
    private function validateRows(Collection $rows): void
    {
        $this->verifyRepeatedIsbnInFile($rows);

        foreach ($rows as $rowNumber => $row) {
            try {
                Validator::make($row->toArray(), [
                    'id' => 'nullable',
                    'isbn' => ['required', 'numeric', 'digits:13', "unique:books,isbn,{$row['id']}"],
                    'title' => ['required', 'string', 'min: 2', 'max:100', 'regex:/^[a-zA-Z0-9áéíóúüñÑ\'\s\.]+$/'],
                    'author' => ['required', 'string', 'min: 2', 'max:80', 'regex:/^[a-zA-Z0-9áéíóúüñÑ\'\s\.]+$/'],
                    'price' => ['required', 'numeric', 'min:1', 'max:500000'],
                    'stock' => ['required', 'numeric', 'min:1', 'max:1000'],
                    'image_path' => ['string', 'max:200']
                ])->validate();
            } catch (ValidationException $e) {
                $rowErrors = $e->errors();
                array_walk_recursive($rowErrors, function ($error) use ($rowNumber) {
                    $this->errors[] = sprintf('[row %s] %s', $rowNumber + 2, $error);
                });
            }
        }

        if (!empty($this->errors)) {
            throw new ImportValidationException($this->errors);
        }
    }

    private function verifyRepeatedIsbnInFile(Collection $rows)
    {
        $isbnColumn = array_column($rows->toArray(), 'isbn');
        foreach (array_count_values($isbnColumn) as $isbn => $occurrences) {
            if ($occurrences > 1) {
                $this->errors[] = sprintf(
                    '[rows %s] These rows have repeated ISBN',
                    implode(', ', array_map(function ($row) {
                        return $row + 2;
                    }, array_keys($isbnColumn, $isbn)))
                );
            }
        }
    }

    public function getBooksCreated()
    {
        return $this->booksCreated ?? '0';
    }

    public function getBooksUpdated()
    {
        return $this->booksUpdated ?? '0';
    }
}
