-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Set-2024 às 15:35
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `primesupps`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `alteracoes_password`
--

CREATE TABLE `alteracoes_password` (
  `alteracaoID` int(11) NOT NULL,
  `data` datetime DEFAULT NULL,
  `utilizadorID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `avaliacaoID` int(11) NOT NULL,
  `utilizadorID` int(11) NOT NULL,
  `produtoID` int(11) NOT NULL,
  `data` date NOT NULL,
  `comentario` text NOT NULL,
  `avaliacao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `avaliacoes`
--

INSERT INTO `avaliacoes` (`avaliacaoID`, `utilizadorID`, `produtoID`, `data`, `comentario`, `avaliacao`) VALUES
(1, 33, 2, '2024-07-15', 'Produto excelente, entrega rápida.', 4),
(2, 33, 25, '2024-09-02', 'O suplemento vem em cápsulas fáceis de engolir e não tem sabor. Notei uma melhora na minha energia e disposição após algumas semanas de uso. O único ponto negativo é o preço, que é um pouco elevado em comparação com outros produtos similares.\r\n\r\n', 4),
(3, 39, 3, '2024-09-08', 'Real Whey Prime é simplesmente incrível! O sabor de baunilha é delicioso e realmente me ajuda na recuperação após os treinos intensos.\r\nAltamente recomendado!', 5),
(11, 39, 6, '2024-01-12', 'Estou muito satisfeita com Real Whey Prime. Sinto uma grande diferença na minha recuperação muscular e o sabor chocolate é ótimo!', 5),
(12, 41, 3, '2024-03-17', 'Whey Prime tem sido um divisor de águas na minha rotina de treino. Mistura facilmente e tem um gosto ótimo. Estou vendo grandes melhorias na minha massa muscular', 5),
(13, 42, 7, '2024-05-27', '\"Bom produto para aumentar a ingestão de proteínas diárias. O sabor de morango é agradável e se mistura bem com água ou leite.', 4),
(14, 43, 8, '2024-05-30', 'Whey Hydro Isolate é perfeito para a recuperação rápida. Notei uma diferença significativa no tempo de recuperação e na qualidade dos meus treinos.', 4),
(15, 44, 4, '2024-06-10', 'Excelente proteína! A absorção é muito rápida e me ajuda bastante na recuperação pós-treino. Recomendo para quem precisa de resultados rápidos.', 5),
(16, 45, 5, '2024-06-22', 'Real Whey oferece um ótimo custo-benefício. Os resultados são excelentes e o sabor chocolate é maravilhoso', 4),
(17, 46, 1, '2024-07-04', 'Muito bom para quem busca uma proteína de qualidade a um preço acessível. Sabor de baunilha é agradável e fácil de misturar', 4),
(18, 47, 9, '2024-07-18', 'A Creatina Mono-Hidratada da PrimeSupps é de alta qualidade. Tenho mais força e resistência nos treinos. Ótimo produto!', 5),
(19, 48, 10, '2024-07-27', 'Fantástica para melhorar a performance! Sinto-me mais forte e com mais energia durante os treinos.', 5),
(20, 49, 17, '2024-07-29', 'A Creatina Creapure é fantástica! Notei uma diferença na minha performance e não causa nenhum desconforto estomacal.', 5),
(21, 50, 11, '2024-08-01', 'Muito eficaz e de alta pureza. Resultados visíveis na força e na massa muscular. Recomendo.', 5),
(22, 51, 21, '2024-08-06', 'A Glutamina me ajudou muito na recuperação pós-treino. Sinto menos dores musculares e minha imunidade melhorou.', 5),
(23, 52, 21, '2024-08-13', '\"Excelente para recuperação muscular. Sinto-me menos cansada após treinos intensos.', 4),
(24, 53, 22, '2024-08-15', 'Os BCAAs têm sido essenciais na minha rotina. Sinto uma grande diferença na minha energia durante os treinos.', 4),
(25, 54, 22, '2024-08-21', 'Muito bom para recuperação e resistência. Uso diariamente e sinto a diferença na performance.', 5),
(26, 55, 23, '2024-08-22', 'Amino Complex tem tudo que preciso em um só produto. Excelente para a recuperação e saúde geral.', 4),
(27, 56, 23, '2024-08-23', '\"Ótimo mix de aminoácidos. Tenho notado uma melhora na recuperação e na energia durante os treinos', 5),
(28, 57, 24, '2024-08-29', '\"Beta Alanine me deu aquele boost extra que eu precisava. Meus treinos de alta intensidade nunca foram tão eficazes.', 4),
(29, 59, 24, '2024-07-25', 'Ajuda muito na resistência e desempenho durante os treinos. Sinto menos fadiga muscular', 4),
(30, 58, 25, '2024-08-30', 'CLA realmente funciona! Perdi gordura corporal sem perder massa muscular. Ótimo suplemento.', 5),
(31, 60, 25, '2024-08-21', 'Bom para queima de gordura. Notei uma diferença significativa na composição corporal.', 4),
(32, 61, 26, '2024-08-24', 'Fat Burner me ajudou a perder peso rapidamente. Mais energia e menos apetite, excelente combinação.', 4),
(33, 62, 26, '2024-08-29', 'Ajuda muito no controle de peso e aumenta a energia durante os treinos. Muito satisfeito!', 4),
(34, 63, 27, '2024-08-30', 'A L-carnitina é ótima para a queima de gordura e me dá um bom boost de energia antes dos treinos.', 5),
(35, 64, 27, '2024-03-24', 'Ótima para queima de gordura e melhora da performance. Uso regularmente antes dos treinos.', 4),
(36, 65, 28, '2024-03-12', 'As gominolas são deliciosas e fáceis de tomar. Notei uma melhoria geral na minha energia e saúde.', 5),
(37, 66, 28, '2024-03-19', 'Muito prático e saboroso. Ideal para quem tem dificuldade em tomar comprimidos.', 5),
(38, 67, 29, '2024-09-12', 'Multivitaminas-Minerais são ótimas para complementar minha dieta. Me sinto mais saudável e ativa.', 4),
(39, 68, 30, '2024-09-11', 'Produto completo e de alta qualidade. Sinto-me mais disposto e saudável.', 5),
(40, 69, 32, '2024-09-10', 'Vitaminas-Minerais Prime tem tudo que eu preciso. Alta qualidade e sinto a diferença no meu bem-estar diário.', 5),
(41, 70, 31, '2024-09-09', '\"Excelente produto. Ajudou muito na minha saúde geral e nadisposição diária.', 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinhos`
--

CREATE TABLE `carrinhos` (
  `carrinhoID` int(11) NOT NULL,
  `utilizadorID` int(11) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `carrinhos`
--

INSERT INTO `carrinhos` (`carrinhoID`, `utilizadorID`, `estado`) VALUES
(32, 38, 0),
(33, 33, 1),
(34, 33, 1),
(35, 33, 0),
(36, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `codigo_acesso_admin`
--

CREATE TABLE `codigo_acesso_admin` (
  `codigoID` int(11) NOT NULL,
  `utilizadorID` int(11) NOT NULL,
  `usado` tinyint(1) NOT NULL DEFAULT 0,
  `codigo` varchar(255) NOT NULL,
  `dataCriacao` datetime NOT NULL,
  `dataExpiracao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `codigo_acesso_admin`
--

INSERT INTO `codigo_acesso_admin` (`codigoID`, `utilizadorID`, `usado`, `codigo`, `dataCriacao`, `dataExpiracao`) VALUES
(56, 1, 0, 'c2f458d2a4a14c8f73cf', '2024-09-13 10:16:08', '2024-09-13 11:16:08'),
(57, 1, 0, 'f726f645f9a4744f58ff', '2024-09-13 10:17:48', '2024-09-13 11:17:48'),
(58, 1, 0, '336cd39ad8d89c6be5de', '2024-09-13 10:29:50', '2024-09-13 11:29:50'),
(59, 1, 0, '914ce3eeb2eb94501cfd', '2024-09-13 10:30:10', '2024-09-13 11:30:10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cupoes`
--

CREATE TABLE `cupoes` (
  `cupaoID` int(11) NOT NULL,
  `tipoValor` enum('FIXO','PERCENTUAL') NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `dataExpiracao` datetime NOT NULL,
  `estado` enum('ATIVO','INATIVO') NOT NULL DEFAULT 'ATIVO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cupoes`
--

INSERT INTO `cupoes` (`cupaoID`, `tipoValor`, `valor`, `codigo`, `descricao`, `dataExpiracao`, `estado`) VALUES
(5, 'FIXO', 10.00, 'SAVE10NOW', 'Desconto fixo de 10€ em sua próxima compra', '2024-12-31 23:59:59', 'ATIVO'),
(6, 'PERCENTUAL', 0.25, 'SUPERDEAL25', 'Desconto de 25% em todos os produtos', '2024-09-30 23:59:59', 'ATIVO'),
(7, 'FIXO', 20.00, 'SPRINGSALE20', 'Desconto fixo de 20€ na coleção de primavera', '2024-10-15 23:59:59', 'INATIVO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `dados_fiscais`
--

CREATE TABLE `dados_fiscais` (
  `dadosFiscaisID` int(11) NOT NULL,
  `utilizadorID` int(11) NOT NULL,
  `NIF` char(9) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `codigoPostal` varchar(20) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `apelido` varchar(100) NOT NULL,
  `predefinido` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `dados_fiscais`
--

INSERT INTO `dados_fiscais` (`dadosFiscaisID`, `utilizadorID`, `NIF`, `endereco`, `pais`, `codigoPostal`, `cidade`, `nome`, `apelido`, `predefinido`) VALUES
(8, 33, '222222222', 'Rua Cidade Trelazé', 'Portugal', '4440-125', 'Porto', 'Miguel', 'Vieira', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `documentos_legais`
--

CREATE TABLE `documentos_legais` (
  `documentoID` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `documento` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `documentos_legais`
--

INSERT INTO `documentos_legais` (`documentoID`, `nome`, `documento`) VALUES
(1, 'Política de privacidade', 'Na PrimeSupps, valorizamos a sua privacidade e estamos comprometidos em proteger as informações pessoais que você compartilha connosco. Esta política de privacidade explica como recolhemos, utilizamos, compartilhamos e protegemos as suas informações quando visita o nosso website e utiliza os nossos serviços.\r\n\r\nInformações que recolhemos\r\n● Informações Pessoais: Podemos recolher informações pessoais como nome, endereço de e-mail, número de telefone, endereço de entrega, entre outros, quando você se cadastra em nosso site, faz uma compra ou se comunica connosco.\r\n● Informações de Pagamento: Ao realizar uma compra, podemos recolher informações de pagamento, como número do cartão de crédito ou débito, para processar seu pedido de forma segura.\r\n● Informações de navegação: Podemos recolher informações sobre como você interage com o nosso site, incluindo páginas visitadas, links clicados e tempo gasto em cada página, para melhorar a experiência do usuário e otimizar nosso conteúdo.\r\n\r\nComo utilizamos as suas informações\r\n● Para Processar Pedidos: Utilizamos suas informações pessoais para processar seus pedidos, fornecer produtos e serviços solicitados e realizar transações financeiras.\r\n● Para Melhorar o Serviço: Utilizamos informações de navegação para entender como o nosso site é usado e melhorar sua funcionalidade e conteúdo.\r\n● Para Comunicação: Podemos usar suas informações para responder ás suas perguntas, fornecer suporte ao cliente e enviar comunicações relacionadas ao seu pedido ou conta.\r\n\r\n\r\nCompartilhamento de Informações\r\n● Com Fornecedores de Serviços: Podemos compartilhar suas informações com terceiros que prestam serviços em nosso nome, como processamento de pagamentos, entrega de pedidos e análise de dados.\r\n● Com Consentimento: Podemos compartilhar as suas informações pessoais com o seu consentimento explícito para outros fins além dos descritos nesta política de privacidade.\r\n\r\nSegurança das Informações\r\n● Implementamos medidas de segurança técnicas, administrativas e físicas para proteger as suas informações contra o acesso não autorizado, uso indevido ou alteração.\r\n\r\nSeus Direitos e Escolhas\r\n● Acesso e Correção: Você pode acessar e corrigir suas informações pessoais entrando em contacto connosco através das opções de contacto fornecidas neste site.\r\n● Cancelamento da Assinatura: Você pode optar por não receber nossas comunicações de marketing a qualquer momento, seguindo as instruções de cancelamento de inscrição incluídas em cada e-mail.\r\n\r\nAlterações nesta Política\r\n● Podemos atualizar esta política de privacidade periodicamente para refletir mudanças em nossas práticas de privacidade. Recomendamos que\r\nreveja esta página regularmente para estar ciente de qualquer atualização.\r\n\r\nContacto\r\nSe você tiver dúvidas, preocupações ou sugestões sobre nossa política de privacidade ou práticas de privacidade, entre em contato conosco através dos canais de suporte disponibilizados em nosso site.\r\n\r\nÚltima atualização: junho de 2024'),
(2, 'Termos e condições', 'Bem-vindo aos Termos e Condições da PrimeSupps. Por favor, leia atentamente as seguintes diretrizes que regulam o uso do nosso site e as condições para compra de produtos.\r\n\r\n1. Uso do Site\r\n1.1 Aceitação dos Termos: Ao utilizar o site PrimeSupps (doravante \"site\"),\r\nvocê concorda em cumprir estes Termos e Condições, bem como nossa Política de Privacidade.\r\n1.2 Idade Mínima: Você deve ter pelo menos 18 anos de idade para fazer\r\ncompras no site da PrimeSupps. Se você tiver menos de 18 anos, poderá usar o site somente com a supervisão de um pai ou responsável.\r\n\r\n2. Compra de Produtos\r\n2.1 Elegibilidade para Compra: Ao fazer uma compra em nosso site, você declara que possui pelo menos 18 anos de idade ou está sob a supervisão de um pai ou responsável.\r\n2.2 Informações de Pagamento: Ao fornecer informações de pagamento, você declara ser o proprietário legítimo da forma de pagamento utilizada ou ter permissão expressa do proprietário para utilizar essa forma de pagamento.\r\n\r\n3. Proteção de Dados do Cliente\r\n3.1 Coleta de Informações: Coletamos apenas as informações necessárias para processar suas compras e melhorar sua experiência no site. Isso inclui nome, endereço, email e informações de pagamento.\r\n3.2 Uso de Informações: As informações dos clientes são usadas exclusivamente para processar pedidos, fornecer suporte ao cliente e comunicar promoções ou atualizações relevantes.\r\n3.3 Segurança: Implementamos medidas rigorosas para proteger suas informações contra acesso não autorizado ou uso indevido. Utilizamos tecnologias de criptografia para transações seguras.\r\n3.4 Não Venda de Informações: Comprometemo-nos a não vender, alugar\r\nou compartilhar suas informações pessoais com terceiros para fins de marketing sem sua permissão explícita.\r\n\r\n4. Regras e Diretrizes do Site\r\n4.1 Comportamento do Usuário: Esperamos que todos os usuários se comportem de maneira ética e respeitosa ao utilizar nosso site e interagir com outros usuários.\r\n4.2 Conteúdo do Site: Todo o conteúdo disponível no site, incluindo textos,\r\nimagens e vídeos, é propriedade da PrimeSupps ou de seus fornecedores e\r\nestá protegido por direitos autorais.\r\n4.3 Produtos e Preços: Nos esforçamos para manter informações precisas sobre produtos e preços. Reservamo-nos o direito de corrigir erros, alterar\r\npreços ou interromper produtos a qualquer momento sem aviso prévio.\r\n\r\n5. Alterações nos Termos e Condições\r\n5.1 Atualizações: Os Termos e Condições podem ser atualizados periodicamente para refletir mudanças no site ou na legislação aplicável. Recomendamos revisar esta página regularmente para estar ciente de quaisquer alterações.\r\n5.2 Notificação de Alterações: Faremos o possível para notificá-lo sobre alterações significativas por meio de avisos no site ou por email.\r\n\r\n6. Contacto\r\nPara quaisquer dúvidas ou preocupações sobre estes Termos e Condições, entre em contato conosco através das informações fornecidas no site.\r\n\r\nEstes Termos e Condições foram atualizados em junho de 2024.'),
(3, 'Sobre nós', 'Na PrimeSupps, estamos dedicados a fornecer aos nossos clientes produtos de suplementação com a mais alta qualidade e o máximo de rapidez.\r\n\r\nFundada com a paixão por fitness e bem-estar, nossa missão é ajudar você a alcançar seus objetivos de saúde e performance, fornecendo produtos que\r\nrealmente fazem a diferença.\r\n\r\nNossa Missão\r\nQualidade Superior: Nosso compromisso com a excelência se reflete em cada aspecto do nosso negócio. Selecionamos cuidadosamente os melhores fornecedores e ingredientes para garantir que nossos produtos atendam aos mais altos padrões de qualidade e segurança.\r\n\r\nRapidez e Eficiência: Entendemos a importância da rapidez quando se trata\r\nde suas necessidades de suplementação. Nosso processo de atendimento e entrega é otimizado para garantir que seus produtos cheguem até você o mais rápido possível, sem comprometer a qualidade.\r\n\r\nNossos Produtos\r\nOferecemos uma ampla gama de suplementos nutricionais projetados para apoiar diferentes necessidades de fitness e saúde. Desde proteínas premium até vitaminas essenciais e produtos específicos para recuperação muscular,\r\ncada item em nosso catálogo é escolhido para ajudar você a alcançar seus objetivos de maneira eficaz e sustentável.\r\n\r\nCompromisso com o Cliente Atendimento Excepcional: Nossa equipe está aqui para fornecer um atendimento personalizado e eficiente. Estamos sempre disponíveis para responder suas perguntas, oferecer orientação e garantir sua satisfação com\r\ncada compra.\r\n\r\nInovação Contínua: Estamos constantemente buscando novas maneiras de melhorar e expandir nossa linha de produtos para atender às necessidades em evolução de nossos clientes. Seja através de novas formulações, embalagens sustentáveis ou melhorias no processo de entrega, estamos\r\ncomprometidos com a inovação.'),
(4, 'Devoluções e trocas', 'Condições Gerais\r\n\r\n● Prazo para Devolução: Você tem 15 dias corridos a partir da data de entrega do produto para solicitar uma devolução ou troca.\r\n● Estado do Produto: Para ser elegível para uma devolução ou troca, o\r\nproduto deve estar sem uso, em sua embalagem original e nas mesmas condições em que você o recebeu. \r\n\r\nProdutos abertos, utilizados ou danificados não serão aceitos.\r\n\r\nComo Solicitar uma Devolução ou Troca\r\n\r\n● Contacto Inicial: Entre em contacto com nosso suporte ao cliente através do e-mail primesupps.pt@gmail.com, informando o número do pedido e o motivo da devolução ou troca.\r\n● Processamento: Após o contacto, nossa equipe fornecerá as instruções detalhadas sobre como proceder, incluindo o endereço para envio do produto de volta.\r\n\r\nProcessamento de Devoluções\r\n\r\n● Avaliação do Produto: Assim que recebermos o produto devolvido, ele será inspecionado para garantir que atende às condições de devolução.\r\n● Reembolso: Se a devolução for aprovada, processaremos o reembolso através do método de pagamento original. O tempo para o crédito pode variar conforme o método de pagamento e a operadora do cartão de crédito.\r\n\r\nTrocas\r\n\r\n● Disponibilidade do Produto: Para trocas, verificaremos a disponibilidade do produto desejado. Se o item estiver em estoque, enviaremos o novo produto após a devolução e inspeção do item original.\r\n● Diferença de Preço: Se houver diferença de preço entre o produto devolvido e o novo produto, entraremos em contacto para acertar qualquer valor adicional necessário.\r\n\r\nCustos de Envio\r\n\r\n● Devoluções: O custo de envio da devolução será responsabilidade do\r\ncliente, exceto nos casos onde o produto recebido esteja danificado, defeituoso ou diferente do pedido original.\r\n● Trocas: Se a troca for devido a um erro nosso ou produto defeituoso, arcaremos com o custo do envio. Caso contrário, o cliente será responsável pelos custos de envio. Produtos Não Elegíveis para Devolução ou Troca\r\n● Suplementos Abertos: Suplementos e produtos alimentícios que foram abertos ou consumidos parcialmente.\r\n● Produtos Personalizados: Produtos feitos sob encomenda ou personalizados não são elegíveis para devolução ou troca.\r\n\r\nItens Danificados ou Defeituosos\r\n\r\nSe você receber um produto danificado ou defeituoso, por favor, entre em contacto conosco imediatamente. Solicitamos que envie fotos do produto e da embalagem para que possamos avaliar a situação e providenciar uma solução adequada, que pode incluir a substituição do produto ou o reembolso integral.'),
(5, 'Perguntas frequentes', 'Quais são as opções de pagamento disponíveis?\r\n\r\nAceitamos várias formas de pagamento, incluindo:\r\n● Cartões de crédito (Visa, MasterCard, American Express)\r\n\r\nQuanto tempo leva para meu pedido ser processado?\r\nNormalmente, processamos os pedidos em até 2 dias úteis após a confirmação do pagamento. Em períodos de alta demanda, como promoções e feriados, o prazo pode ser estendido para até 3 dias úteis.\r\n\r\nComo faço para rastrear meu pedido?\r\nApós o envio do seu pedido, você receberá um e-mail com o número de rastreamento e um link para acompanhar a entrega pelo site da transportadora.\r\n\r\nQual é a política de devolução?\r\nNossa política de devolução permite que você devolva produtos não utilizados e na embalagem original em até 15 dias após a entrega. Para iniciar uma devolução, entre em contato com nosso suporte ao cliente e siga as instruções fornecidas.\r\n\r\nVocês enviam para o exterior?\r\nSim, enviamos para vários países. As opções de envio internacional e os\r\ncustos associados serão apresentados no checkout. Note que o prazo de entrega pode variar de acordo com a localização.\r\n\r\nComo sei qual suplemento é adequado para mim?\r\nRecomendamos que você consulte um nutricionista ou profissional de saúde\r\nantes de iniciar qualquer suplemento. Eles poderão avaliar suas necessidades específicas e indicar os produtos mais adequados.\r\n\r\nOs produtos são testados para garantir qualidade e segurança?\r\nSim, todos os nossos produtos passam por rigorosos testes de qualidade e segurança. Trabalhamos com fornecedores certificados que seguem as melhores práticas de fabricação.\r\n\r\nPosso alterar ou cancelar meu pedido após a confirmação?\r\nSe precisar alterar ou cancelar seu pedido, entre em contato com nosso\r\nsuporte ao cliente o mais rápido possível. Faremos o possível para atender\r\nsua solicitação antes do envio. Após o envio, alterações ou cancelamentos\r\nnão serão possíveis.\r\n\r\nComo utilizo um cupão de desconto?\r\nNo carrinho digite o código do seu cupão exatamente como recebido (verifique maiúsculas, minúsculas e qualquer caractere especial) e clique em\r\n\"Adicionar Cupão\".');

-- --------------------------------------------------------

--
-- Estrutura da tabela `encomendas`
--

CREATE TABLE `encomendas` (
  `encomendaID` int(11) NOT NULL,
  `enderecoID` int(11) NOT NULL,
  `utilizadorID` int(11) NOT NULL,
  `data` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `numeroEncomenda` varchar(255) NOT NULL,
  `cupaoID` int(11) DEFAULT NULL,
  `dadosFiscaisID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `encomendas`
--

INSERT INTO `encomendas` (`encomendaID`, `enderecoID`, `utilizadorID`, `data`, `total`, `estado`, `numeroEncomenda`, `cupaoID`, `dadosFiscaisID`) VALUES
(199, 18, 33, '2024-09-13', 99.98, 'Processando', 'PS80708', 5, 8),
(200, 18, 33, '2024-09-13', 19.49, 'Processando', 'PS99799', 6, 8);

-- --------------------------------------------------------

--
-- Estrutura da tabela `enderecos`
--

CREATE TABLE `enderecos` (
  `enderecoID` int(11) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `utilizadorID` int(11) NOT NULL,
  `codigoPostal` varchar(20) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `predefinido` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `enderecos`
--

INSERT INTO `enderecos` (`enderecoID`, `endereco`, `pais`, `utilizadorID`, `codigoPostal`, `cidade`, `predefinido`) VALUES
(18, 'Rua cidade trelazé', 'Portugal', 33, '4401-245', 'Porto', 1),
(19, 'Rua Padre Dinis', 'Portugal', 33, '4444-120', 'Porto', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagens_produtos`
--

CREATE TABLE `imagens_produtos` (
  `imagemID` int(11) NOT NULL,
  `produtoID` int(11) NOT NULL,
  `caminho` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `imagens_produtos`
--

INSERT INTO `imagens_produtos` (`imagemID`, `produtoID`, `caminho`) VALUES
(1, 1, '../imagens/produtos/proteinas/real whey 1000g (2).jpg'),
(2, 1, '../imagens/produtos/proteinas/real whey 1000g.jpg'),
(3, 2, '../imagens/produtos/proteinas/real whey prime 1000g (2).jpg'),
(4, 2, '../imagens/produtos/proteinas/real whey prime 1000g.jpg'),
(5, 3, '../imagens/produtos/proteinas/whey prime 1000g.jpg'),
(6, 3, '../imagens/produtos/proteinas/whey prime 1000g (2).jpg'),
(7, 4, '../imagens/produtos/proteinas/Whey Hydro Isolate 1000g (2).jpg'),
(8, 4, '../imagens/produtos/proteinas/Whey Hydro Isolate 1000g.jpg'),
(9, 5, '../imagens/produtos/proteinas/real whey 2000g (2).jpg'),
(10, 5, '../imagens/produtos/proteinas/real whey 2000g.jpg'),
(11, 6, '../imagens/produtos/proteinas/real whey prime 2000g (1).jpg'),
(12, 6, '../imagens/produtos/proteinas/real whey prime 2000g (2).jpg'),
(13, 7, '../imagens/produtos/proteinas/whey prime 2000g (2).jpg'),
(14, 7, '../imagens/produtos/proteinas/whey prime 2000g.jpg'),
(15, 8, '../imagens/produtos/proteinas/Whey Hydro Isolate 2000g (1).jpg'),
(16, 8, '../imagens/produtos/proteinas/Whey Hydro Isolate 2000g (2).jpg'),
(17, 9, '../imagens/produtos/outros/Creatina Mono-Hidratada 90caps (4).jpg'),
(18, 9, '../imagens/produtos/outros/Creatina Mono-Hidratada 90caps (4).jpg'),
(19, 9, '../imagens/produtos/outros/Creatina Mono-Hidratada 90caps (5).jpg'),
(20, 10, '../imagens/produtos/outros/Creatina Mono-Hidratada 350g (1).jpg'),
(21, 10, '../imagens/produtos/outros/Creatina Mono-Hidratada 350g (2).jpg'),
(22, 11, '../imagens/produtos/outros/Creatina Mono-Hidratada 1000g (1).jpg'),
(23, 11, '../imagens/produtos/outros/Creatina Mono-Hidratada 1000g (2).jpg'),
(24, 17, '../imagens/produtos/outros/Creatina Creapure 350g (1).jpg'),
(25, 17, '../imagens/produtos/outros/Creatina Creapure 350g (2).jpg'),
(26, 18, '../imagens/produtos/outros/colagenio (1).jpg'),
(27, 18, '../imagens/produtos/outros/colagenio (2).jpg'),
(28, 19, '../imagens/produtos/pre-treinoePos-treino/Pré-workout 350g (1).jpg'),
(29, 19, '../imagens/produtos/pre-treinoePos-treino/Pré-workout 350g (2).jpg'),
(30, 20, '../imagens/produtos/pre-treinoePos-treino/ultimateRecovery 350g (1).jpg'),
(31, 20, '../imagens/produtos/pre-treinoePos-treino/ultimateRecovery 350g (2).jpg'),
(32, 21, '../imagens/produtos/aminoacidos/Glutamina 350g (1).jpg'),
(33, 21, '../imagens/produtos/aminoacidos/Glutamina 350g (2).jpg'),
(34, 22, '../imagens/produtos/aminoacidos/BCAA 350g (1).jpg'),
(35, 22, '../imagens/produtos/aminoacidos/BCAA 350g (2).jpg'),
(36, 23, '../imagens/produtos/aminoacidos/Amino complex 200caps (1).jpg'),
(37, 23, '../imagens/produtos/aminoacidos/Amino complex 200caps (2).jpg'),
(38, 24, '../imagens/produtos/aminoacidos/Beta Alanine 700g (1).jpg'),
(39, 24, '../imagens/produtos/aminoacidos/Beta Alanine 700g (2).jpg'),
(40, 25, '../imagens/produtos/emagrecimento/CLA 200caps (1).jpg'),
(41, 25, '../imagens/produtos/emagrecimento/CLA 200caps (2).jpg'),
(42, 26, '../imagens/produtos/emagrecimento/fat burner 100caps (1).jpg'),
(43, 26, '../imagens/produtos/emagrecimento/fat burner 100caps (2).jpg'),
(44, 27, '../imagens/produtos/emagrecimento/L-carnitina 90 caps (1).jpg'),
(45, 27, '../imagens/produtos/emagrecimento/L-carnitina 90 caps (2).jpg'),
(46, 28, '../imagens/produtos/vitaminasMinerais/Gominolas multi vitaminas-minerais 30gemmies (1).jpg'),
(47, 28, '../imagens/produtos/vitaminasMinerais/Gominolas multi vitaminas-minerais 30gemmies (2).jpg'),
(48, 29, '../imagens/produtos/vitaminasMinerais/Multi vitaminas-minerais 30caps (1).jpg'),
(49, 29, '../imagens/produtos/vitaminasMinerais/Multi vitaminas-minerais 30caps (2).jpg'),
(50, 30, '../imagens/produtos/vitaminasMinerais/Multi vitaminas-minerais 60caps (1).jpg'),
(51, 30, '../imagens/produtos/vitaminasMinerais/Multi vitaminas-minerais 60caps (2).jpg'),
(52, 31, '../imagens/produtos/vitaminasMinerais/Multi vitaminas-minerais 100caps (1).jpg'),
(53, 31, '../imagens/produtos/vitaminasMinerais/Multi vitaminas-minerais 100caps (2).jpg'),
(54, 32, '../imagens/produtos/vitaminasMinerais/Vitaminas-minerais Prime 32caps (1).jpg'),
(55, 32, '../imagens/produtos/vitaminasMinerais/Vitaminas-minerais Prime 32caps (2).jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens_carrinho`
--

CREATE TABLE `itens_carrinho` (
  `itemID` int(11) NOT NULL,
  `produtoID` int(11) NOT NULL,
  `carrinhoID` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `itens_carrinho`
--

INSERT INTO `itens_carrinho` (`itemID`, `produtoID`, `carrinhoID`, `quantidade`) VALUES
(71, 2, 33, 1),
(72, 32, 33, 2),
(73, 30, 34, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens_encomenda`
--

CREATE TABLE `itens_encomenda` (
  `itemID` int(11) NOT NULL,
  `encomendaID` int(11) NOT NULL,
  `produtoID` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `itens_encomenda`
--

INSERT INTO `itens_encomenda` (`itemID`, `encomendaID`, `produtoID`, `quantidade`) VALUES
(106, 199, 2, 1),
(107, 199, 32, 2),
(108, 200, 30, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens_suporte`
--

CREATE TABLE `mensagens_suporte` (
  `mensagemID` int(11) NOT NULL,
  `utilizadorID` int(11) DEFAULT NULL,
  `assunto` varchar(255) NOT NULL,
  `mensagem` text NOT NULL,
  `dataEnvio` datetime NOT NULL,
  `ficheiro` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `mensagens_suporte`
--

INSERT INTO `mensagens_suporte` (`mensagemID`, `utilizadorID`, `assunto`, `mensagem`, `dataEnvio`, `ficheiro`, `email`) VALUES
(11, 33, 'Reclamações', 'Não recebi a minha encomenda e não consigo entrar em contacto com a trasnportadora.', '2024-09-13 11:15:16', '', 'vieiramiguel813@gmail.com');

-- --------------------------------------------------------

--
-- Estrutura da tabela `metodos_pagamento`
--

CREATE TABLE `metodos_pagamento` (
  `metodoID` int(11) NOT NULL,
  `utilizadorID` int(11) NOT NULL,
  `predefinido` tinyint(1) NOT NULL DEFAULT 0,
  `stripe_payment_method_id` varbinary(256) NOT NULL,
  `nome_titular` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `metodos_pagamento`
--

INSERT INTO `metodos_pagamento` (`metodoID`, `utilizadorID`, `predefinido`, `stripe_payment_method_id`, `nome_titular`) VALUES
(74, 33, 0, 0x706d5f315079554f314a476b7a4c6e736e74564d4c614f7653714e, 'Miguel Vieira'),
(75, 33, 1, 0x706d5f31507956435a4a476b7a4c6e736e7456436c775352564767, 'Miguel Vieira');

-- --------------------------------------------------------

--
-- Estrutura da tabela `permissoes`
--

CREATE TABLE `permissoes` (
  `permissaoID` int(11) NOT NULL,
  `utilizadorID` int(11) DEFAULT NULL,
  `receberNewsletter` tinyint(1) DEFAULT 0,
  `receberEmails` tinyint(1) DEFAULT 0,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `permissoes`
--

INSERT INTO `permissoes` (`permissaoID`, `utilizadorID`, `receberNewsletter`, `receberEmails`, `email`) VALUES
(33, 38, 1, 1, 'anaisacunha36@gmail.com'),
(34, 33, 1, 1, NULL),
(35, 39, 0, 0, NULL),
(36, 40, 0, 0, NULL),
(37, 41, 0, 0, NULL),
(38, 42, 0, 0, NULL),
(39, 43, 0, 0, NULL),
(40, 44, 0, 0, NULL),
(41, 45, 0, 0, NULL),
(42, 46, 0, 0, NULL),
(43, 47, 0, 0, NULL),
(44, 48, 0, 0, NULL),
(45, 49, 0, 0, NULL),
(46, 50, 0, 0, NULL),
(47, 51, 0, 0, NULL),
(48, 52, 0, 0, NULL),
(49, 53, 0, 0, NULL),
(50, 54, 0, 0, NULL),
(51, 55, 0, 0, NULL),
(52, 56, 0, 0, NULL),
(53, 57, 0, 0, NULL),
(54, 58, 0, 0, NULL),
(55, 59, 0, 0, NULL),
(56, 60, 0, 0, NULL),
(57, 61, 0, 0, NULL),
(58, 62, 0, 0, NULL),
(59, 63, 0, 0, NULL),
(60, 64, 0, 0, NULL),
(61, 65, 0, 0, NULL),
(62, 66, 0, 0, NULL),
(63, 67, 0, 0, NULL),
(64, 68, 0, 0, NULL),
(65, 69, 0, 0, NULL),
(66, 70, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `produtoID` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `destaque` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`produtoID`, `nome`, `descricao`, `categoria`, `stock`, `preco`, `destaque`) VALUES
(1, 'Real Whey 1kg', 'Real Whey é uma proteína de soro de leite de alta qualidade que fornece uma excelente fonte de proteína para suporte muscular e recuperação. É uma opção econômica e eficiente para quem deseja\r\naumentar sua ingestão de proteína.\r\n\r\nBenefícios:\r\n● Alta concentração de proteína por porção.\r\n● Ajuda na recuperação muscular e no crescimento.\r\n● Sabor agradável e fácil de misturar.\r\n● Boa relação custo-benefício.\r\n\r\nIndicação de Uso: Misture uma porção (aproximadamente 30g) em 200-250ml de água, leite ou sua bebida preferida. Consumir após o treino ou conforme necessário ao longo do dia.\r\n', 'Proteínas\r\n', 200, 20.00, 1),
(2, 'Real Whey Prime 1kg', 'Real Whey Prime é uma proteína em pó de alta qualidade feita a partir de soro de leite. É projetada para atletas e entusiastas do fitness que buscam uma fonte de proteína de rápida absorção para\r\najudar na recuperação e crescimento muscular.\r\n\r\nBenefícios:\r\n● Alta concentração de proteína por porção.\r\n● Baixo teor de carboidratos e gorduras.\r\n● Facilita a recuperação muscular pós-treino.\r\n● Promove o crescimento e a manutenção da massa muscular magra.\r\n● Disponível em vários sabores agradáveis.\r\n\r\nIndicação de Uso: Misture uma porção (aproximadamente 30g) em 250ml de água ou leite. Consumir após o treino ou conforme a orientação de um nutricionista.', 'Proteínas', 799, 50.00, 0),
(3, 'Whey Prime 1kg', 'Whey Prime é uma proteína de soro de leite premium projetada para fornecer uma fonte eficiente de proteína para suporte\r\nmuscular. É ideal para consumo diário e para qualquer pessoa que precise aumentar sua ingestão de proteína.\r\n\r\nBenefícios:\r\n● Fonte rica de aminoácidos essenciais.\r\n● Ajuda na recuperação e no crescimento muscular.\r\n● Fácil de misturar e sabor agradável.\r\n● Pode ser usado a qualquer hora do dia para aumentar a ingestão de proteína.\r\n\r\nIndicação de Uso: Misture uma porção (aproximadamente 30g) em 200-250ml de água, leite ou sua bebida preferida. Consumir uma ou duas vezes ao dia, conforme necessário.', 'Proteínas', 900, 49.99, 1),
(4, 'Whey Hydro Isolate 1kg', 'Whey Hydro Isolate é uma proteína de soro de leite isolada e hidrolisada, oferecendo a forma mais pura e de mais rápida absorção de proteína. É ideal para atletas de alta performance que precisam de uma proteína de absorção extremamente rápida.\r\n\r\nBenefícios:\r\n● Proteína de absorção ultra-rápida.\r\n● Baixo teor de lactose e gorduras.\r\n● Ideal para consumo imediato após o treino.\r\n● Auxilia na recuperação muscular e na síntese proteica.\r\n● Altamente biodisponível.\r\n\r\nIndicação de Uso: Misture uma porção (aproximadamente 30g) em 200ml de água fria. Consumir imediatamente após o treino para melhores resultados.', 'Proteínas', 560, 69.99, 0),
(5, 'Real Whey 2kg', 'Real Whey é uma proteína de soro de leite de alta qualidade que fornece uma excelente fonte de proteína para suporte muscular e recuperação. É uma opção econômica e eficiente para quem deseja\r\naumentar sua ingestão de proteína.\r\n\r\nBenefícios:\r\n● Alta concentração de proteína por porção.\r\n● Ajuda na recuperação muscular e no crescimento.\r\n● Sabor agradável e fácil de misturar.\r\n● Boa relação custo-benefício.\r\n\r\nIndicação de Uso: Misture uma porção (aproximadamente 30g) em 200-250ml de água, leite ou sua bebida preferida. Consumir após o treino ou conforme necessário ao longo do dia.\r\n', 'Proteínas', 950, 39.99, 1),
(6, 'Real Whey Prime 2kg', 'Real Whey Prime é uma proteína em pó de alta qualidade feita a partir de soro de leite. É projetada para atletas e entusiastas do fitness que buscam uma fonte de proteína de rápida absorção para\r\najudar na recuperação e crescimento muscular.\r\n\r\nBenefícios:\r\n● Alta concentração de proteína por porção.\r\n● Baixo teor de carboidratos e gorduras.\r\n● Facilita a recuperação muscular pós-treino.\r\n● Promove o crescimento e a manutenção da massa muscular magra.\r\n● Disponível em vários sabores agradáveis.\r\n\r\nIndicação de Uso: Misture uma porção (aproximadamente 30g) em 250ml de água ou leite. Consumir após o treino ou conforme a orientação de um nutricionista.', 'Proteínas', 449, 89.99, 1),
(7, 'Whey Prime 2kg', 'Whey Prime é uma proteína de soro de leite premium projetada para fornecer uma fonte eficiente de proteína para suporte\r\nmuscular. É ideal para consumo diário e para qualquer pessoa que precise aumentar sua ingestão de proteína.\r\n\r\nBenefícios:\r\n● Fonte rica de aminoácidos essenciais.\r\n● Ajuda na recuperação e no crescimento muscular.\r\n● Fácil de misturar e sabor agradável.\r\n● Pode ser usado a qualquer hora do dia para aumentar a ingestão de proteína.\r\n\r\nIndicação de Uso: Misture uma porção (aproximadamente 30g) em 200-250ml de água, leite ou sua bebida preferida. Consumir uma ou duas vezes ao dia, conforme necessário.', 'Proteínas', 237, 90.25, 0),
(8, 'Whey Hydro Isolate 2kg', 'Whey Hydro Isolate é uma proteína de soro de leite isolada e hidrolisada, oferecendo a forma mais pura e de mais rápida absorção de proteína. É ideal para atletas de alta performance que precisam de uma proteína de absorção extremamente rápida.\r\n\r\nBenefícios:\r\n● Proteína de absorção ultra-rápida.\r\n● Baixo teor de lactose e gorduras.\r\n● Ideal para consumo imediato após o treino.\r\n● Auxilia na recuperação muscular e na síntese proteica.\r\n● Altamente biodisponível. \r\n\r\nIndicação de Uso: Misture uma porção (aproximadamente 30g) em 200ml de água fria. Consumir imediatamente após o treino para melhores resultados.', 'Proteínas', 890, 90.99, 1),
(9, 'Creatina Mono-Hidratada 90caps', 'A Creatina Mono-Hidratada é um suplemento de creatina altamente eficaz e amplamente utilizado. É composta por creatina\r\nmonohidratada pura, um dos tipos mais estudados e comprovados de creatina para melhorar o desempenho atlético e aumentar a massa muscular.\r\n\r\nBenefícios:\r\n● Aumento de Força e Potência: Melhora o desempenho em exercícios de alta intensidade e curta duração, como levantamento de peso e sprints.\r\n● Aumento da Massa Muscular: Estimula a síntese proteica,\r\ncontribuindo para o crescimento muscular.\r\n● Recuperação Muscular: Ajuda na recuperação pós-treino, reduzindo a fadiga e os danos musculares.\r\n● Hidratação Celular: A creatina atrai água para as células musculares, promovendo uma melhor hidratação e um ambiente anabólico.\r\n● Fácil de Usar: Solúvel em água e sem sabor, pode ser facilmente misturada em shakes ou outras bebidas.\r\n\r\nIndicação de Uso: Misture uma porção (aproximadamente 5g) em 200-250ml de água ou sua bebida preferida. Pode ser consumida antes ou após o treino. Durante a fase de carregamento (opcional), consumir 20g por dia, divididos em 4 doses, por 5-7 dias.', 'Outros suplementos', 660, 29.99, 0),
(10, 'Creatina Mono-Hidratada 350g', 'A Creatina Mono-Hidratada é um suplemento de creatina altamente eficaz e amplamente utilizado. É composta por creatina\r\nmonohidratada pura, um dos tipos mais estudados e comprovados de creatina para melhorar o desempenho atlético e aumentar a massa muscular.\r\n\r\nBenefícios:\r\n● Aumento de Força e Potência: Melhora o desempenho em exercícios de alta intensidade e curta duração, como levantamento de peso e sprints.\r\n● Aumento da Massa Muscular: Estimula a síntese proteica,\r\ncontribuindo para o crescimento muscular.\r\n● Recuperação Muscular: Ajuda na recuperação pós-treino, reduzindo a fadiga e os danos musculares.\r\n● Hidratação Celular: A creatina atrai água para as células musculares, promovendo uma melhor hidratação e um ambiente anabólico.\r\n● Fácil de Usar: Solúvel em água e sem sabor, pode ser facilmente misturada em shakes ou outras bebidas.\r\n\r\nIndicação de Uso: Misture uma porção (aproximadamente 5g) em 200-250ml de água ou sua bebida preferida. Pode ser consumida antes ou após o treino. Durante a fase de carregamento (opcional), consumir 20g por dia, divididos em 4 doses, por 5-7 dias.', 'Outros suplementos', 440, 39.99, 1),
(11, 'Creatina Mono-Hidratada 1kg', 'A Creatina Mono-Hidratada é um suplemento de creatina altamente eficaz e amplamente utilizado. É composta por creatina\r\nmonohidratada pura, um dos tipos mais estudados e comprovados de\r\ncreatina para melhorar o desempenho atlético e aumentar a massa muscular.\r\n\r\nBenefícios:\r\n● Aumento de Força e Potência: Melhora o desempenho em\r\nexercícios de alta intensidade e curta duração, como\r\nlevantamento de peso e sprints.\r\n● Aumento da Massa Muscular: Estimula a síntese proteica,\r\ncontribuindo para o crescimento muscular.\r\n● Recuperação Muscular: Ajuda na recuperação pós-treino,\r\nreduzindo a fadiga e os danos musculares.\r\n● Hidratação Celular: A creatina atrai água para as células musculares, promovendo uma melhor hidratação e um ambiente anabólico.\r\n● Fácil de Usar: Solúvel em água e sem sabor, pode ser facilmente misturada em shakes ou outras bebidas.\r\n\r\nIndicação de Uso: Misture uma porção (aproximadamente 5g) em 200-250ml de água ou sua bebida preferida. Pode ser consumida antes ou após o treino. Durante a fase de carregamento (opcional), consumir 20g por dia, divididos em 4 doses, por 5-7 dias.', 'Outros suplementos', 780, 69.99, 1),
(17, 'Creatina Creapure 350g', 'A Creatina Creapure é uma forma de creatina monoidratada de alta qualidade, conhecida por sua pureza e eficácia. Produzida na Alemanha, a Creapure é considerada uma das formas mais puras de\r\ncreatina disponíveis no mercado.\r\n\r\nBenefícios:\r\n● Alta Pureza e Qualidade: Fabricada usando um processo patenteado que garante a máxima pureza e ausência de impurezas e contaminantes.\r\n● Eficácia Comprovada: Melhora a força, potência e resistência muscular em exercícios de alta intensidade.\r\n● Apoio ao Crescimento Muscular: Promove a síntese proteica e o crescimento muscular.\r\n● Segurança: Rigorosamente testada para garantir que é livre de substâncias proibidas e impurezas.\r\n● Facilidade de Uso: Solúvel em água e sem sabor, pode ser facilmente adicionada a qualquer bebida.\r\n\r\nIndicação de Uso: Misture uma porção (aproximadamente 5g) em 200-250ml de água ou sua bebida preferida. Pode ser consumida antes ou após o treino. Durante a fase de carregamento (opcional), consumir 20g por dia, divididos em 4 doses, por 5-7 dias.\r\n', 'Outros suplementos', 654, 49.99, 1),
(18, 'Colagénio', 'O Colagénio é uma proteína estrutural essencial para a saúde da pele, cabelos, unhas, articulações e ossos. Suplementos de colagénio podem ajudar a melhorar a elasticidade da pele e a saúde das\r\narticulações.\r\n● Melhora a elasticidade e hidratação da pele, reduzindo rugas e linhas finas.\r\n● Ajuda a manter a integridade das cartilagens, reduzindo a dor e a\r\ninflamação nas articulações.\r\n● Promove o crescimento saudável dos cabelos e unhas.\r\n\r\nBenefícios:\r\n● Saúde da Pele:\r\n● Fortalecimento das Articulações:\r\n● Cabelos e Unhas:\r\n● Saúde Óssea: Contribui para a densidade óssea e a prevenção de doenças como osteoporose.\r\n\r\nIndicação de Uso: Misture uma porção (aproximadamente 10g) em água, sumo ou smoothie. Consumir uma vez ao dia.\r\n', 'Outros suplementos', 235, 19.99, 1),
(19, 'Pré-workout 350g', 'Aumento da energia, do foco e da performance. Contém uma combinação de ingredientes estimulantes e nutrientes que melhoram a resistência e o desempenho.\r\n\r\nBenefícios:\r\n● Aumento de Energia: Contém cafeína e outros estimulantes para aumentar os níveis de energia.\r\n● Melhora da Performance: Ingredientes como beta-alanina e creatina ajudam a melhorar a resistência e a força.\r\n● Foco e Concentração: Ajuda a aumentar o foco mental durante o treino.\r\n● Redução da Fadiga: Diminui a percepção de fadiga, permitindo treinos mais intensos e prolongados.\r\n\r\nIndicação de Uso: Misture uma porção (aproximadamente 10-15g) em 250ml de água. Consumir 20-30 minutos antes do treino.\r\n', 'Pré-treino e pós-treino', 564, 39.99, 0),
(20, 'Pós-workout 350g', 'Suplemento formulado para ser consumido após o treino, com o objetivo de ajudar na recuperação muscular e na reposição de\r\nnutrientes essenciais. Contém uma combinação de proteínas, carboidratos, aminoácidos e outros nutrientes que promovem a recuperação muscular e a reidratação.\r\n\r\nBenefícios:\r\n1. Recuperação Muscular: Fornecimento de proteínas e aminoácidos que auxiliam na reparação e no crescimento muscular após o treino.\r\n2. Reposição de Nutrientes: Carboidratos e eletrólitos ajudam a reabastecer os estoques de glicogênio e a restabelecer o\r\nequilíbrio hidroeletrolítico.\r\n3. Redução do Catabolismo: Proteínas e aminoácidos essenciais ajudam a prevenir o catabolismo muscular, especialmente após treinos intensos.\r\n4. Hidratação: Inclusão de eletrólitos para ajudar na reidratação após o exercício.\r\n\r\nIndicação de Uso: Misture uma porção (geralmente 20-30g de pó) em água ou leite logo após o treino. Consumir imediatamente para otimizar a absorção dos nutrientes.\r\n\r\nOs pós-workout são projetados para maximizar os benefícios do treino,\r\npromovendo uma recuperação mais rápida e eficiente, além de preparar o corpo para o próximo treino ou atividade física.', 'Pré-treino e pós-treino', 223, 29.99, 1),
(21, 'Glutamina 350g', 'A Glutamina é um aminoácido essencial que desempenha um papel crucial na recuperação muscular, função imunológica e saúde intestinal. Suplementar com glutamina pode ser especialmente benéfico\r\npara atletas e pessoas com altos níveis de estresse físico.\r\n\r\nBenefícios:\r\n● Recuperação Muscular: Ajuda a reduzir a dor muscular e acelerar a recuperação após exercícios intensos.\r\n● Suporte Imunológico: Fortalece o sistema imunológico, ajudando a prevenir doenças.\r\n● Saúde Intestinal: Promove a integridade da mucosa intestinal, essencial para uma boa digestão e absorção de nutrientes.\r\n● Redução da Fadiga: Pode ajudar a reduzir a fadiga e melhorar a resistência durante os treinos.\r\n\r\nIndicação de Uso: Misture uma porção (aproximadamente 5g) em 200ml de água ou sua bebida preferida. Consumir uma a duas vezes ao dia, de preferência após o treino e antes de dormir.\r\n', 'Aminoácidos', 678, 26.99, 0),
(22, 'BCCA 350g', 'BCAA é uma sigla para \"Branched-Chain Amino Acids\" ou Aminoácidos de Cadeia Ramificada em português. São compostos por três aminoácidos essenciais: leucina, isoleucina e valina, que são fundamentais para a síntese de proteínas musculares e recuperação muscular pós-exercício.\r\n\r\nBenefícios:\r\n1. Estímulo à Síntese Proteica: Os BCAAs, especialmente a leucina, estimulam a síntese de proteínas musculares, promovendo o crescimento e a reparação muscular.\r\n2. Redução da Fadiga: Podem diminuir a percepção de fadiga durante exercícios prolongados, ajudando a manter o desempenho físico.\r\n3. Preservação Muscular: Auxiliam na preservação da massa muscular magra, especialmente em períodos de déficit calórico ou durante treinos intensos.\r\n4. Recuperação Muscular: Contribuem para a recuperação muscular após o exercício, reduzindo o tempo necessário para a reparação de danos musculares.\r\n\r\nIndicação de Uso: A dosagem recomendada varia, mas é comum consumir de 5 a 10 gramas antes, durante ou após o treino, misturados em água ou outra bebida.', 'Aminoácidos', 578, 19.99, 1),
(23, 'Amino complex 200caps', 'Amino Complex combina uma variedade de aminoácidos essenciais e não essenciais em uma única fórmula. Esses aminoácidos\r\nsão fundamentais para várias funções do corpo, incluindo a síntese de\r\nproteínas, reparação muscular, e manutenção da saúde geral.\r\n\r\nBenefícios:\r\n1. Síntese de Proteínas: Fornece aminoácidos necessários para a síntese de proteínas musculares, essencial para o crescimento e reparação muscular.\r\n2. Suporte à Saúde Geral: Alguns aminoácidos têm papéis importantes além da construção muscular, como na saúde do\r\nsistema imunológico, pele, cabelo e unhas.\r\n3. Recuperação Muscular: Ajuda na recuperação muscular após o exercício, reduzindo o tempo de recuperação e minimizando o catabolismo muscular.\r\n4. Energia e Desempenho: Alguns aminoácidos podem ser convertidos em energia durante o exercício, ajudando a melhorar o desempenho físico e mental.\r\n\r\nIndicação de Uso: Tomar 1 cápsula por dia. Pode ser consumido antes, durante ou após o treino, dependendo dos objetivos individuais e das necessidades nutricionais.\r\n', 'Aminoácidos', 999, 40.99, 0),
(24, 'Beta Alanine 700g', 'Beta-alanina é um aminoácido não essencial que se combina com a histidina para formar carnosina nos músculos. A carnosina atua como um tampão para os íons de hidrogênio que se acumulam durante o exercício intenso, ajudando a reduzir a fadiga muscular e melhorar o\r\ndesempenho físico.\r\n\r\nBenefícios:\r\n1. Aumento da Resistência Muscular: A carnosina ajuda a retardar a fadiga muscular ao reduzir a acumulação de ácido lático nos músculos, permitindo treinos mais intensos e prolongados.\r\n2. Melhora do Desempenho Anaeróbico: Beneficia atividades de alta intensidade e curta duração, como levantamento de peso e sprints, ao melhorar a capacidade de buffer de ácido lático.\r\n3. Recuperação Muscular: Contribui para a recuperação muscular pós-exercício, ajudando na reparação de danos musculares\r\ninduzidos pelo treino.\r\n4. Antioxidante: Possui propriedades antioxidantes que ajudam a neutralizar os radicais livres produzidos durante o exercício intenso, promovendo a saúde celular.\r\n\r\nIndicação de Uso: A dose típica varia de 2 a 5 gramas por dia, divididos em doses menores ao longo do dia para maximizar a absorção e os benefícios durante o treino.\r\n', 'Aminoácidos', 499, 32.99, 1),
(25, 'CLA 200caps', 'O CLA (Ácido Linoleico Conjugado) é um ácido graxo natural encontrado principalmente em produtos de origem animal e em alguns óleos vegetais. É conhecido por seus potenciais benefícios na redução da gordura corporal e no suporte à composição corporal saudável.\r\n\r\nBenefícios:\r\n1. Redução da gordura corporal: Estudos sugerem que o CLA pode ajudar a reduzir a gordura corporal, especialmente na região\r\nabdominal, ao mesmo tempo que preserva a massa muscular magra.\r\n2. Suporte à composição corporal: Ajuda a melhorar a proporção de massa muscular para gordura corporal, o que pode ser benéfico para a saúde metabólica e o desempenho físico.\r\n3. Potencial anti-inflamatório: Algumas pesquisas indicam que o CLA pode ter efeitos anti-inflamatórios, beneficiando a saúde geral e reduzindo o risco de doenças crônicas.\r\n4. Antioxidante: Possui propriedades antioxidantes que ajudam a neutralizar os radicais livres, contribuindo para a saúde celular e reduzindo o estresse oxidativo.\r\n\r\nIndicação de Uso: A dose diária recomendada é 1 cápsula por dia, durante a refeição.\r\n', 'Emagrecimento', 321, 50.99, 1),
(26, 'Fat burner 100caps', 'Os fat burners, ou queimadores de gordura, são suplementos projetados para aumentar o metabolismo, aumentar a\r\nqueima de gordura e melhorar a perda de peso. Eles geralmente contêm uma combinação de ingredientes termogênicos, estimulantes e outros compostos que podem promover a oxidação de gorduras.\r\n\r\nBenefícios:\r\n1. Aumento do metabolismo: Estimula o metabolismo basal, aumentando a quantidade de calorias queimadas em repouso.\r\n2. Supressão do apetite: Alguns ingredientes podem ajudar a reduzir\r\no apetite, facilitando o controle de calorias e a perda de peso.\r\n3. Aumento da energia: Contêm estimulantes como cafeína que podem aumentar os níveis de energia e melhorar o desempenho durante o exercício.\r\n4. Oxidação de gordura: Promovem a oxidação de ácidos graxos, utilizando a gordura armazenada como fonte de energia.\r\n\r\nIndicação de Uso: Dose diária recomendada é de 1 a 2 cápsulas. Geralmente são tomados antes das refeições ou antes do exercício físico.\r\n', 'Emagrecimento', 555, 49.99, 1),
(27, 'L-carnitina 90caps', 'A L-carnitina é um aminoácido composto naturalmente pelo organismo a partir da lisina e da metionina. É conhecida por\r\ndesempenhar um papel fundamental no metabolismo energético, transportando ácidos graxos para as mitocôndrias onde são convertidos em energia.\r\n\r\nBenefícios:\r\n1. Metabolismo de Gorduras: Ajuda a transportar ácidos graxos para\r\nas mitocôndrias, onde são oxidados para produção de energia, promovendo a queima de gordura.\r\n2. Apoio à Performance Atlética: Pode melhorar a resistência e reduzir a fadiga muscular, especialmente durante atividades aeróbicas de longa duração.\r\n3. Recuperação Muscular: Contribui para a recuperação muscular após o exercício, reduzindo o acúmulo de metabólitos prejudiciais.\r\n4. Saúde Cardíaca: Estudos sugerem que a L-carnitina pode beneficiar a saúde cardíaca ao melhorar o metabolismo lipídico e reduzir os níveis de triglicerídeos.\r\n\r\nIndicação de Uso: A dose diária recomendada é de 1 cápsula, preferencialmente antes do exercício físico para maximizar os benefícios.\r\n', 'Emagrecimento', 320, 29.99, 1),
(28, 'Gominolas multi vitaminas-minerais 30 gemmies', 'Gominolas multivitaminas-minerais são suplementos em forma de gomas mastigáveis que combinam uma variedade de vitaminas e minerais essenciais em uma forma divertida e fácil de consumir. São populares entre aqueles que preferem evitar comprimidos ou cápsulas tradicionais.\r\n\r\nBenefícios:\r\n1. Suporte Nutricional Completo: Fornecem uma ampla gama de vitaminas e minerais essenciais para promover a saúde geral e o bem-estar.\r\n2. Facilidade de Consumo: São mastigáveis e geralmente têm um sabor agradável, facilitando a ingestão, especialmente para aqueles que têm dificuldade em engolir pílulas.\r\n3. Absorção Rápida: As gomas podem ser absorvidas mais rapidamente no organismo em comparação com formas tradicionais de suplementos.\r\n4. Adequadas para Todos: Podem ser adequadas para crianças e adultos que buscam um suplemento vitamínico-mineral diário conveniente.\r\n\r\nIndicação de Uso: Mastigue uma goma por dia, de preferência com uma refeição para melhor absorção dos nutrientes.', 'Vitaminas e minerais', 876, 28.99, 0),
(29, 'Multi vitaminas-minerais 30caps', ' Multivitaminas-minerais são suplementos que combinam uma variedade de vitaminas e minerais essenciais em uma única dose,\r\nprojetados para complementar a dieta diária e preencher lacunas nutricionais.\r\n\r\nBenefícios:\r\n1. Saúde Geral: Fornecem uma ampla gama de nutrientes que apoiam a função geral do organismo, incluindo o sistema imunológico, a saúde óssea, a pele, entre outros.\r\n2. Prevenção de Deficiências: Ajudam a prevenir deficiências de vitaminas e minerais, especialmente em dietas restritas ou desequilibradas.\r\n3. Energia e Vitalidade: Alguns ingredientes podem ajudar a aumentar os níveis de energia e melhorar o bem-estar geral.\r\n4. Suporte Metabólico: Contribuem para o metabolismo adequado de carboidratos, proteínas e gorduras, essencial para a produção de energia.\r\n\r\nIndicação de Uso: Tome uma cápsula por dia, de preferência com alimentos para melhor absorção e eficácia dos nutrientes.\r\n', 'Vitaminas e minerais', 465, 19.99, 0),
(30, 'Multi vitaminas-minerais 60caps', ' Multivitaminas-minerais são suplementos que combinam uma variedade de vitaminas e minerais essenciais em uma única dose,\r\nprojetados para complementar a dieta diária e preencher lacunas nutricionais.\r\n\r\nBenefícios:\r\n1. Saúde Geral: Fornecem uma ampla gama de nutrientes que apoiam a função geral do organismo, incluindo o sistema imunológico, a saúde óssea, a pele, entre outros.\r\n2. Prevenção de Deficiências: Ajudam a prevenir deficiências de vitaminas e minerais, especialmente em dietas restritas ou desequilibradas.\r\n3. Energia e Vitalidade: Alguns ingredientes podem ajudar a aumentar os níveis de energia e melhorar o bem-estar geral.\r\n4. Suporte Metabólico: Contribuem para o metabolismo adequado de carboidratos, proteínas e gorduras, essencial para a produção de energia.\r\n\r\nIndicação de Uso: Tome uma cápsula por dia, de preferência com alimentos para melhor absorção e eficácia dos nutrientes.\r\n', 'Vitaminas e minerais', 234, 25.99, 1),
(31, 'Multi vitaminas-minerais 100caps', ' Multivitaminas-minerais são suplementos que combinam uma variedade de vitaminas e minerais essenciais em uma única dose,\r\nprojetados para complementar a dieta diária e preencher lacunas nutricionais.\r\n\r\nBenefícios:\r\n1. Saúde Geral: Fornecem uma ampla gama de nutrientes que apoiam a função geral do organismo, incluindo o sistema imunológico, a saúde óssea, a pele, entre outros.\r\n2. Prevenção de Deficiências: Ajudam a prevenir deficiências de vitaminas e minerais, especialmente em dietas restritas ou desequilibradas.\r\n3. Energia e Vitalidade: Alguns ingredientes podem ajudar a aumentar os níveis de energia e melhorar o bem-estar geral.\r\n4. Suporte Metabólico: Contribuem para o metabolismo adequado de carboidratos, proteínas e gorduras, essencial para a produção de energia.\r\n\r\nIndicação de Uso: Tome uma cápsula por dia, de preferência com alimentos para melhor absorção e eficácia dos nutrientes.\r\n', 'Vitaminas e minerais', 555, 39.99, 1),
(32, 'Vitaminas-minerais Prime 32caps', 'Vitaminas-Minerais Prime é uma formulação específica de suplemento que combina vitaminas e minerais essenciais em concentrações equilibradas para suportar as necessidades nutricionais diárias.\r\n\r\nBenefícios:\r\n1. Nutrição Abrangente: Fornece uma gama completa de vitaminas e minerais para apoiar funções corporais essenciais, desde a saúde do sistema imunológico até o suporte antioxidante.\r\n2. Formulação Específica: Pode incluir ingredientes adicionais específicos para necessidades nutricionais particulares, como suporte para a saúde óssea, cardíaca ou cerebral.\r\n3. Qualidade e Eficácia: Produtos da linha Prime geralmente são formulados com ingredientes de alta qualidade e testados para garantir eficácia e segurança.\r\n4. Conveniência: Disponível em diferentes formas de dosagem, como comprimidos, cápsulas ou gomas, para atender às preferências individuais.\r\n\r\nIndicação de Uso: Tome uma cápsula por dia, de preferência durante uma refeição para facilitar a absorção dos nutrientes essenciais.', 'Vitaminas e minerais', 979, 29.99, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores`
--

CREATE TABLE `utilizadores` (
  `utilizadorID` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `apelido` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `dataNascimento` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `funcao` enum('utilizador','administrador') NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `emailConfirmado` tinyint(1) NOT NULL DEFAULT 0,
  `token` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `utilizadores`
--

INSERT INTO `utilizadores` (`utilizadorID`, `nome`, `apelido`, `senha`, `dataNascimento`, `email`, `funcao`, `imagem`, `emailConfirmado`, `token`) VALUES
(1, 'root', 'administrador', '$2y$10$Rcw2ZeLPJGgtV.rpluq96uG7HhA7QzToOGMcxa42bb48T8JJ0C5Y6', '2003-08-22', 'primesupps.pt@gmail.com', 'administrador', '../imagens/outras/admin-svgrepo-com.svg', 1, NULL),
(33, 'Miguel', 'Vieira', '$2y$10$bDtU0qTsdaDbq1IbzSMXj.kfgt3yJkDCzuD3lAhoh.CnjL0.Ozvpe', '2003-08-22', 'vieiramiguel813@gmail.com', 'utilizador', '../uploads/imagensteste de perfil comportamental.webp', 1, NULL),
(38, 'Anaísa', 'Cunha', '$2y$10$2gpcpxHk7zqrukNpOXjL4OUD/68vvYb6DXci50pUocc3.eVRjUy3O', '2001-01-12', 'anaisacunha36@gmail.com', 'utilizador', '../uploads/imagensImagem WhatsApp 2024-09-10 às 14.23.07_01dc988d.jpg', 1, NULL),
(39, 'João', 'Silva', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '1998-09-16', 'joasilva@gmail.com', 'utilizador', NULL, 1, NULL),
(40, 'Ana', 'Pereira', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '2000-08-12', 'anapereira@gmail.com', 'utilizador', NULL, 1, NULL),
(41, 'Maria', 'Fernandes', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '2001-05-02', 'mariafernandes@gmail.com', 'utilizador', NULL, 1, NULL),
(42, 'Ricardo', 'Lima', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '2003-02-10', 'ricardolima@gmail.com', 'utilizador', NULL, 1, NULL),
(43, 'Carlos', 'Almeida', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '2004-03-20', 'carlosalmeida@gmail.com', 'utilizador', NULL, 1, NULL),
(44, 'Helena', 'Santos', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '2002-01-12', 'helenasantos@gmail.com', 'utilizador', NULL, 1, NULL),
(45, 'Ana', 'Oliveira', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '2001-12-12', 'anaoliveira@gmail.com', 'utilizador', NULL, 1, NULL),
(46, 'Luís', 'Costa', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '2003-02-21', 'luiscosta@gmail.com', 'utilizador', NULL, 1, NULL),
(47, 'Pedro', 'Santos', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '2002-02-22', 'pedrosantos@gmail.com', 'utilizador', NULL, 1, NULL),
(48, 'Fernanda', 'Ribeiro', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '2004-03-27', 'fernandaribeiro@gmail.com', 'utilizador', NULL, 1, NULL),
(49, 'Rita', 'Martins', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '2005-08-02', 'ritamartins@gmail.com', 'utilizador', NULL, 1, NULL),
(50, 'Bruno', 'Nunes', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '2004-11-11', 'brunonunes@gmail.com', 'utilizador', NULL, 1, NULL),
(51, 'Bruno', 'Costa', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '2002-09-15', 'brunocosta@gmail.com', 'utilizador', NULL, 1, NULL),
(52, 'Sofia', 'Cardoso', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '2001-05-20', 'sofiacardoso@gmail.com', 'utilizador', NULL, 1, NULL),
(53, 'Sofia', 'Lima', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '2002-12-25', 'sofialima@gmail.com', 'utilizador', NULL, 1, NULL),
(54, 'João', 'Martins', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '2005-03-12', 'joamartins@gmail.com', 'utilizador', NULL, 1, NULL),
(55, 'Lucas', 'Pereira', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '2001-01-01', 'lucaspereira@gmail.com', 'utilizador', NULL, 1, NULL),
(56, 'Patricia', 'Gomes', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '1999-08-12', 'patriciagomes@gmail.com', 'utilizador', NULL, 1, NULL),
(57, 'Marcos', 'Rocha', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '1985-04-22', 'marcosrocha@gmail.com', 'utilizador', NULL, 1, NULL),
(58, 'Carolina', 'Mendes', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '1990-10-10', 'carolinamendes@gmail.com', 'utilizador', NULL, 1, NULL),
(59, 'Daniela', 'Sousa', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '1987-05-20', 'danielasousa@gmail.com', 'utilizador', NULL, 1, NULL),
(60, 'Marcelo', 'Silva', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '1995-04-27', 'marcelosilva@gmail.com', 'utilizador', NULL, 1, NULL),
(61, 'João', 'Andrade', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '1992-06-02', 'joaoandrade@gmail.com', 'utilizador', NULL, 1, NULL),
(62, 'Laura', 'Costa', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '1996-09-18', 'lauracosta@gmail.com', 'utilizador', NULL, 1, NULL),
(63, 'Beatriz', 'Silva', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '1995-11-17', 'beatrizsilva@gmail.com', 'utilizador', NULL, 1, NULL),
(64, 'Rafael', 'Oliveira', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '1992-02-02', 'rafaeloliveira@gmail.com', 'utilizador', NULL, 1, NULL),
(65, 'Miguel', 'Ferreira', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '2001-05-29', 'miguelferreira@gmail.com', 'utilizador', NULL, 1, NULL),
(66, 'Clara', 'Moreira', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '1976-12-15', 'claramoreira@gmail.com', 'utilizador', NULL, 1, NULL),
(67, 'Camila', 'Vieira', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '1988-08-12', 'camilavieira@gmail.com', 'utilizador', NULL, 1, NULL),
(68, 'Ricardo', 'Almeida', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '1987-08-18', 'ricardoalmeida@gmail.com', 'utilizador', NULL, 1, NULL),
(69, 'Rafael', 'Neves', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '1992-01-19', 'rafaelneves@gmail.com', 'utilizador', NULL, 1, NULL),
(70, 'Inês', 'Carvalho', '$2y$10$vRbrrw0ZesjGqP2tpzaYOO1bdcTa1G0K.oBZ3I3kep/vRLNgLOuqy', '2000-04-20', 'inescarvalho@gmail.com', 'utilizador', NULL, 1, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `alteracoes_password`
--
ALTER TABLE `alteracoes_password`
  ADD PRIMARY KEY (`alteracaoID`),
  ADD KEY `utilizadorID` (`utilizadorID`);

--
-- Índices para tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`avaliacaoID`),
  ADD KEY `utilizadorID` (`utilizadorID`),
  ADD KEY `produtoID` (`produtoID`);

--
-- Índices para tabela `carrinhos`
--
ALTER TABLE `carrinhos`
  ADD PRIMARY KEY (`carrinhoID`),
  ADD KEY `utilizadorID` (`utilizadorID`);

--
-- Índices para tabela `codigo_acesso_admin`
--
ALTER TABLE `codigo_acesso_admin`
  ADD PRIMARY KEY (`codigoID`),
  ADD KEY `utilizadorID` (`utilizadorID`);

--
-- Índices para tabela `cupoes`
--
ALTER TABLE `cupoes`
  ADD PRIMARY KEY (`cupaoID`);

--
-- Índices para tabela `dados_fiscais`
--
ALTER TABLE `dados_fiscais`
  ADD PRIMARY KEY (`dadosFiscaisID`),
  ADD KEY `idx_utilizadorID` (`utilizadorID`),
  ADD KEY `idx_pais` (`pais`),
  ADD KEY `idx_cidade` (`cidade`);

--
-- Índices para tabela `documentos_legais`
--
ALTER TABLE `documentos_legais`
  ADD PRIMARY KEY (`documentoID`);

--
-- Índices para tabela `encomendas`
--
ALTER TABLE `encomendas`
  ADD PRIMARY KEY (`encomendaID`),
  ADD KEY `enderecoID` (`enderecoID`),
  ADD KEY `utilizadorID` (`utilizadorID`),
  ADD KEY `fk_cupaoID` (`cupaoID`),
  ADD KEY `fk_dados_fiscais` (`dadosFiscaisID`);

--
-- Índices para tabela `enderecos`
--
ALTER TABLE `enderecos`
  ADD PRIMARY KEY (`enderecoID`),
  ADD KEY `utilizadorID` (`utilizadorID`);

--
-- Índices para tabela `imagens_produtos`
--
ALTER TABLE `imagens_produtos`
  ADD PRIMARY KEY (`imagemID`),
  ADD KEY `produtoID` (`produtoID`);

--
-- Índices para tabela `itens_carrinho`
--
ALTER TABLE `itens_carrinho`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `produtoID` (`produtoID`),
  ADD KEY `carrinhoID` (`carrinhoID`);

--
-- Índices para tabela `itens_encomenda`
--
ALTER TABLE `itens_encomenda`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `encomendaID` (`encomendaID`),
  ADD KEY `produtoID` (`produtoID`);

--
-- Índices para tabela `mensagens_suporte`
--
ALTER TABLE `mensagens_suporte`
  ADD PRIMARY KEY (`mensagemID`),
  ADD KEY `idx_utilizadorID` (`utilizadorID`),
  ADD KEY `idx_dataEnvio` (`dataEnvio`);

--
-- Índices para tabela `metodos_pagamento`
--
ALTER TABLE `metodos_pagamento`
  ADD PRIMARY KEY (`metodoID`),
  ADD KEY `utilizadorID` (`utilizadorID`);

--
-- Índices para tabela `permissoes`
--
ALTER TABLE `permissoes`
  ADD PRIMARY KEY (`permissaoID`),
  ADD KEY `utilizadorID` (`utilizadorID`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`produtoID`);

--
-- Índices para tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`utilizadorID`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alteracoes_password`
--
ALTER TABLE `alteracoes_password`
  MODIFY `alteracaoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `avaliacaoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de tabela `carrinhos`
--
ALTER TABLE `carrinhos`
  MODIFY `carrinhoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `codigo_acesso_admin`
--
ALTER TABLE `codigo_acesso_admin`
  MODIFY `codigoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de tabela `cupoes`
--
ALTER TABLE `cupoes`
  MODIFY `cupaoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `dados_fiscais`
--
ALTER TABLE `dados_fiscais`
  MODIFY `dadosFiscaisID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `documentos_legais`
--
ALTER TABLE `documentos_legais`
  MODIFY `documentoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `encomendas`
--
ALTER TABLE `encomendas`
  MODIFY `encomendaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT de tabela `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `enderecoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `imagens_produtos`
--
ALTER TABLE `imagens_produtos`
  MODIFY `imagemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de tabela `itens_carrinho`
--
ALTER TABLE `itens_carrinho`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de tabela `itens_encomenda`
--
ALTER TABLE `itens_encomenda`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT de tabela `mensagens_suporte`
--
ALTER TABLE `mensagens_suporte`
  MODIFY `mensagemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `metodos_pagamento`
--
ALTER TABLE `metodos_pagamento`
  MODIFY `metodoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT de tabela `permissoes`
--
ALTER TABLE `permissoes`
  MODIFY `permissaoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `produtoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `utilizadorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `alteracoes_password`
--
ALTER TABLE `alteracoes_password`
  ADD CONSTRAINT `alteracoes_password_ibfk_1` FOREIGN KEY (`utilizadorID`) REFERENCES `utilizadores` (`utilizadorID`);

--
-- Limitadores para a tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD CONSTRAINT `avaliacoes_ibfk_1` FOREIGN KEY (`utilizadorID`) REFERENCES `utilizadores` (`utilizadorID`),
  ADD CONSTRAINT `avaliacoes_ibfk_2` FOREIGN KEY (`produtoID`) REFERENCES `produtos` (`produtoID`);

--
-- Limitadores para a tabela `carrinhos`
--
ALTER TABLE `carrinhos`
  ADD CONSTRAINT `carrinhos_ibfk_1` FOREIGN KEY (`utilizadorID`) REFERENCES `utilizadores` (`utilizadorID`);

--
-- Limitadores para a tabela `codigo_acesso_admin`
--
ALTER TABLE `codigo_acesso_admin`
  ADD CONSTRAINT `codigo_acesso_admin_ibfk_1` FOREIGN KEY (`utilizadorID`) REFERENCES `utilizadores` (`utilizadorID`);

--
-- Limitadores para a tabela `dados_fiscais`
--
ALTER TABLE `dados_fiscais`
  ADD CONSTRAINT `dados_fiscais_ibfk_1` FOREIGN KEY (`utilizadorID`) REFERENCES `utilizadores` (`utilizadorID`);

--
-- Limitadores para a tabela `encomendas`
--
ALTER TABLE `encomendas`
  ADD CONSTRAINT `encomendas_ibfk_1` FOREIGN KEY (`enderecoID`) REFERENCES `enderecos` (`enderecoID`),
  ADD CONSTRAINT `encomendas_ibfk_2` FOREIGN KEY (`utilizadorID`) REFERENCES `utilizadores` (`utilizadorID`),
  ADD CONSTRAINT `fk_cupaoID` FOREIGN KEY (`cupaoID`) REFERENCES `cupoes` (`cupaoID`),
  ADD CONSTRAINT `fk_dados_fiscais` FOREIGN KEY (`dadosFiscaisID`) REFERENCES `dados_fiscais` (`dadosFiscaisID`);

--
-- Limitadores para a tabela `enderecos`
--
ALTER TABLE `enderecos`
  ADD CONSTRAINT `enderecos_ibfk_1` FOREIGN KEY (`utilizadorID`) REFERENCES `utilizadores` (`utilizadorID`);

--
-- Limitadores para a tabela `imagens_produtos`
--
ALTER TABLE `imagens_produtos`
  ADD CONSTRAINT `imagens_produtos_ibfk_1` FOREIGN KEY (`produtoID`) REFERENCES `produtos` (`produtoID`);

--
-- Limitadores para a tabela `itens_carrinho`
--
ALTER TABLE `itens_carrinho`
  ADD CONSTRAINT `itens_carrinho_ibfk_1` FOREIGN KEY (`produtoID`) REFERENCES `produtos` (`produtoID`),
  ADD CONSTRAINT `itens_carrinho_ibfk_2` FOREIGN KEY (`carrinhoID`) REFERENCES `carrinhos` (`carrinhoID`);

--
-- Limitadores para a tabela `itens_encomenda`
--
ALTER TABLE `itens_encomenda`
  ADD CONSTRAINT `itens_encomenda_ibfk_1` FOREIGN KEY (`encomendaID`) REFERENCES `encomendas` (`encomendaID`),
  ADD CONSTRAINT `itens_encomenda_ibfk_2` FOREIGN KEY (`produtoID`) REFERENCES `produtos` (`produtoID`);

--
-- Limitadores para a tabela `mensagens_suporte`
--
ALTER TABLE `mensagens_suporte`
  ADD CONSTRAINT `mensagens_suporte_ibfk_1` FOREIGN KEY (`utilizadorID`) REFERENCES `utilizadores` (`utilizadorID`);

--
-- Limitadores para a tabela `metodos_pagamento`
--
ALTER TABLE `metodos_pagamento`
  ADD CONSTRAINT `metodos_pagamento_ibfk_1` FOREIGN KEY (`utilizadorID`) REFERENCES `utilizadores` (`utilizadorID`);

--
-- Limitadores para a tabela `permissoes`
--
ALTER TABLE `permissoes`
  ADD CONSTRAINT `permissoes_ibfk_1` FOREIGN KEY (`utilizadorID`) REFERENCES `utilizadores` (`utilizadorID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
