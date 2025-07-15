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
        Schema::create('t_surat', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat', 100);
            $table->date('tanggal_surat');
            $table->string('pengirim', 150);
            $table->string('penerima', 150);
            $table->unsignedBigInteger('fk_m_jenis_surat');
            $table->unsignedBigInteger('fk_m_user')->nullable();

            $table->tinyInteger('isDeleted')->default(0)->index();
            $table->string('created_by', 30)->default('None');
            $table->timestamp('created_at')->useCurrent();
            $table->string('updated_by', 30)->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('deleted_by', 30)->nullable();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('fk_m_jenis_surat')
                ->references('id')
                ->on('m_jenis_surat')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('fk_m_user')
                ->references('id')
                ->on('m_user')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_surat');
    }
};
