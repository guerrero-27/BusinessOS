<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\SkuService;
use Illuminate\Http\Request;

class SkuPreviewController extends Controller
{
    public function __invoke(Request $request, SkuService $skuService)
    {
        $categoryName = 'GEN';

        if ($request->filled('category_id')) {
            $categoryName = Category::find($request->category_id)?->name ?? 'GEN';
        }

        $brand = $request->filled('brand') ? $request->brand : 'GEN';

        return response()->json([
            'preview' => $skuService->preview($categoryName, $brand),
        ]);
    }
}
