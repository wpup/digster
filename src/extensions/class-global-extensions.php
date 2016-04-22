<?php

namespace Frozzare\Digster\Extensions;

class Global_Extensions extends \Twig_Extension implements \Twig_Extension_GlobalsInterface {

    /**
     * Get global variable.
     *
     * @return array
     */
    public function getGlobals() {
        return [
            'post' => get_post( get_the_ID() )
        ];
    }

    /**
     * Get the extension name.
     *
     * @return string
     */
    public function getName() {
        return 'digster-globals';
    }

}
