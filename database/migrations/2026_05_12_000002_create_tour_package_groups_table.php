<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_package_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_package_id')->constrained('tour_packages')->onDelete('cascade');
            $table->integer('group_size');           // jumlah orang: 2, 4, 6
            $table->string('label');                 // "Paket 6 Orang", "Paket 4 Orang", dst
            $table->decimal('price', 12, 2);         // harga total untuk grup ini (bukan per orang)
            $table->decimal('original_price', 12, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_package_groups');
    }
};
