<?php

namespace Vermaysha\Territory\Tests\Models;

use Vermaysha\Territory\Models\District;
use Vermaysha\Territory\Models\Province;
use Vermaysha\Territory\Models\Regency;
use Vermaysha\Territory\Tests\TestCase;
use Vermaysha\Territory\Tests\Traits\ModelTestTrait;

class RegencyTest extends TestCase
{
    use ModelTestTrait;

    public function test_regencies_cant_be_created()
    {
        $this->expectException(\Exception::class);
        Regency::create([]);
    }

    public function test_regencies_cant_be_updated()
    {
        $this->expectException(\Exception::class);
        Regency::first()->update([]);
    }

    public function test_regencies_cant_be_deleted()
    {
        $this->expectException(\Exception::class);
        Regency::first()->delete();
    }

    public function test_regencies_cant_be_restored()
    {
        $this->expectException(\Exception::class);
        Regency::withTrashed()->first()->restore();
    }

    public function test_regencies_cant_be_force_deleted()
    {
        $this->expectException(\Exception::class);
        Regency::withTrashed()->first()->forceDelete();
    }

    public function test_regencies_can_be_found()
    {
        $regency = Regency::find(13);
        $this->assertInstanceOf(Regency::class, $regency);
    }

    public function test_regencies_has_a_province()
    {
        $regency = Regency::with([
            'province',
        ])->find(13);
        $this->assertInstanceOf(Province::class, $regency->province);
    }

    public function test_regencies_has_many_districts()
    {
        $regency = Regency::with([
            'districts',
        ])->find(13);
        $this->assertInstanceOf(District::class, $regency->districts()->first());
    }
}
