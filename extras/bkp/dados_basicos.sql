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

/*Data for the table `beneficio_tipos` */

insert  into `beneficio_tipos`(`id`,`beneficio`,`criado_por`,`criado_em`) values 
(1,'Auxílio Educação','nobret','2023-01-01 00:00:00');

/*Data for the table `deficiencia` */

insert  into `deficiencia`(`id`,`codigo`,`descricao`) values 
(1,1,'FISICA'),
(2,2,'AUDITIVA'),
(3,3,'VISUAL'),
(4,4,'MENTAL'),
(5,5,'MULTIPLA'),
(6,6,'REABILITADO'),
(7,7,'OUTROS');

/*Data for the table `instituicao_financeira` */

insert  into `instituicao_financeira`(`codigo`,`banco`) values 
('033','Banco SANTANDER'),
('077','Banco Inter'),
('080','B&T Cc Ltda'),
('1','Banco do Brasil S.A.'),
('104','Banco Caixa Econômica Federal'),
('107','Banco BOCOM BBM S.A.'),
('117','Advanced Cc Ltda'),
('12','Banco Inbursa S.A.'),
('121','Banco Agibank S.A.'),
('122','Banco Bradesco BERJ S.A.'),
('172','Albatross Ccv S.A'),
('184','Banco Itaú BBA S.A.'),
('188','Ativa Investimentos S.A'),
('196','Banco Fair Corretora de Câmbio S.A'),
('197','Stone Pagamentos'),
('204','Banco Bradesco Cartões S.A.'),
('208','Banco BTG Pactual S.A.'),
('212','Banco Original'),
('213','Banco Arbi S.A.'),
('217','Banco John Deere S.A.'),
('218','Banco BS2 S.A.'),
('222','Banco Credit Agricole Brasil S.A.'),
('224','Banco Fibra S.A.'),
('233','Banco Cifra S.A.'),
('237','Next'),
('241','Banco Clássico S.A.'),
('243','Banco Máxima S.A.'),
('246','Banco ABC Brasil S.A.'),
('249','Banco Investcred Unibanco S.A.'),
('25','Banco Alfa S.A.'),
('260','Nubank'),
('265','Banco Fator S.A.'),
('266','Banco Cédula S.A.'),
('280','Banco Willbank'),
('29','Banco Itaú Consignado S.A.'),
('290','PagBank'),
('3','Banco da Amazônia S.A.'),
('300','Banco de La Nacion Argentina'),
('31','Código Banco Beg S.A.'),
('318','Banco BMG S.A.'),
('323','Mercado Pago'),
('335','Banco Digio S.A'),
('336','Banco C6 S.A – C6 Bank'),
('340','Superdigital'),
('341','Banco Itaú'),
('368','Banco Carrefour'),
('37','Banco do Estado do Pará S.A.'),
('370','Banco Mizuho do Brasil S.A.'),
('376','Banco J. P. Morgan S.A.'),
('380','PicPay'),
('389','Banco Mercantil do Brasil S.A.'),
('394','Banco Bradesco Financiamentos S.A.'),
('4','Banco do Nordeste do Brasil S.A.'),
('40','Banco Cargill S.A.'),
('41','Banco do Estado do Rio Grande do Sul S.A.'),
('412','Banco Capital S.A.'),
('422','Banco Safra'),
('456','Banco MUFG Brasil S.A.'),
('47','Banco do Estado de Sergipe S.A.'),
('473','Banco Caixa Geral – Brasil S.A.'),
('479','Banco ItauBank S.A.'),
('494','Banco de La Republica Oriental del Uruguay'),
('495','Banco de La Provincia de Buenos Aires'),
('505','Banco Credit Suisse (Brasil) S.A.'),
('51','Banco de Desenvolvimento do Espírito Santo S.A.'),
('600','Banco Luso Brasileiro S.A.'),
('604','Banco Industrial do Brasil S.A.'),
('612','Banco Guanabara S.A.'),
('626','Banco Ficsa S.A.'),
('63','Banco Bradescard S.A.'),
('641','Banco Alvorada S.A.'),
('65','Banco Andbank (Brasil) S.A.'),
('653','Banco Indusval S.A.'),
('654','Banco A.J.Renner S.A.'),
('66','Banco Morgan Stanley S.A.'),
('69','Banco Crefisa S.A.'),
('7','Banco Nacional de Desenvolvimento Econômico e Social – BNDES'),
('707','Banco Daycoval S.A.'),
('720','Banco Maxinvest S.A.'),
('735','Neon Pagamentos'),
('739','Banco Cetelem S.A.'),
('745','Banco Citibank S.A.'),
('746','Banco Modal S.A.'),
('748','Banco Cooperativo Sicredi S.A.'),
('75','Banco ABN AMRO S.A'),
('752','Banco BNP Paribas Brasil S.A.'),
('756','Banco Cooperativo do Brasil S.A. – BANCOOB'),
('757','Banco KEB HANA do Brasil S.A.'),
('76','Banco KDB S.A.'),
('77','Banco Inter S.A.'),
('83','Banco da China Brasil S.A.'),
('94','Banco Finaxis S.A.'),
('96','Banco B3 S.A.');

/*Data for the table `mural` */

insert  into `mural`(`id`,`id_beneficio_tipos`,`descricao`,`data_cadastro`,`id_usuario`,`tipo`) values 
(1,1,'Procuradores em exercício na Procuradoria Geral do Estado','2023-03-24 14:31:04','nobret','auxilio'),
(2,1,'Procuradores  ocupantes  de  cargo  de  direção  ou  de  cargo  de  assessoramento jurídico  em  órgão  ou  entidade  da  Administração  Direta  estadual,  Autarquias, Fundações, Empresas Públicas e Sociedade de Economia Mista','2023-03-24 14:31:04','nobret','auxilio'),
(3,1,'Assistentes Jurídicos em exercício na Procuradoria Geral do Estado','2023-03-24 14:31:04','nobret','auxilio'),
(4,1,'servidores ocupantes de cargo de provimento efetivo do quadro permanente de Pessoal  de  Apoio,  em  exercício  na  Procuradoria  Geral  do  Estado,  inclusive durante o período de estagio experimental','2023-03-24 14:31:04','nobret','auxilio'),
(5,1,'servidores ocupantes de cargo em comissão da estrutura da Procuradoria Geral do Estado','2023-03-24 14:31:04','nobret','auxilio'),
(6,1,'servidores  cedidos  por  outros  órgãos,  em  exercício  na  Procuradoria  Geral  do Estado','2023-03-24 14:31:04','nobret','auxilio'),
(7,1,'filho,  enteado  ou  menor  sob  a  guarda  ou  a  tutela,  com  idade  entre  6  (seis) meses  e  18  (dezoito)  anos  completos,  respeitada  a  ressalva  do  §1º,  dos Procuradores e dos servidores do quadro de provimento efetivo da Procuradoria ','2023-03-24 14:31:04','nobret','auxilio'),
(8,2,'Procuradores em exercício na Procuradoria Geral do Estado','2023-03-24 14:31:04','nobret','auxilio'),
(9,2,'Procuradores ocupantes de cargo de direção ou de cargo de assessoramento jurídico em órgão ou entidade da Administração Direta Estadual, Autarquias, Fundações, Empresas Públicas e Sociedades de Economia Mista','2023-03-24 14:31:04','nobret','auxilio'),
(10,2,'Procuradores inativos','2023-03-24 14:31:04','nobret','auxilio'),
(11,2,'Assistentes Jurídicos ativos, em exercício na Procuradoria Geral do Estado, e inativos','2023-03-24 14:31:04','nobret','auxilio'),
(12,2,'Servidores ocupantes de cargo de provimento efetivo do Quadro Permanente de Pessoal de Apoio, em exercício na Procuradoria Geral do Estado, inclusive durante o período de estágio experimental','2023-03-24 14:31:04','nobret','auxilio'),
(13,2,'Servidores ocupantes de cargos em comissão da estrutura da Procuradoria Geral do Estado','2023-03-24 14:31:04','nobret','auxilio'),
(14,2,'Servidores cedidos por outros órgãos, em exercício na Procuradoria Geral do Estado','2023-03-24 14:31:04','nobret','auxilio'),
(15,2,'Servidores inativos, que tenham passado à inatividade na condição de ocupantes de cargo de provimento efetivo do Quadro Permanente','2023-03-24 14:31:04','nobret','auxilio'),
(16,2,'Filhos, enteados ou menores sob a guarda ou tutela dos Procuradores e dos servidores do quadro de provimento efetivo da Procuradoria Geral do Estado, assim como dos Assistentes Jurídicos nela em exercício, que venham a falecer enquanto servidores ','2023-03-24 14:31:04','nobret','auxilio'),
(17,0,'','2023-04-13 09:13:40','nobret','auxilio'),
(18,0,'','2023-04-13 09:14:17','nobret','auxilio'),
(19,2,'Teste de avisos do Núcleo de Benefícios','2023-06-19 12:15:14','nobret','Aviso');

/*Data for the table `tipo_documentos` */

insert  into `tipo_documentos`(`id`,`tipo`) values 
(1,'Mensalidade'),
(2,'Taxa de Matricula'),
(3,'Profissional de Saúde'),
(4,'Plano de Saúde');

/*Data for the table `valor_teto` */

insert  into `valor_teto`(`id`,`valor`,`id_usuario`,`data_cadastro`,`id_tipo_beneficio`) values 
(4,2300.00,'nobret','2023-06-19 15:58:01',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
