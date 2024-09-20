<?php 

    session_start();

    include'conexaobd.php';

    $utilizadorID = $_GET['utilizadorID'];
    
      // Desativar chaves estrangeiras temporariamente para evitar conflitos
      $conn->query("SET FOREIGN_KEY_CHECKS = 0");

      // Arrays de tabelas relacionadas ao utilizador
      $tables = array(
          'alteracoes_password',
          'avaliacoes',
          'dados_fiscais',
          'enderecos',
          'permissoes',
          'metodos_pagamento',
          'encomendas',
          'utilizadores'
      );
  
      $success = true; // Variável para verificar se todas as deleções foram bem-sucedidas
  
      // Preparar e executar as declarações de exclusão
      foreach ($tables as $table) {
          $stmt = $conn->prepare("DELETE FROM $table WHERE utilizadorID = ?");
          $stmt->bind_param("i", $utilizadorID); 
          $stmt->execute();
          
          // Verificar se ocorreu um erro na execução da declaração
          if ($stmt->error) {
              $success = false;
          }
          
          $stmt->close();
      }
  
      // Reativar chaves estrangeiras
      $conn->query("SET FOREIGN_KEY_CHECKS = 1");
  
      // Verificar se todas as deleções foram bem-sucedidas
      if ($success) {
          // Todas as operações foram bem-sucedidas
          echo "<script> alert('Conta removida com sucesso!');
          window.location.href='gerirUtilizadoresAdmin.php'; </script>";
      } else {
          // Alguma operação falhou
          echo "<script>alert('Erro ao remover conta!');</script>";
      }
  
      // Fechar conexão
      $conn->close();
  

?>