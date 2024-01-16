<?php 
    session_start();
    ob_start();
    include_once "conexao.php";
?>
<html>
    <head>
        <title>Fazer login com banco de dados</title>

        <style>
            table, th, td {
                border:1px solid black;
                border-collapse: collapse;
                padding: 4px;
            }
        </style>
    </head>
    <body>

        <?php
            //exemplo de criptografar senha
            // echo password_hash(123456, PASSWORD_DEFAULT);  
        ?>
        <h1>Faça seu login</h1>

        <?php 
            $dadosLogin = filter_input_array(INPUT_POST,FILTER_DEFAULT);
            

            if(!empty($dadosLogin['MandarLogin'])){
                // var_dump($dadosLogin);
                $query_usuario = "SELECT * FROM usuarios 
                                    WHERE email = '".$dadosLogin['usuario']."'
                                    LIMIT 1";
                $result_usuario = $conn->prepare($query_usuario);
                $result_usuario->execute();
                
                if(($result_usuario) AND ($result_usuario ->rowCount() != 0 )){
                    $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
                   
                    
                    if(password_verify($dadosLogin['senha'], $row_usuario['password'])){
                        $_SESSION['id'] = $row_usuario['id'];
                        $_SESSION['nome'] = $row_usuario['nome'];
                        header("Location: home.php");
                        echo "<p style='color:green'>Usuario Logado! </p";
                    }else{
                        $_SESSION['msg'] = "<p style='color:red'>Erroa: Usuario ou senha  inválida </p";
                    }
                }else{
                    $_SESSION['msg'] = "<p style='color:red'>Erro: Usuario ou senha inválido a</p";
                }
            }

            if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
        ?>

        <form method="POST" >
            <label for="">Usuario</label>
            <input type="text" name="usuario" placeholder="Digite o Usuario" 
            value="<?php if(isset($dadosLogin['usuario'])){echo $dadosLogin['usuario'];}  ?>"><br><br>
            <label for="">Senha</label>
            <input type="password" name="senha" placeholder="Digite a senha"
            value="<?php if(isset($dadosLogin['senha'])){echo $dadosLogin['senha'];}  ?>"><br><br>
            <input type="submit" value="Enviar" name="MandarLogin">
        </form>

        <a href="cadastrar.php">Cadastrar</a><br>
        <a href="recuperarSenha.php">Esqueci a senha</a>

    <p>Proxima etapa realizar o cadastro e mostrar que o usuario possa alterar os dados dele no home</p>
    <p>Neste projeto, para realizar o envio de email de recuperação de senha foi utilizado o 
    <a href="https://mailtrap.io/home">Mailtrap</a></p><br>


    <?php
        $query_usuario = "SELECT * FROM usuarios ORDER BY id";
        $result_usuario = $conn->prepare($query_usuario);
        $result_usuario->execute();
        if(($result_usuario) AND ($result_usuario ->rowCount() != 0 )){
            $row_usuario = $result_usuario->fetchAll(PDO::FETCH_ASSOC);
    
            echo "<h3>Lista de usuarios cadastrados</h3>";

        }else{
            echo "<h1>Não há Úsuarios cadastrados na plataforma</h1>";
        }

        
    ?>
        <table style="width:70%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Nome</th>
                    <th>Idade</th>
                    <th>Endereço</th>
                    <th>Senha</th>
                </tr>
            <thead>
            <tbody>
                <?php foreach ($row_usuario as $valor) {
                    echo"<tr>
                            <td>".$valor['id']."</td>
                            <td>".$valor['email']."</td>
                            <td>".$valor['nome']."</td>
                            <td>".$valor['idade']."</td>
                            <td>".$valor['endereco']."</td>
                            <td>".$valor['password']."</td>
                        </tr>";
                    }  
                ?>
            <tbody>
        </table>
                

    </body>
    <footer>
        
    </footer>
    
</html>
