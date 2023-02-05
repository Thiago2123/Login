<?php 
    session_start();
    ob_start();
    include_once "conexao.php";

?>
<html>
    <head>
        <title>Atualizar senha</title>
    </head>
    <body>
        <h1>Atualizar a senha</h1>

        <?php
            $chave = filter_input(INPUT_GET, 'chave', FILTER_DEFAULT);
            if(!empty($chave)){
                //echo($chave);

                $query_usuario = "SELECT * FROM usuarios 
                                        WHERE recuperarSenha = '$chave'
                                        LIMIT 1";
                    $result_usuario = $conn->prepare($query_usuario);
                    $result_usuario->execute();
    
                if(($result_usuario) AND ($result_usuario ->rowCount() != 0 )){
                    $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
                    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                    //var_dump($dados);
                    if(!empty($dados['sendNovaSenha'])){
                        $senhaUsuario = password_hash($dados['senha'], PASSWORD_DEFAULT);
                        $recuperarSenha = 'NULL';
                        
                        $queryUpdateUsuario =  "UPDATE usuarios SET password = '$senhaUsuario',
                                            recuperarSenha = '$recuperarSenha'
                                            WHERE id = '".$row_usuario['id']."' 
                                            LIMIT 1";
                        $resultUpdateUsuario = $conn->prepare($queryUpdateUsuario);
                        if($resultUpdateUsuario-> execute()){
                            $_SESSION['msgRec'] = "<p style='color:green'> Senha atualizada com sucesso</p";
                            header("Location: index.php");
                    
                        }else{
                            echo "<p style='color:red'>Tente novamente</p";
                        }
                    }
    
                }else{
                    $_SESSION['msgRec'] = "<p style='color:red'>ERRO: Link invalido solicitaaaae um novo email</p";
                    header("Location: recuperarSenha.php");
    
                }
       
            }else{
                $_SESSION['msgRec'] = "<p style='color:red'>ERRO: Link invalido solicite bbbbbum novo email</p";
                header("Location: recuperarSenha.php");

            }
        ?>

        <form method="POST" >
            <?php 
                $usuario = "";
                if(isset($dadosLogin['senha'])){$usuario = $dadosLogin['senha'];}  
            ?>
            <label for="">Senha</label>
            <input type="password" name="senha" placeholder="Digite uma nova senha"
            value="<?php echo $usuario; ?>"><br><br>
            <input type="submit" value="Atualizar" name="sendNovaSenha">
        </form>

        Lembrou? <a href="index.php">Clique aqui para logar</a>
    </body>
    <footer>
        
    </footer>
    
</html>
