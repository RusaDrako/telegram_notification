<?php
namespace RusaDrako\telegram_notification;

class Bilder
{
	protected $bot = [];

	public function get(string $token) {
		if (!array_key_exists($token, $this->bot)) {
			$this->bot[$token] = new \RusaDrako\telegram_notification\telegram($token);
		}
		return $this->bot[$token];
	}

	public function delete(Bot $bot) {
		foreach($this->bot as $k => $v) {
			if ($v === $bot) {
				unset($this->bot[$k]);
				continue;
			}
		}
	}
}