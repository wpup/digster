<?php

/**
 * Digster - Twig templates for WordPress.
 *
 * @package Digister
 * @license MIT
 * @version 1.0.0
 */

namespace Digster\Engines;

/**
 * Twig engine.
 *
 * @package Digster
 * @since 1.0.0
 */

class Twig_Engine extends Engine {

    /**
     * The Twig environment instance.
     *
     * @var \Twig_Environment
     * @since 1.0.0
     */

    private static $env_instance = null;

    /**
     * The default extension (empty string).
     *
     * @var string
     * @since 1.0.0
     */

    protected $extension = '.twig';

    /**
     * Boot Twig environment.
     *
     * @since 1.0.0
     *
     * @return \Twig_Environment
     */

    private function boot() {
        list( $locations, $config ) = $this->get_engine_config();

        $loader = new \Twig_Loader_Filesystem( $locations );
        $env    = new \Twig_Environment( $loader, $config );

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            $env->addExtension( new \Twig_Extension_Debug() );
        }

        return $env;
    }

    /**
     * Get the Twig environment instance.
     *
     * @since 1.0.0
     *
     * @return \Twig_Environment
     */

    private function env_instance() {
        if ( ! isset( self::$env_instance ) ) {
            self::$env_instance = $this->boot();
        }

        return self::$env_instance;
    }

    /**
     * Get engine config.
     *
     * @since 1.0.0
     *
     * @return array
     */

    public function prepare_engine_config() {
        return $this->prepare_config( [
            'autoescape'          => true,
            'auto_reload'         => false,
            'base_template_class' => 'Twig_Template',
            'cache'               => [
                WP_CONTENT_DIR . '/cache/twig'
            ],
            'charset'             => 'utf-8',
            'debug'               => false,
            'optimizations'       => -1,
            'strict_variables'    => false
        ] );
    }

    /**
     * Register Twig extensions that use `Twig_ExtensionInterface`.
     *
     * @since 1.0.0
     */

    public function register_extensions() {
        $extensions = func_get_args();

        foreach ( $extensions as $extension ) {
            if ( $extension instanceof \Twig_ExtensionInterface ) {
                $this->env_instance()->addExtension( $extension );
            } else {
                foreach ( (array) $extension as $ext ) {
                    $this->register_extensions( $ext );
                }
            }
        }
    }

    /**
     * Render the data.
     *
     * @param string $template
     * @param array $data
     * @since 1.0.0
     */

    public function render( $template, $data = array() ) {
        $template = $this->extension( $template );
        $instance = $this->env_instance();
        $data     = $this->prepareData( $template, $data );

        return $instance->render( $template, $data );
    }

}
