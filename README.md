# Fileger

File manager for Yii2 Framework.

## Installation

The preferred way to install this extension is through composer.

Add

```json

{
    "type": "git",
    "url": "https://github.com/nowmovesoft/fileger"
}

```

to the `repositories` section of your `composer.json` file.

Then run

```bash

composer require "nowmovesoft/fileger" "@dev"

```

or add

```json

"nowmovesoft/fileger": "@dev"

```

to the `require` section of your `composer.json` file.

Apply migration

```bash

yii migrate --migrationPath=@vendor/nowmovesoft/fileger/migrations

```

## Enable module

Add this code to your site configuration:

```php

    'modules' => [
        'fileger' => [
            'class' => 'nms\fileger\Module',
        ],
    ],

```
