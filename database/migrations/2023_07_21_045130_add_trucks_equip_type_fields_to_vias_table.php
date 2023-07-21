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
        Schema::table('vias', function (Blueprint $table) {
            $table->after('phone', function (Blueprint $table) {
                $table->integer('trucks')->nullable();
                $table->json('equip_type')->nullable();
                $table->json('service_area')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vias', function (Blueprint $table) {
            $table->removeColumn('trucks');
            $table->removeColumn('equip_type');
            $table->removeColumn('service_area');
        });
    }
};
