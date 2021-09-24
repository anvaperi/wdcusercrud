<?php
  session_start();
  include_once 'includes/functions.php';

  spl_autoload_register(function ($className) {
    include_once 'includes/classes/' . strtolower($className) . '.php';
  });
?>