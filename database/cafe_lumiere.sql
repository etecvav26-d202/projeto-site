-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 21/09/2026 às 01:06
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
-- Erro ao ler a estrutura para a tabela cafe_lumiere.eventos: #1932 - Table &#039;cafe_lumiere.eventos&#039; doesn&#039;t exist in engine
-- Erro ao ler dados para tabela cafe_lumiere.eventos: #1064 - Você tem um erro de sintaxe no seu SQL próximo a &#039;FROM `cafe_lumiere`.`eventos`&#039; na linha 1

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
(3, 'Orgulho e Preconceito', 'Jane Austen', 'Romance', 'Um clássico que acompanha Elizabeth Bennet e suas relações.', 42.90, 'compra', NULL, 0, 1, '2026-09-20 21:27:37');

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
(1, 'Espresso Lumière', 'cafe', 'Espresso intenso e aromático, preparado na hora.', 8.90, 'assets/img/espresso.jpg', 1, 1, '2026-09-20 21:15:51'),
(2, 'Cappuccino Clássico', 'cafe', 'Espresso, leite vaporizado e espuma cremosa.', 13.90, 'assets/img/cappuccino.jpg', 1, 1, '2026-09-20 21:15:51'),
(3, 'Cold Brew', 'bebida', 'Café extraído a frio, leve e refrescante.', 14.90, 'assets/img/cold-brew.jpg', 0, 1, '2026-09-20 21:15:51'),
(4, 'Chocolate da Casa', 'bebida', 'Chocolate quente cremoso com toque de baunilha.', 15.90, 'assets/img/chocolate.jpg', 0, 1, '2026-09-20 21:15:51'),
(5, 'Cheesecake de Frutas', 'sobremesa', 'Cheesecake artesanal com cobertura de frutas vermelhas.', 18.90, 'assets/img/cheesecake.jpg', 1, 1, '2026-09-20 21:15:51'),
(6, 'Cookie Lumière', 'sobremesa', 'Cookie artesanal com chocolate meio amargo.', 9.90, 'assets/img/cookie.jpg', 0, 1, '2026-09-20 21:15:51'),
(7, 'Café + Livro', 'combo', 'Um café especial acompanhado de desconto em um livro selecionado.', 29.90, 'assets/img/combo.jpg', 1, 1, '2026-09-20 21:15:51'),
(8, 'Brunch Lumière', 'combo', 'Seleção da casa para uma manhã tranquila.', 39.90, 'assets/img/brunch.jpg', 0, 1, '2026-09-20 21:15:51'),
(9, 'Café Lumière', '', 'Café especial da casa preparado com grãos selecionados.', 9.90, 'assets/img/cafe-lumiere.jpg', 1, 1, '2026-09-20 22:08:31'),
(10, 'Cappuccino Cremoso', '', 'Cappuccino preparado com café espresso, leite vaporizado e espuma cremosa.', 14.90, 'assets/img/cappuccino.jpg', 1, 1, '2026-09-20 22:08:31'),
(11, 'Chocolate Quente', '', 'Chocolate quente cremoso, perfeito para acompanhar uma boa leitura.', 13.90, 'assets/img/chocolate-quente.jpg', 0, 1, '2026-09-20 22:08:31'),
(12, 'Cold Brew', '', 'Café extraído a frio, servido gelado e refrescante.', 15.90, 'assets/img/cold-brew.jpg', 0, 1, '2026-09-20 22:08:31'),
(13, 'Cheesecake de Frutas Vermelhas', '', 'Cheesecake artesanal com cobertura de frutas vermelhas.', 18.90, 'assets/img/cheesecake.jpg', 1, 1, '2026-09-20 22:08:31'),
(14, 'Brownie com Sorvete', '', 'Brownie artesanal servido com uma bola de sorvete.', 19.90, 'assets/img/brownie.jpg', 0, 1, '2026-09-20 22:08:31'),
(15, 'Combo Leitura', '', 'Café especial acompanhado de uma sobremesa da casa.', 24.90, 'assets/img/combo-leitura.jpg', 1, 1, '2026-09-20 22:08:31'),
(16, 'Combo Lumière', '', 'Cappuccino, brownie e uma bebida especial da casa.', 29.90, 'assets/img/combo-lumiere.jpg', 0, 1, '2026-09-20 22:08:31');

-- --------------------------------------------------------

--
-- Estrutura para tabela `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
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
-- Índices para tabelas despejadas
--

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
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reserva_usuario` (`usuario_id`);

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
-- AUTO_INCREMENT de tabela `livros`
--
ALTER TABLE `livros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `mensagens`
--
ALTER TABLE `mensagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `fk_reserva_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
