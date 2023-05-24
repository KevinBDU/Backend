<?php
require_once 'dao.php';

class Client {
    private $dao;

    public function __construct(){
        $this->dao = new dao("localhost","greengarden");
    }

    public function getClientById($id){
        $params = array(
            ':id' => $id
        );
        return $this->dao->select("t_d_client","id_client = :id", $params);
    }

    public function getClientByIdUser($id){
        $params = array(
            ':id' => $id
        );
        return $this->dao->select("t_d_client","id_user = :id", $params);
    }

    public function getAllClient(){
        $params = array();
        return $this->dao->select("t_d_client", "", $params);
    }

    public function getClientByNum($num){
        $params = array(
            ':num'=> $num
        );
        return $this->dao->select("t_d_client", "Num_Client like :num", $params);
    }

    public function insertClient(
        $nomsoc,
        $nom,
        $pre,
        $mail,
        $tel,
        $idco,
        $idtype,
        $delai,
        $num,
        $iduser
    )
    {
        $values = array(
            'Nom_Societe_Client'=>$nomsoc,
            'Nom_Client'=>$nom,
            'Prenom_Client'=>$pre,
            'Mail_Client'=>$mail,
            'Tel_Client'=>$tel,
            'Id_Commercial'=>$idco,
            'Id_Type_Client'=>$idtype,
            'Delai_Paiement'=>$delai,
            'Num_Client'=>$num,
            'Id_User'=>$iduser
        );
        return $this->dao->insert('t_d_client', $values);
    }
}
?>