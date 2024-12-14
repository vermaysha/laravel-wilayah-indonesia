<?php

namespace Vermaysha\Territory\Tests;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Vermaysha\Territory\Facade\Territory;
use Vermaysha\Territory\Models\District;
use Vermaysha\Territory\Models\Province;
use Vermaysha\Territory\Models\Regency;
use Vermaysha\Territory\Models\Village;

class FacadeTest extends TestCase
{
    use Traits\ModelTestTrait;

    public function test_find_by_zip_code()
    {
        $result = Territory::findByZipCode(57752);
        $this->assertInstanceOf(Village::class, $result);
    }

    public function test_find_province()
    {
        $result = Territory::findProvince(33);

        $this->assertInstanceOf(Province::class, $result);
    }

    public function test_find_regency()
    {
        $result = Territory::findRegency(13, 33);

        $this->assertInstanceOf(Regency::class, $result);
    }

    public function test_find_district()
    {
        $result = Territory::findDistrict(15, 13, 33);

        $this->assertInstanceOf(District::class, $result);
    }

    public function test_find_village()
    {
        $result = Territory::findVillage(2002, 15, 13, 33);

        $this->assertInstanceOf(Village::class, $result);
    }

    public function test_province_search()
    {
        $result = Territory::provinces('jawa');

        $this->assertNotEmpty($result);
        $this->assertInstanceOf(Province::class, $result->first());
    }

    public function test_regency_search()
    {
        $result = Territory::regencies(33, 'a');

        $this->assertNotEmpty($result);
        $this->assertInstanceOf(Regency::class, $result->first());
    }

    public function test_district_search()
    {
        $result = Territory::districts(33, 13, 'mojo');

        $this->assertNotEmpty($result);
        $this->assertInstanceOf(District::class, $result->first());
    }

    public function test_village_search()
    {
        $result = Territory::villages(33, 13, 15, 'gedang');

        $this->assertNotEmpty($result);
        $this->assertInstanceOf(Village::class, $result->first());
    }

    public function test_province_structure()
    {
        $province = Territory::provinces();

        $this->assertIsIterable($province);
        $this->assertInstanceOf(Province::class, $province->first());
    }

    public function test_regency_should_be_collection()
    {
        $data = Territory::regencies();

        $this->assertIsIterable($data);
        $this->assertInstanceOf(Regency::class, $data->first());
    }

    public function test_regency_should_be_pagination()
    {
        $data = Territory::regencies(pagination: 1);

        $this->assertInstanceOf(LengthAwarePaginator::class, $data);
    }

    public function test_district_should_be_collection()
    {
        $data = Territory::districts();

        $this->assertIsIterable($data);
        $this->assertInstanceOf(District::class, $data->first());
    }

    public function test_district_should_be_pagination()
    {
        $data = Territory::districts(pagination: 1);

        $this->assertInstanceOf(LengthAwarePaginator::class, $data);
    }

    public function test_village_should_be_collection()
    {
        $data = Territory::villages();

        $this->assertIsIterable($data);
        $this->assertInstanceOf(Village::class, $data->first());
    }

    public function test_village_should_be_pagination()
    {
        $data = Territory::villages(pagination: 1);

        $this->assertInstanceOf(LengthAwarePaginator::class, $data);
    }
}
