<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceKindsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_kinds', function (Blueprint $table) {

            $table->id();
            $table->string('code')->unique()->comment('Символьный код');
            $table->string('description')->nullable()->comment('Описание');
            $table->timestamps();
            $table->softDeletes();
            $table->comment('Виды технических обслуживаний');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenance_kinds');
    }
}
