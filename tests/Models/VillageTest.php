<?php

namespace Vermaysha\Territory\Tests\Models;

use Vermaysha\Territory\Models\District;
use Vermaysha\Territory\Models\Province;
use Vermaysha\Territory\Models\Regency;
use Vermaysha\Territory\Models\Village;
use Vermaysha\Territory\Tests\TestCase;
use Vermaysha\Territory\Tests\Traits\ModelTestTrait;

class VillageTest extends TestCase
{
    use ModelTestTrait;

    public function test_villages_cant_be_created()
    {
        $this->expectException(\Exception::class);
        District::create([]);
    }

    public function test_villages_cant_be_updated()
    {
        $this->expectException(\Exception::class);
        Village::first()->update([]);
    }

    public function test_villages_cant_be_deleted()
    {
        $this->expectException(\Exception::class);
        Village::first()->delete();
    }

    public function test_villages_cant_be_restored()
    {
        $this->expectException(\Exception::class);
        Village::withTrashed()->first()->restore();
    }

    public function test_villages_cant_be_force_deleted()
    {
        $this->expectException(\Exception::class);
        Village::withTrashed()->first()->forceDelete();
    }

    public function test_villages_can_be_found()
    {
        $regency = Village::find(2002);
        $this->assertInstanceOf(Village::class, $regency);
    }

    public function test_villages_has_a_province()
    {
        $regency = Village::with([
            'province',
        ])->find(2002);
        $this->assertInstanceOf(Province::class, $regency->province);
    }

    public function test_villages_has_a_regency()
    {
        $regency = Village::with([
            'regency',
        ])->find(2002);
        $this->assertInstanceOf(Regency::class, $regency->regency);
    }

    public function test_villages_has_a_district()
    {
        $regency = Village::with([
            'district',
        ])->find(2002);
        $this->assertInstanceOf(District::class, $regency->district);
    }
}
