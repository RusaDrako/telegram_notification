<?php

if (class_exists('telegram_note', false)) {
	return;
}

$classMap = [
	'RusaDrako\\telegram_notification\\telegram'             => 'telegram_note',
];

foreach ($classMap as $class => $alias) {
	class_alias($class, $alias);
}
