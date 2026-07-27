<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\BarcodeService;
use App\Services\SkuService;

class ProductObserver
{
    public function creating(Product $product): void
    {
        if (empty($product->barcode)) {
            $product->barcode = app(BarcodeService::class)->generateNumber();
        }

        if (empty($product->sku)) {
            $categoryName = $product->category?->name
                ?? ($product->category_id ? \App\Models\Category::find($product->category_id)?->name : null)
                ?? 'GEN';

            $brand = $product->brand ?? 'GEN';

            $product->sku = app(SkuService::class)->generate($categoryName, $brand);
        }
    }
}
