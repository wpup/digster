<?php

namespace Frozzare\Digster;

use ArrayAccess;
use Frozzare\Digster\Engines\Engine;

class View implements ArrayAccess {

    /**
     * The view engine instance.
     *
     * @var \Frozzare\Digster\Factory
     */
    protected $engine;

    /**
     * The array of view data.
     *
     * @var array
     */
    protected $data;

    /**
     * The view factory instance.
     *
     * @var \Frozzare\Digster\Factory
     */
    protected $factory;

    /**
     * The name of the view.
     *
     * @var string
     */
    protected $view;

    /**
     * The constructor.
     *
     * @param  string $view
     *
     * @throws InvalidArgumentException if an argument is not of the expected type.
     */
    public function __construct( Factory $factory, Engine $engine, $view, array $data = [] ) {
        $this->factory = $factory;
        $this->engine  = $engine;
        $this->view    = $view;
        $this->data    = $data;
    }

    /**
     * Gather the data that should be used when render.
     *
     * @return array
     */
    protected function gather_data() {
        $data = $this->factory->gather_data( $this );

        foreach ( $data as $index => $callback ) {
            if ( is_callable( $callback ) ) {
                $value = call_user_func( $callback, $this );
            } else {
                continue;
            }

            if ( is_array( $value ) ) {
                $this->data = array_merge( $this->data, $value );
                $keys = array_diff( array_keys( $this->data ), array_keys( $value ) );
                foreach ( $keys as $key ) {
                    if ( isset( $this->data[$key] ) ) {
                        unset( $this->data[$key] );
                    }
                }
            } else if ( is_string( $value ) && class_exists( $value ) ) {
				$class = new $value();
				$class->compose( $this );
            }
        }

        foreach ( $this->data as $key => $value ) {
            if ( $value instanceof View ) {
                $this->data[$key] = $value->render();
            }
        }

        return array_merge( $this->factory->get_shared(), $this->data );
    }

    /**
     * Get view data.
     *
     * @return array
     */
    public function get_data() {
        return $this->data;
    }

    /**
     * Get the view name.
     *
     * @return string
     */
    public function get_name() {
        return $this->view;
    }

    /**
     * Add a view instance to the view data.
     *
     * @param  string $key
     * @param  string $view_name
     * @param  array  $data
     *
     * @return $this
     */
    public function nest( $key, $view_name, array $data = [] ) {
        return $this->with( $key, $this->factory->make( $view_name, $data ) );
    }

    /**
     * Render the view.
     *
     * @return string
     */
    public function render() {
        if ( $this->factory->exists( $this->view ) ) {
            return $this->engine->render( $this->view, $this->gather_data() );
        }

        return '';
    }

    /**
     * Add a piece of data to the view.
     *
     * @param  array|string $key
     * @param  mixed        $value
     *
     * @return $this
     */
    public function with( $key, $value = null ) {
        if ( is_array( $key ) ) {
            $this->data = array_merge( $this->data, $key );
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Get the string contents of the view.
     *
     * @return string
     */
    public function __toString() {
        try {
            return $this->render();
        } catch ( \Exception $e ) {
            return '';
        }
    }

	/**
	 * Determine if key exists in view data.
	 *
	 * @param  string $key
	 *
	 * @return bool
	 */
	// @codingStandardsIgnoreStart
	public function offsetExists( $key ) {
	// @codingStandardsIgnoreEnd
		return array_key_exists( $key, $this->data );
	}

	/**
	 * Get value from view data.
	 *
	 * @param  string $key
	 *
	 * @return mixed
	 */
	// @codingStandardsIgnoreStart
	public function offsetGet( $key ) {
	// @codingStandardsIgnoreEnd
		return $this->data[$key];
	}

	/**
	 * Set a value to the view data.
	 *
	 * @param string $key
	 * @param mixed  $value
	 */
	// @codingStandardsIgnoreStart
	public function offsetSet( $key, $value ) {
	// @codingStandardsIgnoreEnd
        $this->with( $key, $value );
    }

	/**
	 * Unset value from view data.
	 *
	 * @param string $id
	 */
	// @codingStandardsIgnoreStart
	public function offsetUnset( $key ) {
	// @codingStandardsIgnoreEnd
		unset( $this->data[$key] );
	}

	/**
	 * Get value from view data.
	 *
	 * @param  string $key
	 *
	 * @return mixed
	 */
    public function &__get( $key ) {
        return $this->data[$key];
    }

	/**
	 * Determine if key exists in view data.
	 *
	 * @param  string $key
	 *
	 * @return bool
	 */
    public function __isset( $key ) {
        return array_key_exists( $key, $this->data );
    }

	/**
	 * Set a value to the view data.
	 *
	 * @param string $key
	 * @param mixed  $value
	 */
    public function __set( $key, $value ) {
        $this->with( $key, $value );
    }

	/**
	 * Unset value from view data.
	 *
	 * @param string $id
	 */
    public function __unset( $key ) {
        unset( $this->data[$key] );
    }

}
