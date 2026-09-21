-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 21/09/2026 às 04:57
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `cafe_lumiere`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cardapio`
--
-- Erro ao ler a estrutura para a tabela cafe_lumiere.cardapio: #1932 - Table &#039;cafe_lumiere.cardapio&#039; doesn&#039;t exist in engine
-- Erro ao ler dados para tabela cafe_lumiere.cardapio: #1064 - Você tem um erro de sintaxe no seu SQL próximo a &#039;FROM `cafe_lumiere`.`cardapio`&#039; na linha 1

-- --------------------------------------------------------

--
-- Estrutura para tabela `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `descricao` text NOT NULL,
  `data_evento` date NOT NULL,
  `horario` time NOT NULL,
  `local_evento` varchar(200) NOT NULL,
  `vagas` int(11) DEFAULT 0,
  `preco` decimal(10,2) DEFAULT 0.00,
  `imagem` varchar(255) DEFAULT NULL,
  `destaque` tinyint(1) DEFAULT 0,
  `ativo` tinyint(1) DEFAULT 1,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `eventos`
--

INSERT INTO `eventos` (`id`, `titulo`, `descricao`, `data_evento`, `horario`, `local_evento`, `vagas`, `preco`, `imagem`, `destaque`, `ativo`, `criado_em`) VALUES
(1, 'Clube do Livro: Realismo Brasileiro', 'Um encontro para conversar sobre grandes obras do Realismo brasileiro e compartilhar diferentes interpretações.', '2026-10-10', '15:00:00', 'Salão Literário', 25, 0.00, 'assets/img/evento-realismo.jpg', 1, 1, '2026-09-20 23:47:33'),
(2, 'Café & Poesia', 'Uma tarde especial com café, leitura de poemas e espaço para conversar sobre literatura.', '2026-10-17', '16:00:00', 'Salão Principal', 30, 15.00, 'assets/img/cafe-poesia.jpg', 1, 1, '2026-09-20 23:47:33'),
(3, 'Noite de Autores Brasileiros', 'Encontro dedicado à literatura brasileira, com leituras e apresentação de autores importantes.', '2026-10-24', '19:00:00', 'Espaço Lumière', 40, 20.00, 'assets/img/autores-brasileiros.jpg', 0, 1, '2026-09-20 23:47:33'),
(4, 'Oficina de Escrita Criativa', 'Uma oficina para desenvolver ideias, personagens e pequenas histórias.', '2026-11-07', '14:00:00', 'Sala de Leitura', 20, 25.00, 'assets/img/escrita-criativa.jpg', 0, 1, '2026-09-20 23:47:33'),
(5, 'Sarau Lumière', 'Uma noite de literatura, música e apresentações em um ambiente inspirado nos cafés literários.', '2026-11-14', '19:30:00', 'Salão Principal', 50, 10.00, 'assets/img/sarau.jpg', 1, 1, '2026-09-20 23:47:33');

-- --------------------------------------------------------

--
-- Estrutura para tabela `livros`
--

CREATE TABLE `livros` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `autor` varchar(150) NOT NULL,
  `genero` varchar(100) NOT NULL,
  `sinopse` text NOT NULL,
  `preco` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tipo` enum('compra','aluguel') DEFAULT 'compra',
  `imagem` varchar(255) DEFAULT NULL,
  `destaque` tinyint(1) DEFAULT 0,
  `ativo` tinyint(1) DEFAULT 1,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `livros`
--

INSERT INTO `livros` (`id`, `titulo`, `autor`, `genero`, `sinopse`, `preco`, `tipo`, `imagem`, `destaque`, `ativo`, `criado_em`) VALUES
(1, 'O Pequeno Príncipe', 'Antoine de Saint-Exupéry', 'Literatura', 'Uma história sobre amizade, afeto e diferentes formas de enxergar o mundo.', 39.90, 'compra', NULL, 0, 1, '2026-09-20 21:27:37'),
(2, 'Dom Casmurro', 'Machado de Assis', 'Romance', 'Clássico da literatura brasileira narrado por Bentinho.', 34.90, 'compra', NULL, 0, 1, '2026-09-20 21:27:37'),
(4, 'O Alienista', 'Machado de Assis', 'Realismo', 'Uma obra que apresenta uma reflexão sobre a ciência e os limites da razão.', 28.90, '', '', 0, 1, '2026-09-20 23:24:59');

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensagens`
--

CREATE TABLE `mensagens` (
  `id` int(11) NOT NULL,
  `nome` varchar(120) NOT NULL,
  `email` varchar(150) NOT NULL,
  `assunto` varchar(180) DEFAULT NULL,
  `mensagem` text NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pendente','confirmado','cancelado') DEFAULT 'pendente',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `total`, `status`, `criado_em`) VALUES
(1, 1, 19.90, 'confirmado', '2026-09-21 00:51:15');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedido_itens`
--

CREATE TABLE `pedido_itens` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 1,
  `preco` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `pedido_itens`
--

INSERT INTO `pedido_itens` (`id`, `pedido_id`, `produto_id`, `quantidade`, `preco`) VALUES
(1, 1, 14, 1, 19.90);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(120) NOT NULL,
  `categoria` enum('cafe','bebida','sobremesa','combo') NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `imagem` varchar(255) DEFAULT 'assets/img/produto.jpg',
  `destaque` tinyint(1) DEFAULT 0,
  `ativo` tinyint(1) DEFAULT 1,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `categoria`, `descricao`, `preco`, `imagem`, `destaque`, `ativo`, `criado_em`) VALUES
(1, 'Espresso Lumière', '', 'Espresso intenso e aromático, preparado na hora.', 8.90, 'imagens/produtos/produto_6ab09a86d08590.73635974.jpg', 1, 1, '2026-09-20 21:15:51'),
(2, 'Cappuccino Clássico', '', 'Espresso, leite vaporizado e espuma cremosa.', 13.90, 'imagens/produtos/produto_6ab09a7f54cdb4.39709488.jpg', 1, 1, '2026-09-20 21:15:51'),
(3, 'Cold Brew', '', 'Café extraído a frio, leve e refrescante.', 14.90, 'imagens/produtos/produto_6ab09a7760cd03.25874014.jpg', 0, 1, '2026-09-20 21:15:51'),
(4, 'Chocolate da Casa', '', 'Chocolate quente cremoso com toque de baunilha.', 15.90, 'imagens/produtos/produto_6ab09a704d7511.20429040.jpg', 0, 1, '2026-09-20 21:15:51'),
(6, 'Cookie Lumière', '', 'Cookie artesanal com chocolate meio amargo.', 9.90, 'imagens/produtos/produto_6ab09a35831982.53173074.jpg', 0, 1, '2026-09-20 21:15:51'),
(7, 'Café + Livro', '', 'Um café especial acompanhado de desconto em um livro selecionado.', 29.90, 'imagens/produtos/produto_6ab09a2935e5d4.75732731.jpg', 1, 1, '2026-09-20 21:15:51'),
(8, 'Brunch Lumière', '', 'Seleção da casa para uma manhã tranquila.', 39.90, 'imagens/produtos/produto_6ab099fcae25f9.77742511.jpg', 0, 1, '2026-09-20 21:15:51'),
(9, 'Café Lumière', '', 'Café especial da casa preparado com grãos selecionados.', 9.90, 'imagens/produtos/produto_6ab099f0a86dc0.88005234.jpg', 1, 1, '2026-09-20 22:08:31'),
(10, 'Cappuccino Cremoso', '', 'Cappuccino preparado com café espresso, leite vaporizado e espuma cremosa.', 14.90, 'imagens/produtos/produto_6ab099e972e1c9.59453531.jpg', 1, 1, '2026-09-20 22:08:31'),
(11, 'Chocolate Quente', '', 'Chocolate quente cremoso, perfeito para acompanhar uma boa leitura.', 13.90, 'imagens/produtos/produto_6ab099da7d40c4.79678238.jpg', 0, 1, '2026-09-20 22:08:31'),
(13, 'Cheesecake de Frutas Vermelhas', '', 'Cheesecake artesanal com cobertura de frutas vermelhas.', 18.90, 'imagens/produtos/produto_6ab099c782bd82.95634323.jpg', 1, 1, '2026-09-20 22:08:31'),
(14, 'Brownie com Sorvete', '', 'Brownie artesanal servido com uma bola de sorvete.', 19.90, 'imagens/produtos/produto_6ab099bd8ac807.01706488.jpg', 0, 1, '2026-09-20 22:08:31'),
(15, 'Combo Leitura', '', 'Café especial acompanhado de uma sobremesa da casa.', 24.90, 'imagens/produtos/produto_6ab099b4943377.84184012.jpg', 1, 1, '2026-09-20 22:08:31'),
(16, 'Combo Lumière', '', 'Cappuccino, brownie e uma bebida especial da casa.', 29.90, 'imagens/produtos/produto_6ab097e6458bf4.63279641.jpg', 0, 1, '2026-09-20 22:08:31');

-- --------------------------------------------------------

--
-- Estrutura para tabela `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `evento_id` int(11) NOT NULL,
  `data_reserva` date NOT NULL,
  `hora_reserva` time NOT NULL,
  `pessoas` int(11) NOT NULL,
  `observacoes` text DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pendente','confirmada','cancelada') DEFAULT 'pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(120) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `criado_em`) VALUES
(1, 'Infonet', 'infonetdavav@gmail.com', '$2y$10$OKw6C6sf0PS2cztEhy1EY.vj99.35oOmFDjFTCMyq58LKUoCahfvK', '2026-09-21 00:40:05');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `livros`
--
ALTER TABLE `livros`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `mensagens`
--
ALTER TABLE `mensagens`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `pedido_itens`
--
ALTER TABLE `pedido_itens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `produto_id` (`produto_id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reserva_usuario` (`usuario_id`),
  ADD KEY `fk_reservas_evento` (`evento_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `livros`
--
ALTER TABLE `livros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `mensagens`
--
ALTER TABLE `mensagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `pedido_itens`
--
ALTER TABLE `pedido_itens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `pedido_itens`
--
ALTER TABLE `pedido_itens`
  ADD CONSTRAINT `pedido_itens_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedido_itens_ibfk_2` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `fk_reserva_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reservas_evento` FOREIGN KEY (`evento_id`) REFERENCES `eventos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
