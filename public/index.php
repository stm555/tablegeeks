<?php 
// @see application/bootstrap.php
$bootstrap = true; 
require '../application/bootstrap.php';  

// $frontController is created in your boostrap file. Now we'll dispatch it, which dispatches your application. 
$frontController->dispatch();
