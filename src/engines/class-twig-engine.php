<?php

namespace Digster\Engines;

/**
 * Twig engine.
 *
 * @package Digster
 */

class Twig_Engine extends Engine {

    /**
     * The Twig environment instance.
     *
     * @var \Twig_Environment
     */

    private static $env_instance = null;

    /**
     * The default extension (empty string).
     *
     * @var string
     */

    protected $extension = '.twig';

    /**
     * Add extension without throwing a error that it exists.
     *
     * @param \Twig_ExtensionInterface $extension
     */

    protected function add_extension( \Twig_ExtensionInterface $extension ) {
        $env = $this->env_instance();

        try {
            $ext = $env->getExtension( $extension->getName() );
            return;
        } catch ( \Twig_Error_Runtime $e ) {
            $env->addExtension( $extension );

        }
    }

    /**
     * Boot Twig environment.
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
     * @return array
     */

    public function prepare_engine_config() {
        return $this->prepare_config( [
            'autoescape'          => true,
            'auto_reload'         => false,
            'base_template_class' => 'Twig_Template',
            'cache'               => WP_CONTENT_DIR . '/cache/twig',
            'charset'             => 'utf-8',
            'debug'               => false,
            'optimizations'       => -1,
            'strict_variables'    => false
        ] );
    }

    /**
     * Register Twig extensions that use `Twig_ExtensionInterface`.
     */

    public function register_extensions() {
        $extensions = func_get_args();

        foreach ( $extensions as $extension ) {
            if ( $extension instanceof \Twig_ExtensionInterface ) {
                $this->add_extension( $extension );
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
     */

    public function render( $template, $data = array() ) {
        $template = $this->extension( $template );
        $instance = $this->env_instance();
        $data     = $this->prepare_data( $template, $data );
        return $instance->render( $template, $data );
    }

    /**
     * Set Twig loader.
     *
     * @param Twig_LoaderInterface $loader
     */

    public function set_loader( \Twig_LoaderInterface $loader ) {
        $this->env_instance()->setLoader( $loader );
    }

}
