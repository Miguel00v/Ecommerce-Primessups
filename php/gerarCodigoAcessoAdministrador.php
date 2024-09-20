<?php 
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'conexaobd.php';

// Verifies if the user is logged in
if (!isset($_SESSION['utilizadorID'])) {
    echo json_encode(['status' => 'error', 'message' => 'Precisa de iniciar sessão para aceder a esta página.']);
    exit();
}

$utilizadorID = $_SESSION['utilizadorID'];
$email = $_SESSION['email'];
$nome = $_SESSION['nome'];
$apelido = $_SESSION['apelido'];

// Function to create a random code
function generateRandomCode($length = 10) {
    return bin2hex(random_bytes($length));
}

$novo_codigo = generateRandomCode(10);
date_default_timezone_set('Europe/Lisbon');
$data_criacao = date('Y-m-d H:i:s');
$data_expiracao = date('Y-m-d H:i:s', strtotime('+1 hour'));

// Insert code into the database
$sqlInsert = "INSERT INTO codigo_acesso_admin (utilizadorID, codigo, dataCriacao, dataExpiracao) VALUES (?, ?, ?, ?)";
$stmtInsert = mysqli_prepare($conn, $sqlInsert);
mysqli_stmt_bind_param($stmtInsert, "ssss", $utilizadorID, $novo_codigo, $data_criacao, $data_expiracao);
mysqli_stmt_execute($stmtInsert);
mysqli_stmt_close($stmtInsert);

// Send code to the email
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/Exception.php';

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Username = 'primesupps.pt@gmail.com';
    $mail->Password = 'nyjh klzg usde zont';
    $mail->Port = 587;

    // Sender and recipient
    $mail->setFrom('primesupps.pt@gmail.com', 'Primesupps');
    $mail->addAddress($email, 'Administrador ' . $nome . ' ' . $apelido);

    // Email content
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'Acesso à área de administração';
    $mail->Body = 'Segue, o seguinte código para confirmar a sua identidade: <strong>' . $novo_codigo . '</strong>';

    $mail->send();
    echo"<script>alert('Um código foi enviado para o seu email, introduza-o.');
        window.location.href='verificarAdministrador.php';
    </script>";
} catch (Exception $e) {
    echo "<script>alert('Erro ao enviar código: " . $mail->ErrorInfo . "');</script>";
}

mysqli_close($conn);

?>