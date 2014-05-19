<?php
/**
 * login.php
 * Created at 5/19/14
 */

include 'engine/engine.php';
include 'layout/header.html';

guest_only();

if (isset($_POST['submit'])) {

    $credentials = new Validation();
    $credentials->isEmpty($_POST['username'], 'Field username cant be empty');
    $credentials->isEmpty($_POST['password'], 'Field password cant be empty');

    if (!$credentials->_errors) {

        $account = $db->multipleQuery('SELECT * FROM accounts WHERE uuid = ? AND password = ? LIMIT 1', array($_POST['username'], sha1($_POST['password'])));

        if (count($account) > 0) {

            $_SESSION['logged'] = true;
            $_SESSION['user_data'] = array(

                'username' => $account[0]['uuid'],
                'password' => $account[0]['password'],
                'name'     => $account[0]['name'],
                'rank'     => $account[0]['rank'],
                'guild'    => $account[0]['guild'],
                'banned'   => $account[0]['banned'],
                'verified' => $account[0]['verified'],
                'vault'    => $account[0]['vaultCount'],
                'id'       => $account[0]['id']
            );

            header("Location: myaccount.php");

        } else {

            generate_errors(array('message' => 'Wrong username or password'));
        }

    } else {

        generate_errors($credentials->_errors);
    }
}
 