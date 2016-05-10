<?php

namespace Frozzare\Digster\Engines;

use Twig_Environment;
use Twig_Error;
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
            'autoescape'          => 'html',
            'auto_reload'         => null,
            'base_template_class' => 'Twig_Template',
            'cache'               => false,
            'charset'             => 'UTF-8',
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
            } else if ( is_string( $extension ) && class_exists( $extension ) ) {
                $this->add_extension( new $extension );
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
     * @param array  $data
     */
    public function render( $view, array $data = [] ) {
        if ( in_array( $view, $this->extensions ) ) {
            return '';
        }

        try {
            return $this->instance()->render( $view, $data );
        } catch ( Twig_Error $e ) {
            do_action( 'digster/twig_render_exception', $e );
            $this->render_error( $e );
        }
    }

    /**
     * Render error view.
     *
     * @param  \Twig_Error $e
     */
    protected function render_error( Twig_Error $e ) {
        $title   = 'Error';
        $message = 'An error occurred while rendering the template for this page. Turn on the "debug" option for more information.';
        $file    = '';
        $code    = '';

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            $template_file     = $e->getTemplateFile();
            list( $locations ) = $this->get_engine_config();

            foreach ( $locations as $location ) {
                if ( file_exists( $location . '/' . $template_file ) ) {
                    $file = $locations[0] . '/' . $template_file;
                    break;
                }
            }

            if ( ! file_exists( $file ) ) {
                throw $e;
                return;
            }

            $line    = $e->getTemplateLine();
            $plus    = 4;
            $content = file_get_contents( $file );
            $lines   = preg_split( "/(\r\n|\n|\r)/", $content );
            $start   = max( 1, $line - $plus );
            $limit   = min( count( $lines ), $line + $plus );
            $excerpt = [];

            for ( $i = $start - 1; $i < $limit; $i++ ) {
                $attr = sprintf( 'data-line="%d"', ( $i+1 ) );

                if ( $i === $line - 1 ) {
                    $excerpt[] = sprintf( '<mark %s>%s</mark>', $attr, $lines[$i] );
                    continue;
                }

                $excerpt[] = sprintf( '<span %s>%s</span>', $attr, $lines[$i] );
            }

            $title   = get_class( $e );
            $message = $e->getMessage();
            $code    = implode( "\n", $excerpt );
            $file    = $file . ':' . $line;
            $message = $e->getRawMessage();
        }

        $view = 'error.php';
        $path = __DIR__ . '/../views/';
        $path = rtrim( $path, '/' ) . '/';
        $path = $path . $view;
        $path = apply_filters( 'digster/twig_error_view', $path );

        if ( file_exists( $path ) ) {
            require $path;
            die;
        }

        throw $e;
    }

    /**
     * Set Twig loader.
     *
     * @param \Twig_LoaderInterface $loader
     */
    public function set_loader( Twig_LoaderInterface $loader ) {
        $this->instance()->setLoader( $loader );
    }

    /**
     * Determine if a given view exists.
     *
     * @param  string $view
     *
     * @return bool
     */
    public function view_exists( $view ) {
        return $this->instance()->getLoader()->exists( $view );
    }
}
