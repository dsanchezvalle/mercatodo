<?php

namespace App\Exports;

use App\Book;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BooksExport implements FromCollection, WithHeadings
{
    use Exportable;
    /**
    * @return Collection
    */
    public function collection()
    {
        return Book::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'isbn',
            'title',
            'author',
            'price',
            'stock',
            'image_path',
            'is_active',
            'created_at',
            'updated_at'
        ];
    }
}
