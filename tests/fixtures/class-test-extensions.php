<?php

class Test_Extensions extends \Twig_Extension {

    /**
     * Get global variable.
     *
     * @return array
     */
    public function getGlobals() {
        return [
            'post' => 1
        ];
    }

    /**
     * Get the extension name.
     *
     * @return string
     */
    public function getName() {
        return 'fixtures-test';
    }

}
