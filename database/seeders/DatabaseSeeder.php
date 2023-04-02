<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 사용자 10만명 생성
        User::factory(100000)->create();
        // 쿠폰 종류 5개 생성
        Coupon::factory(5)->create();
    }
}
