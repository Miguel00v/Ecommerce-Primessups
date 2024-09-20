<?php
// Verifica se o parâmetro 'q' foi recebido via GET
if (isset($_GET['q'])) {
    $query = $_GET['q'];
    
    // Incluir o arquivo de conexão com o banco de dados
    include 'conexaobd.php';

    // Preparar a consulta SQL utilizando uma consulta preparada para evitar SQL injection
    $sql = "SELECT produtoID,nome FROM produtos WHERE LOWER(nome) LIKE LOWER(?)";
    $param = "%" . $query . "%";
    $stmt = mysqli_prepare($conn, $sql);

    // Verifica se a preparação da consulta teve êxito
    if ($stmt) {
        // Vincula o parâmetro à consulta preparada como string
        mysqli_stmt_bind_param($stmt, "s", $param);

        // Executa a consulta preparada
        mysqli_stmt_execute($stmt);

        // Obtém o resultado da consulta
        $result = mysqli_stmt_get_result($stmt);

        // Inicializa um array para armazenar os resultados
        $results = [];

        // Itera sobre os resultados e adiciona-os ao array
        while ($row = mysqli_fetch_assoc($result)) {
            $results[] =  $row;
        }

        // Fecha a consulta preparada e a conexão com o banco de dados
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        // Retorna os resultados como JSON para o AJAX
        echo json_encode($results);
    } else {
        // Se houver erro na preparação da consulta
        echo json_encode(['error' => 'Erro na preparação da consulta']);
    }
} else {
    // Se 'q' não foi recebido via GET
    echo json_encode(['error' => 'Parâmetro "q" não recebido']);
}
?>