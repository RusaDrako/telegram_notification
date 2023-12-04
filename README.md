# telegram_notification
Отправка сообщений в телеграмм

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

$bot_token = '...';

$tn = new telegram();
$tn->set_token($bot_token);
```
или
```php
$bot_token = '...';

$tn = new telegram_note();
$tn->set_token($bot_token);
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


#### Метод set_timeout()
Устанавливает время ожидания ответа от сервиса в секундах.
```php
/** @var RusaDrako\telegram_notification\telegram $tn */
$tn->set_timeout(15);
```


#### Метод set_marker()
Устанавливает маркер сообщений - добавляется в начало сообщения.
```php
/** @var RusaDrako\telegram_notification\telegram $tn */
$tn->set_marker('-->');
```


## License
Copyright (c) Petukhov Leonid. Distributed under the MIT.