<?php


// this is my controler

//turn on buffering
ob_start();

// turnon error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//start session
session_start();
var_dump($_SESSION);
//require autoload file
require_once('vendor/autoload.php');


//create instance of the base class
$f3 = Base::instance();


//define a default root
$f3->route('GET /', function () {
    //echo "<h1>hello world</h1>";
    session_destroy();
    $view = new Template();
    echo $view->render('views/home.html');

});

$f3->route('GET /survey', function () {
    //echo "<h1>hello world</h1>";
    session_destroy();
    $view = new Template();
    echo $view->render('views/survey.html');

});


//run fat free
$f3->run();

ob_flush();
