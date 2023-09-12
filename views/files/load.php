<?php  
if (isset($FILE[0]))
{
    $decoded = base64_decode($FILE[0]->conteudo);
    $extension = $FILE[0]->extensao;
    
    
    if ($extension == 'pdf')
    {
        header('Content-type: application/pdf');
    }elseif ($extension == 'png'){
        header ('Content-type: image/png');
    }elseif ($extension == 'jpg'){
        header ('Content-type: image/jpeg');
    }
    
    
      header("Cache-Control: no-cache");
      header("Pragma: no-cache");
      header("Content-Disposition: inline;filename='document.$extension'");
      header("Content-length: ".strlen($decoded));
      echo $decoded;
    
}
  exit();  
?>


