<?php

/**
 * This is a "CMS" model for quotes, but with bogus hard-coded data.
 * This would be considered a "mock database" model.
 *
 * @author jim
 */
class Menu extends CI_Model {

    protected $xml = null;
    protected $patty_names = array();

    protected $patties = array();
    protected $cheeses = array();
    protected $toppings = array();
    protected $sauces = array();

    // Constructor
    public function __construct() {
        parent::__construct();
        $this->xml = simplexml_load_file(DATAPATH . 'menu.xml');


        // build the list of patties - approach 1
        foreach ($this->xml->patties->patty as $patty) {
            $patty_names[(string) $patty['code']] = (string) $patty;
        }

        // build a full list of patties - approach 2
        foreach ($this->xml->patties->patty as $patty) {
            $record = new stdClass();
            $record->code = (string) $patty['code'];
            $record->name = (string) $patty;
            $record->price = (float) $patty['price'];
            $this->patties[$record->code] = $record;
        }

        //build cheese record
        foreach ($this->xml->cheeses->cheese as $cheese) {
            $record = new stdClass();
            $record->code = (string) $cheese['code'];
            $record->name = (string) $cheese;
            $record->price = (float) $cheese['price'];
            $this->cheeses[$record->code] = $record;
        }

        //toppings
        foreach ($this->xml->toppings->topping as $topping) {
            $record = new stdClass();
            $record->code = (string) $topping['code'];
            $record->name = (string) $topping;
            $record->price = (float) $topping['price'];
            $this->toppings[$record->code] = $record;
        }

        //sauces
        foreach ($this->xml->sauces->sauce as $sauce) {
            $record = new stdClass();
            $record->code = (string) $sauce['code'];
            $record->name = (string) $sauce;
            $record->price = (float) $sauce['price'];
            $this->sauces[$record->code] = $record;
        }


    }


    /**gets the cheese if it exists from the cheeses associative array
     * @param $code the code the cheese object is placed in the cheeses associative array
     * @return null OR cheeseObject - the cheeseObject if it exists
     */
    public function getCheese($code){
        if (isset($this->cheeses[$code]))
            return $this->cheeses[$code];
        else
            return null;
    }

    /**gets the topping if it exists from the toppings associative array
     * @param $code the code the topping object is placed in the toppings associative array
     * @return null OR toppingObject - the toppingObject if it exists
     */
    public function getTopping($code){
        if (isset($this->toppings[$code]))
            return $this->toppings[$code];
        else
            return null;
    }

    /**gets the sauce if it exists from the sauces associative array
     * @param $code the code the sauce object is placed in the sauces associative array
     * @return null OR sauceObject - the sauceObject if it exists
     */
    public function getSauce($code){
        if (isset($this->sauces[$code]))
            return $this->sauces[$code];
        else
            return null;
    }




    // retrieve a list of patties, to populate a dropdown, for instance
    function patties() {
        return $this->patty_names;
    }

    /**gets the patty if it exists from the patties associative array
     * @param $code the code the patty object is placed in the patties associative array
     * @return null OR pattyObject - the pattyObject if it exists
     */
    function getPatty($code) {
        if (isset($this->patties[$code]))
            return $this->patties[$code];
        else
            return null;
    }

}
