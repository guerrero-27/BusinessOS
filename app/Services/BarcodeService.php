<?php

namespace App\Services;

use App\Models\Product;
use Picqer\Barcode\BarcodeGeneratorSVG;

class BarcodeService
{
    private const PREFIX = '890';

    public function generateNumber(): string
    {
        $last = Product::whereNotNull('barcode')
            ->orderByDesc('barcode')
            ->value('barcode');

        $next = $last ? ((int) $last) + 1 : (int)(self::PREFIX . '000000001');

        $candidate = str_pad($next, 12, '0', STR_PAD_LEFT);

        while (Product::where('barcode', $candidate)->exists()) {
            $next++;
            $candidate = str_pad($next, 12, '0', STR_PAD_LEFT);
        }

        return $candidate;
    }

    public function generateSvg(string $barcode): string
    {
        $generator = new BarcodeGeneratorSVG();
        return $generator->getBarcode($barcode, $generator::TYPE_CODE_128, 2, 60);
    }
}
