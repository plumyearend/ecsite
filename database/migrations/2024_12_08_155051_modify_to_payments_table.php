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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('stripe_intent_id')->nullable()->comment('stripeでの支払いID')->after('method');
            $table->string('stripe_method_id')->nullable()->comment('stripeでの支払い方法ID')->after('stripe_intent_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('stripe_intent_id');
            $table->dropColumn('stripe_method_id');
        });
    }
};
