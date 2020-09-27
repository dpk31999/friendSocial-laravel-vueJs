<?php

use App\Interest;
use Illuminate\Database\Seeder;

class InterestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Interest::create([
            'name' => 'Đá bóng',
            'url_icon' => 'https://img.icons8.com/cotton/64/000000/football2.png'
        ]);

        Interest::create([
            'name' => 'Nghe nhạc',
            'url_icon' => 'https://img.icons8.com/cute-clipart/64/000000/music.png'
        ]);

        Interest::create([
            'name' => 'Du lịch',
            'url_icon' => 'https://img.icons8.com/cotton/64/000000/earth-planet--v2.png'
        ]);

        Interest::create([
            'name' => 'Ngủ',
            'url_icon' => 'https://img.icons8.com/dusk/64/000000/sleeping-in-bed.png'
        ]);

        Interest::create([
            'name' => 'Ca hát',
            'url_icon' => 'https://img.icons8.com/bubbles/50/000000/short-hair-lady-music.png'
        ]);

        Interest::create([
            'name' => 'Xem phim',
            'url_icon' => 'https://img.icons8.com/dusk/64/000000/cinema-.png'
        ]);

        Interest::create([
            'name' => 'Mua sắm',
            'url_icon' => 'https://img.icons8.com/dusk/64/000000/shopping.png'
        ]);

        Interest::create([
            'name' => 'Trò chơi điện tử',
            'url_icon' => 'https://img.icons8.com/dusk/64/000000/controller.png'
        ]);

        Interest::create([
            'name' => 'Đọc sách',
            'url_icon' => 'https://img.icons8.com/dusk/64/000000/reading.png'
        ]);
    }
}
