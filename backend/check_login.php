<?php
session_start();

if (isset($_SESSION['serial'])) {
    echo json_encode(array('loggedIn' => true));
} else {
    echo json_encode(array('loggedIn' => false));
}
?>
