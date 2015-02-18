<?php 
    $verify_token = "tokentest";
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'GET' && $_GET['hub_verify_token'] === $verify_token) {
      echo $_GET['hub_challenge'];
    }
?>