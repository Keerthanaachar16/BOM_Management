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
    Schema::create('inventories', function (Blueprint $table) {

        $table->id();

        $table->string('item_code')->unique();

        $table->string('description');

        $table->decimal('available_quantity', 12, 2)
            ->default(0);

        $table->string('uom')->nullable();

        $table->string('location')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
