<?php

namespace Digster;

/**
 * Container class.
 *
 * @package Digster
 */

class Container implements \ArrayAccess {

	/**
	 * The keys holder.
	 *
	 * @var array
	 */

	protected $keys = array();

	/**
	 * The values holder.
	 *
	 * @var array
	 */

	protected $values = array();

	/**
	 * Set a parameter or an object.
	 *
	 * @param string $id
	 * @param mixed  $value
	 */

	public function bind( $id, $value ) {
		if ( ! $value instanceof \Clouser ) {
			$value = function() use ( $value ) {
				return $value;
			};
		}

		$this->values[$id] = $value;
		$this->keys[$id]   = true;
	}

	/**
	 * Check if identifier is set or not.
	 *
	 * @param string $id
	 *
	 * @return bool
	 */

	public function exists( $id ) {
		return isset( $this->keys[$id] );
	}

	/**
	 * Get value from the container.
	 *
	 * @param string $id
	 *
	 * @return mixed
	 */

	public function make( $id ) {
		if ( ! isset( $this->keys[$id] ) ) {
			throw new \InvalidArgumentException( sprintf( 'Identifier [%s] is not defined', $id ) );
		}

		return call_user_func( $this->values[$id] );
	}

	/**
	 * Check if identifier is set or not.
	 *
	 * @param string $id
	 *
	 * @return bool
	 */

	// @codingStandardsIgnoreStart
	public function offsetExists( $id ) {
	// @codingStandardsIgnoreEnd
		return $this->exists( $id );
	}

	/**
	 * Get value by identifier.
	 *
	 * @param string $id
	 *
	 * @return mixed
	 */

	// @codingStandardsIgnoreStart
	public function offsetGet( $id ) {
	// @codingStandardsIgnoreEnd
		return $this->make( $id );
	}

	/**
	 * Set a parameter or an object.
	 *
	 * @param string $id
	 * @param mixed $value
	 */

	// @codingStandardsIgnoreStart
	public function offsetSet( $id, $value ) {
	// @codingStandardsIgnoreEnd
		$this->bind( $id, $value );
	}

	/**
	 * Unset value by identifier.
	 *
	 * @param string $id
	 */

	// @codingStandardsIgnoreStart
	public function offsetUnset( $id ) {
	// @codingStandardsIgnoreEnd
		unset( $this->keys[$id], $this->values[$id] );
	}

}
