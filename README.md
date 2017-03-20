## Laravel cPanel WHM Package

### Contents
- [Installation Guide](#installation-guide)
- [Configuration](#configuration)
- [Usage](#usage)

### IMPORTANT NOTE

If you are Laravel 4 user, please use v1.0.1 version instead.

### Installation Guide

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

### Configuration

In this package, it only using hash as its authentication. It's the safer way than using your root plain password. First, run this command
```shell
	php artisan vendor:publish gufy/cpanel-whm
```
It will generate new file at `config/cpanel-whm.php`. Edit necessary lines.

### Usage

For example, if you are trying to get some list of accounts, you can run this.
```php
	<?php

	Route::get('list-accounts',function(){
		$list_accounts = CpanelWhm::listaccts();

		return $list_accounts;
	});
```


### Multiple Servers

If you have multiple servers saved in your config file, you can access them directly using the CpanelWhm::server('arrayKey') function.

Example:
```php
	<?php

	Route::get('list-accounts',function(){
		$list_accounts = CpanelWhm::server('example1')->listaccts();

		return $list_accounts;
	});
```

For more information you can go to this links [Guide to Cpanel API 2](https://documentation.cpanel.net/display/SDK/Guide+to+cPanel+API+2)
