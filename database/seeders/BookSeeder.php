<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Book::create([
            'title' => 'Belajar Laravel',
            'author' => 'John Doe',
            'publisher' => 'Tech Publisher',
            'year' => 2023,
            'stock' => 10,
            'category_id' => 2,
            'description' => 'Buku panduan Laravel untuk pemula.',
        ]);

        \App\Models\Book::create([
            'title' => 'PHP Advanced',
            'author' => 'Jane Smith',
            'publisher' => 'Code Books',
            'year' => 2022,
            'stock' => 5,
            'category_id' => 2,
            'description' => 'Teknik lanjutan dalam PHP.',
        ]);
    }
}
