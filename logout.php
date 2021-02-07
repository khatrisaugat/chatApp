<?php 
session_start();
session_destroy();
require_once ("config/config.php");
header("location:".base_url());
?>