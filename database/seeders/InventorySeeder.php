<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        Inventory::create([
            'item_code' => 'MTR-001',
            'description' => 'Steel Rod',
            'available_quantity' => 500,
            'uom' => 'PCS',
            'location' => 'Warehouse A'
        ]);

        Inventory::create([
            'item_code' => 'MTR-002',
            'description' => 'Copper Wire',
            'available_quantity' => 20,
            'uom' => 'ROLL',
            'location' => 'Warehouse B'
        ]);

        Inventory::create([
            'item_code' => 'MTR-003',
            'description' => 'PVC Pipe',
            'available_quantity' => 0,
            'uom' => 'PCS',
            'location' => 'Warehouse C'
        ]);

        Inventory::create([
            'item_code' => 'MTR-004',
            'description' => 'Aluminium Sheet',
            'available_quantity' => 150,
            'uom' => 'SHEET',
            'location' => 'Warehouse A'
        ]);
    }
}
