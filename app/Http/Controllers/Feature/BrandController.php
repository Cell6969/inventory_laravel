<?php

namespace App\Http\Controllers\Feature;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BrandController extends Controller
{
    private string $BRAND_IMAGE_PATH = "images/brands/";
    public function view() : View
    {
        $brands = Brand::query()->latest()->get();
        return view('pages.feature.brands', compact('brands'));
    }

    public function viewCreate() : View
    {
        return view('pages.feature.brands-create');
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:brands|:max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $brand = new Brand();
        $brand->name = $request->get('name');

        $image = $request->file('image');
        if ($image) {
            $manager = new ImageManager(new Driver());
            $image_gen = hexdec(uniqid()).".".$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(100,90);
            $full_path = $this->BRAND_IMAGE_PATH.$image_gen;
            $img->save(public_path($full_path));
            $brand->image = $full_path;
        }

        $brand->save();

        $notification = array(
            'message' => 'Brand has been added successfully!',
            'alert-type' => 'success'
        );

        return redirect()->route('app.brands.all')->with($notification);
    }

    public function viewEdit(Request $request,int $id) : View
    {
        $brand = Brand::query()->findOrFail($id);
        return view('pages.feature.brands-edit', compact('brand'));
    }

    public function update(Request $request, int $id) : RedirectResponse
    {
        $brand = Brand::query()->findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|unique:brands,name,' . $id . '|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('image');
        if ($image) {
            $manager = new ImageManager(new Driver());
            $image_gen = hexdec(uniqid()).".".$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(100,90);
            $full_path = $this->BRAND_IMAGE_PATH.$image_gen;
            $img->save(public_path($full_path));

            // delete old image
            if (file_exists(public_path($brand->image))) {
                unlink($brand->image);
            }

            $validated['image'] = $full_path;
        }

        $brand->update($validated);
        $notification = array(
            'message' => 'Brand has been updated successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('app.brands.all')->with($notification);
    }

    public function remove(int $id) : RedirectResponse
    {
        $brand = Brand::query()->findOrFail($id);

        if (file_exists(public_path($brand->image))) {
            unlink($brand->image);
        }

        $brand->delete();
        $notification = array(
            'message' => 'Brand has been deleted successfully!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
