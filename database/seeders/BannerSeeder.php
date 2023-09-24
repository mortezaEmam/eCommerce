<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Banner::query()->create([
            'image' => 'public/upload/files/banner/images/2023_9_24_16_0_24_171683_banner-1.png',
            'title' => 'بنر یک',
            'text' => 'توضیح بنر یک',
            'priority' => 1,
            'is_active' => 1,
            'type' => 'slider',
            'button_text' => 'متن دکمه',
        ]);
        Banner::query()->create([
            'image' => 'public/upload/files/banner/images/2023_9_24_16_0_24_171683_banner-2.png',
            'title' => 'بنر یک',
            'text' => 'توضیح بنر یک',
            'priority' => 1,
            'is_active' => 1,
            'type' => 'slider',
            'button_text' => 'متن دکمه',
        ]);
        Banner::query()->create([
            'image' => 'public/upload/files/banner/images/2023_9_24_16_0_24_171683_banner-3.png',
            'title' => 'بنر یک',
            'text' => 'توضیح بنر یک',
            'priority' => 1,
            'is_active' => 1,
            'type' => 'slider',
            'button_text' => 'متن دکمه',
        ]);
        Banner::query()->create([
            'image' => 'public/upload/files/banner/images/2023_9_24_16_0_24_171683_banner-4.png',
            'title' => 'بنر یک',
            'text' => 'توضیح بنر یک',
            'priority' => 1,
            'is_active' => 1,
            'type' => 'index_top',
            'button_text' => 'متن دکمه',
        ]);
        Banner::query()->create([
            'image' => 'public/upload/files/banner/images/2023_9_24_16_0_24_171683_banner-5.png',
            'title' => 'بنر یک',
            'text' => 'توضیح بنر یک',
            'priority' => 1,
            'is_active' => 1,
            'type' => 'index_top',
            'button_text' => 'متن دکمه',
        ]);
        Banner::query()->create([
            'image' => 'public/upload/files/banner/images/2023_9_24_16_0_24_171683_banner-6.png',
            'title' => 'بنر یک',
            'text' => 'توضیح بنر یک',
            'priority' => 1,
            'is_active' => 1,
            'type' => 'index_top',
            'button_text' => 'متن دکمه',
        ]);
        Banner::query()->create([
            'image' => 'public/upload/files/banner/images/2023_9_24_16_0_24_171683_banner-7.png',
            'title' => 'بنر یک',
            'text' => 'توضیح بنر یک',
            'priority' => 1,
            'is_active' => 1,
            'type' => 'index_bottom',
            'button_text' => 'متن دکمه',
        ]);
        Banner::query()->create([
            'image' => 'public/upload/files/banner/images/2023_9_24_16_0_24_171683_banner-8.png',
            'title' => 'بنر یک',
            'text' => 'توضیح بنر یک',
            'priority' => 1,
            'is_active' => 1,
            'type' => 'index_bottom',
            'button_text' => 'متن دکمه',
        ]);
        Banner::query()->create([
            'image' => 'public/upload/files/banner/images/2023_9_24_16_0_24_171683_banner-8.png',
            'title' => 'بنر یک',
            'text' => 'توضیح بنر یک',
            'priority' => 1,
            'is_active' => 1,
            'type' => 'index_bottom',
            'button_text' => 'متن دکمه',
        ]);
        Banner::query()->create([
            'image' => 'public/upload/files/banner/images/2023_9_24_16_0_24_171683_banner-10.png',
            'title' => 'بنر یک',
            'text' => 'توضیح بنر یک',
            'priority'=> 1,
            'is_active' => 1,
            'type' => 'index_bottom',
            'button_text' => 'متن دکمه',
        ]);
        Banner::query()->create([
            'image' => 'public/upload/files/banner/images/2023_9_24_16_0_24_171683_banner-11.png',
            'title' => 'بنر یک',
            'text' => 'توضیح بنر یک',
            'priority'=> 1,
            'is_active' => 1,
            'type' => 'index_bottom',
            'button_text' => 'متن دکمه',
        ]);
        Banner::query()->create([
            'image' => 'public/upload/files/banner/images/2023_9_24_16_0_24_171683_banner-12.png',
            'title' => 'بنر یک',
            'text' => 'توضیح بنر یک',
            'priority'=> 1,
            'is_active' => 1,
            'type' => 'index_top',
            'button_text' => 'متن دکمه',
        ]);
        Banner::query()->create([
            'image' => 'public/upload/files/banner/images/2023_9_24_16_0_24_171683_banner-13.png',
            'title' => 'بنر یک',
            'text' => 'توضیح بنر یک',
            'priority'=> 1,
            'is_active' => 1,
            'type' => 'index_top',
            'button_text' => 'متن دکمه',
        ]);
        Banner::query()->create([
            'image' => 'public/upload/files/banner/images/2023_9_24_16_0_24_171683_banner-14.png',
            'title' => 'بنر یک',
            'text' => 'توضیح بنر یک',
            'priority'=> 1,
            'is_active' => 1,
            'type' => 'slider',
            'button_text' => 'متن دکمه',
        ]);
        Banner::query()->create([
            'image' => 'public/upload/files/banner/images/2023_9_24_16_0_24_171683_banner-15.png',
            'title' => 'بنر یک',
            'text' => 'توضیح بنر یک',
            'priority'=> 1,
            'is_active' => 1,
            'type' => 'slider',
            'button_text' => 'متن دکمه',
        ]);
        Banner::query()->create([
            'image' => 'public/upload/files/banner/images/2023_9_24_16_0_24_171683_banner-16.png',
            'title' => 'بنر یک',
            'text' => 'توضیح بنر یک',
            'priority'=> 1,
            'is_active' => 1,
            'type' => 'index_bottom',
            'button_text' => 'متن دکمه',
        ]);
    }
}
