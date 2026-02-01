<?php

namespace App\Http\Controllers\Feature;

use App\Http\Controllers\Controller;
use App\Http\Requests\Feature\StoreProductRequest;
use App\Http\Requests\Feature\UpdateProductRequest;
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

/**
 *
 */
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
            $this->extractImage($request, $product);
        }

        $notification = array(
            'message' => 'Product created successfully!',
            'alert-type' => 'success'
        );

        return redirect()->route('app.products.all')->with($notification);
    }

    public function viewEdit(Request $request,int $id): View
    {
        $brands = Brand::all();
        $categories = ProductCategory::all();
        $vendors = Vendor::all();
        $warehouses = Warehouse::all();

        $product = Product::findOrFail($id);
        $product_images = ProductImage::where('product_id', $id)->get();

        return view('pages.feature.product-edit', compact(
            'product', 'brands', 'categories', 'vendors', 'warehouses', 'product_images'));
    }

    public function viewShow(Request $request,int $id): View
    {
        $product = Product::findOrFail($id);
        $product_images = ProductImage::where('product_id', $id)->get();
        return view('pages.feature.product-show', compact('product', 'product_images'));
    }

    public function update(UpdateProductRequest $request, int $id): RedirectResponse
    {
        $validated = $request->except('image');
        $product = Product::findOrFail($id);
        $product->update($validated);

        if ($request->hasFile('image')) {
            // delete existing image first
            $this->removeImages($id);
            $this->extractImage($request, $product);
        }

        $notification = array(
            'message' => 'Product updated successfully!',
            'alert-type' => 'success'
        );

        return redirect()->route('app.products.all')->with($notification);
    }

    public function remove(int $id) : RedirectResponse
    {
        $product = Product::findOrFail($id);
        // delete image first
        $this->removeImages($id);

        $product->delete();

        $notification = array(
            'message' => 'Product deleted successfully!',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return void
     */
    public function extractImage(Request $request, Product $product): void
    {
        foreach ($request->file('image') as $image) {
            $manager = new ImageManager(new Driver());
            $name_image = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $url = 'images/product/' . $name_image;
            $img->resize(150, 150)->save(public_path($url));
            ProductImage::create([
                'product_id' => $product->id,
                'image' => $url,
            ]);
        }
    }

    /**
     * @param int $id
     * @return void
     */
    private function removeImages(int $id) : void
    {
        $productImage = ProductImage::where('product_id', $id)->get();
        if ($productImage) {
            foreach ($productImage as $image) {
                $url = $image->image;
                unlink($url);
            }
        }

        ProductImage::where('product_id', $id)->delete();
    }
}
