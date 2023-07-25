<?php
 require_once './helpers/MemberDAO.php';
 require_once './helpers/CartDAO.php';
 require_once './helpers/SaleDAO.php';

 session_start();

 if(empty($_SESSION['member'])){
    header('Location:login.php');
}

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
     header('Location:cart.php');
}

 $member=$_SESSION['member'];

 $cartDAO=new CartDAO();
 $cart_list=$cartDAO->get_cart_by_memberid($member->memberid);

 $saleDAO=new SaleDAO();
 $ret=$saleDAO->insert($member->memberid,$cart_list);

 if($ret===true){
    $cartDAO->delete_by_memberid($member->memberid);
 }
?>
 <!DOCTYPE html>
 <html>
    <head>
        <meta charset="utf-8">
        <title>購入完了</title>
    </head>
    <body>
    <?php include "header.php"; ?>
    
    <?php if($ret===true) : ?>
        購入が完了しました。<br>
        <a href="index.php">トップページへ</a>
    <?php else: ?>
        <p>購入処理でエラーが発生しました。カートページへ戻りもう一度やり直してください。</p>
        <p><a href="cart.php">カートページへ</a></p>
    <?php endif; ?>
    </body>
 </html>
