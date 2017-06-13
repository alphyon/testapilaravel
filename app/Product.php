<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Seller;
use App\Product;
use App\Category;
use App\Transaction;

class Product extends Model
{
  const PRODUCT_AVALAIBLE = 'avalaible';
  const PRODUCT_NOT_AVALAIBLE = 'not avalaible';

    protected $fillable = [
      'name',
      'description',
      'quantity',
      'status',
      'image',
      'seller_id'
    ];

    public function isAvailable()
    {
      return $this->status == Product::PRODUCT_AVALAIBLE;
    }

    public function seller()
    {
      return $this->belongsTo(Seller::class);
    }

    public function transactions()
    {
      return $this->hasMany(Transaction::class);
    }

    public function categories()
    {
      return $this->belongsToMany(Category::class);
    }


}
