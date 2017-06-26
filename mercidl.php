<?php
  include_once('include/db.php');
  function human_filesize($bytes, $decimals = 2) {
    $sz = 'BKMGTP';
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . @$sz[$factor] . 'o';
  }
  $id_dir=$_REQUEST['file'];
  $result = findFile($id_dir);
  $size = human_filesize($result[0]['size']);
  $name = $result[0]['name']; //modify for the multiple upload if necessary
  $type = $result[0]['type'];
  $mail = $result[0]['email_from'];
  $url = 'http://'.$_SERVER['SERVER_NAME'].'/LFM/download.php?file='.$_REQUEST['file'];

  $nomfichier = $name.".".$type;

  $templateddl = file_get_contents('template/templateddl.html');

  $templateddl = str_replace('{{size}}', $size, $templateddl);
  $templateddl = str_replace('{{nomfichier}}', $nomfichier, $templateddl);
  $templateddl = str_replace('{{email}}', $mail, $templateddl);
  $templateddl = str_replace('{{url}}', $url, $templateddl);
  echo $templateddl;
?>
