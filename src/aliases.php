<?php

if (class_exists('telegram_note', false)) {
	return;
}

$classMap = [
	// Для обрратной совместимости
	'RusaDrako\\telegram_notification\\Bot'      => 'RusaDrako\\telegram_notification\\telegram',
	'RusaDrako\\telegram_notification\\Bot'      => 'telegram_note',

	'RusaDrako\\telegram_notification\\Bot'      => 'RD_TG_Bot',
//	'RusaDrako\\telegram_notification\\Bilder'   => 'RD_TG_Bilder',
];

foreach ($classMap as $class => $alias) {
	class_alias($class, $alias);
}
