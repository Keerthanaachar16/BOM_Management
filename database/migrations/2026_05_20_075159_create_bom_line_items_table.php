<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('bom_line_items', function (Blueprint $table) {

        $table->id();

        $table->foreignId('bom_header_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->string('item_code');

        $table->string('part_number')->nullable();

        $table->string('description');

        $table->string('uom')->nullable();

        $table->decimal('required_quantity', 12, 2);

        $table->string('specification')->nullable();

        $table->string('allocated_to')->nullable();

        $table->enum('inventory_status', [
            'IN_STOCK',
            'PARTIAL_STOCK',
            'OUT_OF_STOCK'
        ])->default('OUT_OF_STOCK');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bom_line_items');
    }
};
