<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $fillable = ["name", "description", "category_id", "manufacturer", "quantity_type_id", "sell_price"];

    public function category()
    {
        return $this->belongsTo(ProductsCategory::class);
    }

    public function stocks()
    {
        return $this->belongsTo(ProductStock::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
