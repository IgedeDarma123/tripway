<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('snap_token')->nullable()->after('total_price');
            $table->string('payment_status')->nullable()->after('snap_token');
            $table->string('payment_type')->nullable()->after('payment_status');
            $table->string('order_id')->nullable()->after('payment_type');
            $table->string('pdf_url')->nullable()->after('order_id');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['snap_token', 'payment_status', 'payment_type', 'order_id', 'pdf_url']);
        });
    }
};

