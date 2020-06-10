<?php

/**
 * @author		Obed Ademang <kizit2012@gmail.com>
 * @copyright	Copyright (C), 2015 Obed Ademang
 * @license		MIT LICENSE (https://opensource.org/licenses/MIT)
 * 				Refer to the LICENSE file distributed within the package.
 *
 *
 * @category	Form
 *
 */

namespace DIY\Base\Form;
use \Exception as Exception;

class Format {
    // ------------------------------------------------------------------------

    /**
     * call - Run any PHP function to format
     *
     * @param string $call
     * @param string $param
     *
     * @return string
     *
     * @throws Exception Upon invalid function
     */
    public function __call($call, $unlimitedParams) {
        if (!function_exists($call)) {
            throw new Exception(__CLASS__ . ": Invalid formatting: $call (Invalid Function)");
        }
        $args = func_get_args();
        $param = $args[1];
        /**
         * Count the arguments beyond the call
         */
        switch (count($param)) {
            case 2:
                return call_user_func($call, $param[0], $param[1]);
                break;
            case 3:
                return call_user_func($call, $param[0], $param[1], $param[2]);
                break;
            case 4:
                return call_user_func($call, $param[0], $param[1], $param[2], $param[3]);
                break;
            default:
                return call_user_func($call, $param[0]);
        }
    }

    // ------------------------------------------------------------------------

    /**
     * upper - Shortcut
     *
     * @param string $str String to format
     *
     * @return string
     */
    public function upper($str) {
        return strtoupper($str);
    }

    // ------------------------------------------------------------------------

    /**
     * lower - Shortcut
     *
     * @param string $str String to format
     *
     * @return string
     */
    public function lower($str) {
        return strtolower($str);
    }

    // ------------------------------------------------------------------------

    /**
     * replace - Replaces values in a string
     *
     * @param string $str String to change
     * @param string $array Item to change the value to
     *
     * @return string
     *
     * @throws Exception
     */
    public function replace($str, $param) {
        if (count($param) != 2) {
            throw new Exception(__FUNCTION__ . ': $param must have two values: find, replace');
        }
        return str_replace($param[0], $param[1], $str);
    }

    // ------------------------------------------------------------------------

    /**
     * iftrue - If the value is set, change the value to the parameter
     *
     * @param string $str String to change
     * @param string $array Item to change the value to
     *
     * @return string
     */
    public function iftrue($str, $param) {
        if (!empty($str)) {
            return $param[0];
        }
    }

    // ------------------------------------------------------------------------

    /**
     * iffalse - If the value is not set, change the value to the parameter
     *
     * @param string $str String to change
     * @param string $array Item to change the value to
     *
     * @return string
     */
    public function iffalse($str, $param) {
        if (empty($str)) {
            return $param[0];
        }
    }

    // ------------------------------------------------------------------------

    /**
     * ifgt - If greater than, replace with ..
     *
     * @param mixed $str Integer will compare value, String will compare length
     * @param array $param When greater than, replace value of key 0 with 1
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function ifgt($str, $param) {
        if (count($param) != 2) {
            throw new Exception(__FUNCTION__ . ': $param must have two values: find, replace');
        }

        if (is_int($str)) {
            if ($str > $param[0]) {
                return $param[1];
            }
        }

        if (is_string($str)) {
            if (strlen($str) > $param[0]) {
                return $param[1];
            }
        }
    }

    // ------------------------------------------------------------------------

    /**
     * iflt - If less than, replace with ..
     *
     * @param mixed $str Integer will compare value, String will compare length
     * @param array $param When less than, replace value of key 0 with 1
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function iflt($str, $param) {
        if (count($param) != 2) {
            throw new Exception(__FUNCTION__ . ': $param must have two values: find, replace');
        }

        if (is_int($str)) {
            if ($str > $param[0]) {
                return $param[1];
            }
        }
        if (is_string($str)) {
            if (strlen($str) > $param[0]) {
                return $param[1];
            }
        }
    }

    // ------------------------------------------------------------------------

    /**
     * ifeq - If equals than, replace with ..
     *
     * @param mixed $str Integer will compare value, String will compare value
     * @param array $param When equal, replace value of key 0 with 1
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function ifeq($str, $param) {
        if (count($param) != 2) {
            throw new Exception(__FUNCTION__ . ': $param must have two values: find, replace');
        }

        if (is_int($str)) {
            if ($str == $param[0]) {
                return $param[1];
            }
        }

        if (is_string($str)) {
            if ($str == $param[0]) {
                return $param[1];
            }
        }
    }

    // ------------------------------------------------------------------------

    /**
     * toint - Cast to an integer
     *
     * @param string $str
     *
     * @return integer
     */
    public function toint($str) {
        return (integer) $str;
    }

    // ------------------------------------------------------------------------

    /**
     * tostr - Cast to string
     *
     * @param string $str
     *
     * @return string
     */
    public function tostr($str) {
        return (string) $str;
    }

    // ------------------------------------------------------------------------

    /**
     * slug - Formats to a URL friendly slug
     *
     * @param string $str
     *
     * @return string
     */
    public function slug($str) {
        $str = strtolower($str);
        $str = preg_replace('/[^a-z0-9_\s-]/', '', $str);
        $str = preg_replace("/[\s-]+/", " ", $str);
        $str = preg_replace("/[\s_]/", "-", $str);
        return (string) $str;
    }

    // ------------------------------------------------------------------------

    /**
     * regex - Run a replacement with a regex pattern (preg_replace)
     *
     * @param string $str
     * @param array $param The Regular Expression and Replacements
     *
     * @return string
     *
     * @throws Exception
     */
    public function regex($str, $param) {
        if (count($param) != 2) {
            throw new Exception(__FUNCTION__ . ': $param must have two values: regex');
        }

        return preg_replace($param[0], $param[1], $str);
    }

    // ------------------------------------------------------------------------

    /**
     * hash - Use a custom hash algorithm
     *
     * @param string $str
     * @param array $param One or two arguements. 1: Encryption Method, 2: Hash Key (Optional)
     */
    public function hash($str, $param) {
        if (!is_array($param) || count($param) > 2 || empty($param)) {
            throw new Exception(__FUNCTION__ . ': $param must have one or two values (Encryption, Key (Optional))');
        }

        if (count($param) == 1) {
            $ctx = hash_init($param[0]);
        } else {
            $ctx = hash_init($param[0], HASH_HMAC, $param[1]);
        }

        /** Finalize the output */
        hash_update($ctx, $str);
        return hash_final($ctx);
    }

    // ------------------------------------------------------------------------
}

/** eof */