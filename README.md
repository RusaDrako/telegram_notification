# telegram_notification
Простые оповещения в телеграмм-бот

[![Version](http://poser.pugx.org/rusadrako/telegram_notification/version)](https://packagist.org/packages/rusadrako/telegram_notification)
[![Total Downloads](http://poser.pugx.org/rusadrako/telegram_notification/downloads)](https://packagist.org/packages/rusadrako/telegram_notification/stats)
[![License](http://poser.pugx.org/rusadrako/telegram_notification/license)](./LICENSE)

## Установка (composer)
```sh
composer require 'rusadrako/telegram_notification'
```


## Установка (manual)
- Скачать и распоковать библиотеку.
- Добавить в код инструкцию:
```php
require_once('/telegram_notification/src/autoload.php')
```


## Класс telegram
Базовый класс.
```php
use RusaDrako\telegram_notification\telegram;

$token = 'botToken'; // токен телеграм-бота
$options = [];

$tn = new telegram($token, $options);
```
или
```php
$token = 'botToken'; // токен телеграм-бота
$options = [];

$tn = new telegram_note($token, $options);
```

Доступные свойств:
```php
$options = [
    'timeout' => 15, // время ожидания ответа от сервиса в секундах
    'marker' => 'Сервисное сообщение с test.ru: ', // маркер сообщений
];
```


#### Метод send()
Отправлят сообщения
```php
$chat_id = 'USER_ID';
$message = 'test message';

/** @var RusaDrako\telegram_notification\telegram $tn */
$tn->send($chat_id, $message);
```
- **$chat_id** - ID пользователя, которому отправляется сообщение
- **$message** - Текст сообщения


#### Метод sendPhoto()
Отправлят сообщения с картинкой
```php
$chat_id = 'USER_ID';
$file_path = __DIR__.'/test.jpg';
$message = 'test message';

/** @var RusaDrako\telegram_notification\telegram $tn */
$tn->sendPhoto($chat_id, $file_path, $message);
```
- **$chat_id** - ID пользователя, которому отправляется сообщение
- **$file_path** - Путь к файлу
- **$message** - Текст сообщения


#### Метод set_token()
Устанавливает токен телеграм-бота.
```php
/** @var RusaDrako\telegram_notification\telegram $tn */
$tn->set_token('...');
```


#### Метод set_timeout()
Устанавливает время ожидания ответа от сервиса в секундах.
```php
/** @var RusaDrako\telegram_notification\telegram $tn */
$tn->set_timeout(15);
```


#### Метод set_marker()
Устанавливает маркер сообщений - добавляется перед текстом в сообщения.
```php
/** @var RusaDrako\telegram_notification\telegram $tn */
$tn->set_marker('-->');
```


#### Метод set_timeout()
Устанавливает время ожидания ответа от сервиса в секундах.
```php
/** @var RusaDrako\telegram_notification\telegram $tn */
$tn->set_timeout(15);
```


## License
Copyright (c) Petukhov Leonid. Distributed under the MIT.