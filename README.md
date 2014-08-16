# Laravel CPanel WHM Package

## Contents
- [Installation Guide](#installation-guide)
- [Configuration](#configuration)
- [Usage](#usage)

## Installation Guide

To install this package, you can run this code via your terminal
```shell
	composer require gufy/cpanel-whm:~1.0
```
Or update your `composer.json` by adding this line
```json
	"gufy/cpanel-whm":"~1.0"
```
Then, run this code
```shell
	composer update
```
After install it, you have to add this line on your `app/config/app.php` on Service Providers lines.
```php
	'Gufy\CpanelWhm\CpanelWhmServiceProvider',
```

It will automatically set an alias 'CpanelWhm' as Facade Accessor.

## Configuration

In this package, it only using hash as its authentication. It's the safer way than using your root plain password. First, run this command
```shell
	php artisan config:publish gufy/cpanel-whm
```
It will generate new file at `app/config/packages/gufy/cpanel-whm/config.php`. Edit necessary lines.

## Usage

For example, if you are trying to get some list of accounts, you can run this.
```php
	<?php

	Route::get('list-accounts',function(){
		$list_accounts = CpanelWhm::listaccts();

		return $list_accounts;
	});
```
For more information you can go to this links http://docs.cpanel.net/twiki/bin/view/SoftwareDevelopmentKit/XmlApi
