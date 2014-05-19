<?php
/**
 * validation.php
 * Created at 5/19/14
 */

class Validation {

    public $_errors = false;

    public function __construct() {

    }

    public function isEmpty($field, $message) {

        if (empty($field)) $this->_errors[] = array('message' => $message);
    }

    public function isEmail($field, $message) {
        if (!filter_var($field, FILTER_VALIDATE_EMAIL)) $this->_errors[$field] = array('message' => $message);

    }

    public function isBigger($size, $field, $message) {

        if ($field > $size) $this->_errors[] = array('message' => $message);
    }

    public function isSmaller($size, $field, $message) {

        if ($field < $size) $this->_errors[] = array('message' => $message);
    }

    public function isInt($field, $message) {

        if (!filter_Var($field, FILTER_VALIDATE_INT)) $this->_errors[] = array('message' => $message);
    }

    public function isUrl($field, $message) {

        if (!filter_Var($field, FILTER_VALIDATE_URL)) $this->_errors[] = array('message' => $message);
    }

    public function isIp($field, $message) {

        if (!filter_Var($field, FILTER_VALIDATE_IP)) $this->_errors[] = array('message' => $message);
    }
}