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

-- Copiando estrutura para tabela beneficios_dev.lancamento_contratual
DROP TABLE IF EXISTS `lancamento_contratual`;
CREATE TABLE IF NOT EXISTS `lancamento_contratual` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `colaborador` varchar(11) NOT NULL COMMENT 'cpf do colaborador',
  `id_contrato` int(11) NOT NULL COMMENT 'ID da instituicao de ensino',
  `meses` int(11) NOT NULL COMMENT 'meses de vigencia do contrato',
  `id_usuario_cadastro` varchar(30) DEFAULT NULL,
  `data_cadastro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `total` decimal(8,2) unsigned NOT NULL COMMENT 'valor total do contrato',
  `dependente` varchar(20) DEFAULT NULL COMMENT 'cpf do dependente',
  `nome_dependente` varchar(100) DEFAULT NULL,
  `identificacao_contrato` varchar(20) DEFAULT NULL,
  `inicio_vigencia` date NOT NULL,
  `fim_vigencia` date DEFAULT NULL,
  `arquivo` varchar(100) DEFAULT NULL,
  `situacao` varchar(10) DEFAULT 'ABERTO',
  `justificativa` varchar(100) DEFAULT NULL,
  `beneficio_tipos_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `ukLancamentoEduacao` (`dependente`,`identificacao_contrato`,`inicio_vigencia`),
  KEY `beneficio_tipos_id` (`beneficio_tipos_id`),
  CONSTRAINT `FK_lancamento_contratual_beneficio_tipos` FOREIGN KEY (`beneficio_tipos_id`) REFERENCES `beneficio_tipos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Exportação de dados foi desmarcado.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
