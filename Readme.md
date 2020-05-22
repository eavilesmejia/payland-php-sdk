## installing the package

### From CLI
```$xslt
$ composer config repositories.paylands-php-sdk vcs https://github.com/eavilesmejia/paylands-php-sdk.git
$ composer require paylands/sdk:dev-master
```

### From composer.json
```$xslt
"require": {
        "paylands/sdk": "dev-master"
 },
 "repositories": {
     "paylands/sdk": {
         "type": "vcs",
         "url": "https://github.com/eavilesmejia/paylands-php-sdk.git"
     }
 },

```

## Unit testing

### Install in your local
```$xslt
$ composer install
```
### Run Tests
```$xslt
$ php vendor/bin/phpunit --bootstrap vendor/autoload.php tests/unit/Services/OrderPayment.php
```