<?php
/**
 * Created by PhpStorm.
 * User: huncyrus
 * Date: 2015.12.23.
 * Time: 17:17
 */
class smallCurl {
	private $temp = '';
	private $url = '';
	private $userAgent = '';

	public function __construct($url = '') {
		if ('' != $url) {
			$this->setUrl($url);
		}
		$this->setUserAgent('Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0 Safari/533.16');
	}

	/**
	 * @return string
	 */
	public function getUserAgent() {
		return $this->userAgent;
	}

	/**
	 * @param string $userAgent
	 */
	public function setUserAgent($userAgent) {
		$this->userAgent = $userAgent;
	}

	/**
	 * @return string
	 */
	public function getTemp() {
		return $this->temp;
	}

	/**
	 * @param string $temp
	 */
	public function setTemp($temp) {
		$this->temp = $temp;
	}

	/**
	 * @return string
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * @param string $url
	 */
	public function setUrl($url) {
		$this->url = $url;
	}

	/**
	 * @return bool|mixed|string
	 */
	public function run() {
		$this->temp = $this->smallCurl();

		return $this->temp;
	}

	/**
	 * Very minimal cURL usage
	 * @return bool|mixed
	 */
	private function smallCurl() {
		$url = $this->getUrl();
		if ($url) {
			$c = curl_init($url);
			curl_setopt($c, CURLOPT_HEADER, false);
			curl_setopt($c, CURLOPT_USERAGENT, $this->getUserAgent());
			curl_setopt($c, CURLOPT_FAILONERROR, true);
			//curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($c, CURLOPT_AUTOREFERER, true);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($c, CURLOPT_TIMEOUT, 10);

			// Grab the data.
			$html = curl_exec($c);

			if ($html) {
				return $html;
			}

			curl_close($c);
		}
		return false;
	}
}
