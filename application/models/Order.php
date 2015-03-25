<?php
/**
 * Created by PhpStorm.
 * User: ben
 * Date: 25/03/15
 * Time: 10:58 AM
 */

class Order extends CI_Model{

    //private $pattyArray = array();
    //private $cheesesArray = array();
    //private $toppingArray = array();
    //private $sauceArray = array();
    protected $xml = null;
    protected $customer = null;
    protected $orderType = null;
    private $burgerArray = array();

    public function __construct(){
        parent::__construct();
    }

    /** parse parses the passed in file for procesing
     * @param $orderFile the file to be parsed
     */
    public function parse($orderFile){
        $this->xml = simplexml_load_file(DATAPATH . $orderFile);

        $this->orderType = $this->xml["type"];
        $this->customer = $this->xml->customer;


        foreach($this->xml->burger as $item){
            $burgerObject = new stdClass();
            $burgerObject->patty = $item->patty["type"];

            if(isset($item->cheeses)){
                if(isset($item->cheeses["top"])){
                    $burgerObject->cheeses["top"] = $item->cheeses["top"];
                }
                if(isset($item->cheeses["bottom"])){
                    $burgerObject->cheeses["bottom"] = $item->cheeses["bottom"];
                }
            }

            if(isset($item->topping)){
                foreach($item->topping as $topping){
                    $burgerObject->toppings[] = $topping["type"];
                }
            }

            if(isset($item->sauce)){
                foreach($item->sauce as $sauce){
                    $burgerObject->sauces[] = $sauce["type"];
                }
            }


            if(isset($item->instructions)){
                $burgerObject->instructions = $item["instructions"];
            }

            if(isset($item->name)){
                $burgerObject->name = $item->name;
            }

            $this->burgerArray[] = $burgerObject;
        }
    }

    /**a dev function that dumps the created array of data
     * @return array the array of burgers in this order
     */
    public function dump(){
        return $this->burgerArray;
    }

    /**gets the number of burgers in the burgerArray
     * @return int the number of burgers
     */
    public function getBurgerCount(){
        return count($this->burgerArray);
    }

    /**gets the toppings array at the given index of the burgersArray
     * @param $index the index point in the burgersArray
     * @return array the toppings array. Returns empty array if there are no toppings
     */
    public function getToppings($index){
        if(isset($this->burgerArray[$index]->toppings)){
            return $this->burgerArray[$index]->toppings;
        }else{
            return array();
        }
    }

    /**gets the sauces for a burger in the burger array
     * @param $index the index value in the burger array
     * @return array the array of sauces. Returns empty array if there are no sauces
     */
    public function getSauces($index){
        if(isset($this->burgerArray[$index]->sauces)){
            return $this->burgerArray[$index]->sauces;
        }else{
            return array();
        }
    }

    /**creates an array of associative arrays containing content from the passed in array
     * and are accessible with the key value passed in
     * @param $array the array of values
     * @param $key the key to access each value in thier asociative array
     * @return array the array of associative arrays
     */
    public function getAssociative($array, $key){
        $associative = array();

        for($i = 0; $i < count($array); $i++){
            $subArray[$key] = $array[$i];
            $associative[] = $subArray;
        }

        return $associative;
    }

    /**gets the patty at the specified index in the burger array
     * @param $index the index value in the burger array
     * @return mixed the patty string
     */
    public function getPatty($index){
        return $this->burgerArray[$index]->patty;
    }

    /**gets the instructions from the specified index in the burgerArray
     * @param $index the index in the burgerArray
     * @return null OR mixed if instructions exist they are returned, else null
     */
    public function getInstructions($index){
        if(isset($this->burgerArray[$index]->instructions)){
            return $this->burgerArray[$index]->instructions;
        }else{
            return null;
        }
    }

    /**gets the name in the specified index of the burgerArray if it exists
     * @param $index the index of the name
     * @return null OR mixed - returns the name if it exists, else null
     */
    public function getName($index){
        if(isset($this->burgerArray[$index]->name)){
            return $this->burgerArray[$index]->name;
        }else{
            return null;
        }
    }

    /**gets the cheeses array at the specified index of the burgerArray
     * @param $index the index in the burgerArray
     * @return null OR array - returns the cheese array if exists, else null
     */
    public function getCheeses($index){
        if(isset($this->burgerArray[$index]->cheeses)){
            return $this->burgerArray[$index]->cheeses;
        }else{
            return null;
        }
    }

    /**gets the ordertype for the order
     * @return string the ordertype
     */
    public function getOrderType(){
        return $this->orderType;
    }

    /**gets the customer for the order
     * @return string the customer
     */
    public function getCustomer(){
        return $this->customer;
    }
}