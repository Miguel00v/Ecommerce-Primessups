<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include 'conexaobd.php';

    $emailInput = trim($_POST['email']);
    $email = $emailInput;

    // Função para validar o formato do email
    function isValidEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    // Verificar se o email é válido
    if (!isValidEmail($email)) {
        echo "<script>alert('Endereço de email inválido'); window.location.href='index.php';</script>";
        exit();
    }
    
    // Verificar se o utilizador já existe
    $sql = "SELECT utilizadorID FROM utilizadores WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $numRows = mysqli_num_rows($result);

            if ($numRows == 1) {
                // Utilizador existe, verificar se newsletter está ativa
                $row = mysqli_fetch_assoc($result);
                $utilizadorID = $row['utilizadorID'];

                $sqlNews = "SELECT receberNewsletter FROM permissoes WHERE utilizadorID = ?";
                $stmtNews = mysqli_prepare($conn, $sqlNews);

                if ($stmtNews) {
                    mysqli_stmt_bind_param($stmtNews, 'i', $utilizadorID);
                    mysqli_stmt_execute($stmtNews);
                    $resultNews = mysqli_stmt_get_result($stmtNews);

                    if ($resultNews) {
                        $rowNews = mysqli_fetch_assoc($resultNews);

                        if ($rowNews['receberNewsletter'] == 1) {
                            // Newsletter já está ativa
                            echo "<script>alert('Newsletter já está ativa'); window.location.href='index.php';</script>";
                        } else {
                            // Newsletter não está ativa, ativar agora
                            $sqlUpdate = "UPDATE permissoes SET receberNewsletter = 1 WHERE utilizadorID = ?";
                            $stmtUpdate = mysqli_prepare($conn, $sqlUpdate);

                            if ($stmtUpdate) {
                                mysqli_stmt_bind_param($stmtUpdate, 'i', $utilizadorID);
                                mysqli_stmt_execute($stmtUpdate);

                                if (mysqli_stmt_affected_rows($stmtUpdate) > 0) {
                                    echo "<script>alert('Newsletter ativada com sucesso'); window.location.href='index.php';</script>";
                                } else {
                                    echo "<script>alert('Erro ao ativar newsletter'); window.location.href='index.php';</script>";
                                }
                                mysqli_stmt_close($stmtUpdate);
                            } else {
                                echo "<script>alert('Erro ao preparar a atualização da newsletter'); window.location.href='index.php';</script>";
                            }
                        }
                        mysqli_stmt_close($stmtNews);
                    } else {
                        echo "<script>alert('Erro ao executar a consulta de permissões de newsletter'); window.location.href='index.php';</script>";
                    }
                } else {
                    echo "<script>alert('Erro ao preparar a verificação da newsletter'); window.location.href='index.php';</script>";
                }
            } else {
                // Utilizador não existe, verificar se o email já está na tabela de permissões
                $sql1 = "SELECT receberNewsletter FROM permissoes WHERE email = ?";
                $stmt1 = mysqli_prepare($conn, $sql1);

                if ($stmt1) {
                    mysqli_stmt_bind_param($stmt1, 's', $email);
                    mysqli_stmt_execute($stmt1);
                    $result1 = mysqli_stmt_get_result($stmt1);

                    if ($result1) {
                        $numRows1 = mysqli_num_rows($result1);

                        if ($numRows1 > 0) {
                            $row1 = mysqli_fetch_assoc($result1);

                            if ($row1['receberNewsletter'] == 1) {
                                // Newsletter já está ativa para o email
                                echo "<script>alert('Newsletter já está ativa para o email fornecido'); window.location.href='index.php';</script>";
                            } else {
                                // Newsletter não está ativa para o email, ativar agora
                                $sqlInsert = "UPDATE permissoes SET receberNewsletter = 1 WHERE email = ?";
                                $stmtInsert = mysqli_prepare($conn, $sqlInsert);

                                if ($stmtInsert) {
                                    mysqli_stmt_bind_param($stmtInsert, 's', $email);
                                    mysqli_stmt_execute($stmtInsert);

                                    if (mysqli_stmt_affected_rows($stmtInsert) > 0) {
                                        echo "<script>alert('Newsletter ativada com sucesso'); window.location.href='index.php';</script>";
                                    } else {
                                        echo "<script>alert('Erro ao ativar newsletter'); window.location.href='index.php';</script>";
                                    }
                                    mysqli_stmt_close($stmtInsert);
                                } else {
                                    echo "<script>alert('Erro ao preparar a atualização da newsletter'); window.location.href='index.php';</script>";
                                }
                            }
                        } else {
                            // Email não está na tabela de permissões, adicionar agora
                            $sqlInsert = "INSERT INTO permissoes (email, receberNewsletter) VALUES (?, 1)";
                            $stmtInsert = mysqli_prepare($conn, $sqlInsert);

                            if ($stmtInsert) {
                                mysqli_stmt_bind_param($stmtInsert, 's', $email);
                                mysqli_stmt_execute($stmtInsert);

                                if (mysqli_stmt_affected_rows($stmtInsert) > 0) {
                                    echo "<script>alert('Newsletter ativada com sucesso'); window.location.href='index.php';</script>";
                                } else {
                                    echo "<script>alert('Erro ao ativar newsletter'); window.location.href='index.php';</script>";
                                }
                                mysqli_stmt_close($stmtInsert);
                            } else {
                                echo "<script>alert('Erro ao preparar a inserção da newsletter'); window.location.href='index.php';</script>";
                            }
                        }
                        mysqli_stmt_close($stmt1);
                    } else {
                        echo "<script>alert('Erro ao executar a consulta de permissões de newsletter'); window.location.href='index.php';</script>";
                    }
                } else {
                    echo "<script>alert('Erro ao preparar a verificação da newsletter'); window.location.href='index.php';</script>";
                }
            }
        } else {
            echo "<script>alert('Erro ao executar a consulta de verificação do usuário'); window.location.href='index.php';</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Erro ao preparar a consulta de verificação do usuário'); window.location.href='index.php';</script>";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primesupps - Subscrever newsletter</title>
    <meta name="description" content="Subscreva a newsletter da Primesupps para receber as últimas novidades e ofertas especiais diretamente no seu email.">
    <meta name="keywords" content="Primesupps, newsletter, subscrição, ofertas, novidades">
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
    <script type="text/javascript" src="../js/subscreverNewsletter.js"></script>
    <link rel="stylesheet" href="../css/subscreverNewsletter.css">
</head>
<body>
    
<div id="header"></div>

<main>

    <form id="formSubNews" method="post">
        <h2 id="titulo1">Subscrever a newsletter</h2>
        <input id="email" type="email" name="email" value="" placeholder="Endereço de email" onchange="verificarEmail()" required>
        <button type="submit"><p>Subscrever</p></button>

    </form>

</main>

<div id="footer"></div>

</body>
</html>