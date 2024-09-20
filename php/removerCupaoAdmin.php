<?php

    if(isset($_GET['cupaoID'])){

        $cupaoID = $_GET['cupaoID'];

        include'conexaobd.php';

        $sql = " DELETE FROM cupoes WHERE cupaoID = ? ";

           //Desativar chaves estrangeiras
            $conn->query("SET FOREIGN_KEY_CHECKS = 0");


            $stmt = mysqli_prepare($conn,$sql);
            mysqli_stmt_bind_param($stmt, 'i', $cupaoID);
            mysqli_stmt_execute($stmt);
            if(mysqli_stmt_affected_rows($stmt)>0){

                echo " <script> alert('Cupão removido com sucesso!'); 
                    window.location.href='gerirCupoesAdmin.php'
                </script> ";
                exit();

            }else {

                echo " <script> alert('Erro ao remover cupão.'); 
                    window.location.href='gerirCupoesAdmin.php';
                </script> ";
                exit();
            }

            mysqli_stmt_close($stmt);


            //Reativar chaves estrangeiras
            $conn->query("SET FOREIGN_KEY_CHECKS = 1");
            
            $conn->close();
    }

?>