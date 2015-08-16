<?php

namespace Digster;

use Closure;
use Digster\Engines\Engine;
use Digster\Finder;

class Factory {

    /**
     * The engine in use.
     *
     * @var \Digster\View\Engines\Engine
     */
    protected $engine;

    /**
     * The view composers.
     *
     * @var array
     */
    protected $composers = [];

    /**
     * Shared data for the views.
     *
     * @var array
     */
    protected $shared = [];

    /**
     * The constructor.
     *
     * @param \Digster\Engine $engine
     */
    public function __construct( Engine $engine ) {
        $this->engine = $engine;
    }

    /**
     * Register preprocess with views.
     *
     * @param array|string $views
     * @param \Closure $fn
     */
    public function composer( $views, $callback ) {
        foreach ( (array) $views as $view ) {
            if ( $callback instanceof Closure === false ) {
                $callback = function () use ( $callback ) {
                    return $callback;
                };
            }

            if ( $view === '*' ) {
                $this->shared[] = $callback;
                continue;
            }

            $view = $this->view( $view );

            if ( ! isset( $this->composers[$view] ) ) {
                $this->composers[$view] = [];
            }

            $this->composers[$view][] = $callback;
        }
    }

    /**
     * Get the view engine.
     *
     * @return \Digster\Engine
     */
    public function engine() {
        return $this->engine;
    }

    /**
     * Determine if a given view exists.
     *
     * @param string $view
     *
     * @return bool
     */
    public function exists( $view ) {
        return $this->engine()->view_exists( $this->view( $view ) );
    }

    /**
     * Add extension to the view string if it don't exists.
     *
     * @param string $view
     *
     * @return string
     */
    protected function extension( $view ) {
        $extensions = $this->extensions();

        // Return if a valid extension exists in the template string.
        $ext_reg = '/(' . implode( '|', $extensions ) . ')+$/';
        if ( preg_match( $ext_reg, $view ) ) {
            return $template;
        }

        // Add extension to template string if it don't exists.
        return substr( $view, -strlen( $extensions[0] ) ) === $extensions[0]
            ? $view : $view . $extensions[0];
    }

    /**
     * Get the extensions from the engine.
     *
     * @return array
     */
    protected function extensions() {
        return $this->engine->extensions();
    }

    /**
     * Call composer.
     *
     * @param \Digster\View $view
     *
     * @return string
     */
    public function get_composer( View $view ) {
        $view_name = $view->get_name();

        if ( isset( $this->composers[$view_name] ) ) {
            return $this->composers[$view_name];
        }

        return [];
    }

    /**
     * Get all of the shared data for the views.
     *
     * @return array
     */
    public function get_shared() {
        return $this->shared;
    }

    /**
     * Get the evaluated view contents for the given view.
     *
     * @param string $view
     * @param array $data
     *
     * @return \Digster\View
     */
    public function make( $view, array $data = [] ) {
        return new View( $this, $this->engine, $this->view( $view ), $data );
    }

    /**
     * Get the right view string from dot view or view that missing extension.
     *
     * @param string $view
     *
     * @return string
     */
    public function view( $view ) {
        if ( preg_match( '/\.\w+$/', $view, $matches ) && in_array( $matches[0], $this->extensions() ) ) {
            return str_replace( '.', '/', preg_replace( '/' . $matches[0] . '$/', '', $view ) ) . $matches[0];
        }

        return $this->extension( str_replace( '.', '/', $view ) );
    }

}
