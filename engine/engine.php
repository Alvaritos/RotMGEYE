<?php include 'database.php';
/**
 * engine.php
 * Created at 5/19/14
 */

ob_start();
session_start();

$config = include 'config/config.php';

include 'functions/cache.php';
include 'functions/general.php';
include 'functions/validation.php';

$item_list = include 'layout/js/renders.php';
$db = new Database($config['mysql']);



