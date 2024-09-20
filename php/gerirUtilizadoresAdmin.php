<?php

    session_start();
    if (!isset($_SESSION['utilizadorID'])) {
        echo "<script> 
            alert('Não tem sessão iniciada.'); 
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
    <title>PrimeSupps - Área de administrador: Gerir utilizadores</title>
    <meta name="description" content="Gerencie os utilizadores da PrimeSupps na área de administração. Visualize, edite e organize os dados dos utilizadores com facilidade.">
    <meta name="keywords" content="administração, gerenciar utilizadores, PrimeSupps, gestão de utilizadores, painel de administração">
    <!-- Inserir em todas as páginas -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/regrasEstilo.css">
    <link rel="stylesheet" href="../css/footerMobile.css">
    <script type="text/javascript" src="../js/atualizarIconeNumeroCarrinho.js"></script>
    <script type="text/javascript" src="../js/header.js"></script>
    <script src="https://kit.fontawesome.com/c3bcd53a96.js" crossorigin="anonymous"></script>
    <!-- Inserir em todas as páginas -->
    <script type="text/javascript" src="../js//gerirUtilizadoresAdmin.js"></script>
    <link rel="stylesheet" href="../css/gerirUtilizadoresAdmin.css">
</head>
<body>

<?php include'headerMobile.php'; ?>

    <main>

        <div>
            <div><h2>Procurar utilizador</h2></div>
            <form id="searchForm">
                <div class="flex1">
                    <input class="inputs" id="nome" type="text" name="nome" value="" aria-placeholder="Nome" placeholder="Nome" oninput="filtrarEncomendas()">
                    <input class="inputs" id="apelido" type="text" name="apelido" value="" aria-placeholder="Apelido" placeholder="Apelido" oninput="filtrarEncomendas()">
                </div>
                <div class="flex1">
                    <input class="inputs" id="email" type="text" name="email" value="" aria-placeholder="Email" placeholder="Email" oninput="filtrarEncomendas()">
                    <select class="inputs" id="funcao" name="funcao" onchange="filtrarEncomendas()">
                        <option disabled selected style="display: none;">Função</option>
                        <option>administrador</option>
                        <option>utilizador</option>
                    </select>
                </div>
                <div class="flex1">
                    <button class="btnsPesquisa" type="submit" id="filtrar" disabled><p>Filtrar</p></button>
                    <button class="btnsPesquisa" type="button" id="limpar"><p>Limpar</p></button>
                </div>
            </form>

        </div>

        <a class="linkNovoUser" href="adicionarUtilizadorAdmin.php" title="Criar um novo utilizador"><button class="btnNovoUser"type="button"><p>Adicionar utilizador</p></button></a>

        <div id="utilizadoresPadrao">
            <?php foreach ($users as $user): ?>
                <div class="background2">
                    <div class="editarUser"><a href="editarUtilizadorAdmin.php?utilizadorID=<?php echo htmlspecialchars($user['utilizadorID']); ?>" title="Editar utilizador"><button id="btnEditar" class="btns" type="button"><i class="fa-solid fa-user-pen"></i></button></a></div>
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

    <?php include'footerMobile.php'; ?>
    
</body>
</html>