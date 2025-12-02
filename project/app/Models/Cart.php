<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Cart
 *
 * Represents a shopping cart in the online store.
 * 
 * This model interacts with the 'carts' table to store and manage cart items for users.
 * Each record typically contains information about the user, product, selected size,
 * quantity, and any associated pricing details.
 *
 * @package App\Models
 */
class Cart extends Model
{
    
    /**
     * The name of the database table this model represents.
     *
     * @var string
     */
    protected $table = 'cart';


    /**
     * The primary key for the carts table.
     *
     * @var string
     */
    protected $primaryKey = 'Cart_id';


     /**
     * Determines if Laravel should automatically keep track of when cart items
     * are created or updated.
     *
     * @var bool
     */
    public $timestamps = false;


    /**
     * The attributes that can be set all at once when creating or updating a cart item.
     *
     * @var array
     */
    protected $fillable = [
        'User_id',
        'Product_id',
        'Size',
        'Quantity',
        'Price',
        'Total_price'
    ];


    /**
     * Get the product associated with this cart item.
     *
     * Defines an inverse one-to-many relationship between Cart and Product.
     * Each cart item belongs to a single product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'Product_id', 'Product_id');
    }
}
