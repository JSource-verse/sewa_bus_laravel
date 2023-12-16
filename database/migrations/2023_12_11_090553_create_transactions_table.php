<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bus_id');
            $table->unsignedBigInteger('user_id');
            $table->string('tanggal_checkin');
            $table->string('tanggal_checkout');
            $table->string('durasi_sewa');
            $table->string('tujuan');
            $table->string('penjemputan');
            $table->string('bukti_pembayaran');
            $table->text('keterangan');
            $table->enum('status', ['menunggu persetujuan', 'sudah disetujui'])->default('menunggu persetujuan');
            $table->string('total');
            $table->timestamps();

            $table->foreign('bus_id')->on('buses')->references('id')->onDelete('cascade');
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
