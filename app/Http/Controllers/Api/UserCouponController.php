<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserCoupon;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserCouponController extends Controller
{
    private $faker;
    public function __construct(){
        $this->faker = Container::getInstance()->make(Generator::class);
    }

    //유저별 쿠폰 생성
    function store(Request $request) {
        try {
            if (!$request->coupon_id) {
                return response()->json([
                    'error' => '유저에게 할당 할 쿠폰 id를 입력하세요.'
                ]);
            }

            $allUser = DB::table('users')
                    ->select('id', 'email', 'phone')
                    ->get();

            //code : 영문 대/소문자+ 숫자로 총 62개로 중복을 허용한 4자리 문자열을 만들면 경우의 수 62 * 62 * 62 * 62 = 14,776,336
            foreach($allUser as $user) {
                $data[] = [
                    'user_id' => $user->id,
                    'coupon_id' => $request->coupon_id,
                    'code' => $this->faker->regexify('([a-zA-Z0-9]{4})-([a-zA-Z0-9]{4})-([a-zA-Z0-9]{4})-([a-zA-Z0-9]{4})'),
                    'status' => 0,
                    'created_at'=> now()->toDateTimeString(),
                    'updated_at'=> now()->toDateTimeString()
                ];
            }

            // 5000개씩 나눠 bulk
            $chunks = array_chunk($data, 5000);
            foreach ($chunks as $chunk) {
                UserCoupon::query()->insert($chunk);
            }

            //send coupon
            foreach($allUser as $user) {
                // 여기서 발송하는 Api 호출

            }

            return response()->json([
                'ok' => 'Success'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }


    // 쿠폰 다운로드
    function download(Request $request)
    {
        try {
            $data = array(
                'user_id' => $request->user_id,
                'coupon_id' => $request->coupon_id,
                'code' => $this->faker->regexify('([a-zA-Z0-9]{4})-([a-zA-Z0-9]{4})-([a-zA-Z0-9]{4})-([a-zA-Z0-9]{4})'),
                'status' => 0,
                'created_at'=> now()->toDateTimeString(),
                'updated_at'=> now()->toDateTimeString()
            );

            UserCoupon::query()->insert($data);

            return response()->json([
                'ok' => 'Success',
                'code' => $data['code']
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
