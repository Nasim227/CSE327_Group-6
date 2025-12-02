<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductSize
 *
 * Represents the available sizes for products in the online store.
 * 
 * This model interacts with the 'product_sizes' table to store the size options
 * for each product. It helps in determining which sizes a product is available in
 * and can be used to validate stock availability.
 *
 * @package App\Models
 */
class ProductSize extends Model
{
    
    /**
     * The name of the database table this model represents.
     *
     * @var string
     */
    protected $table = 'product_sizes';


    /**
     * The primary key for the product_sizes table.
     *
     * @var string
     */
    protected $primaryKey = 'id';


    /**
     * Determines if Laravel should automatically keep track of when product sizes
     * are created or updated.
     *
     * @var bool
     */
    public $timestamps = false;


    /**
     * The attributes that can be set all at once when creating or updating a product size.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',  
        'size',         
        'stock'        
    ];
}
