<?php

/* data-layer.php
 * Return data for the diner app
 *
*/

require_once ($_SERVER['DOCUMENT_ROOT']."/../config.php");

class DataLayer
{
    // Add a field for the database object
    private $_dbh;

    // Define a constructor
    function __construct()
    {
        //Connect to the database
        try {
            $this->_dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            //echo "Connected to database!";
        }
        catch (PDOException $e) {
            echo $e->getMessage();
            die ("Golly Gee!");
        }
    }

    //Saves an order to the database
    function saveOrder($order)
    {
        //1. Define the query
        $sql = "Insert Into orders (food, meal_id, condiments)
                VALUES (:food, :meal, :condiments)";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters
        $statement->bindParam(':food', $_SESSION['order']->getFood(), PDO::PARAM_STR);
        $statement->bindParam(':meal', $_SESSION['order']->getMeal(), PDO::PARAM_STR);
        $statement->bindParam(':condiments', $_SESSION['order']->getCondiments(), PDO::PARAM_STR);

        //4. Execute the query
        $statement->execute();

        //5. Process the results (get OrderID)
        $id = $this->_dbh->LastInsertId();
        return $id;

    }

    /**
     * getOrders returns all orders from the database
     * @return array An array of data rows
     */
    function getOrders()
    {
        //1. Define the query
        $sql = "SELECT order_id, food, meal_name, condiments, order_date FROM orders, meal
                WHERE orders.meal_id = meal.meal_id";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Execute the query
        $statement->execute();

        //4. Return the result
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Get the meals for the order form
    function getMeals()
    {
        //1. Define the query
        $sql = "SELECT meal_id, meal_name FROM meal";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters
        //$statement->bindParam(':food', $_SESSION['order']->getFood(), PDO::PARAM_STR);
        //$statement->bindParam(':meal', $_SESSION['order']->getMeal(), PDO::PARAM_STR);
        //$statement->bindParam(':condiments', $_SESSION['order']->getCondiments(), PDO::PARAM_STR);

        //4. Execute the query
        $statement->execute();

        //5. Process the results (get OrderID)
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $meals = array();
        foreach ($result as $row)
        {
            $meal_id = $row['meal_id'];
            $meal_name = $row['meal_name'];
            $meals[$meal_id] = $meal_name;
        }
        return $meals;
    }

    static function getConds()
    {
        return array("ketchup", "mustard", "sriracha");
    }
}


/*
 * 1. Help each other
 * 2. Add a getCondiments() function to the Model
 * 3. Modify your controller to get the condiments from the Model and send them to the View
 * 4. Modify the View page to display the
 */

