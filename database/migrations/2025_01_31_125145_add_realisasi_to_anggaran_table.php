<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('anggaran', function (Blueprint $table) {
        $table->boolean('realisasi')->default(0)->after('jumlah');
    });
}

public function down()
{
    Schema::table('anggaran', function (Blueprint $table) {
        $table->dropColumn('realisasi');
    });
}

};
