<?PHP

include 'engine/engine.php';
include 'layout/header.html';
	unset($_SESSION['logged']);
	unset($_SESSION['user_data']);
    header("Location: index.php"); 

?>
