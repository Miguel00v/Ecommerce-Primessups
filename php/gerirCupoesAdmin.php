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

    $sql = "SELECT * FROM cupoes ";
    $stmt = mysqli_prepare($conn,$sql); 
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $cupaoID, $tipoValor, $valor, $codigo, $descricao, $dataExpiracao, $estado);
    $results = [];
    while (mysqli_stmt_fetch($stmt)) {
     $results[] = [
        'cupaoID' => $cupaoID,
        'tipoValor' => $tipoValor,
        'valor' => $valor,
        'codigo' => $codigo,
        'descricao' => $descricao,
        'dataExpiracao' => $dataExpiracao,
        'estado' => $estado
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
    <title>PrimeSupps- Área de administrador : Gerir cupões</title>
    <meta name="description" content="Área de administração para gerenciar cupons no sistema PrimeSupps.">
    <meta name="keywords" content="administração, cupons, PrimeSupps, gerenciamento, área de administrador">
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
     <link rel="stylesheet" href="../css/gerirCupoesAdmin.css">
</head>
<body>
    
<div id="header"></div>

<main>
    <h1 id="titulo1">Gerir cupões</h1>

    <h1 id="tituloAdminDesktop">Olá, administrador <?php echo htmlspecialchars($_SESSION['nome']).' '. htmlspecialchars($_SESSION['apelido']) ?></h1>
    <div class="background1">

        <div class="divs" id="encomendasDesktop"><a class="linksAdmin" href="areaAdministrador.php" title="Ver encomendas"><p>Ver encomendas</p></a></div>
        <div class="divs" id="produtosDesktop"><a class="linksAdmin" href="gerirProdutosAdmin.php" title="Gerir produtos"><p>Gerir produtos</p></a></div>
        <div class="divs" id="utilizaodresDesktop"><a class="linksAdmin" href="gerirUtilizadoresAdminDesktop.php" title="Gerir utilizadores"><p>Gerir utilizadores</p></a></div>
        <div class="divs" id="cupoesDesktop"><a class="linksAdmin" href="gerirCupoesAdmin.php" title="Gerir cupões"><p>Gerir Cupões</p></a></div>
        <div class="divs" id="documentosLegaisDesktop"><a class="linksAdmin" href="gerirDocumentosLegaisAdmin.php" title="Gerir documentos legais"><p>Gerir documentos legais</p></a></div>

    </div>

    <div id="divBtnNovoCupao"><a id="linkBtnNovoCupao" href="adicionarCupaoAdmin.php" title="Adicionar cupão"><button id="btnNovoCupao" type="button"><p>Adicionar cupão</p></button></a></div>

    <?php foreach ($results as $row){ ?>

        <div class="background">

            <div class="divBtnRemover"><a class="linkRemover" href="removerCupaoAdmin.php?cupaoID=<?php echo htmlspecialchars($row['cupaoID']) ?>" title="Remover cupão"><button class="btnRemover" type="button"><p>X</p></button></a></div>
            <div class="infoCupao">
                <div><p><?php echo htmlspecialchars($row['descricao']) ?></p></div>
                <div><p><?php echo htmlspecialchars($row['codigo']) ?></p></div>
                <div><p><?php if($row['tipoValor']=='PERCENTUAL'){ echo htmlspecialchars($row['valor'] *100) .'%';}else{ echo htmlspecialchars($row['valor']).'€';}?></p></div>
            </div>
            <div class="estadoCupao"><p><?php if($row['estado']=='ATIVO'){echo '<i style="color: green" class="fa-solid fa-circle"></i> '. htmlspecialchars($row['estado']);  } else{ echo '<i style="color: red" class="fa-solid fa-circle"></i> '. htmlspecialchars($row['estado']); } ?></p></div>
            <div class="dataExpiracao"><p><?php echo htmlspecialchars($row['dataExpiracao']) ?></p></div>
        </div>

    <?php } ?>

</main>
<div id="footer"></div>

</body>
</html>