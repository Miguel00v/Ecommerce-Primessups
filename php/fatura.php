<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Fatura</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header, .invoice-box {
            margin-bottom: 20px;
        }
        .header img {
            display: block;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .invoice-box {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-header {
            margin-bottom: 20px;
        }
        .invoice-header p {
            margin: 0;
        }
        .container {
    display: flex;
    justify-content: space-between; 
    gap: 20px; 
}

.invoice-fiscal,
.invoice-endereco {
    flex: 1; 
    padding: 10px; 
    box-sizing: border-box; 
}

.invoice-fiscal h3,
.invoice-endereco h3 {
    margin-top: 0;
}

@media (max-width: 768px) {
    .container {
        flex-direction: column; 
    }
}
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px; 
            text-align: left; 
        }
        th { 
            background-color: #f2f2f2; 
        }
        .footer {
            bottom: 0px;
            font-size: 12px;
            font-style: italic;
        }
        .full-width-image {
            width: 100%;
            height: 25%; 
            object-fit: cover; 
        }
    </style>
</head>
<body>
    <div class="header">
        <img class="full-width-image" src="http://localhost/Trabalho%20final/Desenvolvimento/imagens/identidadeVisual/logotipo.png" alt="Logotipo">
        <h2>Fatura nº <?php echo $numeroEncomenda; ?></h2>
    </div>
    <div class="invoice-box">
        <div class="invoice-header">
            <p>Data: <?php echo date('d/m/Y'); ?></p>
            <p>Cliente: <?php echo $nome . ' ' . $apelido; ?></p>
        </div>
        <?php if($nomeFiscal != '') {?>
            <div class="container">
    <div class="invoice-fiscal">
        <h3>Dados de faturação</h3>
        <p><?php echo htmlspecialchars($nomeFiscal .' '.$apelidoFiscal); ?></p>
        <p><?php echo htmlspecialchars($enderecoFiscal); ?></p>
        <p><?php echo htmlspecialchars($codigoPostalFiscal); ?></p>
        <p><?php echo htmlspecialchars($cidadeFiscal .', '.$paisFiscal); ?></p>
        <p><?php echo htmlspecialchars($NIF); ?></p>
    </div>
    <?php } ?>
    <div class="invoice-endereco">
        <h3>Endereço de envio</h3>
        <p><?php echo htmlspecialchars($endereco); ?></p>
        <p><?php echo htmlspecialchars($codigoPostal); ?></p>
        <p><?php echo htmlspecialchars($cidade.', '.$pais); ?></p>
    </div>
</div>
        <table class="invoice-items">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carrinho as $item): ?>
                    <tr>
                        <td><?php echo $item['nome']; ?></td>
                        <td><?php echo $item['quantidade']; ?></td>
                        <td><?php echo number_format($item['preco'], 2, ',', '.') . ' €'; ?></td>
                        <td><?php echo number_format($item['preco'] * $item['quantidade'], 2, ',', '.') . ' €'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="invoice-total">
            <h3>Desconto: <?php echo number_format($desconto, 2, ',', '.') . ' €'; ?></h3>
            <h3>Total: <?php echo number_format($valorFinal, 2, ',', '.') . ' €'; ?></h3>
        </div>
    </div>
    <div class="footer">
        <h2>Termos e condições</h2>
        <p>Esta fatura deve ser guardada para sua referência. Veja os <a href="../php/termosCondicoes.php" title="Termos e Condições">termos e condições</a> aplicáveis.</p>
    </div>
</body>
</html>