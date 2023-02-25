# Wilayah Administrasi Indonesia

[![Latest Version on Packagist](https://img.shields.io/packagist/v/vermaysha/laravel-wilayah-indonesia.svg?style=flat-square)](https://packagist.org/packages/vermaysha/laravel-wilayah-indonesia)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/vermaysha/laravel-wilayah-indonesia/run-tests.yml?branch=master&label=tests&style=flat-square)](https://github.com/vermaysha/laravel-wilayah-indonesia/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/vermaysha/laravel-wilayah-indonesia/fix-php-code-style-issues.yml?branch=master&label=code%20style&style=flat-square)](https://github.com/vermaysha/laravel-wilayah-indonesia/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/vermaysha/laravel-wilayah-indonesia.svg?style=flat-square)](https://packagist.org/packages/vermaysha/laravel-wilayah-indonesia)

Data Wilayah Administrasi Indonesia yang disusun ulang berdasarkan Provinsi, Kabupaten, Kecamatan dan Desa

<!-- ## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-wilayah-indonesia.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-wilayah-indonesia)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards). -->

## Installation

You can install the package via composer:

```bash
composer require vermaysha/laravel-wilayah-indonesia
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-wilayah-indonesia-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-wilayah-indonesia-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-wilayah-indonesia-views"
```

## Usage

```php
$LaravelWilayahID = new Vermaysha\LaravelWilayahID();
echo $LaravelWilayahID->echoPhrase('Hello, Vermaysha!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Ashary Vermaysha](https://github.com/vermaysha)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
