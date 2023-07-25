<?php
require_once 'DAO.php';

class GoodsGroup
{
    public int $groupcode;
    public string $groupname;
}

class GoodsGroupDAO
{
    public function get_goodgroup()
    {
        $dbn=DAO::get_db_connect();

        $sql="SELECT * FROM GoodsGroup";
        $stmt=$dbn->prepare($sql);

        $stmt->execute();

        $data=[];
        while($row=$stmt->fetchObject('GoodsGroup')){
            $data[]=$row;
        }

        return $data;
    }
}