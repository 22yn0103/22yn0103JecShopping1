<?php
    require_once './helpers/MemberDAO.php';

    $email='';
    $err=[];

    session_start();

    if(!empty($_SESSION['member'])){
        header('Location: index.php');
    }

    if($_SERVER['REQUEST_METHOD']==='POST'){
        $email=$_POST['email'];
        $password=$_POST['password'];

        if($email === ''){
            $err[]='メールアドレスを入力してください。';
        }
        else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $err[]='メールアドレスの形式に誤りがあります。';
        }
        if($password===''){
            $err[]='パスワードを入力してください。';
        }
        if(empty($err)){
            $memberDAO = new MemberDAO();
            $member=$memberDAO->get_member($email,$password);

            if($member !== false){
                session_regenerate_id(true);
                $_SESSION['member']=$member;

                header('Location: index.php');
                exit;
            }
            else{
                $err[]='メールアドレスまたはパスワードに誤りがあります。';
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="css/LoginStyle.css" rel="stylesheet">
    <title>ログイン</title>
</head>
<body>
    <form action="" method="POST">
    <?php include "header2.php"; ?>
    <table id="LoginTable" class="box">
        <tr>
            <th colspan="2">
                ログイン
            </th>
        </tr>
        <tr>
            <td>メールアドレス</td>
            <td>
                <input type="text" name="email">
            </td>
        </tr>
        <tr>
            <td>パスワード</td>
            <td>
                <input type="password" name="password">
            </td>
        </tr>
        <tr>
            <td>
                <input type="submit" value="ログイン">
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">
                <?php foreach($err as $e) : ?>
                    <span style="color:red"><?= $e ?></span>
                    <br>
                <?php endforeach; ?>
            </td>
        </tr>
    </table>
    </form>

    <table class="box">
        <tr>
            <th>初めてご利用の方</th>
        </tr>
        <tr>
            <td>
                ログインするには会員登録が必要です。
            </td>
        </tr>
        <tr>
            <td><a href="signup.php">新規会員登録はこちら</a></td>
        </tr>
    </table>
</body>
</html>
