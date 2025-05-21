<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

//php artisan migrate --path=database/migrations/2025_05_21_103000_create_geo_structure.php
return new class extends Migration {
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('name', 100)->unique()->collation('utf8mb4_general_ci');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE countries COMMENT = 'страны | государства'");

        Schema::create('zones', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->foreignId('country_id')->constrained('countries')->restrictOnDelete()->restrictOnUpdate();
            $table->string('name', 100)->collation('utf8mb4_general_ci');
            $table->string('short_name', 100)->collation('utf8mb4_general_ci');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['country_id', 'name'], 'zones_unique');
        });
        DB::statement("ALTER TABLE zones COMMENT = 'территориальные зоны | федеральные округа'");

        Schema::create('provinces', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->foreignId('country_id')->constrained('countries')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('zone_id')->nullable()->constrained('zones')->restrictOnDelete()->restrictOnUpdate();
            $table->string('name', 100)->collation('utf8mb4_general_ci');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['country_id', 'name'], 'provinces_unique');
        });
        DB::statement("ALTER TABLE provinces COMMENT = 'региональные субъекты | провинции'");

        Schema::create('districts', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->foreignId('province_id')->constrained('provinces')->restrictOnDelete()->restrictOnUpdate();
            $table->string('name', 100)->collation('utf8mb4_general_ci');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['province_id', 'name'], 'districts_unique');
        });
        DB::statement("ALTER TABLE districts COMMENT = 'муниципалитеты | сельские округа | сельсоветы\n(служат для уникализации населённых пунктов)'");

        Schema::create('settlement_types', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('name', 100)->collation('utf8mb4_general_ci')->unique();
            $table->string('short_name', 100)->collation('utf8mb4_general_ci');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE settlement_types COMMENT = 'типы населённых пунктов'");

        Schema::create('settlements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('district_id')->constrained('districts')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('settlement_type_id')->constrained('settlement_types')->restrictOnDelete()->restrictOnUpdate();        
            $table->unsignedBigInteger('price_category')->comment('идентификатор категории цен');
            $table->foreign('price_category')->references('id')->on('regions')->restrictOnDelete()->restrictOnUpdate();        
            $table->foreignId('declination_id')->constrained('declinations')->restrictOnDelete()->restrictOnUpdate();        
            $table->string('ohrana_slug', 100)->nullable();
            $table->string('name', 100);
            $table->unsignedInteger('population');
            $table->decimal('latitude', 9, 6)->comment('широта');
            $table->decimal('longitude', 9, 6)->comment('долгота');        
            $table->timestamps();
            $table->softDeletes();        
            $table->unique(['district_id', 'settlement_type_id', 'name'], 'settlements_unique');
        });
        DB::statement("ALTER TABLE `settlements` COMMENT = 'населённые пункты'");

        Schema::create('settlement_divisions', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->foreignId('settlement_id')->constrained('settlements')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('declination_id')->nullable()->constrained('declinations')->restrictOnDelete()->restrictOnUpdate();
            $table->string('slug', 100)->nullable();
            $table->string('name', 100)->collation('utf8mb4_general_ci');
            $table->string('short_name', 100)->collation('utf8mb4_general_ci');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['settlement_id', 'name'], 'settlement_divisions_unique');
        });
        DB::statement("ALTER TABLE settlement_divisions COMMENT = 'внутригородские округа'");

        Schema::create('settlement_sectors', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->foreignId('settlement_id')->constrained('settlements')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('settlement_division_id')->nullable()->constrained('settlement_divisions')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('declination_id')->nullable()->constrained('declinations')->restrictOnDelete()->restrictOnUpdate();
            $table->string('slug', 100)->nullable();
            $table->string('name', 100)->collation('utf8mb4_general_ci');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['settlement_id', 'settlement_division_id', 'name'], 'settlement_sectors_unique');
        });
        DB::statement("ALTER TABLE settlement_sectors COMMENT = 'внутригородские районы'");
    }

    public function down(): void
    {
        Schema::dropIfExists('settlement_sectors');
        Schema::dropIfExists('settlement_divisions');
        Schema::dropIfExists('settlements');
        Schema::dropIfExists('settlement_types');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('zones');
        Schema::dropIfExists('countries');
    }
};
//php artisan migrate --path=database/migrations/2025_05_21_103000_create_geo_structure.php
