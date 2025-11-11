<?php
require_once "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $razao_social = $_POST["razao_social"];
    $cnpj = $_POST["cnpj"];
    $inscricao_estadual = $_POST["inscricao_estadual"];
    $setor = $_POST["setor"];

    $nome_usuario = $_POST["nome_usuario"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    try {
        $sql_empresa = "INSERT INTO Empresa (razao_social, cnpj, inscricao_estadual, setor)
                        VALUES (:razao_social, :cnpj, :inscricao_estadual, :setor)";
        $stmt = $pdo->prepare($sql_empresa);
        $stmt->execute([
            ":razao_social" => $razao_social,
            ":cnpj" => $cnpj,
            ":inscricao_estadual" => $inscricao_estadual,
            ":setor" => $setor
        ]);

        $id_empresa = $pdo->lastInsertId();

        $sql_usuario = "INSERT INTO Usuario (id_empresa, nome, email, senha_hash, telefone)
                        VALUES (:id_empresa, :nome, :email, :senha, :telefone)";
        $stmt = $pdo->prepare($sql_usuario);
        $stmt->execute([
            ":id_empresa" => $id_empresa,
            ":nome" => $nome_usuario,
            ":email" => $email,
            ":senha" => $senha,
            ":telefone" => $telefone
        ]);

        header("Location: calculadora.html");
        exit();

    } catch (PDOException $e) {
        echo "<h3>Erro ao cadastrar: " . $e->getMessage() . "</h3>";
    }
} else {
    header("Location: cadastro.html");
    exit();
}
?>
