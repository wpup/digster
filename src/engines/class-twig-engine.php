<?php

namespace Digster\Engines;

use Twig_Environment;
use Twig_ExtensionInterface;
use Twig_Extension_Debug;
use Twig_Loader_Filesystem;
use Twig_LoaderInterface;
use LogicException;

class Twig_Engine extends Engine {

    /**
     * The Twig environment instance.
     *
     * @var \Twig_Environment
     */
    private static $instance = null;

    /**
     * Twig extension.
     *
     * @var string
     */
    protected $extensions = ['.twig', '.html'];

    /**
     * Add extension if it don't exists.
     *
     * @param \Twig_ExtensionInterface $extension
     */
    public function add_extension( Twig_ExtensionInterface $extension ) {
        $env  = $this->instance();
        $exts = $env->getExtensions();

        if ( isset( $exts[$extension->getName()] ) ) {
            return;
        }

        try {
            $env->addExtension( $extension );
        } catch ( LogicException $e ) {
            return;
        }
    }

    /**
     * Boot Twig environment.
     *
     * @return \Twig_Environment
     */
    private function boot() {
        list( $locations, $config ) = $this->get_engine_config();

        $loader = new Twig_Loader_Filesystem( $locations );
        $env    = new Twig_Environment( $loader, $config );

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            $env->addExtension( new Twig_Extension_Debug() );
        }

        return $env;
    }

    /**
     * Get the Twig environment instance.
     *
     * @return \Twig_Environment
     */
    private function instance() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = $this->boot();
        }

        return self::$instance;
    }

    /**
     * Get engine config.
     *
     * @return array
     */
    protected function prepare_engine_config() {
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
            if ( $extension instanceof Twig_ExtensionInterface ) {
                $this->add_extension( $extension );
            } else {
                foreach ( (array) $extension as $ext ) {
                    $this->register_extensions( $ext );
                }
            }
        }
    }

    /**
     * Get the rendered view string.
     *
     * @param string $view
     * @param array $data
     */
    public function render( $view, array $data = [] ) {
        if ( in_array( $view, $this->extensions ) ) {
            return '';
        }

        return $this->instance()->render( $view, $data );
    }

    /**
     * Set Twig loader.
     *
     * @param \Twig_LoaderInterface $loader
     */
    public function set_loader( Twig_LoaderInterface $loader ) {
        $this->instance()->setLoader( $loader );
    }

}
