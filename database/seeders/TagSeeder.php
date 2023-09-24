<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::query()->create([
            'name' => 'tag1'
        ]);
        Tag::query()->create([
            'name' => 'tag1256'
        ]);
        Tag::query()->create([
            'name' => 'tag1236'
        ]);
        Tag::query()->create([
            'name' => 'tag256'
        ]);
        Tag::query()->create([
            'name' => 'tag136'
        ]);
    }
}
