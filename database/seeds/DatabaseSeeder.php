<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\User;
use App\Product;
use App\Category;
use App\Transaction;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
      App\User::truncate();
      App\Category::truncate();
      App\Product::truncate();
      App\Transaction::truncate();
      DB::table('category_product')->truncate();

      $usersQuantity = 200;
      $categoriesQuantity = 30;
      $productsQuantity = 1000;
      $transactionsQuantity = 1000;


      factory(User::class,$usersQuantity)->create();
      factory(Category::class,$categoriesQuantity)->create();

      factory(Product::class,$transactionsQuantity)->create()->each(
        function($product)
        {
          $categories = Category::all()->random( mt_rand(1,5))->pluck('id');
          $product->categories()->attach($categories);
        }
      );

      factory(Transaction::class,$transactionsQuantity)->create();


    }
}
