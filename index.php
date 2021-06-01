<?php

//This is my controller for the diner project

//Turn on error-reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require autoload file
require_once ('vendor/autoload.php');

//require_once ('model/data-layer.php');
//require_once ('model/validation.php');
//require_once ('classes/order.php');

//Start a session AFTER the autoload
//If it comes before, it causes an error
session_start();



//Instantiate Fat-Free
$f3 = Base::instance();
$con = new Controller($f3);
$dataLayer = new DataLayer();

//Test my saveOrder method
//$dataLayer->saveOrder(new Order("BLT", "Lunch", "Mayo"));
/*echo "<pre>";
$result = $dataLayer->getOrders();
var_dump($result);
echo "</pre>";*/

//Define default route
$f3->route('GET /', function(){
    $GLOBALS['con']->home();
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
    $GLOBALS['con']->order1();
});

$f3->route('GET|POST /order2', function(){
    $GLOBALS['con']->order2();
});

$f3->route('GET|POST /summary', function(){
    $GLOBALS['con']->summary();
});

$f3->route('GET|POST /adminPage', function (){
    $GLOBALS['con']->adminPage();
});

//Run Fat-Free
$f3->run();

/*
 * DROP TABLE orders;
CREATE TABLE orders (
	order_id int(5) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    food VARCHAR(50),
    meal Varchar (10),
    condiments varchar (100),
    order_date Datetime DEFAULT NOW()
);
INSERT INTO orders (food, meal, condiments)
VALUES ('waffles','breakfast', 'maple syrup, butter');

 */

