<?php 
    session_start();
    ob_start();
    include_once "conexao.php";
 


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuario</title>
</head>
<body>
    <h1>Cadastrar</h1>

    <?php 
        // PEGAR TODOS OS POST DO SUMIBT E TRANSFORMAR EM ARRAY
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if(!empty($dados['mandarCadUser'])){
            // var_dump($dados);

            $query_usuario =    "INSERT INTO usuarios (email, password, nome, idade, endereco) VALUES (:email, :password, :nome, :idade, :endereco)";
            $cad_usuario = $conn->prepare($query_usuario);
            $cad_usuario->bindParam(':email', $dados['email']);
            $semha_criptografada = password_hash($dados['password'], PASSWORD_DEFAULT);
            $cad_usuario->bindParam(':password', $semha_criptografada);
            $cad_usuario->bindParam(':nome', $dados['nome']);
            $cad_usuario->bindParam(':idade', $dados['idade']);
            $cad_usuario->bindParam(':endereco', $dados['endereco']);

            $cad_usuario->execute();

            if($cad_usuario->rowCount()){
               $_SESSION['msg'] = "<p style='color: green'>Usuario cadastrado com sucesso</p>";

               header("Location: index.php");
            }else{
                echo "<p style='color: red'>Usuario não cadastrado com sucesso</p>";

            }
            
            
        
        }

    ?>

    <form method="POST">
        <label for="">Nome: </label>
        <input type="text" name="nome" placeholder="Nome Completo"><br><br>
        
        <label for="">Email: </label>
        <input type="email" name="email" placeholder="Email"><br><br>

        <label for="">Senha: </label>
        <input type="password" name="password" placeholder="Senha"><br><br>

        <label for="">Idade: </label>
        <input type="number" name="idade" placeholder="Idade"><br><br>

        <label for="">Endereço: </label>
        <input type="text" name="endereco" placeholder="Endereço"><br><br>

        <input type="submit" name="mandarCadUser" value="cadastrar"><br><br>

    </form>
    <a href="index.php">Login</a>
</body>
</html>