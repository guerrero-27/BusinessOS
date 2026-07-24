<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'sku', 'barcode', 'category_id', 'description', 'image',
        'cost_price', 'selling_price', 'unit', 'current_stock',
        'min_stock', 'max_stock', 'warehouse', 'status',
    ];

    protected function casts(): array
    {
        return [
            'cost_price'    => 'decimal:2',
            'selling_price' => 'decimal:2',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function isLowStock(): bool
    {
        return $this->current_stock > 0 && $this->current_stock <= $this->min_stock;
    }

    public function isOutOfStock(): bool
    {
        return $this->current_stock <= 0;
    }

    public function stockStatusLabel(): string
    {
        if ($this->isOutOfStock()) return 'out_of_stock';
        if ($this->isLowStock())   return 'low_stock';
        return 'in_stock';
    }
}
