<?php

if (class_exists('telegram_note', false)) {
	return;
}

$classMap = [
	'RusaDrako\\telegram_notification\\Bot'      => 'RD_TG_Bot',
	'RusaDrako\\telegram_notification\\Bilder'   => 'RD_TG_Bilder',
];

foreach ($classMap as $class => $alias) {
	class_alias($class, $alias);
}
