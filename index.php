<?php

//This is my controller for the diner project

//Turn on error-reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require autoload file
require_once ('vendor/autoload.php');
require_once ('model/data-layer.php');
require_once ('model/validation.php');
//require_once ('classes/order.php');

//Start a session AFTER the autoload
session_start();

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

    //Instantiate order object
    //$order = new Order();
    //var_dump($order);

    $_SESSION['order'] = new Order();

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
            $_SESSION['order']->setFood($userFood);
        }
        else {
            $f3->set('errors["food"]', 'Invalid food');
        }

        //If meal is valid, store data
        if(!empty($userMeal) && validMeal($_POST['meal'])) {
            $_SESSION['order']->setMeal($userMeal);
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

    $userConds = array();

    //If the form has been submitted, add the data to the session
    //and send the user to the summary page
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //var_dump($_POST);

        if (!empty($_POST['conds'])) {

            $userConds = $_POST['conds'];

            if (validCondiments($userConds)) {
                $_SESSION['order']->setCondiments(implode(", ", $userConds));
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

    $f3->set('userConds', $userConds);

    $view = new Template();
    echo $view->render('views/orderForm2.html');
});

$f3->route('GET|POST /summary', function(){
    $view = new Template();
    echo $view->render('views/summary.html');
});

//Run Fat-Free
$f3->run();

