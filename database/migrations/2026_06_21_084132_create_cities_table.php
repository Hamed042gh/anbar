<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();

            $table->string('name', 30)
                ->charset('utf8mb4')
                ->collation('utf8mb4_persian_ci');

            $table->string('slug_en', 30)
                ->charset('utf8mb4')
                ->collation('utf8mb4_general_ci')
                ->nullable();

            $table->string('slug_fa', 30)
                ->charset('utf8mb3')
                ->collation('utf8mb3_general_ci');

            $table->string('province_id', 4)
                ->charset('utf8mb4')
                ->collation('utf8mb4_general_ci');

            $table->boolean('is_active')->default(true);
            $table->boolean('active_for_order')->default(true);

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();

            $table->boolean('deleted')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};