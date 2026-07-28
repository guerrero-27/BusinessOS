<?php

namespace App\Services;

use App\Models\Product;

class SkuService
{
    /**
     * Generate a unique SKU in the format: CAT-BRD-001
     * e.g. Laptop + Lenovo → LAP-LEN-001
     */
    public function generate(string $categoryName, string $brand): string
    {
        $catCode   = $this->abbreviate($categoryName, 3);
        $brandCode = $this->abbreviate($brand, 3);
        $prefix    = "{$catCode}-{$brandCode}";

        $last = Product::where('sku', 'like', "{$prefix}-%")
            ->orderByDesc('sku')
            ->value('sku');

        $next = $last ? ((int) substr($last, strrpos($last, '-') + 1)) + 1 : 1;

        $candidate = "{$prefix}-" . str_pad($next, 3, '0', STR_PAD_LEFT);

        while (Product::where('sku', $candidate)->exists()) {
            $next++;
            $candidate = "{$prefix}-" . str_pad($next, 3, '0', STR_PAD_LEFT);
        }

        return $candidate;
    }

    /**
     * Preview the SKU prefix without hitting the DB (for live JS preview).
     */
    public function preview(string $categoryName, string $brand): string
    {
        $catCode   = $this->abbreviate($categoryName, 3);
        $brandCode = $this->abbreviate($brand, 3);
        return "{$catCode}-{$brandCode}-XXX";
    }

    /**
     * Convert a name to an uppercase abbreviation of given length.
     * Uses first letters of each word, padded/trimmed to $length.
     */
    private function abbreviate(string $name, int $length): string
    {
        $words = preg_split('/[\s\-_]+/', trim($name));
        $abbr  = '';

        foreach ($words as $word) {
            $abbr .= strtoupper(substr($word, 0, 1));
            if (strlen($abbr) >= $length) break;
        }

        // If single word, take first N chars
        if (strlen($abbr) < $length) {
            $abbr = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $name), 0, $length));
        }

        return str_pad(strtoupper($abbr), $length, 'X');
    }
}