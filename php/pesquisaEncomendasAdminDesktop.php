<?php
session_start();

if (isset($_GET['numero']) || isset($_GET['data'])) {
    include 'conexaobd.php';

    $numeroEncomenda = isset($_GET['numero']) ? $_GET['numero'] : '';
    $dataEncomenda = isset($_GET['data']) ? $_GET['data'] : '';

    // Validar a data no formato 'YYYY-MM-DD'
    if ($dataEncomenda && !validateDate($dataEncomenda, 'Y-m-d')) {

        echo "<script>alert('Formato de data inválido.');</script>";
        exit;

    }

    // Preparar a consulta SQL com base nos parâmetros recebidos
    if ($numeroEncomenda && $dataEncomenda) {

        $sql = " SELECT e.*, u.nome, u.apelido 
            FROM encomendas e 
            JOIN utilizadores u ON e.utilizadorID = u.utilizadorID 
            WHERE e.numeroEncomenda = ? AND e.data = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $numeroEncomenda, $dataEncomenda);

    } else
    if ($numeroEncomenda) {

        $sql = " SELECT e.*, u.nome, u.apelido 
            FROM encomendas e 
            JOIN utilizadores u ON e.utilizadorID = u.utilizadorID 
            WHERE e.numeroEncomenda = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $numeroEncomenda);

    } else
    if ($dataEncomenda) {

        $sql = "SELECT e.*, u.nome, u.apelido 
            FROM encomendas e 
            JOIN utilizadores u ON e.utilizadorID = u.utilizadorID 
            WHERE e.data = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $dataEncomenda);

    }

    // Executar a consulta
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    // Verificar os resultados
    if ($resultado->num_rows > 0) {
        while ($encomendas = mysqli_fetch_assoc($resultado)) {
            $numeroEncomenda = $encomendas['numeroEncomenda'];
            $dataEncomenda = $encomendas['data'];
            $estadoEncomenda = $encomendas['estado'];
            $total = $encomendas['total'];
            $encomendaID = $encomendas['encomendaID'];

            // Selecionar imagem do primeiro produto de cada encomenda
            $sqlImage = "SELECT ip.caminho AS imagem
                         FROM itens_encomenda ie
                         JOIN produtos p ON ie.produtoID = p.produtoID
                         JOIN imagens_produtos ip ON p.produtoID = ip.produtoID
                         WHERE ie.encomendaID = ?
                         LIMIT 1";
            $stmtImage = mysqli_prepare($conn, $sqlImage);
            mysqli_stmt_bind_param($stmtImage, "i", $encomendaID);
            mysqli_stmt_execute($stmtImage);
            $resultadoImagem = mysqli_stmt_get_result($stmtImage);
            $imagemProduto = mysqli_fetch_assoc($resultadoImagem)['imagem'];

            echo "
            <div class='encomendasBack'>
                <div class='encomendas'>
                    <a class='linkBtnEncomenda' href='detalhesEncomendaDesktopAdmin.php?numero=".urlencode($encomendas['encomendaID'])."' title='Detalhes da encomenda'>
                    <div class='numeroEncomenda'>
                        <h2>Encomenda ".htmlspecialchars($encomendas['numeroEncomenda'])."</h2>
                    </div>
                    <div class='nomeCliente'>
                        <p>Cliente : ".htmlspecialchars($encomendas['nome']).' '.htmlspecialchars($encomendas['apelido'])."</p>
                    </div>
                    <div class='dataEncomenda'>
                        <p>Data da compra : ".htmlspecialchars($encomendas['data'])."</p>
                    </div>
                    <div class='infoEncomendas'>
                        <div class='dadosInfoEncomenda'>
                            <p>Total : ".number_format($encomendas['total'], 2, ',', '.')." €</p>
                        </div>
                        <div class='dadosInfoEncomenda'>
                            <p>Estado : ".htmlspecialchars($encomendas['estado'])."</p>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
            ";
        }
    } else {

        echo 

            "<div class='semEncomendas'>
                <h3>Sem resultados.</h3>
            </div>";

    }

    // Fechar o statement e a conexão
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

// Função para validar a data no formato específico
function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}
?>