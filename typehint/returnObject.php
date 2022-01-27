<?php
class Originator{

    private $state;

    public function __construct(String $state){
        $this->state=$state;
        //echo "My current state is: {$this->state}.\n";
    } 

}

class Caretaker{

    private $originator;

    public function __construct(Originator $originator){
        $this->originator = $originator;
    }

    public function returnObject() : Originator
    {
        return $this->originator;
    }

}

$originator = new Originator("Morning-wakeup");
$caretaker = new CareTaker($originator);
$object = $caretaker->returnObject();
var_dump($object);
