<?php

namespace Tests\Feature\Api;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserCouponControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_유저별_쿠폰_생성(): void
    {
        User::factory(10000)->create();
        Coupon::factory(5)->create();

        $data = [
            'coupon_id' => 1
        ];

        $response = $this->json('POST', route('user_coupon.grantall'), $data)
            ->assertStatus(200)
            ->assertJson(['ok' => 'Success']);
    }

    public function test_유저_쿠폰_다운로드() : void
    {
        User::factory(1)->create()->first();
        Coupon::factory(1)->create();

        $data = [
            'coupon_id' => 1,
            'user_id' => 1
        ];

        $response = $this->json('POST', route('user_coupon.download'), $data)
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->hasAll('ok', 'code'));
    }

}
