<?php

namespace DIY\Base\Utils;
use DIY\Base\Controller as DefaultController;

class DError extends DefaultController {

    /**
     * DError constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     *
     */
    public function error_code_403() {}

    /**
     *
     */
    public function error_code_404() {
        echo "The file does not exist";
    }

    /**
     *
     */
    public function error_code_500() {}

}
