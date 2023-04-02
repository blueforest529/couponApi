<?php

use App\Http\Controllers\Api\UserCouponController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Api routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//유저별 쿠폰 생성
Route::post('user_coupon', [UserCouponController::class, 'store'])->name('user_coupon.store');

//쿠폰 다운로드
Route::post('user_coupon/download', [UserCouponController::class, 'download'])->name('user_coupon.download');
