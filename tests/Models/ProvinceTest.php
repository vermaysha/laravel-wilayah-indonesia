<?php

namespace Vermaysha\Territory\Tests\Models;

use Vermaysha\Territory\Models\District;
use Vermaysha\Territory\Models\Province;
use Vermaysha\Territory\Models\Regency;
use Vermaysha\Territory\Models\Village;
use Vermaysha\Territory\Tests\TestCase;
use Vermaysha\Territory\Tests\Traits\ModelTestTrait;

class ProvinceTest extends TestCase
{
    use ModelTestTrait;

    public function test_provinces_cant_be_created()
    {
        $this->expectException(\Exception::class);
        Province::create([
            'province_code' => '34',
            'province_name' => 'Jawa Timur',
        ]);
    }

    public function test_provinces_cant_be_updated()
    {
        $this->expectException(\Exception::class);
        Province::first()->update([
            'province_code' => '34',
            'province_name' => 'Jawa Timur',
        ]);
    }

    public function test_provinces_cant_be_deleted()
    {
        $this->expectException(\Exception::class);
        Province::first()->delete();
    }

    public function test_provinces_cant_be_restored()
    {
        $this->expectException(\Exception::class);
        Province::withTrashed()->first()->restore();
    }

    public function test_provinces_cant_be_force_deleted()
    {
        $this->expectException(\Exception::class);
        Province::withTrashed()->first()->forceDelete();
    }

    public function test_provinces_can_be_found()
    {
        $province = Province::find(33);
        $this->assertInstanceOf(Province::class, $province);
    }

    public function test_provinces_has_many_regencies()
    {
        $province = Province::find(33);
        $this->assertInstanceOf(Regency::class, $province->regencies()->first());
    }

    public function test_provinces_has_many_districts()
    {
        $province = Province::with([
            'districts',
        ])->find(33);
        $this->assertInstanceOf(District::class, $province->districts()->first());
    }

    public function test_provinces_has_many_villages()
    {
        $province = Province::with([
            'villages',
        ])->find(33);
        $this->assertInstanceOf(Village::class, $province->villages()->first());
    }
}
