<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->foreignId('province_id')->nullable()->after('address')->constrained();
            $table->foreignId('city_id')->nullable()->after('province_id')->constrained();
            $table->string('postal_code', 10)->nullable()->after('city_id');
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['province_id']);
            $table->dropForeign(['city_id']);
            $table->dropColumn(['province_id', 'city_id', 'postal_code']);
        });
    }
};