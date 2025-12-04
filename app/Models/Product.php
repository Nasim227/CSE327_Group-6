<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Represents a product in the store's inventory.
 * 
 * Each instance corresponds to one row in the 'products' table.
 * 
 * @property int $id Primary key
 * @property string $name Product name
 * @property float $price Product price in dollars
 * @property int $stock Quantity available in inventory
 * @property string $status Current status (Active, Low Stock, Out of Stock)
 * @property string|null $image Path to product image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @package App\Models
 */
class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * 
     * Only these fields can be set via create() or update().
     * This prevents attackers from setting fields like 'id'.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'price',
        'stock',
        'status',
        'image',
    ];
}
