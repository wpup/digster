<?php

namespace Digster\Engines;

use Frozzare\Tank\Container;

abstract class Engine extends Container {

    /**
     * The default extensions.
     *
     * @var string
     */
    protected $extensions = ['.html'];

    /**
     * Get or set configuration values.
     *
     * @param array|string $key
     * @param mixed $value
     *
     * @return mixed
     */
    public function config( $key, $value = null ) {
        if ( is_array( $key ) ) {
            foreach ( $key as $id => $val ) {
                $this->config( $id, $val );
            }
        } else {
            if ( ! is_null( $value ) ) {
                return $this->bind( $key, $value );
            }

            if ( $this->exists( $key ) ) {
                return $this->make( $key );
            } else {
                $default = $this->get_default_config();
                return isset( $default[$key] ) ? $default[$key] : null;
            }
        }
    }

    /**
     * Get default configuration.
     *
     * @return array
     */
    protected function get_default_config() {
        $config = [];

        $config['locations'] = [
            get_template_directory() . '/views'
        ];

        return $config;
    }

    /**
     * Get the file extensions.
     *
     * @return array
     */
    public function extensions() {
        return $this->extensions;
    }

    /**
     * Get engine config.
     *
     * @return array
     */
    protected function get_engine_config() {
        $config    = $this->prepare_engine_config();
        $locations = $config['locations'];

        unset( $config['locations'] );

        $locations = array_filter( (array) $locations, function ( $location ) {
            return file_exists( $location );
        } );

        return [$locations, $config];
    }

	/**
	 * Get view locations.
	 *
	 * @return array
	 */
	public function get_locations() {
		list( $locations, $config ) = $this->get_engine_config();
		return $locations;
	}

    /**
     * Prepare the template engines real configuration.
     *
     * @param array $arr
     *
     * @return array
     */
    protected function prepare_config( $arr ) {
        $result = [];

        if ( ! is_array( $arr ) ) {
            return $result;
        }

        $arr = array_merge( $this->get_default_config(), $arr );

        foreach ( $arr as $key => $value ) {
            $res          = $this->config( $key );
            $result[$key] = is_null( $res ) ? $value : $res;
        }

        return apply_filters( 'digster/config', $result );
    }

    /**
     * Register extension.
     */
    abstract protected function prepare_engine_config();

    /**
     * Register extensions.
     */
    abstract public function register_extensions();

    /**
     * Get the rendered view string.
     *
     * @param string $view
     * @param array $data
     */
    abstract public function render( $view, array $data = [] );

}
