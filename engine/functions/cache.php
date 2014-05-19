<?php
/**
 * cache.php
 * Created at 5/19/14
 */

class Cache {

    private $_file;
    private $_expiration;
    private $_content;

    public function __construct($file, $lifetime) {

        $this->_file = $file.'.cache.php';
        $this->_expiration = $lifetime;
    }

    public function hasExpired() {

        if (is_file('engine/cache/'.$this->_file ) && time() < filemtime('engine/cache/'.$this->_file) + $this->_expiration) {

            return false;

        } else {

            return true;
        }
    }

    public function loadCache() {

        ob_start();

        include 'engine/cache/'.$this->_file;

        $this->_content = json_decode(ob_get_clean(), true);

        return (array) $this->_content;
    }

    public function setContent($content) {

        $this->_content = json_encode($content);
        $cache_file = fopen('engine/cache/'.$this->_file, 'w');

        fwrite($cache_file, $this->_content);
        fclose($cache_file);
    }
}