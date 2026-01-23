<?php

namespace App\Http\Controllers\Feature;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WarehouseController extends Controller
{
    public function view() : View
    {
        $warehouses = Warehouse::query()->latest()->get();
        return view('pages.feature.warehouses', compact('warehouses'));
    }

    public function viewCreate() : View
    {
        return view('pages.feature.warehouses-create');
    }

    public function store(Request $request) : RedirectResponse
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "email" => "nullable|email|unique:warehouses,email|max:255",
            "phone" => "nullable|string|max:255",
            "city" => "nullable|string|max:255",
            "address" => "nullable|string|max:255",
        ]);

        $warehouse = new Warehouse($validated);
        $warehouse->save();

        $notification = array(
            "message" => "Warehouse added successfully",
            "alert-type" => "success"
        );

        return redirect()->route('app.warehouses.all')->with($notification);
    }

    public function viewEdit(int $id) : View
    {
        $warehouse = Warehouse::query()->findOrFail($id);
        return view('pages.feature.warehouses-edit', compact('warehouse'));
    }

    public function update(Request $request, int $id) : RedirectResponse
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "email" => "nullable|email|unique:warehouses,email,".$id."|max:255",
            "phone" => "nullable|string|max:255",
            "city" => "nullable|string|max:255",
            "address" => "nullable|string|max:255",
        ]);
        $warehouse = Warehouse::query()->findOrFail($id);
        $warehouse->update($validated);

        $notification = array(
            "message" => "Warehouse updated successfully",
            "alert-type" => "success"
        );

        return redirect()->route('app.warehouses.all')->with($notification);
    }

    public function remove(int $id) : RedirectResponse
    {
        $warehouse = Warehouse::query()->findOrFail($id);
        $warehouse->delete();
        $notification = array(
            "message" => "Warehouse deleted successfully",
            "alert-type" => "success"
        );
        return back()->with($notification);
    }
}
