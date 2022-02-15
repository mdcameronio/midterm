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
require ('model/data-layer.php');
require ("model/valid-function.php");


//create instance of the base class
$f3 = Base::instance();


//define a default root
$f3->route('GET /', function () {
    //echo "<h1>hello world</h1>";
    session_destroy();
    $view = new Template();
    echo $view->render('views/home.html');

});

$f3->route('GET|POST /survey', function ($f3) {
    //echo "<h1>hello world</h1>";
    $name = "";
    $comm = "";
    //Get the comms from the model and add to F3 hive
    $f3->set('comm', getcomm());

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];

        //Add the data to the session variable
        //If condiments were selected
        if(empty($_POST['name'])){
            $f3->set("errors['name']", "enter name");
        }else{
            $_SESSION['name'] = $_POST['name'];
        }
        if (isset($_POST['comm'])) {

            $comm = $_POST['comm'];

            //If coms are valid
            if (validComs($comm)) {
                $comm = implode(", ", $_POST['comm']);
            }
            else {
                $f3->set("errors['comm']", "Invalid selection");
            }
        }
        else {

            $comm = "None selected";
        }

        //Redirect user to summary page
        if (empty($f3->get('errors'))) {
            $_SESSION['comm'] = $comm;
            $f3->reroute('summery');
        }
    }

    $f3->set('name',$name);
    $f3->set('usercomm',$comm);

    $view = new Template();
    echo $view->render('views/survey.html');

});


//run fat free
$f3->run();

ob_flush();
