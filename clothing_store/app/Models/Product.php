<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Table name in your database
    protected $table = 'products';

    // Primary key column
    protected $primaryKey = 'Product_id';

    // Your table does not have created_at / updated_at
    public $timestamps = false;

    // Columns that can be filled (optional but good practice)
    protected $fillable = [
        'Category_id',
        'Product_id',
        'Product_name',
        'Brand_name',
        'Price',
        'Product_pic',
        'Brand_logo',
        'Available_quantity',
    ];
}
