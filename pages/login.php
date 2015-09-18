<?php
/* авторизація */
$login = 'user';
$password = '12345';
$error='';

if(isset($_POST['login'])){
    if (isset($_POST['name']) &&  isset($_POST['password'])) {
//    if(( $_POST['login']==$login )&& ( $_POST['password']==$password ) ){
        $_SESSION['admin']=1;

//    }else{
//        $error = 'Невірний логін або пароль.';
//        unset($_SESSION['admin']);
//    }

    }
}elseif(isset($_POST['logout'])){
    unset($_SESSION['admin']);
}

?>
<?php if(isAuthoriz( )){ ?>

<form id="aytoriz_logout" action="/login" method="post">
    <p>Ви авторизовані.</p>
    <p class="error"><?= $error ?></p>
    <ul class="login">
        <li><a href="/admin">Перейти в адміністративну панель</a> </li>
        <li><br></li>
        <li><input type="submit" name="logout" value="logout"></li>
    </ul>
</form>

<?php } else { ?>

<form id="authoriz_login" action="/login" method="post">
    <p>введіть логін та пароль</p>
    <p class="error"><?= $error ?></p>
    <ul class="login">
        <li><label for="name">логін</label><input name="name" type="text" ></li>
        <li><label for="password">пароль</label><input name="password" type="password" ></li>
        <li><input type="submit" name="login" value="login"></li>
    </ul>
</form>

<?php } ?>
