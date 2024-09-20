<?php
session_start();

function getCartCount() {
    if (isset($_SESSION['carrinhoID'])) {
        $carrinhoID = $_SESSION['carrinhoID'];

        include 'conexaobd.php';

        $sql = "SELECT COUNT(*) AS item_count FROM itens_carrinho WHERE carrinhoID = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $carrinhoID);

            mysqli_stmt_execute($stmt);

            mysqli_stmt_bind_result($stmt, $item_count);

            mysqli_stmt_fetch($stmt);

            mysqli_stmt_close($stmt);

            mysqli_close($conn);

            return $item_count;
        }
    }
    
    return 0;
}

header('Content-Type: application/json');

echo json_encode(['cartCount' => getCartCount()]);
?>