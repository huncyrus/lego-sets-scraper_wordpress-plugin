<?php

/**
 * Class legoScraperModel
 * @package legoScaper
 * @version 1.0
 * @author huncyrus
 */
class legoScraperModel {
	protected $db;
	protected $lastId;
	protected $legoSetId;

	public function __construct() {
		global $wpdb;

		$this->setDb($wpdb);
	}

	/**
	 * @return mixed
	 */
	public function getDb() {
		return $this->db;
	}

	/**
	 * @param mixed $db
	 */
	public function setDb( $db ) {
		$this->db = $db;
	}

	/**
	 * @return mixed
	 */
	public function getLastId() {
		return $this->lastId;
	}

	/**
	 * @param mixed $lastId
	 */
	public function setLastId( $lastId ) {
		$this->lastId = $lastId;
	}

	/**
	 * @return mixed
	 */
	public function getLegoSetId() {
		return $this->legoSetId;
	}

	/**
	 * @param mixed $legoSetId
	 */
	public function setLegoSetId( $legoSetId ) {
		$this->legoSetId = $legoSetId;
	}

	/**
	 * Retrieve stored shop links (title and url)
	 * @return bool|object
	 */
	public function getLinks() {
		$sql = '
			SELECT
				dls.id,
				dls.shop_title,
				dls.shop_url
			FROM
				danceg_lego_shops AS dls
			WHERE
				dls.shop_title <> ""
			AND
				dls.shop_title <> ""
		';
		$links = $this->db->get_results($sql);
		if (null == $links) {
			return false;
		} else {
			return $links;
		}
	}

	/**
	 * @param array $data
	 * @param int $storeId the shop ID from database
	 * @return bool
	 */
	public function storeLegoSets(array $data = null, $storeId = 0) {
		if (null != $data && is_array($data) && 0 != $storeId) {
			foreach ($data as $item) {
				if (true == $this->checkLegoSetExists($item['name'])) {
					// just update price
					$itemId = $this->getLegoSetId();
					$checkStoredData = $this->checkLegoAndShopStored($itemId, $storeId);

					if (true == $checkStoredData) {
						// update price
						$this->updateLegoInShop($storeId, $itemId, $item['price']);
					} else {
						// insert price
						$this->addLegoInShop($storeId, $itemId, $item['price']);
					}
				} else {
					// insert new set + check price
					$this->addLegoSet($item);
					$lastId = $this->getLastId();

					if ($lastId) {
						$checkStoredData = $this->checkLegoAndShopStored($lastId, $storeId);

						if (true == $checkStoredData) {
							// update price
							$this->updateLegoInShop($storeId, $lastId, $item['price']);
						} else {
							// insert price
							$this->addLegoInShop($storeId, $lastId, $item['price']);
						}
						$this->eraseLastInsertId();
					}
				}
			}
			return true;
		}

		return false;
	}

	/**
	 * Store lego sets individually without shop or price
	 * @param array|null $data
	 *
	 * @return bool
	 */
	private function addLegoSet(array $data = null) {
		if (null != $data && is_array($data)) {
			$this->db->insert(
				'danceg_lego_sets',
				array(
					'lego_set_name' => $data['name'],
					'lego_set_img' => $data['img'],
					'modify_date' => date('Y-m-d H:i:s'),
				)
			);
			$this->setLastId($this->db->insert_id);

			return true;
		}
		return false;
	}

	/**
	 * Store legoset & shop id with price
	 * @param int $shopId
	 * @param int $legoSetId
	 * @param int $price
	 *
	 * @return bool
	 */
	private function addLegoInShop($shopId = 0, $legoSetId = 0, $price = 0) {
		if (0 != $legoSetId && 0 != $shopId && 0 != $price) {
			$this->db->insert(
				'danceg_lego_sets_in_shop',
				array(
					'set_id' => $legoSetId,
					'shop_id' => $shopId,
					'price' => $price,
				)
			);

			return true;
		}

		return false;
	}

	/**
	 * @param int $shopId
	 * @param int $legoSetId
	 * @param int $price
	 *
	 * @return bool
	 */
	private function updateLegoInShop($shopId = 0, $legoSetId = 0, $price = 0) {
		if (0 != $legoSetId && 0 != $shopId && 0 != $price) {
			$this->db->update(
				'danceg_lego_sets_in_shop',
				array(
					'price' => $price,
				),
				array(
					'set_id' => $legoSetId,
					'shop_id' => $shopId,
				)
			);

			return true;
		}
		return false;
	}

	/**
	 * Erase cached last insert ID for lego sets
	 */
	private function eraseLastInsertId() {
		$this->lastId = null;
		unset($this->lastId);
	}

	/**
	 * Check the Lego set exists or not (by set name)
	 * @param string $setName
	 *
	 * @return bool
	 */
	private function checkLegoSetExists($setName = '') {
		if ('' != $setName) {
			$sql = '
				SELECT
					ls.id
				FROM
					danceg_lego_sets AS ls
				WHERE
					MD5(ls.lego_set_name) = "' . md5($setName) . '"
				LIMIT 1;
			';
			$result = $this->db->get_results($sql);

			if (null != $result) {
				if ($result[0]->id) {
					$this->setLegoSetId( $result[0]->id );
				}

				return true;
			}
		}

		return false;
	}

	/**
	 * Check lego set & shop stored together or not
	 * @param int $legoSetId
	 * @param int $shopId
	 *
	 * @return bool
	 */
	private function checkLegoAndShopStored($legoSetId = 0, $shopId = 0) {
		if (0 != $legoSetId && 0 != $shopId) {
			$sql = '
				SELECT
					lsis.id
				FROM
					danceg_lego_sets_in_shop as lsis
				WHERE
					lsis.shop_id = "' . $shopId . '"
				AND
					lsis.set_id = "' . $legoSetId . '"
				LIMIT 1;
			';
			$result = $this->db->get_results($sql);

			if (null != $result) {
				return true;
			}
		}
		return false;
	}
}
