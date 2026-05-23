<?php

namespace App\Jobs;

use App\Models\BomHeader;
use App\Models\Inventory;
use App\Models\PurchaseIntent;
use App\Models\MaterialAllocation;
use App\Models\PurchaseIntentBatch;
use App\Models\AuditTrail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\User;
use App\Notifications\LowStockNotification;

class ProcessBomInventoryJob implements ShouldQueue
{
    use Queueable;

    public $bomHeader;

    public function __construct(BomHeader $bomHeader)
    {
        $this->bomHeader = $bomHeader;
    }

    public function handle(): void
    {
        $batch = PurchaseIntentBatch::create([

            'bom_header_id' => $this->bomHeader->id,
            'batch_number' => 'PIB-' . time()
        ]);

        foreach ($this->bomHeader->lineItems as $lineItem) 
        {

            $inventory = Inventory::where('item_code',$lineItem->item_code)->first();
            // $inventory = Inventory::whereRaw(
            // 'LOWER(description) = ?',

            // [strtolower(trim($lineItem->description))]
            // )->first();

            /*OUT OF STOCK*/

            if (!$inventory ||$inventory->available_quantity <= 0) 
            {

                $lineItem->update(['inventory_status' =>'OUT_OF_STOCK']);

                PurchaseIntent::create([

                    'purchase_intent_batch_id' =>$batch->id,

                    'item_code' =>$lineItem->item_code,

                    'description' =>$lineItem->description,

                    'specification' =>$lineItem->specification,

                    'required_quantity' =>$lineItem->required_quantity,

                    'available_quantity' => 0,

                    'shortfall_quantity' =>$lineItem->required_quantity,

                    'status' => 'Pending',

                    'date_raised' => now()
                ]);
                $admins = User::whereHas('roles', function ($query) {

                    $query->where('name', 'Admin');})->get();

                    foreach ($admins as $admin) 
                    {

                        $admin->notify(new LowStockNotification($lineItem->item_code));
                    }

                    AuditTrail::create([
                    'action' =>'Purchase Intent Raised : '. $lineItem->item_code,
                    'user_id' => 1
                    ]);

                    continue;
            }

            /*FULL STOCK AVAILABLE*/

            if ($inventory->available_quantity >=$lineItem->required_quantity) 
            {

                $lineItem->update(['inventory_status' =>'IN_STOCK'
                ]);

                $inventory->decrement('available_quantity',$lineItem->required_quantity);

                MaterialAllocation::create([

                    'bom_line_item_id' =>$lineItem->id,

                    'item_code' =>$lineItem->item_code,

                    'description' =>$lineItem->description,

                    'allocated_quantity' =>$lineItem->required_quantity,

                    'allocated_to' =>$lineItem->allocated_to,

                    'allocated_at' => now()
                ]);

                AuditTrail::create([

                    'action' =>'Material Allocated : '. $lineItem->item_code,
                    'user_id' => 1
                ]);
            }

            /*PARTIAL STOCK*/

            else 
            {

                $lineItem->update([

                'inventory_status' =>'PARTIAL_STOCK'
                ]);

                $availableQty = $inventory->available_quantity;

                $shortfall = $lineItem->required_quantity -$availableQty;

                MaterialAllocation::create([

                    'bom_line_item_id' => $lineItem->id,

                    'item_code' => $lineItem->item_code,

                    'description' => $lineItem->description,

                    'allocated_quantity' => $availableQty,

                    'allocated_to' => $lineItem->allocated_to,

                    'allocated_at' => now()
                ]);

                AuditTrail::create([

                    'action' =>'Partial Material Allocation : '. $lineItem->item_code,
                    'user_id' => 1
                ]);

                PurchaseIntent::create([

                    'purchase_intent_batch_id' =>$batch->id,

                    'item_code' =>$lineItem->item_code,

                    'description' =>$lineItem->description,

                    'specification' =>$lineItem->specification,

                    'required_quantity' =>$lineItem->required_quantity,

                    'available_quantity' =>$availableQty,

                    'shortfall_quantity' =>$shortfall,

                    'status' => 'Pending',

                    'date_raised' => now()
                ]);

                AuditTrail::create([

                    'action' =>'Shortfall Purchase Intent Raised : '. $lineItem->item_code,
                    'user_id' => 1
                ]);

                $inventory->update([

                    'available_quantity' => 0
                ]);
            }
        }
    }
}