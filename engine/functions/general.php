<?php
/**
 * general.php
 * Created at 5/19/14
 */

function generate_errors($errs = array()) {

    echo '<br><div class="alert alert-danger"><span class="glyphicon glyphicon-fire"></span> Following errors occurred <ul>';

    foreach ($errs as $errors) {

        echo '<li>'.$errors['message'].'</li>';
    }

    echo '</ul></div>';
}

function logged_only() {

    if (!isset($_SESSION['logged'])) header("Location: login.php");
}

function guest_only() {

    if (isset($_SESSION['logged'])) header("Location: myaccount.php");
}