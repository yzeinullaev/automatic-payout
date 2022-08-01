<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Brackets\AdminAuth\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'activated' => true,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'last_login_at' => $faker->dateTime,

    ];
});/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Branch::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'number' => $faker->randomNumber(5),
        'address' => $faker->sentence,
        'bin' => $faker->sentence,
        'perex' => $faker->text(),
        'published_at' => $faker->date(),
        'enabled' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Agent::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'initials' => $faker->sentence,
        'iin' => $faker->sentence,
        'requisite' => $faker->sentence,
        'partner_id' => $faker->randomNumber(5),
        'slug' => $faker->unique()->slug,
        'perex' => $faker->text(),
        'published_at' => $faker->date(),
        'enabled' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Partner::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'bin' => $faker->sentence,
        'branch_id' => $faker->randomNumber(5),
        'slug' => $faker->unique()->slug,
        'perex' => $faker->text(),
        'published_at' => $faker->date(),
        'enabled' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\PayStatus::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'slug' => $faker->unique()->slug,
        'perex' => $faker->text(),
        'published_at' => $faker->date(),
        'enabled' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\PayType::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'slug' => $faker->unique()->slug,
        'perex' => $faker->text(),
        'published_at' => $faker->date(),
        'enabled' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\ContractList::class, static function (Faker\Generator $faker) {
    return [
        'branch_id' => $faker->randomNumber(5),
        'contract_number' => $faker->sentence,
        'start_contract_date' => $faker->date(),
        'end_contract_date' => $faker->date(),
        'partner_id' => $faker->randomNumber(5),
        'partner_bin' => $faker->sentence,
        'agent_id' => $faker->randomNumber(5),
        'pay_status_id' => $faker->randomNumber(5),
        'pay_type_id' => $faker->randomNumber(5),
        'agent_fee' => $faker->randomFloat,
        'enabled' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\ContractListMonth::class, static function (Faker\Generator $faker) {
    return [
        'contract_list_id' => $faker->randomNumber(5),
        'month' => $faker->randomNumber(5),
        'pay_decode' => $faker->randomFloat,
        'pay_act' => $faker->randomFloat,
        'upload_decode_file' => $faker->randomNumber(5),
        'download_akt_file' => $faker->randomNumber(5),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Test::class, static function (Faker\Generator $faker) {
    return [
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\ChackeAll::class, static function (Faker\Generator $faker) {
    return [
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\CheckAll::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'enabled' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
