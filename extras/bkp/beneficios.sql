/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 5.1.61 : Database - beneficios
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`beneficios` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `beneficios`;

/*Table structure for table `auxiliado` */

DROP TABLE IF EXISTS `auxiliado`;

CREATE TABLE `auxiliado` (
  `dependente` varchar(20) NOT NULL,
  `meses` int(5) NOT NULL COMMENT 'idade em meses',
  `idade` int(3) NOT NULL,
  `educacao` char(1) DEFAULT NULL,
  `saude` char(1) DEFAULT NULL,
  `vitaliceo` char(1) DEFAULT NULL,
  `requerente` char(1) DEFAULT NULL,
  PRIMARY KEY (`dependente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `beneficiario` */

DROP TABLE IF EXISTS `beneficiario`;

CREATE TABLE `beneficiario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `id_funcional` varchar(10) DEFAULT NULL,
  `cargo` varchar(50) DEFAULT NULL,
  `vinculo` varchar(30) DEFAULT NULL,
  `status` varchar(7) DEFAULT NULL,
  `sexo` char(1) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `email_corp` varchar(100) DEFAULT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `deficiente` varchar(10) DEFAULT NULL,
  `tipo_deficiencia` varchar(50) DEFAULT NULL,
  `certidao` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ukCPF` (`cpf`)
) ENGINE=InnoDB AUTO_INCREMENT=2172 DEFAULT CHARSET=utf8;

/*Table structure for table `beneficio_tipos` */

DROP TABLE IF EXISTS `beneficio_tipos`;

CREATE TABLE `beneficio_tipos` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `beneficio` varchar(50) NOT NULL,
  `criado_por` varchar(20) NOT NULL,
  `criado_em` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ukBeneficio` (`beneficio`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table `complementar` */

DROP TABLE IF EXISTS `complementar`;

CREATE TABLE `complementar` (
  `id_funcional` varchar(10) DEFAULT NULL,
  `cpf` varchar(11) NOT NULL,
  `login_rede` varchar(20) DEFAULT NULL,
  `especializada` varchar(10) DEFAULT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `email_corp` varchar(100) DEFAULT NULL,
  `educacao` char(1) DEFAULT 'N' COMMENT 'tem direito auxilio educacao',
  `saude` char(1) DEFAULT 'N' COMMENT 'tem direito auxilio saude',
  PRIMARY KEY (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `conta_bancaria` */

DROP TABLE IF EXISTS `conta_bancaria`;

CREATE TABLE `conta_bancaria` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cpf` varchar(20) NOT NULL,
  `banco_beneficio` varchar(6) DEFAULT NULL,
  `agencia_beneficio` varchar(10) DEFAULT NULL,
  `conta_beneficio` varchar(20) DEFAULT NULL,
  `banco_pagamento` varchar(6) DEFAULT NULL,
  `agencia_pagamento` varchar(10) DEFAULT NULL,
  `conta_pagamento` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=521 DEFAULT CHARSET=utf8;

/*Table structure for table `contrato` */

DROP TABLE IF EXISTS `contrato`;

CREATE TABLE `contrato` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_contrato` varchar(100) NOT NULL,
  `cnpj_contrato` varchar(20) NOT NULL,
  `id_usuario_cadastro` varchar(30) DEFAULT NULL,
  `data_cadastro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `internacional` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `idx_contrato_unique_nome` (`nome_contrato`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Table structure for table `deficiencia` */

DROP TABLE IF EXISTS `deficiencia`;

CREATE TABLE `deficiencia` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo` int(10) unsigned NOT NULL,
  `descricao` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ukCodigo` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Table structure for table `dependente` */

DROP TABLE IF EXISTS `dependente`;

CREATE TABLE `dependente` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_funcional` varchar(15) NOT NULL,
  `id_reg` varchar(20) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `sexo` char(1) DEFAULT NULL,
  `dependencia` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ukDependente` (`id_reg`)
) ENGINE=InnoDB AUTO_INCREMENT=2710 DEFAULT CHARSET=utf8;

/*Table structure for table `educacao` */

DROP TABLE IF EXISTS `educacao`;

CREATE TABLE `educacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `protocolo` varchar(50) NOT NULL,
  `colaborador` varchar(100) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `dependente` varchar(100) DEFAULT NULL,
  `nome_dependente` varchar(100) DEFAULT NULL,
  `colaborador_nome` varchar(100) DEFAULT NULL,
  `competencia` varchar(10) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `id_folha` int(11) DEFAULT NULL,
  `id_valor_teto` int(11) DEFAULT NULL,
  `valor_disponivel` decimal(10,2) DEFAULT NULL,
  `data_cadastro` timestamp NULL DEFAULT NULL,
  `observacao` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table `educacao_historico_alteracao_valor` */

DROP TABLE IF EXISTS `educacao_historico_alteracao_valor`;

CREATE TABLE `educacao_historico_alteracao_valor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_educacao` int(11) NOT NULL,
  `observacao` longtext NOT NULL,
  `valor_antigo` decimal(10,2) NOT NULL,
  `valor_novo` decimal(10,2) DEFAULT NULL,
  `data_registro` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Table structure for table `educacao_historico_status` */

DROP TABLE IF EXISTS `educacao_historico_status`;

CREATE TABLE `educacao_historico_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) DEFAULT NULL,
  `observacao` longtext,
  `id_educacao` int(11) DEFAULT NULL,
  `data_registro` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table `folha_pagamento` */

DROP TABLE IF EXISTS `folha_pagamento`;

CREATE TABLE `folha_pagamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `competencia` varchar(10) DEFAULT NULL,
  `tipo_folha` varchar(20) DEFAULT NULL,
  `data_abertura` date DEFAULT NULL,
  `responsavel_abertura` varchar(30) DEFAULT NULL,
  `data_reabertura` timestamp NULL DEFAULT NULL,
  `responsavel_reabertura` varchar(30) DEFAULT NULL,
  `data_consolidacao` timestamp NULL DEFAULT NULL,
  `responsavel_consolidacao` int(11) DEFAULT NULL,
  `numeracao` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Table structure for table `historico_valor_teto` */

DROP TABLE IF EXISTS `historico_valor_teto`;

CREATE TABLE `historico_valor_teto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valor` decimal(10,2) NOT NULL,
  `id_usuario` varchar(30) DEFAULT NULL,
  `data_cadastro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_tipo_beneficio` int(3) unsigned NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Table structure for table `instituicao_financeira` */

DROP TABLE IF EXISTS `instituicao_financeira`;

CREATE TABLE `instituicao_financeira` (
  `codigo` varchar(3) NOT NULL,
  `banco` varchar(100) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `lancamento_contratual` */

DROP TABLE IF EXISTS `lancamento_contratual`;

CREATE TABLE `lancamento_contratual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `ukLancamentoEduacao` (`dependente`,`identificacao_contrato`,`inicio_vigencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `mural` */

DROP TABLE IF EXISTS `mural`;

CREATE TABLE `mural` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `id_beneficio_tipos` int(3) NOT NULL,
  `descricao` tinytext NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `id_usuario` varchar(30) NOT NULL,
  `tipo` varchar(10) NOT NULL DEFAULT 'Auxílio',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

/*Table structure for table `notificacao` */

DROP TABLE IF EXISTS `notificacao`;

CREATE TABLE `notificacao` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `remetente` varchar(30) NOT NULL,
  `destinatario` varchar(30) NOT NULL,
  `assunto` varchar(50) DEFAULT NULL,
  `descricao` text,
  `justificativa` varchar(255) DEFAULT NULL,
  `enviado_em` datetime NOT NULL,
  `lido` char(1) NOT NULL DEFAULT 'N' COMMENT 'flag identificando se foi lida pelo destinatario',
  `lido_em` datetime DEFAULT NULL,
  `id_resposta` int(10) unsigned DEFAULT NULL COMMENT 'id da notificacao sendo respondida',
  `respondido_em` datetime DEFAULT NULL,
  `respondido_por` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Table structure for table `protocolo` */

DROP TABLE IF EXISTS `protocolo`;

CREATE TABLE `protocolo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_tipo_beneficio` int(3) unsigned NOT NULL,
  `protocolo` varchar(50) NOT NULL,
  `id_usuario` varchar(30) NOT NULL,
  `data_criacao` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `registro_lancamento_contratual` */

DROP TABLE IF EXISTS `registro_lancamento_contratual`;

CREATE TABLE `registro_lancamento_contratual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_lancamento_contratual` int(11) NOT NULL,
  `colaborador` varchar(255) NOT NULL,
  `dependente` varchar(255) NOT NULL,
  `competencia` varchar(20) NOT NULL,
  `mes_relacao` int(11) DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL,
  `id_usuario_cadastro` varchar(30) DEFAULT NULL,
  `data_cadastro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `solicitacao` */

DROP TABLE IF EXISTS `solicitacao`;

CREATE TABLE `solicitacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `protocolo` varchar(50) NOT NULL,
  `colaborador` varchar(100) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `dependente` varchar(100) DEFAULT NULL,
  `nome_dependente` varchar(100) DEFAULT NULL,
  `colaborador_nome` varchar(100) DEFAULT NULL,
  `competencia` varchar(10) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `id_folha` int(11) DEFAULT NULL,
  `id_valor_teto` int(11) DEFAULT NULL,
  `valor_disponivel` decimal(10,2) DEFAULT NULL,
  `data_cadastro` timestamp NULL DEFAULT NULL,
  `observacao` tinytext,
  `id_beneficio` int(3) unsigned DEFAULT NULL,
  `beneficiario` char(1) DEFAULT NULL,
  `tipo_documento` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tipo_documentos` */

DROP TABLE IF EXISTS `tipo_documentos`;

CREATE TABLE `tipo_documentos` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `valor_teto` */

DROP TABLE IF EXISTS `valor_teto`;

CREATE TABLE `valor_teto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valor` decimal(10,2) NOT NULL,
  `id_usuario` varchar(30) DEFAULT NULL,
  `data_cadastro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_tipo_beneficio` int(3) unsigned NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `ukBeneficio` (`id_tipo_beneficio`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
