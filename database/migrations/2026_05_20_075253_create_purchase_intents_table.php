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
    Schema::create('purchase_intents', function (Blueprint $table) {

        $table->id();

        $table->foreignId('purchase_intent_batch_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->string('item_code');

        $table->string('description');

        $table->string('specification')->nullable();

        $table->decimal('required_quantity', 12, 2);

        $table->decimal('available_quantity', 12, 2);

        $table->decimal('shortfall_quantity', 12, 2);

        $table->enum('status', [
            'PENDING',
            'ACKNOWLEDGED',
            'PO_RAISED'
        ])->default('PENDING');

        $table->date('date_raised');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_intents');
    }
};
