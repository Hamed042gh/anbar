<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variant_id')->constrained('product_variants');
            $table->foreignId('warehouse_id')->constrained();
            $table->foreignId('location_id')->nullable()->constrained('warehouse_locations')->nullOnDelete();
            $table->foreignId('user_id')->constrained();
            $table->enum('type', [
                'purchase',     // خرید
                'sale',         // فروش
                'transfer_in',  // انتقال ورودی
                'transfer_out', // انتقال خروجی
                'adjustment',   // تعدیل
                'return_in',    // مرجوعی ورودی
                'return_out',   // مرجوعی خروجی
            ]);
            $table->decimal('quantity', 15, 3);  // مثبت = ورود، منفی = خروج
            $table->decimal('unit_cost', 15, 2)->default(0);
            $table->morphs('referenceable'); // پلی‌مورفیک به invoice یا purchase_receipt
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
