<?php

namespace App\Http\Controllers;

use App\Models\PurchaseIntent;
use Illuminate\Http\Request;
use App\Models\AuditTrail;

class PurchaseIntentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $purchaseIntents = PurchaseIntent::when($search,
            function ($query) use ($search) 
            {

                $query->where('item_code','like',"%{$search}%")
                ->orWhere('description','like',"%{$search}%");
            }
        )
        ->latest()
        ->paginate(20);

        return view('purchase_intents.index',compact('purchaseIntents','search'));
    }

    public function updateStatus(Request $request,$id)
    {
        $intent =PurchaseIntent::findOrFail($id);

        $intent->update(['status' =>$request->status]);

        AuditTrail::create([
        'action' =>'Purchase Intent Status Updated : '
            . $intent->item_code
            . ' -> '
            . $request->status,'user_id' => 1
        ]);

        return back()->with('success','Status Updated Successfully');
    }
}