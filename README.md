
# Laravel Wilayah Indonesia
[![Latest Version on Packagist](https://img.shields.io/packagist/v/vermaysha/laravel-wilayah-indonesia.svg?style=flat-square)](https://packagist.org/packages/vermaysha/laravel-wilayah-indonesia)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/vermaysha/laravel-wilayah-indonesia/run-tests.yml?branch=master&label=tests&style=flat-square)](https://github.com/vermaysha/laravel-wilayah-indonesia/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/vermaysha/laravel-wilayah-indonesia/fix-php-code-style-issues.yml?branch=master&label=code%20style&style=flat-square)](https://github.com/vermaysha/laravel-wilayah-indonesia/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/vermaysha/laravel-wilayah-indonesia.svg?style=flat-square)](https://packagist.org/packages/vermaysha/laravel-wilayah-indonesia)
![LICENSE](https://img.shields.io/github/license/vermaysha/laravel-wilayah-indonesia)

Package untuk laravel yang berisi Data Wilayah Administrasi Indonesia yang tersusun berdasarkan Provinsi, Kabupaten, Kecamatan dan Desa


## Installation

Install package menggunakan composer

```bash
composer require vermaysha/laravel-wilayah-indonesia
```

Setelah package terinstall, jalankan kode dibawah 

```bash
php artisan wilayah:install
```

File config serta migration akan otomatis tercopy ke folder masing-masing, lalu jalankan perintah dibawah

```bash
php artisan migrate
php artisan wilayah:seed
```

## Usage/Examples

Gunakan beberapa model yang telah disediakan untuk mengolah data wilayah

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vermaysha\Wilayah\Models\City;
use Vermaysha\Wilayah\Models\District;
use Vermaysha\Wilayah\Models\Province;
use Vermaysha\Wilayah\Models\Village;

class ExampleController extends Controller
{
    /**
     * Display all province
     */
    public function provinces(Request $request)
    {
        $province = Province::all();
        return $province;
    }

    /**
     * Display all province
     */
    public function cities(Request $request)
    {
        $city = City::limit(50)->get();
        return $city;
    }

    /**
     * Display all province
     */
    public function districts(Request $request)
    {
        $district = District::limit(50)->get();
        return $district;
    }

    /**
     * Display all province
     */
    public function villages(Request $request)
    {
        $village = Village::limit(50)->get();
        return $village;
    }
}

```


## Running Tests

```bash
  composer test
```


## Authors

- [@vermaysha](https://www.github.com/vermaysha)


## License

[LGPL-2.1](https://choosealicense.com/licenses/lgpl-2.1/)


## FAQ

#### Berapa banyak data provinsi, kabupaten, kecamatan dan desa yang tercantum ?

Data pada package ini diambil dari repository https://github.com/vermaysha/kode-wilayah-indonesia, yang sesuai dengan Permendagri No 58 Tahun 2021 (diperbaharui dengan Kepmendagri No. 050-145 Tahun 2022)
