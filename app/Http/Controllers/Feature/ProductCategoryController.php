<?php

namespace App\Http\Controllers\Feature;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductCategoryController extends Controller
{
    public function view() : View
    {
        $product_categories = ProductCategory::latest()->get();
        return view('pages.feature.product-categories', compact('product_categories'));
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        ProductCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        $notification = array(
            'message' => 'Product Category added successfully!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function findProduct(int $id) : JsonResponse
    {
        $product_category = ProductCategory::findOrFail($id);

        return response()->json($product_category);
    }

    public function update(Request $request, int $id) : RedirectResponse
    {
        $request->validate([
           "name" => "required|max:255",
        ]);

        $product_category = ProductCategory::findOrFail($id);
        $product_category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        $notification = array(
            'message' => 'Product Category updated successfully!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function remove(int $id) : RedirectResponse
    {
        $product_category = ProductCategory::findOrFail($id);
        $product_category->delete();

        $notification = array(
            'message' => 'Product Category deleted successfully!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
