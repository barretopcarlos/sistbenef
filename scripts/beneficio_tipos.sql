-- --------------------------------------------------------
-- Servidor:                     10.120.100.14
-- Versão do servidor:           5.1.61 - Source distribution
-- OS do Servidor:               redhat-linux-gnu
-- HeidiSQL Versão:              12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Copiando estrutura para tabela beneficios_dev.beneficio_tipos
DROP TABLE IF EXISTS `beneficio_tipos`;
CREATE TABLE IF NOT EXISTS `beneficio_tipos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `beneficio` varchar(50) NOT NULL,
  `criado_por` varchar(20) NOT NULL,
  `criado_em` datetime NOT NULL,
  `dia_limite` int(11) NOT NULL COMMENT 'dia limite para entrega do benefÃ­cio',
  `reembolso` varchar(3) NOT NULL DEFAULT '' COMMENT 'Identifica se o beneficio Ã© reembolsÃ¡vel ou nÃ£o',
  `gasto_teto` varchar(3) NOT NULL DEFAULT '' COMMENT 'Identifica se o beneficio possui teto de gasto ou nÃ£o',
  `tipo_beneficio` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ukBeneficio` (`beneficio`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;