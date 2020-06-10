<?php

/**
 * @author      Obed Ademang <kizit2012@gmail.com>
 * @copyright   Copyright (C), 2015 Obed Ademang
 * @license     MIT LICENSE (https://opensource.org/licenses/MIT)
 *              Refer to the LICENSE file distributed within the package.
 *
 * @category    Form
 *
 */

namespace DIY\Base\Form;
use \Exception as Exception;

class Validate {
    // ------------------------------------------------------------------------

    /**
     * length - Require min and max length in one call
     *
     * @param string $value
     * @param array $param
     *
     * @return string For an error
     * @throws Exception For a malformed argument
     */
    public function length($value, $param) {

        if (!is_array($param) || count($param) > 2) {
            throw new Exception(__CLASS__ . ': Length Parameter must be an array of 1 (exact) or 2 (min/max).');
        }

        $len = strlen($value);

        if (count($param) == 1) {
            if ($len != $param[0]) {
                return "must be exactly $param[0] characters.";
            }
        } else {
            if ($len < $param[0] || $len > $param[1]) {
                return "must be between $param[0] and $param[1] characters.";
            }
        }
    }

    // ------------------------------------------------------------------------

    /**
     * minlength - Require a minimum length
     *
     * @param string $value
     * @param integer $param
     *
     * @return string For an error
     */
    public function minlength($value, $param) {
        if (strlen($value) < $param) {
            return "must be atleast $param in length";
        }
    }

    // ------------------------------------------------------------------------

    /**
     * maxlength - Require a maximum length
     *
     * @param string $value
     * @param integer $param
     *
     * @return string For an error
     */
    public function maxlength($value, $param) {
        if (strlen($value) > $param) {
            return "must be no more than $param in length";
        }
    }

    // ------------------------------------------------------------------------

    /**
     * exact - Require an exact length
     *
     * @param string $value
     * @param integer $param
     *
     * @return string For an error
     */
    public function exactlength($value, $param) {
        if (strlen($value) !== $param) {
            return "must be exactly $param in length";
        }
    }

    // ------------------------------------------------------------------------

    /**
     * gt - The value must be greater than the param
     *
     * @param string $value
     * @param mixed $param
     *
     * @return string For an error
     */
    public function gt($value, $param) {
        if (!is_int($param)) {
            throw new Exception(__CLASS__ . ": must supply an integer: $method");
        }

        if ($value <= $param) {
            return "must be greater than $param";
        }
    }

    // ------------------------------------------------------------------------

    /**
     * lt - The value must be less than the param
     *
     * @param string $value
     * @param mixed $param
     *
     * @return string For an error
     */
    public function lt($value, $param) {
        if (!is_int($param)) {
            throw new Exception(__CLASS__ . ": must supply an integer: $method");
        }

        if ($value >= $param) {
            return "must be less than $param";
        }
    }

    // ------------------------------------------------------------------------

    /**
     * eq - Make sure a value matches/equals something
     *
     * @param string $value
     * @param mixed $param
     *
     * @return string For an error
     */
    public function eq($value, $param) {
        if ($value !== $param) {
            return "does not match";
        }
    }

    // ------------------------------------------------------------------------

    /**
     * eqany - Require atleast a single match inside of an array
     *
     * @todo: This should combine with match, and you can pass an array
     *
     * @param string $value
     * @param array $param
     * @param boolean $caseSensitive Default: true
     *
     * @return string For an error
     */
    public function eqany($value, $param = array(), $caseSensitive = true) {
        if ($caseSensitive == false) {
            $value = strtolower($value);
            $param = array_map('strtolower', $param);
        }

        if (!is_array($param)) {
            throw new Exception(__CLASS__ . ': matchAny $param must be any array');
        }

        if (!in_array($value, $param)) {
            return "is not valid";
        }
    }

    // ------------------------------------------------------------------------

    /**
     * regex - Require a match of every item
     *
     * @param string $value
     * @param string $param Regular Expression
     */
    public function regex($value, $param) {
        if (!preg_match($param, $value)) {
            return 'must match regular expression';
        }
    }

    // ------------------------------------------------------------------------

    /**
     * digit - Require a digit
     *
     * @param mixed $value
     *
     * @return string For an error
     */
    public function digit($value) {
        if (!is_numeric($value)) {
            return 'must be numeric.';
        }
    }

    // ------------------------------------------------------------------------

    /**
     * float - Require float value
     *
     * @param float $value
     *
     * @return string For an error
     */
    public function float($value) {
        if (!is_float($value)) {
            return 'must be a float.';
        }
    }

    // ------------------------------------------------------------------------

    /**
     * alpha - Require only alphabetical characters
     *
     * @param string $value
     *
     * @return string For an error
     */
    public function alpha($value) {
        if (!ctype_alpha($value)) {
            return 'must be alphabetical only.';
        }
    }

    // ------------------------------------------------------------------------

    /**
     * alphanum - Require only alphanumeric characters
     *
     * @param string $value
     *
     * @return string For an error
     */
    public function alphanum($value) {
        if (!ctype_alnum($value)) {
            return 'must be alphanumeric only.';
        }
    }

    // ------------------------------------------------------------------------

    /**
     * email - Require an email
     *
     * @param string $value
     *
     * @return string For an error
     */
    public function email($value) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return 'invalid email format.';
        }
    }

    // ------------------------------------------------------------------------

    /**
     * age - Checks to see if a person is old enough
     *
     * @param string $dob Use MySQL Format YYYY-MM-DD
     * @param string $min Minimum age allowed
     *
     * @return integer
     */
    public function agemin($dob, $min = 18) {
        try {
            $result = $this->_ageCalc($dob);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        if ($result <= 0 || $result >= 125) {
            return "invalid date provided";
        }

        if ($result < $min) {
            return "minimum age is $min";
        }
    }

    // ------------------------------------------------------------------------

    /**
     * age - Checks to see if a person is young enough
     *
     * @param string $dob Use MySQL Format YYYY-MM-DD
     * @param string $min Minimum age allowed
     *
     * @return integer
     */
    public function agemax($dob, $max = 50) {
        try {
            $result = $this->_ageCalc($dob);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        if ($result <= 0 || $result >= 125) {
            return "invalid date provided";
        }

        if ($result > $max) {
            return "maximum age is $max";
        }
    }

    // ------------------------------------------------------------------------

    /**
     * _ageCalc - Return the age
     *
     * @param string $dob Date of birth
     *
     * @return integer Age based on date calculation
     */
    private function _ageCalc($dob) {
        /** Make sure a valid string is being passed for the date */
        if (!preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $dob)) {
            throw new Exception('date format must be in YYYY-MM-DD');
        }

        list($yyyy, $mm, $dd) = explode('-', $dob);

        if (($mm = (date('m') - $mm)) < 0) {
            $yyyy++;
        } elseif ($mm == 0 && date('d') - $dd < 0) {
            $yyyy++;
        }

        return (int) date('Y') - $yyyy;
    }

    // ------------------------------------------------------------------------

    /**
     * __call - Handles non-existant methods
     *
     * @param string $method
     * @param string $arg
     *
     * @throws Exception
     */
    public function __call($method, $arg = null) {
        $args = func_get_args();
        array_shift($args); // Remove the method name
        /**
         * Aliases
         */
        switch ($method) {
            case 'len':
                return $this->length($args[0][0], $args[0][1]);
                break;
            case 'minlen':
                return $this->minlength($args[0][0], $args[0][1]);
                break;
            case 'maxlen':
                return $this->maxlength($arg[0][0], $args[0][1]);
                break;
            case 'match':
                return $this->eq($args[0][0], $args[0][1]);
                break;
            case 'matchany':
                return $this->eqany($args[0], $args[0][1]);
                break;
            case 'greaterthan':
                return $this->gt($args[0][0], $args[0][1]);
                break;
            case 'lessthan':
                return $this->lt($args[0][0], $args[0][1]);
                break;
            default:
                throw new Exception(__CLASS__ . ": Does not have any method called: $method");
        }
    }

    // ------------------------------------------------------------------------
}

/** eof */