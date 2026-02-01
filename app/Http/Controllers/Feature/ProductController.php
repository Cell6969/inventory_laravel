<?php

namespace App\Http\Controllers\Feature;

use App\Http\Controllers\Controller;
use App\Http\Requests\Feature\StoreProductRequest;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Vendor;
use App\Models\Warehouse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProductController extends Controller
{
    public function view(): View
    {
        $products = Product::orderBy('name', 'asc')->get();
        return view('pages.feature.product', compact('products'));
    }

    public function viewCreate(): View
    {
        $brands = Brand::all();
        $categories = ProductCategory::all();
        $vendors = Vendor::all();
        $warehouses = Warehouse::all();
        return view('pages.feature.product-create', compact('brands', 'categories', 'vendors', 'warehouses'));
    }

    public function store(StoreProductRequest $request) : RedirectResponse
    {
        $validated = $request->validated();
        unset($validated['image']);
        $product = Product::create($validated);

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $manager = new ImageManager(new Driver());
                $name_image = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $img = $manager->read($image);
                $url = 'images/product/' . $name_image;
                $img->resize(150,150)->save(public_path($url));
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $url,
                ]);
            }
        }

        $notification = array(
            'message' => 'Product created successfully!',
            'alert-type' => 'success'
        );

        return redirect()->route('app.products.all')->with($notification);
    }
}
