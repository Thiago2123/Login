<?php 
    session_start();
    ob_start();
    include_once "conexao.php";

    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require 'lib/vendor/autoload.php';
    $mail = new PHPMailer(true);
?>
<html>
    <head>
        <title>Recuperação de senha</title>
    </head>
    <body>
        <h1>Recuperar a senha</h1>

        <?php 
            $dadosLogin = filter_input_array(INPUT_POST,FILTER_DEFAULT);
           

            if(!empty($dadosLogin['sendRecuperarSenha'])){
                //var_dump($dadosLogin);

                $query_usuario = "SELECT * FROM usuarios 
                                   WHERE email = '".$dadosLogin['usuario']."'
                                   LIMIT 1";
                $result_usuario = $conn->prepare($query_usuario);
                $result_usuario->execute();

                if(($result_usuario) AND ($result_usuario ->rowCount() != 0 )){
                    $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
                    $chaveRecuperarSenha = password_hash($row_usuario['id'], PASSWORD_DEFAULT); 
                    //echo "Chave $chaveRecuperarSenha <br>";
                    $queryUpdateUsuario =  "UPDATE usuarios SET recuperarSenha = '$chaveRecuperarSenha'
                                            WHERE id = '".$row_usuario['id']."' 
                                            LIMIT 1";
                    $resultUpdateUsuario = $conn->prepare($queryUpdateUsuario);

                    if($resultUpdateUsuario-> execute()){
                        $link =  "http://localhost/Login/atualizarSenha.php?chave=$chaveRecuperarSenha";

                        try{
                            
                            //Server settings
                            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;    
                            $mail->CharSet = 'UTF-8';                                   //Enable verbose debug output
                            $mail->isSMTP();                                            //Send using SMTP
                            $mail->Host       = 'sandbox.smtp.mailtrap.io';             //Set the SMTP server to send through
                            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                            $mail->Username   = '2083010c7e60b4';                       //SMTP username
                            $mail->Password   = '9a1cfcc43520d7';                       //SMTP password
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable implicit TLS encryption
                            $mail->Port       = 2525;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`



                            //Recipients
                            $mail->setFrom('tiagoBomzao@hotmail.com', 'Thiago');
                            $mail->addAddress($row_usuario['email'], $row_usuario['nome']);     //Add a recipient
                        
                        
                            //Content
                            $mail->isHTML(true);                                  //Set email format to HTML
                            $mail->Subject = 'Recuperação de senha';
                            $mail->Body    = 'Prezado(a) '. $row_usuario['nome']. "<br>Você solicitou a troca de senha. <br><br>
                            Para realizar a troca de senha, clique no link abaixo ou cole no endereço do seu navegador: <br>Caso 
                            você não tenha solicitado essa solicitação, nenhuma ação é necessária.    <a href='".$link."'>Clique aqui </a><br>
                            <br><br> Apenas ignore.<br>";
                            $mail->AltBody = 'Prezado(a) '. $row_usuario['nome']. 'Você solicitou a troca de senha. \n\n
                            Para realizar a troca de senha, clique no link abaixo ou cole no endereço do seu navegador: \n'. $link . "Caso 
                            você não tenha solicitado essa solicitação, nenhuma ação é necessária. Apenas ignore.\n\n";

                            $mail->send();
                            $_SESSION['msg'] = "<p style='color:green'> Email enviado para a recuperação de senha, verifique sua caixa de entrada ou span</p";
                            header("Location: index.php");
                            
                        
                        } catch (Exception $e) {
                            echo "Erro Email não enviado com sucesso
                             Mailer Error: {$mail->ErrorInfo}";
                        }
                        
                     
                    }else{
                       echo "<p style='color:red'>Tente novamente</p";
                    }

                }else{
                    echo "<p style='color:red'>Erro: Email não encontrado </p";

                }

               if(isset($_SESSION['msgRec'])){
                  echo $_SESSION['msgRec'];
                  unset($_SESSION['msgRec']);
               }

            }

      
        ?>

        <form method="POST" >
            <label for="">Email</label>
            <input type="text" name="usuario" placeholder="Digite o Email" 
            value="<?php if(isset($dadosLogin['usuario'])){echo $dadosLogin['usuario'];}  ?>"><br><br>
            
          
            <input type="submit" value="Recuperar Senha" name="sendRecuperarSenha">
        </form>
            <br>
        Lembrou? <a href="Index.php">Clique aqui para logar</a>

    </body>
    <footer>
        
    </footer>
    
</html>
