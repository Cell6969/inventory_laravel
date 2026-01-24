<?php

namespace App\Http\Controllers\Feature;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class CustomerController extends Controller
{
    private string $CUSTOMER_IMAGE_PATH = "photo/";
    public function view() : View
    {
        $customers = Customer::latest()->get();
        return view('pages.feature.customers', compact('customers'));
    }

    public function viewCreate() : View
    {
        return view('pages.feature.customers-create');
    }

    public function store(Request $request) : RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $file_image = $request->file('image');
        if ($file_image) {
            $manager = new ImageManager(new Driver());
            $filename = hexdec(uniqid()) . '.' . $file_image->getClientOriginalExtension();
            $image = $manager->read($file_image);
            $image->resize(100,90);
            $fullpath = $this->CUSTOMER_IMAGE_PATH . $filename;
            $image->save(public_path($fullpath));
            $validated['image'] = $fullpath;
        };

        $customer = new Customer($validated);
        $customer->save();

        $notification = array(
            'message' => 'Customer added successfully!',
            'alert-type' => 'success'
        );

        return redirect()->route('app.customers.all')->with($notification);
    }

    public function viewEdit(int $id) : View
    {
        $customer = Customer::findOrFail($id);
        return view('pages.feature.customers-edit', compact('customer'));
    }

    public function update(Request $request, int $id) : RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email,' . $id,
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $customer = Customer::findOrFail($id);
        $file_image = $request->file('image');
        if ($file_image) {
            $manager = new ImageManager(new Driver());
            $filename = hexdec(uniqid()) . '.' . $file_image->getClientOriginalExtension();
            $image = $manager->read($file_image);
            $image->resize(100,90);
            $fullpath = $this->CUSTOMER_IMAGE_PATH . $filename;
            $image->save(public_path($fullpath));
            $validated['image'] = $fullpath;

            if (file_exists(public_path($customer->image))) {
                unlink($customer->image);
            }
        }

        $customer->update($validated);
        $notification = array(
            'message' => 'Customer updated successfully!',
            'alert-type' => 'success'
        );

        return redirect()->route('app.customers.all')->with($notification);
    }

    public function remove(int $id) : RedirectResponse
    {
        $customer = Customer::findOrFail($id);
        if (!empty($customer->image) && file_exists(public_path($customer->image))) {
            unlink($customer->image);
        }
        $customer->delete();

        $notification = array(
            'message' => 'Customer deleted successfully!',
            'alert-type' => 'success'
        );

        return redirect()->route('app.customers.all')->with($notification);
    }
}
