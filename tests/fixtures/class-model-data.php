<?php

use Frozzare\Digster\Contracts\Model;

class Model_Data implements Model {

    /**
     * Get model instance as a array.
     *
     * @return array
     */
    public function to_array() {
        return [
            'name' => 'Fredrik'
        ];
    }

}
