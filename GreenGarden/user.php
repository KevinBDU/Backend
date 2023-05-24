<?php
require_once 'dao.php';
require_once 'user_type.php';

class User {
    private $dao;
    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $password;
    private $user_type;
    
    public function __construct() {
      
        $dao = new dao("localhost","greengarden");
       
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function getNom() {
        return $this->nom;
    }
    
    public function getPrenom() {
        return $this->prenom;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function getUserType() {
        return $this->user_type;
    }
}
?>
