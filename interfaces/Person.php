<?php
/**
 * Interfaces
 * - can be instanciated
 * - not a parent, so can be called by different children
 */

interface Person{

    public function getRole();
}

// Family
class Parents implements Person{

    private $mother;
    private $father;

    public function getRole(){
        echo "I am the parent.";
    }
}

// Family
class Child implements Person{

    public function getRole(){
        echo "I am the child.";
    }
}

// Not in a family
class bookKeeper implements Person{

    public function getRole(){
        echo "I am a book keeper";
    }
}

// Not in a family
class garbageCollector{
    public function getRole(){
        echo "I collect Garbage";
    }
}


// ----------------------------------------

// This is our intermediate class. It helps to call instanciate* the interface
class whoAmI{

    // PHP 4 constructor - perfectly works
    /* public function whoAmI(Person $person){ 
        $person->getRole();
    }  */

    // Interface variable = instanciate
    public function findMe(Person $person){
        $person->getRole();
    }
}

$mother = new Parents(); // this is an object instance that implements the interface
$findMe= new whoAmI(); 
$findMe->findMe($mother); // should be an interface - true - as obj implements the interface

//  PHP 4 style - works
$manoj = new bookKeeper();
$findMe= new whoAmI($manoj);

// Fatal Error - Argument 1 passed to whoAmI::findMe() must implement interface Person
$garbageCollector = new garbageCollector();
$findMe= new whoAmI(); 
$findMe->findMe($garbageCollector); 


