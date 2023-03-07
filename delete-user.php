<?php


require dirname(__FILE__). "/PHPFunc/db-connect.php";
require dirname(__FILE__). "/PHPFunc/dbcheck.php";
require dirname(__FILE__). "/Style/links.php";


delete_user();


header ("Location: /projects/Bookface/admin.php");

?>