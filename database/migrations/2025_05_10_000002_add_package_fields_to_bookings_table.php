<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('package_id')->nullable()->constrained('tour_packages')->onDelete('set null')->after('tour_id');
            $table->string('package_type')->default('private')->after('package_id'); // private, shared
            $table->integer('quantity')->default(1)->after('package_type');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['package_id']);
            $table->dropColumn(['package_id', 'package_type', 'quantity']);
        });
    }
};
