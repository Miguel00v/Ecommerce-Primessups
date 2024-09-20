<?php
session_start();

include 'conexaobd.php';

function sendJsonResponse($status, $message) {
    echo json_encode([
        'status' => $status,
        'message' => $message
    ]);
    exit();
}

// Verificar se o usuário está logado
if (isset($_SESSION['utilizadorID'])) {
    $utilizadorID = $_SESSION['utilizadorID'];

    // Verificar se já existe um carrinho ativo para o utilizador
    $sql = "SELECT carrinhoID FROM carrinhos WHERE utilizadorID = ? AND estado = '0'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $utilizadorID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $carrinhoID);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Se o carrinho não for encontrado, criar um novo
    if (!$carrinhoID) {
        $sql_insert_carrinho = "INSERT INTO carrinhos (utilizadorID, estado) VALUES (?, '0')";
        $stmt_insert_carrinho = mysqli_prepare($conn, $sql_insert_carrinho);
        mysqli_stmt_bind_param($stmt_insert_carrinho, 'i', $utilizadorID);
        mysqli_stmt_execute($stmt_insert_carrinho);

        if (mysqli_stmt_affected_rows($stmt_insert_carrinho) > 0) {
            $carrinhoID = mysqli_insert_id($conn);
        } else {
            sendJsonResponse('error', 'Erro ao criar o carrinho.');
        }
        mysqli_stmt_close($stmt_insert_carrinho);
    }

    // Definir o carrinhoID na sessão
    $_SESSION['carrinhoID'] = $carrinhoID;

} else {
    sendJsonResponse('error', 'Você precisa estar logado para comprar.');
}

// Verificar se o ID do produto e a quantidade foram enviados
if (isset($_POST['produtoID'], $_POST['quantidade'])) {
    $produtoID = $_POST['produtoID'];
    $quantidade = $_POST['quantidade'];

    // Verificar se o produto existe na tabela produtos
    $sql_check_produto = "SELECT produtoID FROM produtos WHERE produtoID = ?";
    $stmt_check_produto = mysqli_prepare($conn, $sql_check_produto);
    mysqli_stmt_bind_param($stmt_check_produto, 'i', $produtoID);
    mysqli_stmt_execute($stmt_check_produto);
    mysqli_stmt_store_result($stmt_check_produto);

    if (mysqli_stmt_num_rows($stmt_check_produto) === 0) {
        mysqli_stmt_close($stmt_check_produto);
        sendJsonResponse('error', 'Produto não encontrado.');
    }
    mysqli_stmt_close($stmt_check_produto);

    // Verificar se o produto já está no carrinho
    $sql_check = "SELECT * FROM itens_carrinho WHERE carrinhoID = ? AND produtoID = ?";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, 'ii', $carrinhoID, $produtoID);
    mysqli_stmt_execute($stmt_check);
    $resultado = mysqli_stmt_get_result($stmt_check);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        // Se o produto já estiver no carrinho, atualiza a quantidade
        $row = mysqli_fetch_assoc($resultado);
        $nova_quantidade = $row['quantidade'] + $quantidade;
        $sql_update = "UPDATE itens_carrinho SET quantidade = ? WHERE carrinhoID = ? AND produtoID = ?";
        $stmt_update = mysqli_prepare($conn, $sql_update);
        mysqli_stmt_bind_param($stmt_update, 'iii', $nova_quantidade, $carrinhoID, $produtoID);
        mysqli_stmt_execute($stmt_update);

        if (mysqli_stmt_affected_rows($stmt_update) > 0) {
            sendJsonResponse('success', 'Quantidade do produto atualizada no carrinho.');
        } else {
            sendJsonResponse('error', 'Erro ao atualizar a quantidade do produto no carrinho.');
        }
        mysqli_stmt_close($stmt_update);

    } else {
        // Se o produto não estiver no carrinho, adiciona ao carrinho
        $sql_insert = "INSERT INTO itens_carrinho (carrinhoID, produtoID, quantidade) VALUES (?, ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $sql_insert);
        mysqli_stmt_bind_param($stmt_insert, 'iii', $carrinhoID, $produtoID, $quantidade);

        if (mysqli_stmt_execute($stmt_insert)) {
            if (mysqli_stmt_affected_rows($stmt_insert) > 0) {
                sendJsonResponse('success', 'Produto adicionado ao carrinho.');
            } else {
                sendJsonResponse('error', 'Erro ao adicionar produto ao carrinho.');
            }
        } else {
            sendJsonResponse('error', 'Erro ao executar a inserção.');
        }

        mysqli_stmt_close($stmt_insert);
    }

    mysqli_stmt_close($stmt_check);
} else {
    sendJsonResponse('error', 'ID do produto ou quantidade não encontrada.');
}
?>