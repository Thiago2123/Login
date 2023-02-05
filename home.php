<?php 
    session_start();
    ob_start();
    include_once "conexao.php";

    if((!isset($_SESSION['id'])) AND (!isset($_SESSION['nome']))){
        $_SESSION['msg'] = "<p style='color:red'>Erro 500, precisa estar logado para acessar a página </p";
        header("Location: index.php");
    }
?>
<html>
    <head>
        <title>Home</title>
    </head>
    <body>
       
        <h1 style='color:green'>Bem vindo <?php echo $_SESSION['nome'];?></h1
        <div><a href="sair.php">Sair</a></div>
         
    </body>
    <footer>
    </footer>
    
</html>
