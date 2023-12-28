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


## Класс Bot
Базовый класс подключения к телеграмм-боту.
```php
use RusaDrako\telegram_notification\Bot;

$token = 'botToken'; // токен телеграм-бота
$options = [];

$tn_bot = new Bot($token, $options);
```
или
```php
$token = 'botToken'; // токен телеграм-бота
$options = [];

$tn_bot = new RD_TG_Bot($token, $options);
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

/** @var RusaDrako\telegram_notification\Bot $tn_bot */
$tn_bot->send($chat_id, $message);
```
- **$chat_id** - ID пользователя, которому отправляется сообщение
- **$message** - Текст сообщения


#### Метод sendPhoto()
Отправлят сообщения с картинкой
```php
$chat_id = 'USER_ID';
$file_path = __DIR__.'/test.jpg';
$message = 'test message';

/** @var RusaDrako\telegram_notification\Bot $tn_bot */
$tn_bot->sendPhoto($chat_id, $file_path, $message);
```
- **$chat_id** - ID пользователя, которому отправляется сообщение
- **$file_path** - Путь к файлу
- **$message** - Текст сообщения


#### Метод set_token()
Устанавливает токен телеграм-бота.
```php
/** @var RusaDrako\telegram_notification\Bot $tn_bot */
$tn_bot->set_token('...');
```


#### Метод set_timeout()
Устанавливает время ожидания ответа от сервиса в секундах.
```php
/** @var RusaDrako\telegram_notification\Bot $tn_bot */
$tn_bot->set_timeout(15);
```


#### Метод set_marker()
Устанавливает маркер сообщений - добавляется перед текстом в сообщения.
```php
/** @var RusaDrako\telegram_notification\Bot $tn_bot */
$tn_bot->set_marker('-->');
```


#### Метод set_timeout()
Устанавливает время ожидания ответа от сервиса в секундах.
```php
/** @var RusaDrako\telegram_notification\Bot $tn_bot */
$tn_bot->set_timeout(15);
```


## Класс Bilder
Управляющий класс для работы с несколькими ботами.
```php
use RusaDrako\telegram_notification\Bilder;

$bilder = new Bilder(Bilder);
```

#### Метод get($token)
Возвращает объект подключения по токену.
```php
$token = 'botToken'; // токен телеграм-бота

/** @var RusaDrako\telegram_notification\Bilder $bilder */
$tn_bot = $bilder->get($token);
```
- **$token** - токен телеграм-бота

#### Метод delete($tn_bot)
Удаляет объект подключения из списка подключений.
```php
/** @var RusaDrako\telegram_notification\Bilder $bilder */
$bilder->delete($tn_bot);
```
- **$tn_bot** - Объект подключения к телеграм-боту

## License
Copyright (c) Petukhov Leonid. Distributed under the MIT.