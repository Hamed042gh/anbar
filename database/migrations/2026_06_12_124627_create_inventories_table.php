<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variant_id')->constrained('product_variants');
            $table->foreignId('warehouse_id')->constrained();
            $table->foreignId('location_id')->nullable()->constrained('warehouse_locations')->nullOnDelete();
            $table->decimal('quantity', 15, 3)->default(0);
            $table->decimal('avg_cost', 15, 2)->default(0); // میانگین موزون
            $table->timestamps();

            $table->unique(['variant_id', 'warehouse_id', 'location_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
