<?php
require_once 'dao.php';

class CategorieProduit
{
  private $dao;

  function __construct()
  {
    $this->dao = new dao("localhost", "greengarden");
  }

  public function getAllCategories()
  {
    $sql = "SELECT * FROM t_d_categorie";
    return $this->dao->select("t_d_categorie");
  }

  public function getCategorieById($id)
  {
    $sql = "SELECT * FROM t_d_categorie ";
    $params = array(':id' => $id);
    return $this->dao->select("t_d_categorie", "Id_Categorie = :id", $params);
  }

  public function getCategorieByLibelle($lib)
  {
    $sql = "SELECT * FROM t_d_categorie ";
    $params = array(':lib' => $lib);
    return $this->dao->select("t_d_categorie", "Libelle = :lib", $params);
  }
}
