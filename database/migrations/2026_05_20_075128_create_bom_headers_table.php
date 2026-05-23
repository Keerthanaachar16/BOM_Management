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
    Schema::create('bom_headers', function (Blueprint $table) {

        $table->id();

        $table->foreignId('project_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->string('bom_number')->unique();

        $table->string('version');

        $table->string('uploaded_file');

        $table->timestamp('uploaded_at');

        $table->foreignId('uploaded_by')
            ->constrained('users');

        $table->boolean('is_locked')->default(true);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bom_headers');
    }
};
