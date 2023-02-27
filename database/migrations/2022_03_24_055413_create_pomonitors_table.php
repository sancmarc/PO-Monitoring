<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePomonitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pomonitors', function (Blueprint $table) {
            $table->id();
            $table->string('received_date');
            $table->string('model');
            $table->string('p_n');
            $table->string('po_no');
            $table->string('unit_price');
            $table->integer('po_qty');
            $table->integer('balance_po');
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
        Schema::dropIfExists('pomonitors');
    }
}
