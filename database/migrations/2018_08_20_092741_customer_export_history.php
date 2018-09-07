<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerExportHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_export_history', function (Blueprint $table) {
            $table->increments('id');
            $table->string('customer_id');
            $table->string('vendor_code');
            $table->string('location');
            $table->string('database_type');
            $table->string('category');
            $table->string('from_count');
            $table->string('to_count');
            $table->string('export_count');
            $table->integer('temp_datas_id');
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
        Schema::dropIfExists('customer_export_history');
    }
}
