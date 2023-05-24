<?php
require_once 'dao.php';

class Commande
{
    private $dao;

    public function __construct()
    {
        $this->dao = new dao("localhost", "greengarden");
    }

    public function getCommandeById($id)
    {
        $sql = "SELECT * FROM t_d_commande ";
        $params = array(':id' => $id);
        return $this->dao->select("t_d_commande", "Id_Commande = :id", $params);
    }

    public function getAllCommandes()
    {
        $sql = "SELECT * FROM t_d_commande";
        $params = array();
        return $this->dao->select("t_d_commande", "", $params);
    }

    public function getCommandeByNum($num)
    {
        $sql = "SELECT * FROM t_d_commande";
        $params = array(':num' => $num);
        return $this->dao->select("t_d_commande", "Num_Commande = :num", $params);
    }

    public function insertCommande(
        $numcom,
        $datecom,
        $idstat,
        $idcli,
        $idtypai,
        $remiscom
    )
    {
        $values = array(
            'Num_Commande'=>$numcom,
            'Date_Commande'=>$datecom,
            'Id_Statut'=>$idstat,
            'Id_Client'=>$idcli,
            'Id_TypePaiement'=>$idtypai,
            'Remise_Commande'=>$remiscom
        );
        return $this->dao->insert('t_d_commande', $values);
    }

    public function updateCommande($id, $num, $dateco, $statut, $remise){
        $sql = "UPDATE t_d_commande SET num = :num, dateco = :dateco, statut = :statut, remise = :remise WHERE id = :id";
        $params = array(
            ':id' => $id,
            ':num' => $num,
            ':dateco' => $dateco,
            ':statut' => $statut,
            ':remise' => $remise
        );
        return $this->dao->update($sql, $params);
    }

    public function deleteCommande($id){
        $sql = "DELETE FROM t_d_commande WHERE id = :id";
        $params = array(
            ':id' => $id
        );
        return $this->dao->delete($sql, $params);
    }
}
