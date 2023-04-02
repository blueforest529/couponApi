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
    //code : 영문 대/소문자+ 숫자로 총 62개로 중복을 허용한 4자리 문자열을 만들면 경우의 수 62 * 62 * 62 * 62 = 14,776,336
    const COUPON_REGEX = '([a-zA-Z0-9]{4})-([a-zA-Z0-9]{4})-([a-zA-Z0-9]{4})-([a-zA-Z0-9]{4})';
    private $faker;
    public function __construct(){
        $this->faker = Container::getInstance()->make(Generator::class);
    }

    //유저별 쿠폰 생성
    function grantAll(Request $request) {
        try {
            if (!$request->coupon_id) {
                return response()->json([
                    'error' => '유저에게 할당 할 쿠폰 id를 입력하세요.'
                ]);
            }

            $data = [];
            $emailList = [];
            $smsList = [];
            $allUser = DB::table('users')
                    ->select('id', 'name', 'email', 'phone')
                    ->get();

            foreach($allUser as $user) {
                $now  = now()->toDateTimeString();
                $code = $this->faker->regexify(self::COUPON_REGEX);

                $data[] = [
                    'user_id' => $user->id,
                    'coupon_id' => $request->coupon_id,
                    'code' => $code,
                    'status' => 0,
                    'created_at'=> $now,
                    'updated_at'=> $now
                ];

                $emailList[] = [
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'coupon_id' => $request->coupon_id,
                    'code' => $code,
                ];

                $smsList[] = [
                    'user_name' => $user->name,
                    'user_phone' => $user->phone,
                    'coupon_id' => $request->coupon_id,
                    'code' => $code
                ];
            }

            // 5000개씩 나눠 bulk
            $chunks = array_chunk($data, 5000);
            foreach ($chunks as $chunk) {
                UserCoupon::query()->insert($chunk);
            }

            $this->sendEmail($emailList);
            $this->sendSms($smsList);

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
            $now = now()->toDateTimeString();

            $data = [
                'user_id' => $request->user_id,
                'coupon_id' => $request->coupon_id,
                'code' => $this->faker->regexify(self::COUPON_REGEX),
                'status' => 0,
                'created_at'=> $now,
                'updated_at'=> $now
            ];

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


    private function sendEmail($userList) {
        foreach ($userList as $user) {
            // 여기서 메일 발송
        }
    }

    private function sendSms($userList) {
        foreach ($userList as $user) {
            // 여기서 문자 발송
        }
    }

}
