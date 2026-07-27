<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\BarcodeService;

class ProductObserver
{
    public function creating(Product $product): void
    {
        if (empty($product->barcode)) {
            $product->barcode = app(BarcodeService::class)->generateNumber();
        }
    }
}
