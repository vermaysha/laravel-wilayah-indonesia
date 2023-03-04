<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Vermaysha\Wilayah\Models\District;
use Vermaysha\Wilayah\Models\Village;

return new class extends Migration
{
    public function up()
    {
        Schema::create($this->tableName(), function (Blueprint $table) {
            $table->id();
            $table->char('code', 10)->unique();
            $table->char('district_code', 6);
            $table->string('name');
            $table->timestamps();

            $table->foreign('district_code')->references('code')->on((new District)->getTable());
        });
    }

    private function tableName(): string
    {
        return (new Village())->getTable();
    }
};
