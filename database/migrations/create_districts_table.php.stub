<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Vermaysha\Wilayah\Models\City;
use Vermaysha\Wilayah\Models\District;

return new class extends Migration
{
    public function up()
    {
        Schema::create($this->tableName(), function (Blueprint $table) {
            $table->id();
            $table->char('code', 6)->unique();
            $table->char('city_code', 4);
            $table->string('name');
            $table->timestamps();

            $table->foreign('city_code')->references('code')->on((new City)->getTable());
        });
    }

    private function tableName(): string
    {
        return (new District())->getTable();
    }
};
