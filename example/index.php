<pre><?php
require_once('../src/autoload.php');

$bot_token   = 'BOT_TOKEN';
$chat_id     = 'USER_ID';


$bot = new RD_TG_Bot($bot_token);
$bot->set_marker('☑✅☑');
$bot->set_timeout(3);

$bot->send($chat_id, 'test message');



echo '<hr>';
echo 'Конец кода';
