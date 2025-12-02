<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Product
 *
 * Represents a product in the online store.
 * 
 * This model interacts with the 'products' table
 * to retrieve, display, and manage product information such as name, category,
 * brand, price, images, and available quantity. It is used throughout the
 * application wherever product data is needed.
 *
 * @package App\Models
 */
class Product extends Model
{

    /**
     * The name of the database table this model represents.
     *
     * @var string
     */
    protected $table = 'products';


    /**
     * The primary key for the products table.
     *
     * @var string
     */
    protected $primaryKey = 'Product_id';


    /**
     * Determines if Laravel should automatically keep track of when products
     * are created or updated.
     *
     * @var bool
     */
    public $timestamps = false;


    /**
     * The attributes that can be set all at once when creating or updating a product.
     *
     * @var array
     */
    protected $fillable = [
        'Product_name',
        'Category_name',
        'Brand_name',
        'Price',
        'Product_pic',
        'Brand_logo',
        'Avaliable_quantity'
    ];


    /**
     * Get all sizes associated with the product.
     *
     * Defines a one-to-many relationship between Product and ProductSize.
     * Each product can have multiple sizes available in the store.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sizes()
    {
        return $this->hasMany(ProductSize::class, 'Product_id', 'Product_id');
    }

}
