<?php
    require_once './helpers/MemberDAO.php';
    require_once './helpers/CartDAO.php';

    if(session_status()===PHP_SESSION_NONE){
        session_start();
    }

    if(!empty($_SESSION['member'])){
        $member=$_SESSION['member'];
        $cartDAO=new CartDAO();
        $cart_list=$cartDAO->get_cart_by_memberid($member->memberid);
        $sum=0;
        foreach($cart_list as $cart){
            $sum=$sum+$cart->num;
        }
    }
?>
<header>
    <link href="css/HeaderStyle.css" rel="stylesheet">

    <div id=""logo>
        <a href="index.php">
            <img src="images/JecShoppingLogo.jpg" alt="JecShoppingロゴ">
        </a>
    </div>
    <div id="link">
    <input type="text" name="keyword" method="GET"> <input type="submit" value="検索"><br>
        <?php if(isset($member)) : ?>
            <?= $member->membername ?><a href="cart.php">カート(<?= $sum ?>)</a><a href="logout.php">ログアウト</a>
        <?php else: ?>
            <a href="login.php">ログイン</a>
        <?php endif; ?>
    </div>
    <div id="clear">
        <hr>
    </div>
</header>
