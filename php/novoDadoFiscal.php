<?php 

session_start();

if (!isset($_SESSION['utilizadorID'])) {
    echo "<script> 
        alert('Não tem sessão iniciada.'); 
        window.location.href='iniciarSessao.php';
      </script>";
    exit();
}

include 'conexaobd.php';

$utilizadorID = $_SESSION['utilizadorID'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Escapar entradas usando mysqli_real_escape_string
    $nome = $conn->real_escape_string(trim($_POST['nome']));
    $apelido = $conn->real_escape_string(trim($_POST['apelido']));
    $endereco = $conn->real_escape_string(trim($_POST['endereco']));
    $codigoPostal = $conn->real_escape_string(trim($_POST['codigoPostal']));
    $cidade = $conn->real_escape_string(trim($_POST['cidade']));
    $pais = $conn->real_escape_string(trim($_POST['pais']));
    $NIF = $conn->real_escape_string(trim($_POST['NIF']));
    $predefinido = isset($_POST['predefinido']) ? 1 : 0;

    // Adicionar "Rua" no início do endereço se não estiver especificado
    if (!startsWithRua($endereco)) {
        $endereco = "Rua " . $endereco;
    }

    // Verificar se o código postal está no formato correto
    $codigoPostalFormatado = formatarCodigoPostal($codigoPostal);
    if ($codigoPostalFormatado === false) {
        echo "<script>alert('Código postal inválido! Deve estar no formato 0000-000.');</script>";
        exit();
    }

    // Verificar se o NIF tem exatamente 9 dígitos
    if (!verificarNIF($NIF)) {
        echo "<script>alert('NIF inválido! Deve ter exatamente 9 dígitos.');</script>";
        exit();
    }

    // Validar e formatar cidade e país
    if (!validarCidadeOuPais($cidade) || !validarCidadeOuPais($pais)) {
        echo "<script>alert('Cidade ou país inválido! Só são permitidos letras.');</script>";
        exit();
    }
    $cidade = formatarCapitalizacao($cidade);
    $pais = formatarCapitalizacao($pais);

    // Preparar e executar a consulta para inserção
    $sql = "INSERT INTO dados_fiscais (utilizadorID, NIF, endereco, pais, codigoPostal, cidade, nome, apelido, predefinido) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssssss", $utilizadorID, $NIF, $endereco, $pais, $codigoPostalFormatado, $cidade, $nome, $apelido, $predefinido);
        if ($stmt->execute()) {
            echo "<script>alert('Dados inseridos com sucesso!'); window.location.href='dadosFiscais.php';</script>";
        } else {
            echo "<script>alert('Erro ao inserir os dados.');</script>";
        }
        $stmt->close();
    } else {
        echo "Erro: " . $conn->error;
    }

    $conn->close();
}

// Função para formatar o código postal
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

// Função para verificar se o endereço começa com "Rua"
function startsWithRua($endereco) {
    return (substr($endereco, 0, 4) === "Rua ");
}

// Função para verificar se o NIF tem exatamente 9 dígitos
function verificarNIF($NIF) {
    // Remove todos os caracteres não numéricos
    $NIF = preg_replace('/\D/', '', $NIF);
    
    // Verifica se o NIF tem 9 dígitos
    return strlen($NIF) === 9;
}

// Função para validar cidade ou país (apenas letras e espaços)
function validarCidadeOuPais($string) {
    return preg_match('/^[a-zA-Z\s]+$/', $string);
}

// Função para formatar a primeira letra de cada palavra como maiúscula
function formatarCapitalizacao($string) {
    return ucwords(strtolower($string));
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Adicionar dados fiscais</title>
    <meta name="description" content="Adicione seus dados fiscais na Primesupps.">
    <meta name="keywords" content="dados fiscais, atualização fiscal, Primesupps">
    <!-- Inserir em todas as páginas -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/regrasEstilo.css">
    <script type="text/javascript" src="../js/detecaoDispositivo.js"></script><!-- Detetar tipo de dispositivo para páginas que o layout é o mesmo -->
    <link rel="stylesheet" href="../css/footerMobile.css">
    <link rel="stylesheet" href="../css/headerDesktop.css">
    <link rel="stylesheet" href="../css/footerDesktop.css">
    <script type="text/javascript" src="../js/atualizarIconeNumeroCarrinho.js"></script>
    <script type="text/javascript" src="../js/headerDesktop.js"></script>
    <script src="https://kit.fontawesome.com/c3bcd53a96.js" crossorigin="anonymous"></script>
    <!-- Inserir em todas as páginas -->
    <script type="text/javascript" src="../js/novoDadoFiscal.js"></script>
    <link rel="stylesheet" href="../css/novoDadoFiscal.css">
</head>
<body>

<div id="header"></div>

<main>
<div class="background">

<div class="divs" id="encomendasDesktop"><a class="linksAdmin" href="encomendasDesktop.php" title="Ver minhas encomendas"><p>Encomendas</p></a></div>
    <div class="divs" id="enderecosUser"><a class="linksAdmin" href="listaEnderecos.php" title="Gerir lista de endereços"><p>Lista de endereços</p></a></div>
    <div class="divs" id="dadosUser"><a class="linksAdmin" href="gerirDadosContaDesktop.php" title="Gerir dados da conta"><p>Dados da conta</p></a></div>
    <div class="divs" id="dadosFiscais"><a class="linksAdmin" href="dadosFiscais.php" title="Gerir dados fiscais"><p>Dados fiscais</p></a></div>
    <div class="divs" id="metodosPagamento"><a class="linksAdmin" href="metodosPagamento.php" title="Gerir meus métodos Pagamento"><p>Métodos pagamento</p></a></div>
    <div class="divs" id="alterarPassword"><a class="linksAdmin" href="alterarPassword.php" title="Alterar password"><p>Alterar password</p></a></div>

</div>


    <div id="formInsert">
        
    <div class="tituloDados"><h1>Novos dados fiscais</h1></div>

        <form method="post">

            <input class="inputs" type="text" name="nome" value="" placeholder="Nome" aria-label="Nome">
            <input class="inputs" type="text" name="apelido" value="" placeholder="Apelido" aria-label="Apelido">
            <input class="inputs" type="text" name="endereco" value="" placeholder="Sua morada" aria-label="Sua morada">
            <input class="inputs" type="text" id="codigoPostal" name="codigoPostal" value="" placeholder="Código postal" aria-label="Código postal" maxlength="8" oninput="formatarCodigoPostal()">
            <input class="inputs" type="text" name="cidade" value="" placeholder="Cidade" aria-label="Cidade">
            <input class="inputs" type="text" name="pais" value="" placeholder="País" aria-label="País">
            <input class="inputs" type="text" name="NIF" value="" placeholder="NIF" aria-label="NIF" maxlength="9">
            <div class="flexbox">
                <input class="checkbox" type="checkbox" name="predefinido" value="">
                <label>Dados fiscais predefinidos</label>
            </div>
            <button class="btnAdicionar" type="submit"><p>Adicionar</p></button>

        </form>

    </div>

</main>
    
<div id="footer"></div>

</body>
</html>