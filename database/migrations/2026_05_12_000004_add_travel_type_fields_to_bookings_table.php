<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // private atau sharing
            $table->enum('travel_type', ['private', 'sharing'])->default('private')->after('package_type');

            // untuk private: FK ke tour_package_groups yang dipilih
            $table->foreignId('group_option_id')->nullable()->constrained('tour_package_groups')->onDelete('set null')->after('travel_type');

            // untuk sharing: jumlah orang yang ikut
            $table->integer('num_persons')->default(1)->after('group_option_id');

            // untuk sharing: add-on yang dipilih (simpan sebagai JSON array of addon IDs)
            $table->json('addon_ids')->nullable()->after('num_persons');

            // total harga add-on (untuk kemudahan kalkulasi)
            $table->decimal('addon_price', 12, 2)->default(0)->after('addon_ids');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['group_option_id']);
            $table->dropColumn(['travel_type', 'group_option_id', 'num_persons', 'addon_ids', 'addon_price']);
        });
    }
};
