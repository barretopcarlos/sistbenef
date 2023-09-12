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

-- Copiando estrutura para tabela beneficios_dev.protocolo
CREATE TABLE IF NOT EXISTS `protocolo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_tipo_beneficio` int(3) unsigned NOT NULL,
  `protocolo` varchar(50) NOT NULL,
  `id_usuario` varchar(30) NOT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `data_criacao` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_protocolo_beneficio_tipos` (`id_tipo_beneficio`) USING BTREE,
  CONSTRAINT `FK_protocolo_beneficio_tipos` FOREIGN KEY (`id_tipo_beneficio`) REFERENCES `beneficio_tipos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=160 DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
