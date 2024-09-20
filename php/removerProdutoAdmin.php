<?php 

    session_start();

    if(isset($_GET['produtoID'])){

        include'conexaobd.php';

        $produtoID = $_GET['produtoID'];
        //Desativar chaves estrangeiras
        $conn->query("SET FOREIGN_KEY_CHECKS = 0");

        $sql ="DELETE FROM produtos WHERE produtoID = ?";
        $stmt = mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt, "i", $produtoID);
        mysqli_stmt_execute($stmt);

        if(mysqli_stmt_affected_rows($stmt)>0){

            echo " <script> alert('Produto removido com sucesso!'); 
                  window.location.href='gerirProdutosAdmin.php';
            </script> ";

        } else{

            echo " <script> alert('Erro ao remover produto.'); 
                window.location.href='gerirProdutosAdmin.php';
            </script> ";

        }

        mysqli_stmt_close($stmt);


        //Reativar chaves estrangeiras
        $conn->query("SET FOREIGN_KEY_CHECKS = 1");
    }

?>