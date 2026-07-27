<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barcode Label — {{ $product->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Courier New', monospace; background: #f3f4f6; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
        .label { background: white; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px 28px; width: 320px; text-align: center; box-shadow: 0 4px 16px rgba(0,0,0,0.08); }
        .product-name { font-size: 15px; font-weight: 700; color: #111827; margin-bottom: 12px; font-family: sans-serif; line-height: 1.3; }
        .meta { font-size: 11px; color: #6b7280; margin-bottom: 4px; font-family: sans-serif; }
        .meta span { font-weight: 600; color: #374151; }
        .divider { border: none; border-top: 1px dashed #e5e7eb; margin: 14px 0; }
        .barcode-number { font-size: 13px; letter-spacing: 2px; color: #374151; margin-bottom: 10px; }
        .barcode-svg { width: 100%; }
        .barcode-svg svg { width: 100%; height: auto; }
        .actions { margin-top: 20px; display: flex; gap: 10px; justify-content: center; }
        .btn { padding: 8px 20px; border-radius: 8px; font-size: 13px; font-family: sans-serif; cursor: pointer; border: none; font-weight: 500; }
        .btn-print { background: #4f46e5; color: white; }
        .btn-back { background: #f3f4f6; color: #374151; text-decoration: none; display: inline-flex; align-items: center; }
        @media print {
            body { background: white; }
            .label { box-shadow: none; border: none; }
            .actions { display: none; }
        }
    </style>
</head>
<body>
    <div>
        <div class="label">
            <p class="product-name">{{ $product->name }}</p>

            <p class="meta">SKU: <span>{{ $product->sku }}</span></p>
            @if ($product->category)
                <p class="meta">Category: <span>{{ $product->category->name }}</span></p>
            @endif

            <hr class="divider">

            <p class="meta" style="margin-bottom:6px;">Barcode</p>
            <p class="barcode-number">{{ $product->barcode }}</p>

            <div class="barcode-svg">{!! $barcodeSvg !!}</div>
        </div>

        <div class="actions">
            <a href="{{ route('products.index') }}" class="btn btn-back">← Back</a>
            <button class="btn btn-print" onclick="window.print()">🖨 Print Label</button>
        </div>
    </div>
</body>
</html>
