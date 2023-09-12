<?php
//Ferramenta de Debug
require 'kint.phar';

require_once('lib/limonade.php');
require_once('config.php');

layout('layout/master.php');

/*
executar script de ajuste de base de dados 
Antes de usuario obter informações deve-se ajustar vigencias vencidas, ou informações que atrapalhem no seu dia a dia
*/

require_once('routes.php');
run();