<?php

namespace App\Http\Controllers\Feature;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorController extends Controller
{
    public function view() : View
    {
        $vendors = Vendor::query()->latest()->get();
        return view("pages.feature.vendors", compact("vendors"));
    }

    public function viewCreate() : View
    {
        return view("pages.feature.vendors-create");
    }

    public function store(Request $request) : RedirectResponse
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "email" => "nullable|email|unique:warehouses,email|max:255",
            "phone" => "nullable|string|max:255",
            "address" => "nullable|string|max:255",
        ]);

        $vendor = new Vendor($validated);
        $vendor->save();

        $notification = array(
            "message" => "Vendor added successfully!",
            "alert-type" => "success"
        );

        return redirect()->route("app.vendors.all")->with($notification);
    }

    public function viewEdit(int $id) : View
    {
        $vendor = Vendor::query()->findOrFail($id);
        return view("pages.feature.vendors-edit", compact("vendor"));
    }

    public function update(Request $request, int $id) : RedirectResponse
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "email" => "nullable|email|unique:warehouses,email,".$id."|max:255",
            "phone" => "nullable|string|max:255",
            "address" => "nullable|string|max:255",
        ]);

        $vendor = Vendor::query()->findOrFail($id);
        $vendor->update($validated);

        $notification = array(
            "message" => "Vendor updated successfully!",
            "alert-type" => "success"
        );
        return redirect()->route("app.vendors.all")->with($notification);
    }

    public function remove(int $id) : RedirectResponse
    {
        $vendor = Vendor::query()->findOrFail($id);
        $vendor->delete();

        $notification = array(
            "message" => "Vendor deleted successfully!",
            "alert-type" => "success"
        );

        return back()->with($notification);
    }
}
