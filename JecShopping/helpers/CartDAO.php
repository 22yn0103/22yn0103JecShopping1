<?php
require_once 'DAO.php';

class Cart
{
    public int $memberid;
    public string $goodscode;
    public string $goodsname;
    public int $price;
    public string $detail;
    public string $goodsimage;
    public int $num;
}

class CartDAO
{
    public function get_cart_by_memberid(int $memberid)
    {
        $dbh=DAO::get_db_connect();

        $sql="SELECT memberid,Cart.goodscode,goodsname,price,detail,goodsimage,num FROM Cart INNER JOIN Goods ON Cart.goodscode = Goods.goodscode WHERE Cart.memberid=:memberid";

        $stmt=$dbh->prepare($sql);

        $stmt->bindValue(':memberid',$memberid, PDO::PARAM_INT);
        $stmt->execute();

        $data=[];
        while($row=$stmt->fetchObject('Cart')){
            $data[]=$row;
        }

        return $data;
    }

    public function cart_exists(int $memberid, string $goodscode)
    {
        $dbh=DAO::get_db_connect();

        $sql="SELECT * FROM Cart WHERE memberid=:memberid AND goodscode=:goodscode";

        $stmt=$dbh->prepare($sql);

        $stmt->bindValue(':memberid',$memberid, PDO::PARAM_INT);
        $stmt->bindValue(':goodscode',$goodscode, PDO::PARAM_STR);
        $stmt->execute();

        if($stmt->fetch()!==false){
            return true;
        }
        else{
            return false;
        }
    }

    public function insert(int $memberid,string $goodscode, int $num)
    {
        $dbh=DAO::get_db_connect();

        if(!$this->cart_exists($memberid,$goodscode)){
            $sql="INSERT INTO Cart VALUES(:memberid,:goodscode,:num)";

            $stmt=$dbh->prepare($sql);
    
            $stmt->bindValue(':memberid',$memberid, PDO::PARAM_INT);
            $stmt->bindValue(':goodscode',$goodscode, PDO::PARAM_STR);
            $stmt->bindValue(':num',$num, PDO::PARAM_STR);
            $stmt->execute();
        }
        else{
            $sql="UPDATE Cart SET num = num+:num WHERE memberid=:memberid AND goodscode=:goodscode";

            $stmt=$dbh->prepare($sql);
    
            $stmt->bindValue(':memberid',$memberid, PDO::PARAM_INT);
            $stmt->bindValue(':goodscode',$goodscode, PDO::PARAM_STR);
            $stmt->bindValue(':num',$num, PDO::PARAM_STR);
            $stmt->execute();
        }
    }
    public function update(int $memberid,string $goodscode, int $num)
    {
        $dbh=DAO::get_db_connect();

        $sql="UPDATE Cart SET num = :num WHERE memberid=:memberid AND goodscode=:goodscode";

        $stmt=$dbh->prepare($sql);

        $stmt->bindValue(':memberid',$memberid, PDO::PARAM_INT);
        $stmt->bindValue(':goodscode',$goodscode, PDO::PARAM_STR);
        $stmt->bindValue(':num',$num, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function delete(int $memberid,string $goodscode)
    {
        $dbh=DAO::get_db_connect();

        $sql="DELETE FROM Cart WHERE memberid=:memberid AND goodscode=:goodscode";

        $stmt=$dbh->prepare($sql);

        $stmt->bindValue(':memberid',$memberid, PDO::PARAM_INT);
        $stmt->bindValue(':goodscode',$goodscode, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function delete_by_memberid($memberid)
    {
        $dbh=DAO::get_db_connect();

        $sql="DELETE FROM Cart WHERE memberid=:memberid";

        $stmt=$dbh->prepare($sql);

        $stmt->bindValue(':memberid',$memberid, PDO::PARAM_INT);
        $stmt->execute();
    }
}
?>