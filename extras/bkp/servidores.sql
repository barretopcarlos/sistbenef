USE `beneficios`;

/*Data for the table `auxiliado` */

insert  into `auxiliado`(`dependente`,`meses`,`idade`,`educacao`,`saude`,`vitaliceo`,`requerente`) values 
('1',6,0,'S',NULL,NULL,'N');

/*Data for the table `beneficiario` */

insert  into `beneficiario`(`id`,`nome`,`cpf`,`id_funcional`,`cargo`,`vinculo`,`status`,`sexo`,`email`,`email_corp`,`celular`,`telefone`,`uf`,`cidade`,`bairro`,`complemento`,`data_nascimento`,`deficiente`,`tipo_deficiencia`,`certidao`) values 
(1,'FLAVIANE GONÇALO','99999999999','9999999',NULL,NULL,'ATIVO','F',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'1990-11-11','N',NULL,NULL);

/*Data for the table `complementar` */

insert  into `complementar`(`id_funcional`,`cpf`,`login_rede`,`especializada`,`nome`,`email`,`email_corp`,`educacao`,`saude`) values 
('9999999','99999999999','goncalof',NULL,'FLAVIANE GONÇALO',NULL,NULL,'N','S');

/*Data for the table `conta_bancaria` */

insert  into `conta_bancaria`(`id`,`cpf`,`banco_beneficio`,`agencia_beneficio`,`conta_beneficio`,`banco_pagamento`,`agencia_pagamento`,`conta_pagamento`) values 
(1,'99999999999','237','129','xxxxxx-x',NULL,NULL,NULL);

/*Data for the table `dependente` */

insert  into `dependente`(`id`,`id_funcional`,`id_reg`,`nome`,`cpf`,`data_nascimento`,`sexo`,`dependencia`) values 
(2709,'9999999','99999991','MARIA DA CONCEIÇÃO GONÇALO','99999999999','2000-01-02','F','FILHO(A)');
