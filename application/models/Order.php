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
    private $burgerArray = array();

    public function __construct(){
        parent::__construct();
    }

    public function parse($orderFile){
        $this->xml = simplexml_load_file(DATAPATH . $orderFile);

        foreach($this->xml->burger as $item){
            $burgerObject = new stdClass();
            $burgerObject->patty = $item->patty["type"];

            if(isset($item->cheeses)){
                $burgerObject->cheeses = $item->cheeses["top"];
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


    public function dump(){
        return $this->burgerArray;
    }

    public function getBurgerCount(){
        return count($this->burgerArray);
    }

    public function getToppings($index){
        if(isset($this->burgerArray[$index]->toppings)){
            return $this->burgerArray[$index]->toppings;
        }else{
            return array();
        }
    }

    public function getSauces($index){
        if(isset($this->burgerArray[$index]->sauces)){
            return $this->burgerArray[$index]->sauces;
        }else{
            return array();
        }
    }

    public function getAssociative($array, $key){
        $associative = array();

        for($i = 0; $i < count($array); $i++){
            $subArray[$key] = $array[$i];
            $associative[] = $subArray;
        }

        return $associative;
    }

    public function getPatty($index){
        return $this->burgerArray[$index]->patty;
    }


    public function getInstructions($index){
        if(isset($this->burgerArray[$index]->instructions)){
            return $this->burgerArray[$index]->instructions;
        }else{
            return null;
        }
    }

    public function getName($index){
        if(isset($this->burgerArray[$index]->name)){
            return $this->burgerArray[$index]->name;
        }else{
            return null;
        }
    }

    public function getCheeses($index){
        if(isset($this->burgerArray[$index]->cheeses)){
            return $this->burgerArray[$index]->cheeses;
        }else{
            return null;
        }
    }
}