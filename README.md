# Geld

**Bring currency exchange rates to your Laravel application**

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]


## Install

Via Composer

``` bash
composer require victoravelar/geld
```

## Getting started

Geld allows you to pull and store currency exchange rates using [Fixer.io](https://fixer.io) as source, it is highly
configurable and it solely depends on your needs.

## Usage

Set your Fixer.io API key as an environment variable for your project using `FIXER_API_KEY` as name.

#### Configuration

To check the configuration options, please refer to `config/geld.php` where you will find the available options and a
detailed explanation of the purpose of each one of them.

If you are ok with the defaults then you are good to go but if you desire to change something run `php artisan vendor
:publish` and select `GeldServiceProvider` from the list.

The `geld.php` file will be published to the Laravel default config folder.

#### Setting up the scheduler

To be able to use Task Scheduling in laravel you need to start Cron in your server, you can follow the
introduction of the related [Laravel documentation for a detailed explanation](https://laravel.com/docs/6.x/scheduling).

#### Pulling the exchange rates

If you are using a free Fixer.io account, you have access to hourly updates and it is recommended to pull the
rates as often as possible.

Copy and paste the following code into your `app/Console/Kernel.php` file to start pulling rates every hour.

```php
$schedule->command(UpdateExchangeRatesCommand::class)->hourlyAt(5);
```

This snippet instructs your Laravel application to pull the rates every hour 5 minutes past the hour.

#### The history table

This table will potentially become a huge information container (if enabled) as every hour it will pull new records
from the API, the history table is meant to solve some problems when displaying or calculating entries performed on a
certain day at a certain time or for use cases where having access to older rates for a currency is required.

If you only need the latest exchange rates then you can disable the history storage by setting the `history_mode`
configuration variable to false.

#### Retention period
 
We ship a command that soft deletes records older than the defined retention period which you can change using the
`retention` configuration variable.

To schedule the execution of this command copy and paste the following snippet in the `app/Console/Kernel.php` file.

```php
$schedule->command(CheckRetentionCommand::class)->weekly();
```

#### Data incineration

**When gone means gone**

Geld also chips an incinerator, this command will hard delete the records older than the defined incineration period, 
you can control this time window using the `incinerate_after` configuration variable.

If you don't want to hard delete information from the history table, you can disable the incinerator by setting the
`incinerate` configuration variable to false.

To schedule the execution of this command copy and paste the following snippet in the `app/Console/Kernel.php` file.

```php
$schedule->command(DataIncineratorCommand::class)->monthly();
```

### Events

After every successful pull from Fixer.io, Geld will dispatch a RatesUpdated event that you can hook into.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) and [CODE_OF_CONDUCT](.github/CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email deltatuts@gmail.com instead of using the issue tracker.

## Credits

- [Victor Hugo Avelar Ossorio][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/victoravelar/geld.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/victoravelar/geld/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/victoravelar/geld.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/victoravelar/geld.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/victoravelar/geld.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/victoravelar/geld
[link-travis]: https://travis-ci.org/victoravelar/geld
[link-scrutinizer]: https://scrutinizer-ci.com/g/victoravelar/geld/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/victoravelar/geld
[link-downloads]: https://packagist.org/packages/victoravelar/geld
[link-author]: https://github.com/VictorAvelar
[link-contributors]: ../../contributors
