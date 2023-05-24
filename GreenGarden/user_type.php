<?php
require_once 'dao.php';

class User_Type
{
    private $dao;

    public function __construct()
    {
        $this->dao = new dao("localhost", "greengarden");
    }

    public function getUserType($id)
    {
        $result = $this->dao->select('t_d_usertype', 'Id_UserType=:id', array(':id' => $id));
        if ($result) {
            return $result[0];
        } else {
            return null;
        }
    }

    public function getAllUserTypes()
    {
        $result = $this->dao->select('t_d_usertype', '', array(), 'ORDER BY id');
        return $result;
    }
}
