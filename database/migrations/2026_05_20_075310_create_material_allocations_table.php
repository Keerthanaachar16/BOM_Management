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
    Schema::create('material_allocations', function (Blueprint $table) {

        $table->id();

        $table->foreignId('bom_line_item_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->string('item_code');

        $table->string('description');

        $table->decimal('allocated_quantity', 12, 2);

        $table->string('allocated_to');

        $table->string('allocated_by')
            ->default('SYSTEM_AUTO');

        $table->timestamp('allocated_at');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_allocations');
    }
};
