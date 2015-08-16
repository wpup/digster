<?php

namespace Digster;

use Digster\Engines\Engine;

class View {

    /**
     * The view engine instance.
     *
     * @var \Digster\Factory
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
     * @var \Digster\Factory
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
     * @param string $view
     *
     * @throws InvalidArgumentException if an argument is not of the expected type.
     */
    public function __construct( Factory $factory, Engine $engine, $view, $data = [] ) {
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
        $data    = array_merge( $this->factory->get_composer( $this ), $this->data );
        $data    = array_merge( $this->factory->get_shared(), $data );
        $result  = $data;

        foreach ( $data as $index => $callback ) {
            if ( is_callable( $callback ) ) {
                $value = call_user_func( $callback, $result );
            } else {
                $value = $callback;
            }

            if ( is_array( $value ) ) {
                $this->data = $result = $value;
            } else if ( is_string( $value ) && class_exists( $this->get_composer_class( $value ) ) ) {
                $value = $this->get_composer_class( $value );
				$class = new $value();
				$class->compose( $this );
                $result = array_merge( $result, $this->data );
            }
        }

        foreach ( $result as $key => $value ) {
            if ( $value instanceof View ) {
                $result[$key] = $value->render();
            }
        }

        return $result;
    }

	/**
	 * Get composer class name.
	 *
	 * @param string $class
	 *
	 * @return string
	 */
	protected function get_composer_class( $class ) {
		return preg_match( '/\_Composer$/', $class ) ?
			$class : $class . '_Composer';
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
     * @param string $key
     * @param string $view
     * @param array $data
     *
     * @return $this
     */
    public function nest( $key, $view, array $data = [] ) {
        return $this->with( $key, $this->factory->make( $view, $data ) );
    }

    /**
     * Render the view.
     *
     * @return string
     */
    public function render() {
        return $this->engine->render( $this->view, $this->gather_data() );
    }

    /**
     * Add a piece of data to the view.
     *
     * @param array|string $key
     * @param mixed $value
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

}
