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
        Schema::table('employees', function (Blueprint $table) {
            $table->string('no_sip')->nullable()->after('jenis_pegawai');
            $table->date('tanggal_terbit')->nullable()->after('no_sip');
            $table->date('tanggal_kadaluwarsa')->nullable()->after('tanggal_terbit');
            $table->string('email')->nullable()->after('tanggal_kadaluwarsa');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['no_sip', 'tanggal_terbit', 'tanggal_kadaluwarsa', 'email']);
        });
    }
};
