<?php

//This is my controller for the diner project

//Turn on error-reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//Require autoload file
require_once ('vendor/autoload.php');
require_once ('model/data-layer.php');
require_once ('model/validation.php');

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

$f3->route('GET|POST /order1', function($f3){

    //Reinitialize session array
    $_SESSION = array();

    //Initialize variables to store user input
    $userFood = "";
    $userMeal = "";

    //If the form has been submitted, add the data to the session
    //and send the user to the next order form
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //var_dump($_POST);

        $userFood = $_POST['food'];
        $userMeal = $_POST['meal'];

        //If food is valid, store data
        if(validFood($_POST['food'])) {
            $_SESSION['food'] = $userFood;
        }
        else {
            $f3->set('errors["food"]', 'Invalid food');
        }

        //If meal is valid, store data
        if(!empty($userMeal) && validMeal($_POST['meal'])) {
            $_SESSION['meal'] = $userMeal;
        }
        //Otherwise, set an error variable in the hive
        else {
            $f3->set('errors["meal"]', 'Invalid meal');
        }

        //If there are no errors, redirect to order2
        if (empty($f3->get('errors'))) {
            header('location: order2');
        }
    }

    //Get the data from the model
    $f3->set('meals', getMeals());

    //Store the user input in the hive
    $f3->set('userFood', $userFood);
    $f3->set('userMeal', $userMeal);

    $view = new Template();
    echo $view->render('views/orderForm1.html');
});

$f3->route('GET|POST /order2', function($f3){
    //If the form has been submitted, add the data to the session
    //and send the user to the summary page
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //var_dump($_POST);

        if (!empty($_POST['conds'])) {
            if (validCondiments($_POST['conds'])) {
                $_SESSION['conds'] = implode(", ", $_POST['conds']);
            }
            else {
                $f3->set('errors["conds"]', 'Invalid selection');
            }
        }

        if (empty($f3->get('errors'))) {
            header('location: summary');
        }
    }

    //Get the data from the model
    $f3->set('conds', getConds());

    $view = new Template();
    echo $view->render('views/orderForm2.html');
});

$f3->route('GET|POST /summary', function(){
    $view = new Template();
    echo $view->render('views/summary.html');
});

//Run Fat-Free
$f3->run();

