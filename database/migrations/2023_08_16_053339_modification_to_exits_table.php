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
        Schema::table('exits', function (Blueprint $table) {
            $table->after('name', function (Blueprint $table) {
                $table->string('address')->nullable();
                $table->string('note')->nullable();
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
        Schema::table('exits', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('note');
        });
    }
};
