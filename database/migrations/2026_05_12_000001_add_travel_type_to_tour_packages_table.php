<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tour_packages', function (Blueprint $table) {
            // private = hanya bisa private, sharing = hanya bisa sharing, both = bisa keduanya
            $table->enum('travel_type', ['private', 'sharing', 'both'])->default('both')->after('sort_order');
        });
    }

    public function down(): void
    {
        Schema::table('tour_packages', function (Blueprint $table) {
            $table->dropColumn('travel_type');
        });
    }
};
