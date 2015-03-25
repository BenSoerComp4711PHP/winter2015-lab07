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
                $xmlFilesArray[] = $subArray;
            }
        }

        $this->data["orders"] = $xmlFilesArray;

        //var_dump($filesArray);

        //var_dump($xmlFilesArray);




	
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
            $toppingsAssoc = $this->order->getAssociative($toppingsArray, "topping");

            $aBurger["toppings"] = $toppingsAssoc;

            //get sauces

            $saucesArray = $this->order->getSauces($i);
            $saucesAssoc = $this->order->getAssociative($saucesArray, "sauce");

            $aBurger["sauces"] = $saucesAssoc;

            //get patties

            $aBurger["patty"] = $this->order->getPatty($i);

            //get cheeses

            $cheese = $this->order->getCheeses($i);
            $cheeseString = "";
            if($cheese != null){
                foreach($cheese as $key => $value ){
                    $cheeseString .= " $value ($key)";
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

            $aBurger["name"] = $name;
            $burgersArray[] = $aBurger;

        }


        $this->data["burgers"] = $burgersArray;
        $this->data["ordertype"] = $this->order->getOrderType();
        $this->data["customer"] = $this->order->getCustomer();


	// Present the list to choose from
	$this->data['pagebody'] = 'justone';
	$this->render();
    }
    

}
