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
        Schema::table('penjualan_details', function (Blueprint $table) {
            $table->decimal('diskon', 10, 2)->default(0)->after('jumlah');
        });
    }

    public function down()
    {
        Schema::table('penjualan_details', function (Blueprint $table) {
            $table->dropColumn('diskon');
        });
    }
};
