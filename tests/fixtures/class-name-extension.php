<?php

namespace Digster\Tests\Fixtures;

class Name_Extension extends \Twig_Extension {

    /**
     * Get functions.
     *
     * @return array
     */

    public function getFunctions() {
        return [
            new \Twig_SimpleFunction('name', function () {
                return 'World';
            })
        ];
    }

    /**
     * Get the extension name.
     *
     * @return string
     */

    public function getName() {
        return '';
    }

}
