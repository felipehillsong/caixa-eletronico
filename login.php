<?php
require 'config.php';
session_start();
if(isset($_POST['agencia']) && empty($_POST['agencia']) == false){
    $agencia = addslashes($_POST['agencia']);
    $conta = addslashes($_POST['conta']);
    $senha = md5(addslashes($_POST['senha']));

    $sql = $pdo->prepare("SELECT * FROM contas WHERE agencia = :agencia AND conta = :conta AND senha = :senha");
    $sql->bindValue(":agencia", $agencia);
    $sql->bindValue(":conta", $conta);
    $sql->bindValue(":senha", $senha);
    $sql->execute();

    if($sql->rowCount() > 0){
        $sql = $sql->fetch();
        $_SESSION['banco'] = $sql['id'];
        header("Location: index.php");
        exit;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />    
    <title>Caixa Eletronico</title>    
</head>
<body>
<form method="POST">
Agência<br/>
<input type="text" name="agencia" placeholder="Agência"><br/><br/>
Conta<br/>
<input type="text" name="conta" placeholder="Conta"><br/><br/>
Senha<br/>
<input type="password" name="senha" placeholder="Senha"><br/><br/>
<input type="submit" value="Entrar">
</form>
    
</body>
</html>