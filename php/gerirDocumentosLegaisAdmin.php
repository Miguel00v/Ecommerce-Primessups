<?php 

    session_start();
    if (!isset($_SESSION['utilizadorID'])) {
        echo "<script> 
            alert('Não tem sessão iniciada.'); 
            window.location.href='iniciarSessao.php';
          </script>";
        exit();
    }

    if($_SERVER['REQUEST_METHOD']=='POST'){
        include'conexaobd.php';

        $nome = $_POST['nome'];

        $sql = " SELECT * FROM documentos_legais WHERE nome = ?";
        $stmt = mysqli_prepare($conn,$sql);

        if ($stmt === false) {
            echo json_encode(['error' => 'Failed to prepare the SQL statement']);
            exit; // Terminate script execution
        }

        mysqli_stmt_bind_param($stmt, "s", $nome);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $documentoID = $row['documentoID'];
            $titulo = $row['nome']; 
            $conteudo = $row['documento']; 
    
            echo json_encode([
                'documentoID' => $documentoID,
                'titulo' => $titulo,
                'conteudo' => $conteudo
            ]);
        } else {
            echo json_encode([
                'error' => 'Documento não encontrado'
            ]);
        }
    
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        exit;
    }



?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrimeSupps - Área de administrador : Gerir documentos legais</title>
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
    <script type="text/javascript" src="../js/gerirDocumentosLegaisAdmin.js"></script>
    <link rel="stylesheet" href="../css/gerirDocumentosLegaisAdmin.css">
</head>
<body>

<div id="header"></div>

    <main>

        <h1 id="tituloAdminDesktop">Olá, administrador <?php echo htmlspecialchars($_SESSION['nome']).' '. htmlspecialchars($_SESSION['apelido']) ?></h1>
        <div class="background">

            <div class="divs" id="encomendasDesktop"><a class="linksAdmin" href="areaAdministrador.php" title="Ver encomendas"><p>Ver encomendas</p></a></div>
            <div class="divs" id="produtosDesktop"><a class="linksAdmin" href="gerirProdutosAdmin.php" title="Gerir produtos"><p>Gerir produtos</p></a></div>
            <div class="divs" id="utilizaodresDesktop"><a class="linksAdmin" href="gerirUtilizadoresAdminDesktop.php" title="Gerir utilizadores"><p>Gerir utilizadores</p></a></div>
            <div class="divs" id="cupoesDesktop"><a class="linksAdmin" href="gerirCupoesAdmin.php" title="Gerir cupões"><p>Gerir Cupões</p></a></div>
            <div class="divs" id="documentosLegaisDesktop"><a class="linksAdmin" href="gerirDocumentosLegaisAdmin.php" title="Gerir documentos legais"><p>Gerir documentos legais</p></a></div>

        </div>

        <h1 id="titulo1">Gerir documentos legais</h1>

        <div id="posicaoDesktop">

                <select name="nomeDocumento" id="nomeDocumento" onchange="exibirDocumento()">
                    <option disabled selected style="display: none;">Tipo de documento</option>
                    <option>Devoluções e trocas</option>
                    <option>Perguntas frequentes</option>
                    <option>Política de privacidade</option>
                    <option>Sobre nós</option>
                    <option>Termos e condições</option>
                </select>

                <form method="post" action="atualizarDocumentoLegalAdmin.php">

                <div style="display:none" id="formConteudo">

                    <input type="hidden" name="documentoID" value="">
                    <input class="inputs" type="text" name="tituloDocumento" value="" readonly>
                    <textarea id="auto-resize-textarea" class="textArea" name="conteudo"></textarea>
                    <button id="btnGuardar" type="submit"><p>Guardar</p></button>

                </div>

            </form>

        </div>

    </main>

    <div id="footer"></div>

</body>
</html>