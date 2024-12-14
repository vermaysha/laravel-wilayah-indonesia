<?php

namespace Vermaysha\Territory\Tests\Models;

use Vermaysha\Territory\Models\District;
use Vermaysha\Territory\Models\Province;
use Vermaysha\Territory\Models\Regency;
use Vermaysha\Territory\Models\Village;
use Vermaysha\Territory\Tests\TestCase;
use Vermaysha\Territory\Tests\Traits\ModelTestTrait;

class DistrictTest extends TestCase
{
    use ModelTestTrait;

    public function test_districts_cant_be_created()
    {
        $this->expectException(\Exception::class);
        District::create([]);
    }

    public function test_districts_cant_be_updated()
    {
        $this->expectException(\Exception::class);
        District::first()->update([]);
    }

    public function test_districts_cant_be_deleted()
    {
        $this->expectException(\Exception::class);
        District::first()->delete();
    }

    public function test_districts_cant_be_restored()
    {
        $this->expectException(\Exception::class);
        District::withTrashed()->first()->restore();
    }

    public function test_districts_cant_be_force_deleted()
    {
        $this->expectException(\Exception::class);
        District::withTrashed()->first()->forceDelete();
    }

    public function test_districts_can_be_found()
    {
        $regency = District::find(15);
        $this->assertInstanceOf(District::class, $regency);
    }

    public function test_districts_has_a_province()
    {
        $regency = District::with([
            'province',
        ])->find(15);
        $this->assertInstanceOf(Province::class, $regency->province);
    }

    public function test_districts_has_a_regency()
    {
        $regency = District::with([
            'regency',
        ])->find(15);
        $this->assertInstanceOf(Regency::class, $regency->regency);
    }

    public function test_districts_has_many_villages()
    {
        $regency = District::with([
            'villages',
        ])->find(15);
        $this->assertInstanceOf(Village::class, $regency->villages()->first());
    }
}
