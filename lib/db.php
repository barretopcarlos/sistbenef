<?php

function find_objects_by_ergon($sql = '', $params = array()) {
	$db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = srv-pge-128.in.pge.rj.gov.br)(PORT = 1521)))(CONNECT_DATA=(SID=ergondev)))";
	$conn = oci_connect("c_ergon", "c_ergon",$db, 'AL32UTF8');	
	$result = array();
	$array_funcionarios= oci_parse($conn, $sql);
	oci_execute($array_funcionarios);
		while($row=oci_fetch_object($array_funcionarios)){
		$result[]= $row;	
		}
	oci_close($conn);
    return $result;
}


function find_objects_by_sql($sql = '', $params = array()) {
    $db = option('db_conn');

    $result = array();
    $stmt = $db->prepare($sql);
    if ($stmt->execute($params)) {
        while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
            $result[] = $obj;
        }
    }
	
    return $result;
}

function find_objects_by_sql_files($sql = '', $params = array()) {
    $db = option('db_conn_files');

    $result = array();
    $stmt = $db->prepare($sql);
    if ($stmt->execute($params)) {
        while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
            $result[] = $obj;
        }
    }
	
    return $result;
}

function find_object_by_sql($sql = '', $params = array()) {
    $db = option('db_conn');

    $stmt = $db->prepare($sql);
    if ($stmt->execute($params) && $obj = $stmt->fetch(PDO::FETCH_OBJ)) {
        return $obj;
    }
    return null;
}

function make_model_object($params, $obj = null) {
    if (is_null($obj)) {
        $obj = new stdClass();
    }
    foreach ($params as $key => $value) {
        $obj->$key = $value;
    }
    return $obj;
}

function make_model_object_files($params, $obj = null) {
    if (is_null($obj)) {
        $obj = new stdClass();
    }
    foreach ($params as $key => $value) {
        $obj->$key = $value;
    }
    return $obj;
}

function add_colon($x) { return ':' . $x; };


function name_eq_colon_name($x) { return $x . ' = :' . $x; };

//excluir por id
function delete_object_by_id($obj_id, $table) {
    $db = option('db_conn');

    $stmt = $db->prepare("DELETE FROM `$table` WHERE id = ?");
    $stmt->execute(array($obj_id));
}


//inserir
function create_object($object = array(), $table, $obj_columns = array(), $replace=0) {
    $db = option('db_conn');
      
    if (!count($obj_columns)) {
        $obj_columns = array_keys(get_object_vars($object));
    }
    unset($obj_columns['id']);

    $replaceInsert = "INSERT";
    if ($replace) $replaceInsert="REPLACE";


    $sql =
        "$replaceInsert INTO `$table` (" .
        implode(', ', $obj_columns) .
        ') VALUES (' .
        implode(', ', array_map('add_colon', $obj_columns)) . ')';

    $stmt = $db->prepare($sql);
    foreach ($obj_columns as $column) {
        $stmt->bindValue(':' . $column, $object->$column);
    }
    $stmt->execute();  
    return $db->lastInsertId(); 
}


//inserir
function create_objects($object = array(), $table, $obj_columns = array(),$object_files = array(),$count_data) {  

    try{
        $db = option('db_conn');
        $msg = '';
        $data_count = count($count_data);
    
        $id_teto = get_id_teto_atual();
    
            if( empty($id_teto) ):
                throw new Exception("Não há valor teto disponível!");
                return;
            endif;
    
        for ($i = 0; $i < $data_count; $i++) { 
                   $count = 0;
                    
                    if($count > 0){
                        $msg .= $object->dependente[$i]." não adicionado, já existe um registro para competência.\\n";
                    } else{  
                        if (!count($obj_columns)) {
                            $obj_columns = array_keys(get_object_vars($object));
                        }
                    
                    $index_of = $object->index_of[$i];
                    unset($obj_columns['id']);
            
                   /* $sql =
                        "INSERT INTO `$table` (" .
                        implode(', ', $obj_columns) .
                        ') VALUES (' .
                        implode(', ', array_map('add_colon', $obj_columns)) . ')';
                        */
                       //echo "<pre>";print_r($object);die();

                    $valor =  $object->valor[$i];
                    $competencia = $object->competencia[$i];
                    $dependente = $object->codigo_dependente[$i];
                    $Nomedependente = $object->dependente[$i];
                    $observacao = $object->observacao[$i];
                    $observacao = str_replace("'","",$observacao);
                    $observacao = str_replace('"',"",$observacao);
                    
                    $colaborador_nome = $object->colaborador_nome[$i];
                    $colaborador = $object->colaborador[$i];
                    $id_folha = $object->id_folha;
                    $valor_disponivel = $object->valor_disponivel[$i];
                    $id_valor_teto = $object->id_valor_teto[$i];
                    $protocolo =  $object->protocolo;
                   

                    $sql="
                    INSERT INTO `beneficios`.`educacao` 
                    (`protocolo`, `colaborador`, `valor`, `dependente`, `nome_dependente`, `colaborador_nome`, `competencia`,
                    `id_folha`, `id_valor_teto`, `valor_disponivel`, `data_cadastro`, `observacao`
                    )
                    VALUES
                    ('$protocolo', '$colaborador', '$valor', '$dependente','$Nomedependente', '$colaborador_nome', '$competencia',  
                    '$id_folha', '$id_valor_teto', '$valor_disponivel', NOW(),'$observacao');
                    ";    

                    $stmt = $db->prepare($sql);
                    /*foreach ($obj_columns as $column) {
                            if( !in_array($column, ["id_folha","protocolo"]) ){
                                if( $column == "id_valor_teto" && empty( (int) $object->$column[$i] ) ):
                                    $object->$column[$i] = $id_teto;
                                endif;
        
                                    
                                $stmt->bindValue(':' . $column, $object->$column[$i]);
                            }
                        
            
                    } */   

                            if ($stmt->execute()) { 
                                //DELETAR METADADOS CASO NÃO CONSIGA ADICIONAR ARQUIVOS 
                                if(create_object_files($object_files, $db->lastInsertId(), $index_of) == ''){
                                    $msg .= $object->dependente[$i]." adicionado com sucesso.\\n";    
                                } else {
                                    $msg = "ERROR ED02 Contate o administrador do sistemaa"; 
                                    $db->prepare("DELETE FROM educacao WHERE id=?")->execute([$db->lastInsertId()]);           
                                }                          
                            } else {
                                $msg .= $object->dependente[$i]." ERROR ED01.\\n";
                            }    

                    }
        }

    }catch(Exception $e){
        $msg = $e->getMessage();
    }
    
    return $msg;
    
}


function create_lancamento_files($object_files = array(),$id_metadata) 
{
    $db = option('db_conn_files');

    $msg='';
    $fp_boleto              = base64_encode(file_get_contents($object_files["tmp_name"]));    

    $path_parts = pathinfo($object_files["name"]);
    $extensao = $path_parts['extension'];

    
    
    if( !empty($fp_boleto) ):
        $stmt = $db->prepare("INSERT INTO upload_lancamento_contratual (conteudo, id_educacao, extensao) VALUES ( :boleto, :id_metadada, :extensao )");
        $stmt->bindParam(':boleto', $fp_boleto, PDO::PARAM_LOB);
        $stmt->bindParam(':id_metadada', $id_metadata);  
        $stmt->bindParam(':extensao', $extensao);  
        if ( !$stmt->execute() ):
            $msg .= "ERROR ED0007 Contate o administrador do sistema";
        endif;
    endif;

    return $msg;
}


//inserir
function create_object_files($object_files = array(),$id_metadata,$position) {  
    $db = option('db_conn_files');
    $msg = '';


    //BOLETOS
    forEach( $object_files->tmp_name['boleto'][$position] AS $index => $dtt ):
        $tmpName_boleto = '';
        $fp_boleto      = '';

        $tmpName_boleto         = $dtt;   
        $fp_boleto              = base64_encode(file_get_contents($tmpName_boleto));    

        $Name_boleto         = $object_files->name['boleto'][$position][$index];
        $path_parts = pathinfo($Name_boleto);
        if (isset($path_parts['extension']))
        {
            $extensao = $path_parts['extension'];
    
    
            if( !empty($fp_boleto) ):
                $stmt = $db->prepare("INSERT INTO upload_educacao_boletos (conteudo, id_educacao, extensao) VALUES ( :boleto, :id_metadada, :extensao )");
                $stmt->bindParam(':boleto', $fp_boleto, PDO::PARAM_LOB);
                $stmt->bindParam(':id_metadada', $id_metadata);  
                $stmt->bindParam(':extensao', $extensao);  
                if ( !$stmt->execute() ):
                    $msg .= "ERROR ED0002 Contate o administrador do sistema";
                    break;
                endif;
            endif;
        }


    endforeach;


    //COMPROVANTES
    forEach( $object_files->tmp_name['comprovante'][$position] AS $index => $dtt ):
        $tmpName_comprovante    = '';
        $fp_comprovante         = '';
        
        $tmpName_comprovante    = $object_files->tmp_name['comprovante'][$position][$index];  
        $fp_comprovante         = base64_encode(file_get_contents($tmpName_comprovante));
    
        $Name_comprovante         = $object_files->name['comprovante'][$position][$index];
        $path_parts = pathinfo($Name_comprovante);
        if (isset($path_parts['extension']))
        {
            
        $extensao = $path_parts['extension'];

        if( !empty($fp_comprovante) ):
            $stmt = $db->prepare("INSERT INTO upload_educacao_comprovantes (conteudo, id_educacao, extensao) VALUES ( :comprovante, :id_metadada, :extensao )");
            $stmt->bindParam(':comprovante', $fp_comprovante);
            $stmt->bindParam(':id_metadada', $id_metadata);  
            $stmt->bindParam(':extensao', $extensao);  
            

            if ( !$stmt->execute() ):
                $msg .= "ERROR ED0003 Contate o administrador do sistema";
                break;
            endif;
        endif;        
        }

    endforeach;

    
    //OUTROS
    forEach( $object_files->tmp_name['outros'][$position] AS $index => $dtt ):    
        $tmpName_outros = '';
        $fp_outros      = '';

        $tmpName_outros         = $object_files->tmp_name['outros'][$position][$index];
        $fp_outros              = base64_encode(file_get_contents($tmpName_outros));

        $Name_outros         = $object_files->name['outros'][$position][$index];
        $path_parts = pathinfo($Name_outros);
        if (isset($path_parts['extension']))
        {
            $extensao = $path_parts['extension'];

            if( !empty($fp_outros) ):
                $stmt = $db->prepare("INSERT INTO upload_educacao_outros (conteudo, id_educacao, extensao) VALUES ( :outros, :id_metadada, :extensao )");
                $stmt->bindParam(':outros', $fp_outros, PDO::PARAM_LOB);
                $stmt->bindParam(':id_metadada', $id_metadata);  
                $stmt->bindParam(':extensao', $extensao);  

                if ( !$stmt->execute() ):
                    $msg .= "ERROR ED0003 Contate o administrador do sistema";
                    break;
                endif;
            endif;
        }        
        
            
    endforeach;

    
    return $msg;   
    
}




//atualizar
function update_object($object, $table, $obj_columns = array()) {
    $db = option('db_conn');

    if (!count($obj_columns)) {
        $obj_columns = array_keys(get_object_vars($object));
    }

    $sql =
        "UPDATE `$table` SET " .
        implode(', ', array_map('name_eq_colon_name', $obj_columns)) .
        ' WHERE id = :id';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', $object->id);
    foreach ($obj_columns as $column) {      
        $stmt->bindValue(':' . $column, $object->$column);
       
    }

    return $stmt->execute();
}


//executar comandos
function execute($sql) {
    $db = option('db_conn');
    $stmt = $db->prepare($sql);
    return $stmt->execute();
}

//atualizar
function update_all_object($object, $table, $obj_columns, $where_condition){
    $db = option('db_conn');

    if( !count($obj_columns) ):
        $obj_columns = array_keys($object);
    endif;


    $colunas_valores    = implode(', ', array_map('name_eq_colon_name', $obj_columns));
    $condition          = array_keys($where_condition);
    $condition          = implode(" AND ", array_map("name_eq_colon_name", $condition));

    $sql = "UPDATE {$table}
                SET {$colunas_valores}
            WHERE {$condition}
    ";

    $stmt = $db->prepare($sql);
        forEach( $obj_columns AS $column ):
            $stmt->bindValue(':' . $column, $object->$column);
        endforeach;
        
        forEach( $where_condition AS $nome => $valor ):
            $stmt->bindValue(":" . $nome, $valor);
        endforeach;

    return $stmt->execute();
}
