<?php

/**
 * Our homepage. Show the most recently added quote.
 * 
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application {

    function __construct()
    {
	parent::__construct();
    }

    //-------------------------------------------------------------
    //  Homepage: show a list of the orders on file
    //-------------------------------------------------------------

    function index()
    {
	// Build a list of order
        $this->load->helper('directory');

        $filesArray = directory_map("./data");
        $xmlFilesArray = array();
        foreach($filesArray as $file){
            if(substr_compare($file, "order", 0, 5) == 0){


                $subArray["filename"] = $file;

                //get the name of the customer in the order
                $this->order->parse($file);
                $subArray["customername"] = $this->order->getCustomer();

                $xmlFilesArray[] = $subArray;

            }
        }

        $this->data["orders"] = $xmlFilesArray;

        // Present the list to choose from
        $this->data['pagebody'] = 'homepage';
        $this->render();
    }
    
    //-------------------------------------------------------------
    //  Show the "receipt" for a specific order
    //-------------------------------------------------------------

    function order($filename)
    {
	// Build a receipt for the chosen order
        $this->order->parse($filename);
        //$content = $this->order->dump();

        $burgerCount = $this->order->getBurgerCount();

        $burgersArray = array();

        for($i = 0 ; $i < $burgerCount; $i++){

            $aBurger = array();

            //get toppings

            $toppingsArray = $this->order->getToppings($i);
            $toppingsNameArray = array();
            foreach($toppingsArray as $toppingCode){
                $topping = $this->menu->getTopping($toppingCode);
                $toppingsNameArray[] = $topping->name;
            }
            $toppingsAssoc = $this->order->getAssociative($toppingsNameArray, "topping");

            $aBurger["toppings"] = $toppingsAssoc;

            //get sauces

            $saucesArray = $this->order->getSauces($i);
            $saucesNameArray = array();
            foreach($saucesArray as $sauceCode){
                $sauce = $this->menu->getSauce($sauceCode);
                $saucesNameArray[] = $sauce->name;
            }
            $saucesAssoc = $this->order->getAssociative($saucesNameArray, "sauce");

            $aBurger["sauces"] = $saucesAssoc;

            //get patties

            $patty = $this->menu->getPatty($this->order->getPatty($i));
            $aBurger["patty"] = $patty->name;

            //get cheeses

            $cheese = $this->order->getCheeses($i);
            $cheeseString = "";
            if($cheese != null){
                foreach($cheese as $key => $value ){
                    $cheeseObject = $this->menu->getCheese($value);
                    $cheeseString .= " $cheeseObject->name ($key)";
                }
            }
            $aBurger["cheese"] = $cheeseString;

            //get instructions if any

            $instructions = $this->order->getInstructions($i);
            if($instructions == null){
                $instructions = "";
            }

            $aBurger["instructions"] = $instructions;

            //get name if any

            $name = $this->order->getName($i);
            if($name == null){
                $name = "";
            }

            //get price
            $cost = $this->order->getBurgerTotalPrice($i);
            $aBurger["cost"] = $cost;
            $aBurger["index"] = $i + 1;


            $aBurger["name"] = $name;
            $burgersArray[] = $aBurger;

        }


        $this->data["burgers"] = $burgersArray;
        $this->data["ordertype"] = $this->order->getOrderType();
        $this->data["customer"] = $this->order->getCustomer();
        $this->data["ordertotal"] = $this->order->getOrderTotal();


	// Present the list to choose from
	$this->data['pagebody'] = 'justone';
	$this->render();
    }

    private function convertCodeToName($array){

    }
    

}
