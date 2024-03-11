<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceSpecificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_specifications', function (Blueprint $table) {

            $table->id();
            $table->string('maintenance_kinds_code')->nullable()->comment('символьный код элемента в таблице maintenance_kinds');
            $table->integer('vehicle_categories_id')->nullable()->comment('идентификатор записи в таблице Категории ТС');
            $table->integer('catalog_id')->nullable()->comment('идентификатор записи в таблице Каталог');
            $table->float('quantity')->nullable()->comment('нужное количество');
            $table->integer('units_id')->nullable()->comment('идентификатор записи в таблице Единицы измерения');
            $table->foreign('maintenance_kinds_code')->references('code')->on('maintenance_kinds')->restrictOnDelete();
            $table->foreign('vehicle_categories_id')->references('id')->on('vehicle_categories')->restrictOnDelete();
            $table->foreign('catalog_id')->references('id')->on('catalog')->restrictOnDelete();
            $table->foreign('units_id')->references('id')->on('units')->restrictOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->comment('регламенты обслуживания');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenance_specifications');
    }
}
