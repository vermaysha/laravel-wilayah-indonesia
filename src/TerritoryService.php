<?php

namespace Vermaysha\Territory;

use Illuminate\Cache\CacheManager;
use Illuminate\Cache\Repository;
use Vermaysha\Territory\Models\District;
use Vermaysha\Territory\Models\Province;
use Vermaysha\Territory\Models\Regency;
use Vermaysha\Territory\Models\Village;

class TerritoryService
{
    protected Repository $cache;

    protected string $cachePrefix;

    protected \DateInterval $cacheExpiration;

    /**
     * Initialize the TerritoryService with caching configurations.
     *
     * @param  CacheManager  $cacheManager  The cache manager instance for handling caching operations.
     */
    public function __construct(CacheManager $cacheManager)
    {
        $this->cache = $this->getCacheStoreFromConfig($cacheManager);
        $this->cachePrefix = config('territory.cache.prefix', 'territory');
        $this->cacheExpiration = config('territory.cache.expiration_time', \DateInterval::createFromDateString('7 days'));
    }

    /**
     * Return the cache store based on the configuration specified in the package's config file.
     *
     * The method will return the cache store specified in the config file or the default cache store.
     * If the specified cache store is not defined in the cache.php config file, it will fallback to the 'array' cache store.
     */
    protected function getCacheStoreFromConfig(CacheManager $cacheManager): Repository
    {
        // the 'default' fallback here is from the permission.php config file,
        // where 'default' means to use config(cache.default)
        $cacheDriver = config('permission.cache.store', 'default');

        // when 'default' is specified, no action is required since we already have the default instance
        if ($cacheDriver === 'default') {
            return $cacheManager->store();
        }

        // if an undefined cache store is specified, fallback to 'array' which is Laravel's closest equiv to 'none'
        if (! \array_key_exists($cacheDriver, config('cache.stores'))) {
            $cacheDriver = 'array';
        }

        return $cacheManager->store($cacheDriver);
    }

    /**
     * Find a full address by zip code.
     *
     * @return Village|null
     */
    public function findByZipCode(string|int $zipCode)
    {
        return $this->cache->remember(
            $this->cachePrefix . ':find_by_zip_code:' . $zipCode,
            $this->cacheExpiration,
            fn() => Village::with([
                'province',
                'regency',
                'district',
            ])
                ->where('zip_code', $zipCode)
                ->first()
        );
    }

    /**
     * Find a province by its code.
     *
     * @return Province|null
     */
    public function findProvince(string|int $provinceCode)
    {
        return $this->cache->remember(
            $this->cachePrefix . ':find_province:' . $provinceCode,
            $this->cacheExpiration,
            fn() => Province::where('province_code', $provinceCode)->first()
        );
    }

    /**
     * Find a regency by its code.
     *
     * @return Regency|null
     */
    public function findRegency(string|int $regencyCode, string|int|null $provinceCode = null)
    {
        return $this->cache->remember(
            $this->cachePrefix . ':find_regency:' . $regencyCode . ':' . $provinceCode,
            $this->cacheExpiration,
            fn() => Regency::where('regency_code', $regencyCode)
                ->when($provinceCode, function ($query) use ($provinceCode) {
                    $query->where('province_code', $provinceCode);
                })->first(),
        );
    }

    /**
     * Find a district by its code.
     *
     * @return District|null
     */
    public function findDistrict(string|int $districtCode, string|int|null $regencyCode = null, string|int|null $provinceCode = null)
    {
        return $this->cache->remember(
            $this->cachePrefix . ':find_district:' . $districtCode . ':' . $regencyCode . ':' . $provinceCode,
            $this->cacheExpiration,
            fn() => District::where('district_code', $districtCode)
                ->when($regencyCode, function ($query) use ($regencyCode) {
                    $query->where('regency_code', $regencyCode);
                })
                ->when($provinceCode, function ($query) use ($provinceCode) {
                    $query->where('province_code', $provinceCode);
                })->first()
        );
    }

    /**
     * Find a village by its code.
     *
     * @return Village|null
     */
    public function findVillage(string|int $villageCode, string|int|null $districtCode = null, string|int|null $regencyCode = null, string|int|null $provinceCode = null)
    {
        return $this->cache->remember(
            $this->cachePrefix . ':find_village:' . $villageCode . ':' . $districtCode . ':' . $regencyCode . ':' . $provinceCode,
            $this->cacheExpiration,
            fn() => Village::where('village_code', $villageCode)
                ->when($districtCode, function ($query) use ($districtCode) {
                    $query->where('district_code', $districtCode);
                })
                ->when($regencyCode, function ($query) use ($regencyCode) {
                    $query->where('regency_code', $regencyCode);
                })
                ->when($provinceCode, function ($query) use ($provinceCode) {
                    $query->where('province_code', $provinceCode);
                })->first()
        );
    }

    /**
     * Retrieve a list of provinces.
     *
     * @param  string|null  $name  The name of the province to search for. If null, all provinces will be returned.
     * @param  int|null  $pagination  The number of items per page. If null, all items will be returned.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function provinces(?string $name = null, ?int $pagination = null)
    {
        // Cache the result to avoid duplicate database queries
        return $this->cache->remember(
            $this->cachePrefix . ':provinces:' . $name . ':' . $pagination,
            $this->cacheExpiration,
            function () use ($name, $pagination) {
                // Build the query to retrieve the provinces
                $result = Province::when($name, function ($query) use ($name) {
                    // If a name is provided, filter the results by the name
                    if (method_exists($query, 'whereLike')) {
                        $query->whereLike('province_name', "%{$name}%");
                    } else {
                        $query->where('province_name', 'like', "%{$name}%");
                    }
                });

                // If pagination is required, paginate the result
                $collection = $pagination ? $result->paginate($pagination) : $result->get();

                // Otherwise, return all the results
                return $collection;
            }
        );
    }

    /**
     * Retrieve a list of regencies, optionally filtered by province code and name.
     *
     * @param  string|int|null  $provinceCode  The code of the province to filter regencies by. If null, regencies from all provinces are included.
     * @param  string|null  $name  The name of the regency to search for. If null, all regencies are included.
     * @param  int|null  $pagination  The number of items per page. If null, all items are returned.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function regencies(string|int|null $provinceCode = null, ?string $name = null, ?int $pagination = null)
    {
        return $this->cache->remember(
            $this->cachePrefix . ':regencies:' . $provinceCode . ':' . $name . ':' . $pagination,
            $this->cacheExpiration,
            function () use ($provinceCode, $name, $pagination) {
                $result = Regency::with([
                    'province' => function ($query) {
                    },
                ])->when($provinceCode, function ($query) use ($provinceCode) {
                    $query->where('province_code', $provinceCode);
                })
                    ->when($name, function ($query) use ($name) {
                        if (method_exists($query, 'whereLike')) {
                            $query->whereLike('regency_name', "%{$name}%");
                        } else {
                            $query->where('regency_name', 'like', "%{$name}%");
                        }
                    });


                $collection = $pagination ? $result->paginate($pagination) : $result->get();
                return $collection;
            }
        );
    }

    /**
     * Retrieve a list of districts, optionally filtered by province code, regency code, and name.
     *
     * @param  string|int|null  $provinceCode  The code of the province to filter districts by.
     *                                         If null, districts from all provinces are included.
     * @param  string|int|null  $regencyCode  The code of the regency to filter districts by.
     *                                        If null, districts from all regencies are included.
     * @param  string|null  $name  The name of the district to search for. If null, all districts are included.
     * @param  int|null  $pagination  The number of items per page. If null, all items are returned.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function districts(string|int|null $provinceCode = null, string|int|null $regencyCode = null, ?string $name = null, ?int $pagination = null)
    {
        return $this->cache->remember(
            $this->cachePrefix . ':districts:' . $provinceCode . ':' . $regencyCode . ':' . $name . ':' . $pagination,
            $this->cacheExpiration,
            function () use ($provinceCode, $regencyCode, $name, $pagination) {
                $result = District::when($provinceCode, function ($query) use ($provinceCode) {
                    $query->where('province_code', $provinceCode);
                })
                    ->when($regencyCode, function ($query) use ($regencyCode) {
                        $query->where('regency_code', $regencyCode);
                    })
                    ->when($name, function ($query) use ($name) {
                        if (method_exists($query, 'whereLike')) {
                            $query->whereLike('district_name', "%{$name}%");
                        } else {
                            $query->where('district_name', 'like', "%{$name}%");
                        }
                    });

                $collection = $pagination ? $result->paginate($pagination) : $result->get();

                return $collection;
            }
        );
    }

    /**
     * Retrieve a list of villages, optionally filtered by province code, regency code, district code, and name.
     *
     * @param  string|int|null  $provinceCode  The code of the province to filter villages by.
     *                                         If null, villages from all provinces are included.
     * @param  string|int|null  $regencyCode  The code of the regency to filter villages by.
     *                                        If null, villages from all regencies are included.
     * @param  string|int|null  $districtCode  The code of the district to filter villages by.
     *                                         If null, villages from all districts are included.
     * @param  string|null  $name  The name of the village to search for. If null, all villages are included.
     * @param  int|null  $pagination  The number of items per page. If null, all items are returned.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function villages(string|int|null $provinceCode = null, string|int|null $regencyCode = null, string|int|null $districtCode = null, ?string $name = null, ?int $pagination = null)
    {
        return $this->cache->remember(
            $this->cachePrefix . ':villages:' . $provinceCode . ':' . $regencyCode . ':' . $districtCode . ':' . $name . ':' . $pagination,
            $this->cacheExpiration,
            function () use ($provinceCode, $regencyCode, $districtCode, $name, $pagination) {
                $result = Village::when($provinceCode, function ($query) use ($provinceCode) {
                    $query->where('province_code', $provinceCode);
                })
                    ->when($regencyCode, function ($query) use ($regencyCode) {
                        $query->where('regency_code', $regencyCode);
                    })
                    ->when($districtCode, function ($query) use ($districtCode) {
                        $query->where('district_code', $districtCode);
                    })
                    ->when($name, function ($query) use ($name) {
                        if (method_exists($query, 'whereLike')) {
                            $query->whereLike('village_name', "%{$name}%");
                        } else {
                            $query->where('village_name', 'like', "%{$name}%");
                        }
                    });

                if ($pagination) {
                    return $result->paginate($pagination);
                }

                return $result->get();
            }
        );
    }
}
