<?php
require 'config.php';
session_start();
if(isset($_POST['tipo'])){
    $tipo = $_POST['tipo'];
    $valor = str_replace(",", ".",$_POST['valor']);
    $valor = floatval($valor);

    $sql = $pdo->prepare("INSERT INTO historico (id_conta, tipo, valor, data_op) VALUES (:id_conta, :tipo, :valor, NOW())");
    $sql->bindValue(":id_conta", $_SESSION['banco']);
    $sql->bindValue(":tipo", $tipo);    
    $sql->bindValue(":valor", $valor);
    $sql->execute();

    if($tipo == '0'){
        //DEPOSITO
        $sql = $pdo->prepare("UPDATE contas SET saldo = saldo + :valor WHERE id = :id");
        $sql->bindValue(":valor", $valor);
        $sql->bindValue(":id", $_SESSION['banco']);
        $sql->execute();
    }else{
        //SAQUE
        $sql = $pdo->prepare("UPDATE contas SET saldo = saldo - :valor WHERE id = :id");
        $sql->bindValue(":valor", $valor);
        $sql->bindValue(":id", $_SESSION['banco']);
        $sql->execute();
    }

    header("Location: index.php");
    exit;
}
?>
<html>
<head>
    <meta charset="utf-8" />    
    <title>Caixa Eletronico</title>    
</head>
<body>
<form method="POST">
Tipo de Transação:<br/>
<select name="tipo">
<option value="0">Depósito</option>
<option value="1">Saque</option>
</select><br/><br/>

Valor:<br/>
<input type="text" name="valor" placeholder="Valor" pattern="[0-9.,]{1,}"/><br/><br/>
<input type="submit" value="Adicionar">

</form>
    
</body>
</html>