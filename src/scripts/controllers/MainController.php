<?php
/*
 * @link      https://github.com/bit55/litero
 * @copyright Copyright (c) 2017 Eugene Dementyev.
 * @license   https://opensource.org/licenses/BSD-3-Clause
 */
namespace Bit55\Litero;

class MainController {

    public static function base() {
        $page = 'base';
        require_once './baseTemplate.php';
    }

    public static function services() {
        $jsonData = 'pages/services/services';
        require_once './baseTemplate.php';
    }

    public static function servicesAny($any) {
        $arr = explode('/', $any);
        $uri = '/services/' . $any;

        if (isset($arr[1])) {
            $jsonData = 'pages/services/' . $any;
            require_once './baseTemplate.php';
        } else {
            $jsonData = 'pages/services/' . $any. '/' . $any;
            require_once './baseTemplate.php';
        }
    }

    public static function sale() {
        $jsonData = 'pages/sale/sale';
        $uri = '/sale';
        require_once './baseTemplate.php';
    }
}

?>