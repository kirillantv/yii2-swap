# Getting started with Yii2-swap

### 1. Download
Yii2-Swap extension can be installed using composer. Run the command bellow to download 
and install Yii2-swap:

```bash
composer require kirillantv/yii2-swap
```

or you can add following require to composer.json:
```bash
...
"require": {
  ...
  "kirillantv/yii2-swap": "*"
  ...
}
```
### 2. Configure

Add following lines to your main configuration file:

```php
'modules' => [
    'swap' => [
        'class' => 'kirillantv\swap\Module',
    ],
],
```
### 3. Update database schema

The last thing you need to do is updating your database schema by applying the
migrations. Make sure that you have properly configured `db` application component
and run the following command:

```bash
$ php yii migrate/up --migrationPath=@vendor/kirillantv/yii2-swap/migrations
```

