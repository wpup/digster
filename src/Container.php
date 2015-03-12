<?php

/**
 * Digster - Twig templates for WordPress.
 *
 * @package Digister
 * @license MIT
 * @version 1.0.0
 */

namespace Digster;

/**
 * Engine.
 *
 * @package Digster
 * @since 1.0.0
 */

class Container implements \ArrayAccess
{
    /**
     * The keys holder.
     *
     * @var array
     * @since 1.0.0
     */

    protected $keys = array();

    /**
     * The values holder.
     *
     * @var array
     * @since 1.0.0
     */

    protected $values = array();

    /**
     * Set a parameter or an object.
     *
     * @param string $id
     * @param mixed  $value
     * @since 1.0.0
     */

    public function bind($id, $value)
    {
        if (!$value instanceof \Clouser) {
            $value = function() use ($value) {
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
     * @since 1.0.0
     *
     * @return bool
     */

    public function exists($id)
    {
        return isset($this->keys[$id]);
    }

    /**
     * Get value from the container.
     *
     * @param string $id
     * @since 1.0.0
     *
     * @return mixed
     */

    public function make($id)
    {
        if (!isset($id)) {
            throw new \InvalidArgumentException(sprintf('Identifier [%s] is not defined', $id));
        }

        return call_user_func($this->values[$id]);
    }

    /**
     * Check if identifier is set or not.
     *
     * @param string $id
     * @since 1.0.0
     *
     * @return bool
     */

    public function offsetExists($id)
    {
        return $this->exists($id);
    }

    /**
     * Get value from the container.
     *
     * @param string $id
     * @since 1.0.0
     *
     * @return mixed
     */

    public function offsetGet($id)
    {
        return $this->make($id);
    }

    /**
     * Set a parameter or an object.
     *
     * @param string $id
     * @param mixed  $value
     * @since 1.0.0
     */

    public function offsetSet($id, $value)
    {
        return $this->bind($id, $value);
    }

    /**
     * Unset value and key by identifier.
     *
     * @param string $id
     * @since 1.0.0
     */

    public function offsetUnset($id)
    {
        unset($this->keys[$id], $this->values[$id]);
    }
}
