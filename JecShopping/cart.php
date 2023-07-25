<?php
    require_once './helpers/MemberDAO.php';
    require_once './helpers/CartDAO.php';

    session_start();

    if(empty($_SESSION['member'])){
        header('Location:login.php');
    }

    $member=$_SESSION['member'];

    if($_SERVER['REQUEST_METHOD']==='POST'){
        if(isset($_POST['add'])){
            $goodscode=$_POST['goodscode'];
            $num=$_POST['num'];

            $cartDAO=new CartDAO();
            $cartDAO->insert($member->memberid,$goodscode,$num);
        }
        elseif(isset($_POST['change'])){
            $goodscode=$_POST['goodscode'];
            $num=$_POST['num'];

            $cartDAO=new CartDAO();
            $cartDAO->update($member->memberid,$goodscode,$num);
        }
        elseif(isset($_POST['delete'])){
            $goodscode=$_POST['goodscode'];

            $cartDAO=new CartDAO();
            $cartDAO->delete($member->memberid,$goodscode);
        }
        header("Location:" . $_SERVER['PHP_SELF']);
        exit;
    }
    $cartDAO=new CartDAO();
    $cart_list=$cartDAO->get_cart_by_memberid($member->memberid);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ショッピングカート</title>
</head>
<body>
    <?php include "header.php" ?>

    <?php if(empty($cart_list)) : ?>
        <p>カートに商品がありません。</p>
    <?php else: ?>
        <?php foreach($cart_list as $cart) : ?>
        <table>
        <tr>
                <td rowspan="4">
                        <img src="images/goods/<?= $cart->goodsimage ?>">
                </td>
                <td>
                        <?= $cart->goodsname ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= $cart->detail ?>
                </td>
            </tr>
            <tr>
                <td>
                    ￥<?= number_format($cart->price) ?>
                </td>
            </tr>
            <tr>
                <td>
                    <form action="" method="POST">
                    数量
                    <input type="number" min="1" max="10" name="num" value="<?= $cart->num ?>">   
                    <input type="hidden" id="goodscode" name="goodscode" value="<?= $cart->goodscode ?>">
                    <input type="submit" name="change" value="変更"> 
                    <input type="submit" name="delete" value="削除"> 
                    </form>         
                </td>
            </tr>
        </table>
        <hr>
        <?php endforeach; ?>
        <form action="buy.php" method="POST">
            <input type="submit" value="商品を購入する">
        </from>
    <?php endif; ?>
</body>
</html>
