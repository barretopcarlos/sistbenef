<?php
ini_set('error_reporting', 0);
ini_set('max_execution_time', 0);

$meses=array(
    'JAN'=>'01',
    'FEB'=>'02',
    'MAR'=>'03',
    'APR'=>'04',
    'MAY'=>'05',
    'JUN'=>'06',
    'JUL'=>'07',
    'AUG'=>'08',
    'SEP'=>'09',
    'OCT'=>'10',
    'NOV'=>'11',
    'DEC'=>'12'
);


$pdo = new PDO('mysql:host=mysql-php;dbname=beneficios', 'root','');
$stmt= $pdo->prepare("TRUNCATE TABLE `beneficios`.`beneficiario`;");
$stmt->execute();

$pdo2 = new PDO('mysql:host=mysql-php;dbname=beneficios', 'root','');
$stmt2= $pdo2->prepare("TRUNCATE TABLE `beneficios`.`dependente`;");
$stmt2->execute();



//carga da tabela tipo de deficiencias
$url = "http://10.120.100.165/servico_ergon/?/funcionario/cargaDeficiencias";
$response0 = json_decode(file_get_contents($url));
foreach ($response0 as $record)
{
    $codigo = $record->CODIGO;
    $descricao = $record->DESCR;
    $pdo0 = new PDO('mysql:host=mysql-php;dbname=beneficios', 'root','');
    $insere0 = "
    INSERT IGNORE INTO `beneficios`.`deficiencia` 
    (`codigo`,`descricao`)
    VALUES ('$codigo','$descricao');";
    $stmt0= $pdo0->prepare($insere0);
    $stmt0->execute();

}


//dados pessoais basicos dos beneficiarios
$url = "http://10.120.100.165/servico_ergon/?/funcionario/cargaBeneficiarios";

$response = json_decode(file_get_contents($url));
foreach ($response as $record)
{
    $nome = $record->NOME;
    $cpf = $record->CPF;
    $sexo = $record->SEXO;
    $estCivil = $record->ESTCIVIL;
    $escolaridade = $record->ESCOLARIDADE;
    $uf = $record->UFENDER;
    $cidade = $record->CIDADEENDER;
    $bairro = $record->BAIRROENDER;
    $complemento = $record->TIPOLOGENDER.' '.$record->NOMELOGENDER. ', '. $record->NUMENDER.' '.$record->COMPLENDER;

    $id_funcional = $record->NUMFUNC;
    $cargo = $record->LITERAL_CARGO;
    $vinculo = $record->TIPOVINC;
    $status = $record->SITUACAO;
    $email = $record->E_MAIL;

    $nascBenef = $record->DTNASC;
    $deficiente = $record->DEFICIENTE;
    $deficiente = $record->DEFICIENTE;
    $tipo_deficiencia = $record->TIPODEFIC;
    $email_corp = $record->EMAIL2;
    $telefone = $record->TELEFONE;
    $celular = $record->NUMTEL_CELULAR;
    $certidao = $record->TIPODOC_CERT;
    


    try{


        $pdo = new PDO('mysql:host=mysql-php;dbname=beneficios', 'root','');
    
        $insere = "
        INSERT INTO `beneficios`.`beneficiario` ( `nome`, `cpf`, `id_funcional`,`cargo`,`vinculo`,
        `status`,`sexo`,`email`, `uf`, `cidade`, `bairro`,`complemento`,
        `data_nascimento`,`deficiente`,`tipo_deficiencia`,`email_corp`,`telefone`,`celular`,`certidao`)
        VALUES
        ('$nome', '$cpf','$id_funcional','$cargo', '$vinculo',
        '$status', '$sexo', '$email','$uf', '$cidade', '$bairro', '$complemento',
        '$nascBenef','$deficiente','$tipo_deficiencia','$email_corp','$telefone','$celular','$certidao');
        ";
        $stmt= $pdo->prepare($insere);
        $stmt->execute();
    


        $pdoX = new PDO('mysql:host=mysql-php;dbname=beneficios', 'root','');
        $insereX = "
        INSERT INTO `beneficios`.`complementar` ( `nome`, `cpf`, `id_funcional`,`email`, `email_corp`)
        VALUES
        ('$nome', '$cpf','$id_funcional','$email','$email_corp');
        ";
        $stmtX= $pdoX->prepare($insereX);
        $stmtX->execute();
    


        

        //dependente
        $urlDependente = "http://10.120.100.165/servico_ergon/?/funcionario/cargaDependentes/$cpf";
        $response2 = json_decode(file_get_contents($urlDependente));
        foreach ($response2 as $record2){

            $numFuncional = $record->NUMFUNC;
            $id_reg=$record2->ID_REG;
            $nomeDep = $record2->NOME;
            $cpfDep = $record2->CPF;
            $auxnascDep =explode("-",$record2->DTNASC);
            $dd = $auxnascDep[0];
            $md = $meses[$auxnascDep[1]];
            $ad = $auxnascDep[2];
            if ($ad > date("y")){
                $ad = 1900 + $ad;
            }else{
                $ad = 2000 + $ad;

            }
            

            $nascDep = $ad.'-'.$md.'-'.$dd;
            $sexoDep = $record2->SEXO;
            $parentesco = $record2->PARENTESCO;
            
            if (!empty(trim($parentesco)))
            {

                $pdo2 = new PDO('mysql:host=mysql-php;dbname=beneficios', 'root','');
                $insere2 = "
                INSERT INTO `beneficios`.`dependente` 
                (`id_funcional`,`id_reg`, `nome`,`cpf`, `data_nascimento`,`sexo`,`dependencia`)
                VALUES ('$numFuncional','$id_reg', '$nomeDep','$cpfDep','$nascDep','$sexoDep','$parentesco');";
                $stmt2= $pdo2->prepare($insere2);
                $stmt2->execute();
    
            }

        
        }
        

        //deficiencia dependentes
        $urlDeficienciaDependente = "http://10.120.100.165/servico_ergon/?/funcionario/cargaDeficienciaDependentes/$cpf";
        $responseX = json_decode(file_get_contents($urlDeficienciaDependente));
        foreach ($responseX as $recordX){
            $ddIdReg = $recordX->ID_REG;
            $excepcional = $recordX->EXCEPCIONAL;
            $tipoInvalidez = $recordX->TIPO_INVALIDEZ;
            $tipoExcepcionalidade = $recordX->TIPO_EXCEPCIONALIDADE;
            
            if (!empty(trim($excepcional)))
            {

                $pdoX = new PDO('mysql:host=mysql-php;dbname=beneficios', 'root','');
                $insereX = "
                UPDATE `beneficios`.`dependente` 
                SET excepcional='$excepcional'
                WHERE id_reg='$ddIdReg'";
                $stmtX= $pdoX->prepare($insereX);
                $stmtX->execute();

            }

        
        }
        
    
    
    } catch (PDOException $error){
        //echo "Erro:\n" . $error->getMessage();  
    }
    
    
    

}



//tem direito ao auxilio educacao
$pdo3 = new PDO('mysql:host=mysql-php;dbname=beneficios', 'root','');
$insere3 = "REPLACE INTO auxiliado(dependente,meses,idade,educacao)
SELECT id_reg,
TIMESTAMPDIFF(MONTH,data_nascimento,CURDATE()) AS meses,
TIMESTAMPDIFF(YEAR,data_nascimento,CURDATE()) AS anos,
'S' AS educacao
FROM dependente
WHERE dependencia IN ('FILHO(A)','ENTEADO(A)','TUTELADO/CURATELADO','GUARDA PROVISORIA')
HAVING meses>=6 AND anos<=18
";
$stmt3= $pdo3->prepare($insere3);
$stmt3->execute();


//nao tem direito ao beneficio por causa da idade, mesmo sendo dependentes
$pdo3 = new PDO('mysql:host=mysql-php;dbname=beneficios', 'root','');
$insere3 = "REPLACE INTO auxiliado(dependente,meses,idade,educacao)
SELECT id_reg,
TIMESTAMPDIFF(MONTH,data_nascimento,CURDATE()) AS meses,
TIMESTAMPDIFF(YEAR,data_nascimento,CURDATE()) AS anos,
'N' AS educacao
FROM dependente
WHERE dependencia IN ('FILHO(A)','ENTEADO(A)','TUTELADO/CURATELADO','GUARDA PROVISORIA')
HAVING meses<6 AND anos>18
";
$stmt3= $pdo3->prepare($insere3);
$stmt3->execute();


//nao tem direito ao beneficio independente da idade
$pdo3 = new PDO('mysql:host=mysql-php;dbname=beneficios', 'root','');
$insere3 = "REPLACE INTO auxiliado(dependente,meses,idade,educacao)
SELECT id_reg,
TIMESTAMPDIFF(MONTH,data_nascimento,CURDATE()) AS meses,
TIMESTAMPDIFF(YEAR,data_nascimento,CURDATE()) AS anos,
'N' AS educacao
FROM dependente
WHERE dependencia NOT IN ('FILHO(A)','ENTEADO(A)','TUTELADO/CURATELADO','GUARDA PROVISORIA')";
$stmt3= $pdo3->prepare($insere3);
$stmt3->execute();


//print_r($response);


die('Fim');

?>