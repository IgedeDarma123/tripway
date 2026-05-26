<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->string('method'); // qris, bca, bni, mandiri, bri, gopay, ovo, dana, credit_card
            $table->string('name'); // Display name
            $table->string('account_number')->nullable(); // Account number/VA
            $table->string('account_name')->nullable(); // Account name
            $table->string('image')->nullable(); // QRIS image path
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_settings');
    }
};
