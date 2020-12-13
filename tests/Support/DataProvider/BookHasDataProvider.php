<?php

namespace Tests\Support\DataProvider;

trait BookHasDataProvider
{
    /**
     * @return array[]
     */
    public function bookStoreProvider(): array
    {
        $book = [
            'isbn' => '1111111111111',
            'title' => 'The old man and the sea',
            'author' => 'Ernest Hemingway',
            'price' => 56000,
            'stock' => 100,
            'image_path' => '/uploads/20201022140602494791_1.jpg',
            'is_active' => 'on',
        ];

        return [
            'isbn is null' => [
                array_replace($book, ['isbn' => null]),
                'isbn'
            ],
            'isbn is not a string' => [
                array_replace($book, ['isbn' => []]),
                'isbn'
            ],
            'isbn is too short' => [
                array_replace($book, ['isbn' => '111']),
                'isbn'
            ],
            'isbn is too long' => [
                array_replace($book, ['isbn' => '111111111111111']),
                'isbn'
            ],
            'title is null' => [
                array_replace($book, ['title' => null]),
                'title'
            ],
            'title is not a string' => [
                array_replace($book, ['title' => []]),
                'title'
            ],
            'title is too short' => [
                array_replace($book, ['title' => 'a']),
                'title'
            ],
            'title is too long' => [
                array_replace($book, ['title' => str_repeat('h', 101)]),
                'title'
            ],
            'author is null' => [
                array_replace($book, ['author' => null]),
                'author'
            ],
            'author is not a string' => [
                array_replace($book, ['author' => []]),
                'author'
            ],
            'author is too short' => [
                array_replace($book, ['author' => 'a']),
                'author'
            ],
            'author is too long' => [
                array_replace($book, ['author' => str_repeat('h', 81)]),
                'author'
            ]
        ];
    }
}
