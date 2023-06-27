<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispatches', function (Blueprint $table) {
            $table->id();
            $table->integer('date');
            $table->integer('commodity_id');
            $table->integer('supplier_id');
            $table->string('purchase_code');
            $table->integer('exit_id');
            $table->string('release_code');
            $table->text('driver_instructions');
            $table->integer('via_id');
            $table->integer('destination_id')->nullable();
            $table->integer('rate_id');
            $table->integer('salesman');
            $table->string('sales_num');
            $table->text('sales_notes')->nullable();
            $table->text('accounting_notes')->nullable();
            $table->tinyInteger('noship')->default(0);
            $table->tinyInteger('void')->default(0);
            $table->tinyInteger('delivered')->default(0);
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
        Schema::dropIfExists('dispatches');
    }
};
