<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('postcode', 20);
            $table->foreignId('prefecture_id')->constrained();
            $table->string('address1');
            $table->string('address2');
            $table->string('address3')->nullable();
            $table->string('tel', 20);
            $table->unsignedInteger('shipping_fee');
            $table->unsignedInteger('total_price');
            $table->unsignedTinyInteger('status')->default(0);
            $table->unsignedTinyInteger('pay_method');
            $table->datetime('created_at')->useCurrent();
            $table->datetime('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
