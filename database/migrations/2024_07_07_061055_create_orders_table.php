<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Relasi ke tabel users
            $table->foreignId('category_id')->constrained(); // Relasi ke tabel categories (jika ada)
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'processed', 'shipped', 'delivered'])->default('pending');
            $table->string('snap_token')->nullable(); // Token untuk pembayaran (jika menggunakan payment gateway)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
