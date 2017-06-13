<?php
use App\User;
use App\Seller;
use App\Product;
use App\Category;
use App\Transaction;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'verified' => $verify = $faker->randomElement([User::USER_VERIFY,User::USER_NOT_VERIFY]),
        'verification_token' => $verify == User::USER_VERIFY ? null : User::generateVarificationToken(),
        'admin' => $faker->randomElement([User::USER_ADMINISTRATOR,User::USER_NOT_ADMINISTRATOR])
    ];
});


$factory->define(App\Category::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1)
    ];
});


$factory->define(App\Product::class, function (Faker\Generator $faker) {

    return [
      'name' => $faker->word,
      'description' => $faker->paragraph(1),
      'quantity'=> $faker->numberBetween(1,10),
      'status'=> $faker->randomElement([Product::PRODUCT_AVALAIBLE,Product::PRODUCT_NOT_AVALAIBLE]),
      'image'=> $faker->randomElement(['1.jpg','2.jpg','3.jpg']),
      //'seller_id'=> User::inRandomOrder()->first()->id,
      'seller_id'=> User::all()->random()->id,

    ];
});


$factory->define(App\Transaction::class, function (Faker\Generator $faker) {
  $sellers = Seller::has('products')->get()->random();
  $buyers = User::all()->except($sellers->id)->random();
    return [
      'quantity' =>$faker->numberBetween(1,2),
      'buyer_id' => $buyers->id,
      'product_id' => $sellers->products->random()->id
    ];
});
