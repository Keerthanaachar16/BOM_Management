<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $inventories =Inventory::when($search,
            function ($query) use ($search) 
            {

                $query->where('item_code','like',"%{$search}%")
                ->orWhere('description','like',"%{$search}%");
            }
        )
        ->latest()
        ->paginate(20);

        return view('inventory.index',compact('inventories', 'search'));
    }
}