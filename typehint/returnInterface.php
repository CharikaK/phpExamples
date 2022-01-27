<?php
/**
 * programming into an interface
 */


interface TaxCalculator{
    
    public function calculateTax() : float;
}

class TaxCalculator2019 implements TaxCalculator{

    public function calculateTax():float
    {
        return 1.5;
    }

}

class TaxCalculator2020 implements TaxCalculator{

    public function calculateTax():float
    {
        return 2.6;
    }

}

// Does not implement the interface
class TaxCalculator2021{

    public function calculateTax():float
    {
        return 3.7;
    }

}

// ------------------------------------------------------

// Intermediate class
class Main {

    private $taxYear;

    public function __construct(TaxCalculator $taxCalculator){
        $this->taxYear =  $taxCalculator;
    }

    // return type is the interface.
    // The object instance that get returned has implemented the interface
    public function getCalculator() : TaxCalculator
    {
        // return false; // Fatal error: Uncaught TypeError: Return value of Main::getCalculator() must implement interface TaxCalculator, bool returned
        // return new TaxCalculator2021; // Fatal error: Uncaught TypeError: Return value of Main::getCalculator() must implement interface TaxCalculator, instance of TaxCalculator2021 returned in 
        return new $this->taxYear;
    }


    public function calculate(){
        $taxYear = $this->getCalculator();
        return $tax = $this->taxYear->calculateTax();
    }
    
}

// ------- client code ----------------------------------

$taxYear = new TaxCalculator2019();
$tax = new Main($taxYear);
echo $tax->calculate()."\n";

$taxYear = new TaxCalculator2020();
$tax = new Main($taxYear);
echo $tax->calculate()."\n";