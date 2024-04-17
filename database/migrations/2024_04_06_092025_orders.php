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
        Schema::create('order', function (Blueprint $order) {
            $order->id();
            $order->unsignedBigInteger('table_number');
            $order
                ->foreign('table_number')
                ->references('number')
                ->on('table');
            $order->time('reserve_start');
            $order->time('reserve_end');
            $order->string('phone');
            $order->longText('wish')->nullable();
            $order->string('name');
            $order->integer('places');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
