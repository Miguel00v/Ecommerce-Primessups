<?php
session_start();

// Adicionar um novo endereço
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['utilizadorID'])) {
    include 'conexaobd.php'; // Incluir o arquivo de conexão com o banco de dados

    $utilizadorID = $_SESSION['utilizadorID'];
    $endereco = htmlspecialchars($_POST['endereco']);
    $cidade = ucfirst(strtolower(htmlspecialchars($_POST['cidade']))); // Primeira letra maiúscula
    $codigoPostal = formatarCodigoPostal($_POST['codigoPostal']); // Formato 0000-000
    $pais = ucfirst(strtolower(htmlspecialchars($_POST['pais']))); // Primeira letra maiúscula
    $enderecoPrincipal = isset($_POST['enderecoPrincipal']) ? 1 : 0; // 1 se marcado, 0 se não

    // Adicionar "Rua" no início do endereço se não estiver especificado
    if (!startsWithRua($endereco)) {
        $endereco = "Rua " . $endereco;
    }

    // Verificar se o código postal está no formato correto
    if (!$codigoPostal) {
        echo "<script>alert('Código postal inválido! Deve estar no formato 0000-000.');</script>";
    } else {
        // Iniciar transação para garantir consistência
        mysqli_autocommit($conn, false);

        // Inserir o novo endereço
        $sqlInsert = "INSERT INTO enderecos (utilizadorID, endereco, pais, codigoPostal, cidade, predefinido) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtInsert = mysqli_prepare($conn, $sqlInsert);
        mysqli_stmt_bind_param($stmtInsert, "issssi", $utilizadorID, $endereco, $pais, $codigoPostal, $cidade, $enderecoPrincipal);
        mysqli_stmt_execute($stmtInsert);

        // Verificar se a inserção foi bem-sucedida
        if (mysqli_stmt_affected_rows($stmtInsert) > 0) {
            // Obter o ID do endereço inserido
            $enderecoID = mysqli_insert_id($conn);

            // Se a checkbox de endereço principal estiver marcada, atualizar predefinido para este endereço
            if ($enderecoPrincipal == 1) {
                // Desmarcar todos os outros endereços como não predefinidos
                $sqlUnsetPredefinido = "UPDATE enderecos SET predefinido = 0 WHERE utilizadorID = ? AND enderecoID <> ?";
                $stmtUnsetPredefinido = mysqli_prepare($conn, $sqlUnsetPredefinido);
                mysqli_stmt_bind_param($stmtUnsetPredefinido, "ii", $utilizadorID, $enderecoID);
                mysqli_stmt_execute($stmtUnsetPredefinido);
                mysqli_stmt_close($stmtUnsetPredefinido);
            }

            // Commit da transação
            mysqli_commit($conn);

            echo "<script>alert('Endereço adicionado com sucesso!');
            window.location.href='listaEnderecos.php';
            </script>";
        } else {
            mysqli_rollback($conn);

            echo "<script>alert('Erro ao adicionar endereço!');</script>";
        }

        mysqli_stmt_close($stmtInsert);
    }

    mysqli_close($conn);
}

function formatarCodigoPostal($codigoPostal) {
    // Remove todos os caracteres não numéricos
    $codigoPostal = preg_replace('/\D/', '', $codigoPostal);

    // Verifica se o código postal tem 7 dígitos numéricos
    if (strlen($codigoPostal) !== 7) {
        return false; // Retorna falso se não tiver 7 dígitos
    }

    // Formata para o padrão 0000-000
    $codigoPostalFormatado = substr($codigoPostal, 0, 4) . '-' . substr($codigoPostal, 4, 3);

    return $codigoPostalFormatado;
}

function startsWithRua($endereco) {
    return (substr($endereco, 0, 3) === "Rua");
}
$anteriorURL = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
?>


<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Criar novo endereço</title>
    <meta name="description" content="Página para criar um novo endereço no sistema Primesupps.">
    <meta name="keywords" content="Primesupps, criar endereço, novo endereço, usuário, autenticação">
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
    <script type="text/javascript" src="../js/novoEndereco.js"></script>
    <link rel="stylesheet" href="../css/novoEndereco.css">
</head>
<body>
    
<div id="header"></div>

<main>
    <div class="background1">

    <div class="divs" id="encomendasDesktop"><a class="linksAdmin" href="encomendasDesktop.php" title="Ver minhas encomendas"><p>Encomendas</p></a></div>
        <div class="divs" id="enderecosUser"><a class="linksAdmin" href="listaEnderecos.php" title="Gerir lista de endereços"><p>Lista de endereços</p></a></div>
        <div class="divs" id="dadosUser"><a class="linksAdmin" href="gerirDadosContaDesktop.php" title="Gerir dados da conta"><p>Dados da conta</p></a></div>
        <div class="divs" id="dadosFiscais"><a class="linksAdmin" href="dadosFiscais.php" title="Gerir dados fiscais"><p>Dados fiscais</p></a></div>
        <div class="divs" id="metodosPagamento"><a class="linksAdmin" href="metodosPagamento.php" title="Gerir meus métodos Pagamento"><p>Métodos pagamento</p></a></div>
        <div class="divs" id="alterarPassword"><a class="linksAdmin" href="alterarPassword.php" title="Alterar password"><p>Alterar password</p></a></div>

    </div>
<!-- Verificar se a página carrega para editar ou para criar um endereço novo -->
<?php 
    if(isset($_GET['enderecoID'])){
        //Editar endereço 
        include'conexaobd.php';
        $enderecoID = $_GET['enderecoID']; 

        $sqlSelect ="SELECT * FROM enderecos WHERE enderecoID = ?";
        $stmtSelect = mysqli_prepare($conn,$sqlSelect);
        mysqli_stmt_bind_param($stmtSelect, "i", $enderecoID);
        mysqli_stmt_execute($stmtSelect);
        mysqli_stmt_bind_result($stmtSelect, $enderecoIDAntigo, $enderoAntigo, $paisAntigo, $utilizadorID, $codigoPostalAntigo, $cidadeAntiga, $predefinidoAntigo);
        mysqli_stmt_fetch($stmtSelect);
        mysqli_stmt_close($stmtSelect);
        ?>
            <div class="background2"><h1>Editar endereço</h1></div>
                <div class="background">

                    <form method="post" action="editarEndereco.php">
                        <input class="inputs" type="hidden" name="enderecoID" value="<?php echo $enderecoID ?>">
                        <input class="inputs" type="text" name="endereco" placeholder="<?php echo $enderoAntigo ?>" aria-label="Endereço" value="">
                        <input class="inputs" type="text" id="codigoPostal" name="codigoPostal" placeholder="<?php echo $codigoPostalAntigo ?>" aria-label="Código Postal" value="" oninput="formatarCodigoPostal()">
                        <input class="inputs" type="text" name="cidade" placeholder="<?php echo $cidadeAntiga ?>" aria-label="Cidade" value="">
                        <input class="inputs" type="text" name="pais" placeholder="<?php echo $paisAntigo ?>" aria-label="País" value="">
                        <div class="flexPredefinido">
                            <input type="checkbox" name="enderecoPrincipal" value="" <?php echo ($predefinidoAntigo == 1) ? 'checked' : ''; ?>>
                            <label>Endereço principal</label>
                        </div>
                        <button class="btnAdicionar" type="submit"><p>Alterar</p></button>

                    </form>

                </div>

<?php } else { ?>
<!-- Criar novo endereço -->
        <div class="background2"><h1>Novo endereço</h1></div>
        <div class="background">

            <form method="post">

                <input class="inputs" type="text" name="endereco" placeholder="Endereço" aria-label="Endereço" value="" required>
                <input class="inputs" type="text" id="codigoPostal" name="codigoPostal" placeholder="Código Postal" aria-label="Código Postal" value=""  oninput="formatarCodigoPostal()" required>
                <input class="inputs" type="text" name="cidade" placeholder="Cidade" aria-label="Cidade" value="" required>
                <input class="inputs" type="text" name="pais" placeholder="País" aria-label="País" value="" required>
                <div class="flexPredefinido">
                    <input type="checkbox" name="enderecoPrincipal" value="">
                    <label>Endereço principal</label>
                </div>
                <button class="btnAdicionar" type="submit"><p>Adicionar</p></button>

            </form>

        </div>
<?php } ?>
</main>

<div id="footer"></div>

</body>
</html>