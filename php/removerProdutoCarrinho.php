<?php
    if(isset($_POST['produtoID']) && isset($_POST['carrinhoID'])){
        include 'conexaobd.php'; 

        $produtoID = $_POST['produtoID'];
        $carrinhoID = $_POST['carrinhoID'];

        $sql = "DELETE FROM itens_carrinho WHERE itens_carrinho.produtoID = ? AND itens_carrinho.carrinhoID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ii', $produtoID, $carrinhoID);
        mysqli_stmt_execute($stmt);

        if(mysqli_stmt_affected_rows($stmt) > 0){
            echo "<script> alert('Produto removido do carrinho');
                window.location.href='carrinho.php';
            </script>";
        } else {
            echo "<script> alert('Erro ao remover produto do carrinho');
                window.location.href='carrinho.php';
            </script>";
        }

        mysqli_stmt_close($stmt);
    }
?>