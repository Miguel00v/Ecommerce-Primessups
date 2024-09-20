<?php 
session_start();
include 'conexaobd.php';

$conditions = [];
$params = [];
$types = '';

if (isset($_GET['nome']) && $_GET['nome'] !== '') {
    $conditions[] = "nome LIKE ?";
    $params[] = '%' . $_GET['nome'] . '%';
    $types .= 's';
}

if (isset($_GET['apelido']) && $_GET['apelido'] !== '') {
    $conditions[] = "apelido LIKE ?";
    $params[] = '%' . $_GET['apelido'] . '%';
    $types .= 's';
}

if (isset($_GET['email']) && $_GET['email'] !== '') {
    $conditions[] = "email LIKE ?";
    $params[] = '%' . $_GET['email'] . '%';
    $types .= 's';
}

if (isset($_GET['funcao']) && $_GET['funcao'] !== '') {
    $conditions[] = "funcao = ?";
    $params[] = $_GET['funcao'];
    $types .= 's';
}

$sql = "SELECT utilizadorID, nome, apelido, email, dataNascimento, funcao FROM utilizadores";

if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$stmt = mysqli_prepare($conn, $sql);

if ($types) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $utilizadorID, $nome, $apelido, $email, $dataNascimento, $funcao);

$users = [];
while (mysqli_stmt_fetch($stmt)) {
    $users[] = [
        'utilizadorID' => $utilizadorID,
        'nome' => $nome,
        'apelido' => $apelido,
        'email' => $email,
        'dataNascimento' => $dataNascimento,
        'funcao' => $funcao
    ];
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

if (count($users) > 0) {
    foreach ($users as $user) {
        echo '<div id="utilizadoresPadrao">
                 <div class="background2">
                    <div class="editarUser">
                        <a href="editarUtilizadorAdmin.php?utilizadorID=' . htmlspecialchars($user['utilizadorID']) . '" title="Editar utilizador">
                            <button id="btnEditar" class="btns" type="button">
                                <i class="fa-solid fa-user-pen"></i>
                            </button>
                        </a>
                    </div>
                    <div class="idUser">
                        <p>id : ' . htmlspecialchars($user['utilizadorID']) . '</p>
                    </div>
                    <div class="infoUser">
                        <h3>' . htmlspecialchars($user['nome'] . ' ' . $user['apelido']) . '</h3>
                        <p>' . htmlspecialchars($user['email']) . '</p>
                        <p>' . htmlspecialchars($user['funcao']) . '</p>
                        <p>' . htmlspecialchars($user['dataNascimento']) . '</p>
                    </div>
                    <div class="removerUser">
                        <button class="btns" id="btnRmover" type="button" onclick="confirmarDesativacao(\'removerUtilizadorAdmin.php?utilizadorID=' . htmlspecialchars($user['utilizadorID']) . '\')">
                            <p>X</p>
                        </button>
                    </div>
                </div>
            </div>';
    }
} else {
    echo '<div class="semResultados"><p>Sem resultados</p></div>';
}
?>