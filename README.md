# Laravel Seo Manager
------------------------------
 
## Installation
### 1 - Dependency
The first step is using composer to install the package and automatically update your `composer.json` file, you can do this by running:
```shell
composer require aman5537jains/seo-manager
```
 

### 2 - Provider
You need to update your application configuration in order to register the package so it can be loaded by Laravel, just update your `config/app.php` file adding the following code at the end of your `'providers'` section:

> `config/app.php`

```php
// file START ommited
    'providers' => [
        // other providers ommited
        Aman\SeoManager\SeoManagerServiceProvider::class,
    ],
// file END ommited
```
 

### 2 Configuration

#### Publish config

In your terminal type
```shell
php artisan vendor:publish
php artisam migrate
php artisan storage:link
```

  
