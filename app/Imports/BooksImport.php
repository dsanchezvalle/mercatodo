<?php

namespace App\Imports;

use App\Book;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BooksImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return Model|null
    */
    public function model(array $row)
    {
        $existentBook = Book::find($row['id']);

        if(!$existentBook){
            return new Book([
                'id' => $row['id'],
                'isbn' => $row['isbn'],
                'title' => $row['title'],
                'author' => $row['author'],
                'price' => $row['price'],
                'stock' => $row['stock'],
                'image_path' => $row['image_path']
            ]);
        }

        $existentBook->update([
            'isbn' => $row['isbn'],
            'title'=> $row['title'],
            'author'=> $row['author'],
            'price' => $row['price'],
            'stock' => $row['stock'],
            'image_path' => $row['image_path'],
        ]);
    }

    public function rules(): array
    {
        $id = $this->book->id ?? null;
        return [
            'isbn' => ['required', 'numeric', 'digits:13', "unique:books,isbn,$id"],
            'title' => ['required', 'string', 'min: 2', 'max:100', 'regex:/^[a-zA-Z0-9áéíóúüñÑ\'\s\.]+$/'],
            'author' => ['required', 'string', 'min: 2', 'max:80', 'regex:/^[a-zA-Z0-9áéíóúüñÑ\'\s\.]+$/'],
            'price' => ['required', 'numeric', 'min:1', 'max:500000'],
            'stock' => ['required', 'numeric', 'min:1', 'max:1000' ],
            'image_path' => ['string', 'max:200']
        ];
    }

}
