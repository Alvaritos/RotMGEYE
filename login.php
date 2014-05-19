<?php
/**
 * login.php
 * Created at 5/19/14
 */

include 'engine/engine.php';
include 'layout/header.html';

if (isset($_POST['submit'])) {

    $credentials = new Validation();
    $credentials->isEmpty($_POST['username'], 'Field username cant be empty');
    $credentials->isEmpty($_POST['password'], 'Field password cant be empty');

    if (!$credentials->_errors) {

        echo 'wow';

    } else {

        var_dump($credentials->_errors);
    }
}
 