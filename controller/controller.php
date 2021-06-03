<?php

class Controller
{
    private $_f3; //router

    function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    function home()
    {
        //Display the home page
        $view = new Template();
        echo $view->render('views/home.html');
    }

    function order1()
    {

        //Reinitialize session array
        $_SESSION = array();

        //Instantiate order object
        //$order = new Order();
        //var_dump($order);

        $_SESSION['order'] = new Order();

        //Initialize variables to store user input
        $userFood = "";
        $mealId = 0;

        //If the form has been submitted, add the data to the session
        //and send the user to the next order form
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //var_dump($_POST);

            $userFood = $_POST['food'];
            $mealId = $_POST['meal'];

            //If food is valid, store data
            if(Validation::validFood($_POST['food'])) {
                $_SESSION['order']->setFood($userFood);
            }
            else {
                $this->_f3->set('errors["food"]', 'Invalid food');
            }

            //If meal is valid, store data
            if(!empty($mealId) && Validation::validMeal($mealId)) {
                $_SESSION['order']->setMeal($mealId);
            }
            //Otherwise, set an error variable in the hive
            else {
                $this->_f3->set('errors["meal"]', 'Invalid meal');
            }

            //If there are no errors, redirect to order2
            if (empty($this->_f3->get('errors'))) {
                header('location: order2');
            }
        }

        //Get the data from the model
        $meals = $GLOBALS['dataLayer']->getMeals();
        $this->_f3->set('meals', $meals);

        //Store the user input in the hive
        $this->_f3->set('userFood', $userFood);
        $this->_f3->set('userMeal', $mealId);

        $view = new Template();
        echo $view->render('views/orderForm1.html');
    }

    function order2()
    {
        $userConds = array();

        //If the form has been submitted, add the data to the session
        //and send the user to the summary page
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //var_dump($_POST);

            if (!empty($_POST['conds'])) {

                $userConds = $_POST['conds'];

                if (Validation::validCondiments($userConds)) {
                    $_SESSION['order']->setCondiments(implode(", ", $userConds));
                }
                else {
                    $this->_f3->set('errors["conds"]', 'Invalid selection');
                }
            }

            if (empty($this->_f3->get('errors'))) {
                header('location: summary');
            }
        }

        //Get the data from the model
        $this->_f3->set('conds', DataLayer::getConds());

        $this->_f3->set('userConds', $userConds);

        $view = new Template();
        echo $view->render('views/orderForm2.html');
    }

    function summary()
    {
        //Save order to database
        $orderId = $GLOBALS['dataLayer']->saveOrder($_SESSION['order']);
        $this->_f3->set('orderId', $orderId);

        $view = new Template();
        echo $view->render('views/summary.html');
    }

    function adminPage()
    {
        $result = $GLOBALS['dataLayer']->getOrders();

        $this->_f3->set('result', $result);

        $view = new Template();
        echo $view->render('views/adminPage.html');
        /*$view = new Template();
        echo $view->render('views/adminPage.html');*/
    }
}