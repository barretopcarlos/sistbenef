<?php  
//print_r($pdfid);die();
  $decoded = base64_decode($pdfid[0]->conteudo);
  header('Content-type: application/pdf');
  header("Cache-Control: no-cache");
  header("Pragma: no-cache");
  header("Content-Disposition: inline;filename='document.pdf'");
  header("Content-length: ".strlen($decoded));
  echo $decoded;
  exit();  
?>


