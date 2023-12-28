<?php

namespace RusaDrako\telegram_notification;

/**
 * Отправка сообщений в Telegram
 */
class Bot {

	/** @var string Ссылка для обращения к Telegram */
	protected $link = 'https://api.telegram.org/bot';
	/** @var string Токен бота */
	protected $token;
	/** @var string Маркер сообщений (для визуального понимания, откуда пришло сообщение) */
	protected $marker;
	/** @var string Время ожидания ответа */
	protected $timeout;

	public function __construct($token, $options = []){
		$this->set_token($token);
		$this->set_marker($options['marker'] ?? '');
		$this->set_timeout((int)$options['timeout'] ?? 10);
	}

	/**
	 * Устанавливает токен telegram-bot
	 * @param string $value Токен
	 * @return void
	 */
	public function set_token(string $value) {
		$this->token = $value;
	}

	/**
	 * Устанавливает маркер бота (текстовая составляющая перед основным сообщением)
	 * @param string $value Маркер
	 * @return void
	 */
	public function set_marker(string $value) {
		$this->marker = $value;
	}

	/**
	 * Устанавливает время ожидания ответа
	 * @param int $value
	 * @return void
	 */
	public function set_timeout(int $value) {
		$this->timeout = $value;
	}

	/**
	 * Выводит информацию об ошибке
	 * @param string $text Текст сообщения
	 * @return void
	 */
	protected function _error_view($text) {
		echo "Ошибка curl: {$text}";
	}

	/**
	 * Выполняет команду
	 * @param string $command Команда
	 * @param array $post Массив настроек
	 * @return array|mixed
	 */
	protected function _curl($command, $post = []) {
		# Запускай curl
		$curl = curl_init();
		# Формируем
		$array_curl_set = [
			CURLOPT_URL              => $this->link . $this->token . '/' . $command,
			CURLOPT_POST             => TRUE,
			CURLOPT_RETURNTRANSFER   => TRUE,
			CURLOPT_TIMEOUT          => $this->timeout,
			CURLOPT_POSTFIELDS       => $post,
		];
		# Проверяем отправляется ли файл
		foreach ($post as $v) {
			if (is_object($v)) {
				if (get_class($v) == 'CURLFile') {
					$array_curl_set[CURLOPT_HTTPHEADER] = ['Content-Type:multipart/form-data'];
					break;
				}
			}
		}
		# Выполняем настройки
		curl_setopt_array(
			$curl,
			$array_curl_set
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

	/**
	 * Возвращает строковый список получателей в виде массива
	 * @param string|array $to Строковый список получателей
	 * @return false|string[]
	 */
	protected function _get_arr_id_to($to) {
		if (is_array($to)) { return $to; }
		$arr_to = \explode(',', $to);
		foreach ($arr_to as $k => $v) {
			$arr_to[$k] = trim($v);
		}
		return $arr_to;
	}

	/**
	 * Разбивает сообщение на массив (для отправки длинных сообщений)
	 * @param string $str_msg
	 * @return array
	 */
	protected function _split_msg($str_msg) {
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

	/** Получение данных файла */
	protected function _get_file_data($file_path) {
		return new \CURLFile(realpath($file_path));
	}

	/**
	 * Отправляет сообщение
	 * @param string|array $to Спмсок адресатов (ID)
	 * @param string $message Текст сообщения
	 * @return void
	 */
	public function send($to, string $message) {
		if ($this->marker) {
			$message = "{$this->marker}: {$message}";
		}

		$post = [];

		$arr_to = $this->_get_arr_id_to($to);
		$arr_text = $this->_split_msg($message);

		foreach ($arr_to as $v) {
			$post['chat_id'] = $v;
			foreach ($arr_text as $v_text) {
				$post['text'] = $v_text;
				$result = $this->_curl('sendMessage', $post);
			}
		}
	}

	/** Отправка фотографии (с сервера) */
	function sendPhoto($to, string $file_path, string $message) {
		if ($this->marker) {
			$message = "{$this->marker}: $message";
		}

		$post = [];

		$arr_to = $this->_get_arr_id_to($to);
		$arr_text = $this->_split_msg($message);
		$post['photo'] = $this->_get_file_data($file_path);
		$post['parse_mode'] = 'Markdown';

		foreach ($arr_to as $v) {
			$post['chat_id'] = $v;
			foreach ($arr_text as $v_text) {
				$post['caption'] = $v_text;
				$result[] = $this->_curl('sendPhoto', $post);
			}
		}
		return $result;
	}

/**/
}
