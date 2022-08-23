<?php
declare(strict_types=1);

namespace Hami\Cache\Storage\Adapter;

use Predis\Client;

/**
 * Class Predis
 *
 * @package Hami\Cache
 */
class Predis implements AdapterInterface {
	/**
	 * @var Client
	 */
	protected $client;

	/**
	 * Predis constructor.
	 *
	 * @param Client $client
	 */
	public function __construct(Client $client) {
		$this->client = $client;
	}

	/**
	 * Validate key for storage
	 *
	 * @param string $key
	 *
	 * @return bool
	 */
	public function validateKey(string $key): bool {
		return true;
	}

	/**
	 * @param string[] $keys
	 *
	 * @return array
	 */
	public function fetch(array $keys): array {
		if (!$keys) {
			return [];
		}

		$items = [];

		$result = array_combine($keys, $this->client->mget($keys));

		foreach ($result as $key => $value) {
			if ($value) {
				$items[$key] = unserialize($value);
			}
		}

		return $items;
	}

	/**
	 * @param string $key
	 * @param mixed $value
	 * @param int|null $ttl
	 *
	 * @return bool
	 */
	public function save(string $key, $value, ?int $ttl = null): bool {
		if ($ttl) {
			$this->client->set($key, serialize($value), 'EX', $ttl);
		} else {
			$this->client->set($key, serialize($value));
		}

		return true;
	}
}
