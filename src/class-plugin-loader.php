<?php

namespace Digster;

/**
 * Hook the WordPress plugin into the appropriate WordPress actions and filters.
 */

final class Plugin_Loader {

    /**
     * The instance of Plugin loader class.
     *
     * @var object
     * @since 1.0.0
     */

    private static $instance;

    /**
     * Get Plugin boilerplate loader instance.
     *
     * @since 1.0.0
     *
     * @return object
     */

    public static function instance() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new self;
            self::$instance->setup_actions();
        }

        return self::$instance;
    }

    /**
     * Load Digster extensions.
     *
     * @since 1.0.0
     */

    public function load_extensions() {
        $extensions = [
            new \Digster\Extensions\Filter_Extensions(),
            new \Digster\Extensions\Function_Extensions(),
            new \Digster\Extensions\Global_Extensions()
        ];

        $extensions = apply_filters( 'digster/extensions', $extensions );

        View::register_extensions( $extensions );
    }

    /**
     * Setup actions.
     *
     * @since 1.0.0
     */

    private function setup_actions() {
        add_action( 'after_setup_theme', [$this, 'load_extensions'] );
    }

}
