<?php
// For debug
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set("log_errors", 1);
require_once 'smallCurl.php';

/**
 * Class legoScrape
 * @package legoScaper
 * @version 1.0
 * @author huncyrus
 */
class legoScrape {
	private $url = 'http://www.legekaeden.dk/maerker/lego/lego-star-wars/';
	private $pageSource = '';
	private $result = '';
	private $curl = '';
	private $temp = null;
	protected $error;

	public function __construct() {
		$this->curl = new smallCurl($this->getUrl());
	}

	/**
	 * @return string
	 */
	public function getPageSource() {
		return $this->pageSource;
	}

	/**
	 * @param string $pageSource
	 */
	public function setPageSource($pageSource) {
		$this->pageSource = $pageSource;
	}

	/**
	 * @return string
	 */
	public function getResult() {
		return $this->result;
	}

	/**
	 * @param string $result
	 */
	public function setResult($result) {
		$this->result = $result;
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
	 * Run the scraper
	 */
	public function run() {
		$data = $this->fetchLegoSets($this->retrieveLegoSets());
		if ($data) {
			//$this->storeLegoSets($data); // future feature
			return true;
			//return $data; // for debug & for future feature
		}

		return false;
	}

	/**
	 * @return null
	 */
	public function getTemp() {
		return $this->temp;
	}

	/**
	 * @param null $temp
	 */
	public function setTemp($temp) {
		$this->temp = $temp;
	}

	/**
	 * @return string
	 */
	public function getError() {
		return $this->error;
	}

	/**
	 * @return bool|mixed|string
	 */
	private function retrieveLegoSets() {
		return $this->curl->run();
	}

	/**
	 * Main lego set fetcher method
	 * @param string $source the html source of the site by lib curl
	 * @return bool|mixed
	 */
	private function fetchLegoSets($source = '') {
		if ('' != $source) {
			$dom = new DOMDocument();
			@$dom->loadHtml($source);
			$xpath = new DOMXPath($dom);

			// Get a list of lego sets
			$result = $xpath->query('//ul[@id="productsearchresult"]');

			$temp = array();
			foreach ($result as $node) {
				foreach ($node->getElementsByTagName('li') as $li) {
					$temp[] = array(
						'img' => $this->getProductImageFromNode($li),
						'name' => $this->getProductNameFromNode($li),
						'price' => $this->getPriceFromNode($li),
					);
				}
			}
			$this->setTemp($temp);

			return $result;
		}

		return false;
	}

	/**
	 * Future feature method for pointing to save the results via 3rd party database layer
	 */
	private function storeLegoSets($data = '') {
		//
	}

	/**
	 * @param string $error
	 */
	private function setError($error = '') {
		if ('' != $error) {
			$this->error = $error;
		}
	}

	/**
	 * @param DOMXPath object $node
	 * @return null|string
	 */
	protected function getPriceFromNode($node) {
		$price = $this->nodeFetch($node, '//*[@class="price-box"]');

		return $price;
	}

	/**
	 * Retrieve specific string (product name) from a node
	 * @param $node DOMXPath node element
	 *
	 * @return null|string
	 */
	protected function getProductNameFromNode($node) {
		$productName = $this->nodeFetch($node, '//*[@class="product-name"]');

		return $productName;
	}

	/**
	 * Fetch specific image related value from a node
	 * @param $node DOMXPath node
	 *
	 * @return null|string
	 */
	protected function getProductImageFromNode($node) {
		$productImage = $this->nodeFetch($node, 'string(//img/@data-src)', 'byAttribute');

		return $productImage;
	}

	/**
	 * Node (DomXML) fetcher.
	 * @param DOMXPath $node object
	 * @param string $searchPattern
	 * @param string $output
	 *
	 * @return null|string
	 */
	protected function nodeFetch($node = '', $searchPattern = '', $output = 'nodeValue') {
		$result = null;

		if ('' != $node && '' != $searchPattern) {
			try {
				$ad_Doc = new DOMDocument();
				$cloned = $node->cloneNode(TRUE);
				$ad_Doc->appendChild($ad_Doc->importNode($cloned, True));
				$newXpath = new DOMXPath($ad_Doc);
				$ad_title_tag = $newXpath->evaluate($searchPattern);

				switch ($output) {
					case 'byAttribute':
						$result = $ad_title_tag;
						break;
					case '':
					case 'nodeValue':
					default:
						if ($ad_title_tag->length) {
							$result = trim($ad_title_tag->item(0)->nodeValue);
						}
						break;
				}
			} catch (Exception $e) {
				$this->setError($e->getMessage());
			}
		}

		return $result;
	}
}


// Example of usage
//$a = new legoScrape();
//print 'something';
//print '<pre>';
//$b = $a->run();
//var_dump($b);
//print_r($b);
//var_dump($a->getTemp());
