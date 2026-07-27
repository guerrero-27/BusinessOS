<?php

namespace App\Services;

use App\Models\InventoryMovement;

class ReferenceNumberService
{
    private const PREFIXES = [
        'in'         => 'PO',
        'out'        => 'INV',
        'adjustment' => 'ADJ',
    ];

    public function generate(string $type): string
    {
        $prefix = self::PREFIXES[$type] ?? 'REF';
        $year   = now()->year;

        $last = InventoryMovement::where('reference_number', 'like', "{$prefix}-{$year}-%")
            ->orderByDesc('reference_number')
            ->value('reference_number');

        $next = $last ? ((int) substr($last, -4)) + 1 : 1;

        $candidate = "{$prefix}-{$year}-" . str_pad($next, 4, '0', STR_PAD_LEFT);

        // Ensure uniqueness in case of race condition
        while (InventoryMovement::where('reference_number', $candidate)->exists()) {
            $next++;
            $candidate = "{$prefix}-{$year}-" . str_pad($next, 4, '0', STR_PAD_LEFT);
        }

        return $candidate;
    }
}
