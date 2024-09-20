<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

// Enviar código de recuperação
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['email'], $_SESSION['nome'], $_SESSION['apelido'])) {

    // Enviar email com código
    require '../PHPMailer-master/src/SMTP.php';
    require '../PHPMailer-master/src/PHPMailer.php';
    require '../PHPMailer-master/src/Exception.php';

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Username = 'primesupps.pt@gmail.com';
    $mail->Password = 'nyjh klzg usde zont';
    $mail->Port = 587;

    // Remetente e destinatário
    $mail->setFrom('primesupps.pt@gmail.com', 'Primesupps');
    $mail->addAddress($_SESSION['email'], $_SESSION['nome'] . ' ' . $_SESSION['apelido']);
    // Conteúdo do e-mail
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8'; // Define a codificação de caracteres para UTF-8
    $mail->Subject = 'Pedido de recuperação de password';
    $mail->Body = 'Segue o seguinte código para recuperar a sua password <b>'.$_SESSION['codigo_recuperacao'].'</b>.<br> Se não solicitou nenhum pedido de recuperação, por favor entre em contato connosco.';

    if ($mail->send()) {
        echo json_encode(['status' => 'success', 'message' => 'Foi lhe reenviado um e-mail com o código de recuperação para que possa recuperar a sua senha.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao reenviar código de recuperação.']);
    }
    exit();
}
?>