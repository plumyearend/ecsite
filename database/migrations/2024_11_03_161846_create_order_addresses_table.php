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
        Schema::create('order_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('postcode', 20);
            $table->foreignId('prefecture_id')->constrained();
            $table->string('address1');
            $table->string('address2');
            $table->string('address3')->nullable();
            $table->string('tel', 20);
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_prefecture_id_foreign');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('postcode');
            $table->dropColumn('prefecture_id');
            $table->dropColumn('address1');
            $table->dropColumn('address2');
            $table->dropColumn('address3');
            $table->dropColumn('tel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_addresses');
        Schema::table('orders', function (Blueprint $table) {
            $table->string('first_name')->after('user_id');
            $table->string('last_name')->after('first_name');
            $table->string('postcode', 20)->after('last_name');
            $table->foreignId('prefecture_id')->constrained()->after('postcode');
            $table->string('address1')->after('prefecture_id');
            $table->string('address2')->after('address1');
            $table->string('address3')->nullable()->after('address2');
            $table->string('tel', 20)->after('address3');
        });
    }
};
