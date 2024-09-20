<?php 

session_start();

if (!isset($_SESSION['utilizadorID'])) {
    echo "<script>
        alert('Precisa de iniciar sessão para aceder a esta página.');
        window.location.href='iniciarSessao.php';
    </script>";
    exit();
}

include'conexaobd.php';

    $sql = "SELECT utilizadorID, nome, apelido, email, dataNascimento, funcao FROM utilizadores";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $utilizadorID, $nome, $apelido, $email, $dataNascimento, $funcao);

    $users = [];
    while (mysqli_stmt_fetch($stmt)) {
        $users[] = [
            'utilizadorID' => $utilizadorID,
            'nome' => $nome,
            'apelido' => $apelido,
            'email' => $email,
            'dataNascimento' => $dataNascimento,
            'funcao' => $funcao
        ];
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrimeSupps - Gerir utilizadores</title>
    <!-- Inserir em todas as páginas -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/regrasEstilo.css">
    <script type="text/javascript" src="../js/detecaoDispositivo.js"></script><!-- Detetar tipo de dispositivo para páginas que o layout é o mesmo -->
    <link rel="stylesheet" href="../css/footerMobile.css">
    <link rel="stylesheet" href="../css/headerDesktop.css">
    <link rel="stylesheet" href="../css/footerDesktop.css">
    <script type="text/javascript" src="../js/atualizarIconeNumeroCarrinho.js"></script>
    <script type="text/javascript" src="../js/header.js"></script>
    <script type="text/javascript" src="../js/headerDesktop.js"></script>
    <script src="https://kit.fontawesome.com/c3bcd53a96.js" crossorigin="anonymous"></script>
    <!-- Inserir em todas as páginas -->
     <link rel="stylesheet" href="../css/gerirUtilizadoresAdminDesktop.css">
     <script type="text/javascript" src="../js/gerirUtilizadoresAdmin.js"></script>
</head>
<body>

<?php include'headerDesktop.php'; ?>

<main>

<h1 id="tituloAdminDesktop">Olá, administrador <?php echo htmlspecialchars($_SESSION['nome']).' '. htmlspecialchars($_SESSION['apelido']) ?></h1>
    <div class="background">

        <div class="divs" id="encomendasDesktop"><a class="linksAdmin" href="areaAdministrador.php" title="Ver encomendas"><p>Ver encomendas</p></a></div>
        <div class="divs" id="produtosDesktop"><a class="linksAdmin" href="gerirProdutosAdmin.php" title="Gerir produtos"><p>Gerir produtos</p></a></div>
        <div class="divs" id="utilizaodresDesktop"><a class="linksAdmin" href="gerirUtilizadoresAdminDesktop.php" title="Gerir utilizadores"><p>Gerir utilizadores</p></a></div>
        <div class="divs" id="cupoesDesktop"><a class="linksAdmin" href="gerirCupoesAdmin.php" title="Gerir cupões"><p>Gerir Cupões</p></a></div>
        <div class="divs" id="documentosLegaisDesktop"><a class="linksAdmin" href="gerirDocumentosLegaisAdmin.php" title="Gerir documentos legais"><p>Gerir documentos legais</p></a></div>

    </div>

    <div id="formProcurar">
        <h3>Procurar utilizador</h3>
        <form id="searchForm">
                <div class="flex1">
                    <input class="inputs" id="nome" type="text" name="nome" value="" aria-placeholder="Nome" placeholder="Nome" oninput="filtrarEncomendas()">
                    <input class="inputs" id="apelido" type="text" name="apelido" value="" aria-placeholder="Apelido" placeholder="Apelido" oninput="filtrarEncomendas()">
                    <input class="inputs" id="email" type="text" name="email" value="" aria-placeholder="Email" placeholder="Email" oninput="filtrarEncomendas()">
                </div>    
                    <select class="inputs" id="funcao" name="funcao" onchange="filtrarEncomendas()">
                        <option disabled selected style="display: none;">Função</option>
                        <option>administrador</option>
                        <option>utilizador</option>
                    </select>
                <div class="flex1">
                    <button class="btnsPesquisa" type="submit" id="filtrar" disabled><p>Filtrar</p></button>
                    <button class="btnsPesquisa" type="button" id="limpar"><p>Limpar</p></button>
                </div>
            </form>
    </div>

    <a class="linkNovoUser" href="adicionarUtilizadorAdminDesktop.php" title="Criar um novo utilizador"><button class="btnNovoUser"type="button"><p>Adicionar utilizador</p></button></a>

    <div id="utilizadoresPadrao">
            <?php foreach ($users as $user): ?>
                <div class="background2">
                    <div class="editarUser"><a href="editarUtilizadorAdminDesktop.php?utilizadorID=<?php echo htmlspecialchars($user['utilizadorID']); ?>" title="Editar utilizador"><button id="btnEditar" class="btns" type="button"><i class="fa-solid fa-user-pen"></i></button></a></div>
                    <div class="idUser"><p>id : <?php echo htmlspecialchars($user['utilizadorID']); ?></p></div>
                    <div class="infoUser">
                        <h3><?php echo htmlspecialchars($user['nome'] . ' ' . $user['apelido']); ?></h3>
                        <p><?php echo htmlspecialchars($user['email']); ?></p>
                        <p><?php echo htmlspecialchars($user['funcao']); ?></p>
                        <p><?php echo htmlspecialchars($user['dataNascimento']); ?></p>
                    </div>
                    <div class="removerUser"><button class="btns" id="btnRmover" type="button" onclick="confirmarDesativacao('removerUtilizadorAdmin.php?utilizadorID=<?php echo htmlspecialchars($user['utilizadorID']); ?>')"><p>X</p></button></div>
                </div>
            <?php endforeach; ?>
        </div>

        <div id="resultado"></div>

</main>

<?php include'footerDesktop.php'; ?>
    
</body>
</html>