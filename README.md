# Getting started with Yii2-swap

*** Pre-alpha version ***
### 1. Download
Yii2-Swap extension can be installed using composer. Run the command bellow in console to download 
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

### 4. Available actions

#### Backend management actions

**NOTE: It is not recommended to use actions below in frontend. Even swap/management/items/create action.**
**All index pages designed as GridView by default**
##### 1. Items
`swap/management/items` list of all items
`swap/management/items/create` create item in module management page

##### 2. Categories
`swap/management/categories` list of all categories

`swap/management/categories/create` create category

##### 3. Bets
`swap/management/bets` list of all bets

`swap/management/bets/create` create bet in module management page

##### 4. Orders
`swap/management/orders` list of all orders

`swap/management/orders/create` create order manually

##### 5. Attributes
`swap/management/attributes` list of all attributes

`swap/management/attributes/create` create attributes for your items

##### 6. Attribute Values
`swap/management/values` junction table for items and attributes

`swap/management/values/create` create manually junction between item and attribute. Just for specific solutions

##### 7. Visual Configuration
`swap/management/basic-configuration` configurate module

#### Frontend actions

##### 1.Items
`swap/items` input all active items

`swap/items/create` create item with attributes, categories and bets

##### 2. Orders
`swap/orders/create` create order when user clicks swap button. Available to choose bet
