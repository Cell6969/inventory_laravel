<?php

namespace App\Http\Controllers\Feature;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Vendor;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    public function view() : View
    {
        $purchases = Purchase::latest()->get();
        return view('pages.feature.purchases', compact('purchases'));
    }

    public function viewCreate() : View
    {
        $vendors = Vendor::all();
        $warehouses = Warehouse::all();

        return view('pages.feature.purchases-create', compact('vendors', 'warehouses'));
    }
}
