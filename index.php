<?php

//This is my controller for the diner project

//Turn on error-reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//Require autoload file
require_once ('vendor/autoload.php');

//Instantiate Fat-Free
$f3 = Base::instance();

//Define default route
$f3->route('GET /', function(){
    //Display the home page
    $view = new Template();
    echo $view->render('views/home.html');
});

$f3->route('GET /breakfast', function(){
    $view = new Template();
    echo $view->render('views/breakfast.html');
});

$f3->route('GET /lunch', function(){
    $view = new Template();
    echo $view->render('views/lunch.html');
});

$f3->route('GET|POST /order1', function(){
    //If the form has been submitted, add the data to the session
    //and send the user to the next order form
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //var_dump($_POST);
        $_SESSION['food'] = $_POST['food'];
        $_SESSION['meal'] = $_POST['meal'];
        header('location: order2');
    }
    $view = new Template();
    echo $view->render('views/orderForm1.html');
});

$f3->route('GET|POST /order2', function(){
    //If the form has been submitted, add the data to the session
    //and send the user to the summary page
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //var_dump($_POST);
        $_SESSION['conds'] = implode(", ", $_POST['conds']);
        header('location: summary');
    }
    $view = new Template();
    echo $view->render('views/orderForm2.html');
});

$f3->route('GET|POST /summary', function(){
    $view = new Template();
    echo $view->render('views/summary.html');
});

//Run Fat-Free
$f3->run();

