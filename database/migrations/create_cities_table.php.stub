<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Vermaysha\Wilayah\Models\City;
use Vermaysha\Wilayah\Models\Province;

return new class extends Migration
{
    public function up()
    {
        Schema::create($this->tableName(), function (Blueprint $table) {
            $table->id();
            $table->char('code', 4)->unique();
            $table->char('province_code', 2);
            $table->string('name');
            $table->timestamps();

            $table->foreign('province_code')->references('code')->on((new Province())->getTable());
        });
    }

    private function tableName(): string
    {
        return (new City())->getTable();
    }
};
