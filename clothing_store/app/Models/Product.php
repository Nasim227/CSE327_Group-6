<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * Represents a single clothing product in the store.
 *
 * Columns in the `products` table:
 * - int         $Category_id          Category identifier (e.g. Men, Women, Kids)
 * - int         $Product_id           Internal product ID (if used as column)
 * - string      $Product_name         Name of the product (e.g. "Kurti")
 * - string      $Brand_name           Brand of the product (e.g. "Aarong")
 * - int|float   $Price                Unit selling price
 * - string|null $Product_pic          Filename of the main product image
 * - string|null $Brand_logo           Filename of the brand logo image
 * - int         $Available_quantity   Quantity currently available in stock
 *
 * @package App\Models
 */

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'Product_id';
    public $timestamps = false;
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
