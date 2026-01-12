<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display stock management dashboard
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by stock status
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'low':
                    $query->where('stock', '>', 0)->where('stock', '<', 10);
                    break;
                case 'out':
                    $query->where('stock', 0);
                    break;
                case 'available':
                    $query->where('stock', '>=', 10);
                    break;
            }
        }

        $products = $query->paginate(15);

        // Statistics
        $stats = [
            'total_products' => Product::count(),
            'low_stock' => Product::where('stock', '>', 0)->where('stock', '<', 10)->count(),
            'out_of_stock' => Product::where('stock', 0)->count(),
            'total_stock_value' => Product::sum(DB::raw('stock * price')),
        ];

        $categories = \App\Models\Category::all();

        return view('admin.stock.index', compact('products', 'stats', 'categories'));
    }

    /**
     * Update product stock
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'adjustment' => 'required|integer',
            'reason' => 'required|string|max:255',
        ]);

        $oldStock = $product->stock;
        $newStock = $oldStock + $request->adjustment;

        if ($newStock < 0) {
            return response()->json([
                'success' => false,
                'message' => 'Stock cannot be negative'
            ], 400);
        }

        $product->update(['stock' => $newStock]);

        // Log stock movement
        DB::table('stock_movements')->insert([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'old_stock' => $oldStock,
            'new_stock' => $newStock,
            'adjustment' => $request->adjustment,
            'reason' => $request->reason,
            'created_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Stock updated successfully',
            'new_stock' => $newStock,
        ]);
    }

    /**
     * Get stock history
     */
    public function history(Product $product)
    {
        $movements = DB::table('stock_movements')
            ->where('product_id', $product->id)
            ->join('users', 'stock_movements.user_id', '=', 'users.id')
            ->select('stock_movements.*', 'users.name as user_name')
            ->orderBy('stock_movements.created_at', 'desc')
            ->limit(50)
            ->get();

        return response()->json([
            'success' => true,
            'movements' => $movements,
        ]);
    }

    /**
     * Export stock data
     */
    public function export()
    {
        $products = Product::with('category')->get();

        $csvFileName = 'stock_export_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Category', 'Stock', 'Price', 'Total Value']);

            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->category->name ?? 'N/A',
                    $product->stock,
                    $product->price,
                    $product->stock * $product->price,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
