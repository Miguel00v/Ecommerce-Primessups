<?php
session_start();

if (!isset($_SESSION['utilizadorID'])) {
    // Redirect to login page if the user is not logged in
    header("Location: iniciarSessao.php");
    exit();
}

include 'conexaobd.php';

$utilizadorID = $_SESSION['utilizadorID'];
$newsletter = 0;
$emails = 0;

// Fetch current permissions from the database
$sql = "SELECT receberNewsletter, receberEmails FROM permissoes WHERE utilizadorID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $utilizadorID);
$stmt->execute();
$stmt->bind_result($newsletter, $emails);
$stmt->fetch();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newsletter = isset($_POST['newsletter']) ? 1 : 0;
    $emails = isset($_POST['emails']) ? 1 : 0;

    $sql = "UPDATE permissoes SET receberNewsletter = ?, receberEmails = ? WHERE utilizadorID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iii', $newsletter, $emails, $utilizadorID);

    if ($stmt->execute()) {
        echo '<script>alert("Permissões atualizadas com sucesso");</script>';
    } else {
        echo '<script>alert("Erro ao atualizar permissões");</script>';
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Gerir permissões</title>
    <meta name="description" content="Gerencie as permissões de usuário na Primesupps, incluindo acesso a funcionalidades e configurações.">
    <meta name="keywords" content="Primesupps, gerir permissões, administração, usuários, controle de acesso">
<!-- Inserir em todas as páginas -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/regrasEstilo.css">
    <link rel="stylesheet" href="../css/footerMobile.css">
    <script type="text/javascript" src="../js/atualizarIconeNumeroCarrinho.js"></script>
    <script type="text/javascript" src="../js/header.js"></script>
    <script src="https://kit.fontawesome.com/c3bcd53a96.js" crossorigin="anonymous"></script>
    <!-- Inserir em todas as páginas -->
     <link rel="stylesheet" href="../css/gerirPermissoes.css">
</head>
<body>
    
<?php include'headerMobile.php'; ?>

    <main>

        <div>

            <div><h2>Newsletter</h2></div>
            <form method="post">
            <div id="newsletter">
                    <div><input type="checkbox" name="newsletter" <?php echo ($newsletter ? 'checked' : ''); ?>></div>
                    <div><label>Autorizo a subscrição de newsletter</label></div>
            </div>

        </div>
        <div>

            <div><h2>Notificações por email</h2></div>
            <div id="email">
                    <div><input type="checkbox" name="emails" <?php echo ($emails ? 'checked' : ''); ?>></div>
                    <div><label>Aceito receber emails com informações sobre a minha encomenda, prazos de validade, informações de pagamento e outros lembretes</label></div>

            </div>
            <button id="btnGuardar" type="submit"><p>Guardar</p></button>
            </form>
        </div>

    </main>

    <?php include'footerMobile.php'; ?>

</body>
</html>