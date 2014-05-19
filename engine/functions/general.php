<?php
/**
 * general.php
 * Created at 5/19/14
 */

// Generate errors from a validation class or just a normal array

function generate_errors($errs = array()) {

    echo '<h1><span class="glyphicon glyphicon-fire"></span> Following errors occurred </h1><br><div class="alert alert-danger"><ul>';

    foreach ($errs as $errors) {

        echo '<li>'.$errors['message'].'</li>';
    }

    echo '</ul></div>';
}

// Check if user is logged

function logged_only() {

    if (!isset($_SESSION['logged'])) header("Location: index.php");
}

// Check if user is not logged

function guest_only() {

    if (isset($_SESSION['logged'])) header("Location: myaccount.php");
}

// Logout

function log_out() {

    unset($_SESSION['logged']);
    unset($_SESSION['user_data']);

    header("Location: index.php");
}

// Generate CSRF

function generate_csrf($length) {

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    $_SESSION['csrf'] = $randomString;

    return $randomString;
}

// Check CSRF POST with SESSION

function check_csrf($csrf) {

    if ($csrf != $_SESSION['csrf']) header("Location: index.php");
}

// Render item image from ID

function render_image($item_list = array(), $id) {

    $image = $item_list[$id];

    echo '<span class="item" data-item="'.$id.'" style="background-position: -'.$image[3].'px '.$image[4].'px;"></span>';
}