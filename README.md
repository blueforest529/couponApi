# Coupon API

- 라라벨 프로젝트를 이용하여 API 2개를 만들어주세요.
- 하나는 유저가 10만명이 있다고 할 때 각 유저에게 쿠폰을 생성해서 이메일/문자를 발송하는 API입니다.
- 또 하나는 유저가 쿠폰을 다운받는 API입니다.

## 실행
DB migration
> php artisan migrate

DB 더미 데이터 추가
> php artisan db:seed

테스트
> php artisan test

## Api

1. 각 유저에게 쿠폰 생성
    * [POST]  /user_coupon
    * data : ['coupon_id' : 1]  // 할당 할 쿠폰 id
      * ex ) localhost:8000/api/user_coupon?coupon_id=1
    * return 값
      * {"ok": "Success"}


2. 유저가 쿠폰 다운로드
   * [POST] /user_coupon/download
   * data : ['user_id' : 1, 'coupon_id' : 1] // 유저 id 와 할당 할 쿠폰 id
     * ex ) localhost:8000/api/user_coupon/download?coupon_id=1&user_id=1
   * return 값:
     * {"ok": "Success",
       "code": "XwqY-ZZSu-LiTH-sKux"}


## ERD
<img width="812" alt="erd" src="https://user-images.githubusercontent.com/22957339/229338837-39d486e4-d30c-41b9-ad91-12a142f4b1cd.png">

