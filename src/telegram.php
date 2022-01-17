<?php

namespace RusaDrako\telegram_notification;

/**
 *
 */
class telegram {

	private $link = 'https://api.telegram.org/bot';
	private $token = null;
	private $marker = '';
	private $timeout = 10;





	/** */
	public function __construct() {}





	/** */
	public function set_token(string $value) {
		$this->token = $value;
	}





	/** */
	public function set_marker(string $value) {
		$this->marker = $value;
	}





	/** */
	public function set_timeout(int $value) {
		$this->timeout = $value;
	}





	/** */
	private function _curl($command, $post = []) {
		# Запускай curl
		$curl = curl_init();
		# Выполняем настройки
		curl_setopt_array(
			$curl,
			[
				CURLOPT_URL              => $this->link . $this->token . '/' . $command,
				CURLOPT_POST             => TRUE,
				CURLOPT_RETURNTRANSFER   => TRUE,
				CURLOPT_TIMEOUT          => $this->timeout,
				CURLOPT_POSTFIELDS       => $post,
			]
		);
		# Выполняем curl
		$result = curl_exec($curl);
		# Если curl выдал ошибку
		if ($result === false) {
			# Выводим сообщение
			echo 'Ошибка curl: ' . curl_error($curl);
			# Закрываем соединение
			curl_close($curl);
			return [];
		}
		# Закрываем соединение
		curl_close($curl);
		# Декодируем результат
		$arr_result = \json_decode($result, true);
		# Если telegram выдал ошибку
		if (!$arr_result['ok']) {
			# Выводим сообщение
			echo $arr_result['error_code'] . ' ' . $arr_result['description'];
		}
		return $arr_result;
	}





	/** */
	private function _get_to_id_arr($to) {
		$arr_to = \explode(',', $to);
		foreach ($arr_to as $k => $v) {
			$arr_to[$k] = trim($v);
		}
		return $arr_to;
	}





	/** Разбиваем сообщение на массив части */
	private function _send_msg___arr_sub_str($str_msg) {
		# Максимальная динна
		$max_len = 4096;
		# Длинна строки
		$str_len = \mb_strlen($str_msg);
		# Число необходимых сообщений
		$n = (int)(($str_len / $max_len)) + 1;
		$arr = [];
		# Формируем массив записей
		for ($i = 0; $i < $n ; $i++) {
			# Длинна оставшегося участка
			$len_control = $str_len - $i * $max_len;
			# Определяем длинну отрезка
			$_len = $len_control < $max_len
					? $len_control
					: $max_len;
			# Добавляем элемент в массив
			$arr[] = \mb_substr($str_msg, $i * $max_len, $_len);
		}
		# Возвращаем массив
		return $arr;
	}





	/** Отправка сообщения */
	function send($to, string $text) {
		if ($this->marker) {
			$text = "{$this->marker}: $text";
		}

		$post = [];

		$arr_to = $this->_get_to_id_arr($to);
		$arr_text = $this->_send_msg___arr_sub_str($text);

		foreach ($arr_to as $v) {
			$post['chat_id'] = $v;
			foreach ($arr_text as $v_text) {
				$post['text'] = $v_text;
				$result = $this->_curl('sendMessage', $post);
			}
		}
	}





/**/
}
