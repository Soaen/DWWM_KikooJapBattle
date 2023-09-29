<?php

class Character{

    public $id;
    public $name;
    public $puissance;
    public $attacks = array();
    public $type;

    public function __construct(int $id, string $name, int $puissance, array $attacks, string $type) {
        $this->id = $id;
        $this->name = $name;
        $this->puissance = $puissance;
        $this->attacks = $attacks;
        $this->type = $type;
    }

    public function getId() {
        return $this -> id;
    } 
    
    public function getName() {
        return $this -> name;
    } 

    public function getPower() {
        return $this -> puissance;
    } 

    public function getAttacks() {
        return $this -> attacks;
    } 

    public function getType() {
        return $this -> type;
    } 

}