<?php
require_once './helpers/MemberDAO.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password2=$_POST['password2'];
    $membername=$_POST['membername'];
    $zipcode=$_POST['zipcode'];
    $address=$_POST['address'];
    $tel1=$_POST['tel1'];
    $tel2=$_POST['tel2'];
    $tel3=$_POST['tel3'];

    $memberDAO=new MemberDAO();

    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errs['email']='メールアドレスの形式が正しくありません。';
    }
    elseif($memberDAO->email_exists($email)==true){
        $errs['email']='このメールアドレスはすでに登録されています。';
    }

    if(!preg_match('/\A.{4,}\z/',$password)){
        $errs['password']='パスワードは4文字以上で入力してください。';
    }
    elseif($password!==$password2){
        $errs['password']='パスワードが一致しません。';
    }

    if(empty($membername)){
        $errs['membername']='お名前を入力してください。';
    }
    if(!preg_match('/\d{3}-\d{4}/',$zipcode)){
        $errs['zipcode']='郵便番号は３桁-4桁で入力してください。';
    }
    if(empty($address)){
        $errs['address']='住所を入力してください。';
    }
    if(!preg_match('/\A(\d{2,5})\z/',$tel1) ||
       !preg_match('/\A(\d{1,4})\z/',$tel2) ||
       !preg_match('/\A(\d{4})\z/',  $tel3))
    {
        $errs['tel']='電話番号は半角数字2~5桁、1~4桁、4桁で入力してください。';
    }
    if(empty($errs)){
        $member=new Member();
        $member->email=$_POST['email'];
        $member->password=$_POST['password'];
        $member->membername=$_POST['membername'];
        $member->zipcode=$_POST['zipcode'];
        $member->address=$_POST['address'];
        $member->tel='';
        if($tel1 !== '' && $tel2 !=='' && $tel3 !== ''){
            $member->tel="{$tel1}-{$tel2}-{$tel3}";
        }
        
        $memberDAO->insert($member);
        
        header('Location:signupEnd.php');
        
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>新規会員登録</title>
</head>
<body>
    <?php include 'header2.php'; ?>

    <h1>会員登録</h1>
    <p>以下の項目を入力し、登録ボタンをクリックしてください（*は必須）</p>
    <form action="" method="post">
        <table>
            <tr>
                <td>メールアドレス*</td>
                <td><input type="email" name="email" value="<?=@$email?>"></td>
                <span style="color: red"><?= @$errs['email'] ?></span>
            </tr>
            <tr>
                <td>パスワード（4文字以上）*</td>
                <td><input type="text" name="password"></td>
                <span style="color: red"><?= @$errs['password'] ?></span>
            </tr>
            <tr>
                <td>パスワード（再入力）*</td>
                <td><input type="text" name="password2"></td>
            </tr>
            <tr>
                <td>お名前*</td>
                <td><input type="text" name="membername"></td>
                <span style="color: red"><?= @$errs['membername'] ?></span>
            </tr>
            <tr>
                <td>郵便番号*</td>
                <td><input type="text" name="zipcode"></td>
                <span style="color: red"><?= @$errs['zipcode'] ?></span>
            </tr>
            <tr>
                <td>住所*</td>
                <td><input type="text" name="address"></td>
                <span style="color: red"><?= @$errs['address'] ?></span>
            </tr>
            <tr>
                <td>電話番号</td>
                <td>
                <input type="tel" name="tel1" size="4"> -
                <input type="tel" name="tel2" size="4"> -
                <input type="tel" name="tel3" size="4">
                <span style="color: red"><?= @$errs['tel'] ?></span>
                </td>
            </tr>
        </table>
        <input type="submit" value="登録する">
    </form>
</body>
</html>
