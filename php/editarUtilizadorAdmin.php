<?php
session_start();

if (isset($_GET['utilizadorID'])) {
    include 'conexaobd.php';

    $utilizadorID = $_GET['utilizadorID'];

    $sql = "SELECT nome, apelido, dataNascimento, email, funcao FROM utilizadores WHERE utilizadorID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $utilizadorID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nome, $apelido, $dataNascimento, $email, $funcao);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'conexaobd.php';

    function capitalizeFirstLetter($string) {
        return ucfirst(strtolower(trim($string)));
    }

    $nomeEditado = capitalizeFirstLetter($_POST['nomeEditado']);
    $apelidoEditado = capitalizeFirstLetter($_POST['apelidoEditado']);
    $dataNascimentoEditado = $_POST['dataNascimentoEditado'];
    $emailEditado = trim($_POST['emailEditado']);
    $funcaoEditado = $_POST['funcaoEditado'];

    // Usar os novos dados apenas se não estiverem vazios, caso contrário usar os antigos
    $nomeEditado = !empty($nomeEditado) ? $nomeEditado : $nome;
    $apelidoEditado = !empty($apelidoEditado) ? $apelidoEditado : $apelido;
    $dataNascimentoEditado = !empty($dataNascimentoEditado) ? $dataNascimentoEditado : $dataNascimento;
    $emailEditado = !empty($emailEditado) ? $emailEditado : $email;
    $funcaoEditado = !empty($funcaoEditado) ? $funcaoEditado : $funcao;

    $sqlEditar = "UPDATE utilizadores SET nome = ?, apelido = ?, dataNascimento = ?, email = ?, funcao = ? WHERE utilizadorID = ?";
    $stmtEditar = mysqli_prepare($conn, $sqlEditar);
    mysqli_stmt_bind_param($stmtEditar, "sssssi", $nomeEditado, $apelidoEditado, $dataNascimentoEditado, $emailEditado, $funcaoEditado, $utilizadorID);
    mysqli_stmt_execute($stmtEditar);

    if (mysqli_stmt_affected_rows($stmtEditar) > 0) {
        echo "<script>
                alert('Dados do utilizador atualizados com sucesso!');
                window.location.href='gerirUtilizadoresAdmin.php';
              </script>";
    } else {
        echo "<script>
                alert('Erro ao atualizar dados do utilizador!');
              </script>";
        exit();
    }

    mysqli_stmt_close($stmtEditar);
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrimeSupps - Área de administrador: Editar utilizador</title>
    <meta name="description" content="Área de administração do PrimeSupps - Edite os detalhes dos utilizadores existentes no sistema.">
    <meta name="keywords" content="PrimeSupps, Administração, Editar Utilizador, Gestão de Utilizadores">
    <!-- Inserir em todas as páginas -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/regrasEstilo.css">
    <link rel="stylesheet" href="../css/footerMobile.css">
    <script type="text/javascript" src="../js/atualizarIconeNumeroCarrinho.js"></script>
    <script type="text/javascript" src="../js/header.js"></script>
    <script src="https://kit.fontawesome.com/c3bcd53a96.js" crossorigin="anonymous"></script>
    <!-- Inserir em todas as páginas -->
     <link rel="stylesheet" href="../css/editarUtilizadorAdmin.css">
</head>
<body>

<?php include'headerMobile.php'; ?>

<main>
    <h1 id="titulo1">Editar utilizador: <?php echo htmlspecialchars($nome)?>  <?php echo htmlspecialchars($apelido)?></h1>

    <div>
        <form method="post">
            <div class="flex1">
                <input class="inputs" type="text" name="nomeEditado" value="<?php echo htmlspecialchars($nome, ENT_QUOTES); ?>" placeholder="Nome" aria-label="Nome">
                <input class="inputs" type="text" name="apelidoEditado" value="<?php echo htmlspecialchars($apelido, ENT_QUOTES); ?>" placeholder="Apelido" aria-label="Apelido">
            </div>
            <input class="inputs" type="date" name="dataNascimentoEditado" value="<?php echo htmlspecialchars($dataNascimento, ENT_QUOTES); ?>" placeholder="Data de nascimento" aria-label="Data de nascimento">
            <input class="inputs" type="email" name="emailEditado" value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>" placeholder="Email" aria-label="Email">
            <select class="inputs" name="funcaoEditado" aria-label="Função">
                <option disabled style="display: none;">Função</option>
                <option value="utilizador" <?php if ($funcao === 'utilizador') echo 'selected'; ?>>utilizador</option>
                <option value="administrador" <?php if ($funcao === 'administrador') echo 'selected'; ?>>administrador</option>
            </select>
            <button id="btnGuardar" type="submit"><p>Guardar alterações</p></button>
        </form>
    </div>
</main>

<?php include'footerMobile.php'; ?>

</body>
</html>