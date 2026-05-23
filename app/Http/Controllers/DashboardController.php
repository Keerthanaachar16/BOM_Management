<?php

namespace App\Http\Controllers;

use App\Models\BomHeader;
use App\Models\Inventory;
use App\Models\PurchaseIntent;

class DashboardController extends Controller
{
    public function index()
    {
        $bomCount =BomHeader::count();

        $inventoryCount =Inventory::count();

        $purchaseIntentCount =PurchaseIntent::count();

        $outOfStockCount =
            PurchaseIntent::where('shortfall_quantity','>', 0)->count();

        $lowStockItems =
            PurchaseIntent::where('shortfall_quantity','>',0)->latest()->take(5)->get();

        return view('dashboard.index',compact('bomCount','inventoryCount','purchaseIntentCount','outOfStockCount','lowStockItems'));
    }
}