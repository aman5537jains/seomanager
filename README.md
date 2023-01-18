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
 

### 3 - Configuration

#### Publish config

In your terminal type
```shell
php artisan vendor:publish --provider="Aman\SeoManager\SeoManagerServiceProvider"
php artisam migrate
```

### 4 - Add Models, Excpet Paths amd other config in config\seoconfig.php

```php
<?php 

return
    [
    "models"=>[
        "User"=>\App\User::class,
        "Country"=>\App\Model\Country::class 
    ]   ,
    "except_routes"=>[
        "admin",
        "api",
        'filemanager',
        'file-manager',
        'seo-manager',
        "_debugbar",
        "docs"
    ],
    "subdomain"=>[
        "www",
        // "*"=>["route"=>"{prefix_url}.jiunge.com",]
    ] 
                        
];
```

### 4 - usage
 
#### open http://localhost/project_name/seo-manager

<img width="585" alt="Screenshot 2023-01-18 at 6 47 08 PM" src="https://user-images.githubusercontent.com/8058839/213182697-cb0c3ddf-0b74-4122-a697-946c8461b582.png">

Add New Url 

<img width="1535" alt="Screenshot 2023-01-18 at 6 47 34 PM" src="https://user-images.githubusercontent.com/8058839/213182770-002b7e77-6315-4bcf-9d7c-8cd36fec9fcd.png">

You can configure static as well dyanamic url and can map the model column to params as shown in screenshot

