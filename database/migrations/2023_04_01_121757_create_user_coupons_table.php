<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_coupons', function (Blueprint $table) {
            $table->id();
            $table->Integer('user_id'); // 쿠폰 할당 된 유저
            $table->Integer('coupon_id'); // 쿠폰 종류
            $table->string('code'); // 쿠폰 코드
            $table->Integer('status'); // 쿠폰 사용 여부
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_coupons');
    }
};
