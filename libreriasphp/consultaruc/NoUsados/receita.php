<?php
/**
 * Nesta função iremos baixar a imagem do captcha
 *
 * Parametro $url:
 *   Coloque a url que o captcha usa para reproduzir a imagem
 * Parametro $arquivo:
 *   Coloque o arquivo para salvar a imagem.
 *   IMPORTANTE que o arquivo já exista e tenha permissão CHMOD 777
 */
function recibe_imagen_sunat($url, $arquivo) {
  $cookie = $_SERVER['DOCUMENT_ROOT'].'/sisgescom/sunat/receita.txt'; //Importantissimo que o caminho esteja correto e com permissão CHMOD 777

  $ch = curl_init ();

  curl_setopt_array($ch, array(
    CURLOPT_URL => $url, //url que produz a imagem do captcha.
    CURLOPT_COOKIEFILE => $cookie, //esse mais o debaixo fazem a mágica do captcha
    CURLOPT_COOKIEJAR => $cookie,  //esse mais o de cima fazem a mágica do.. ah já falei isso;
    CURLOPT_FOLLOWLOCATION => 1, //não sei, mas funciona :D
    CURLOPT_RETURNTRANSFER => 1, //retorna o conteúdo.
    CURLOPT_BINARYTRANSFER => 1, //essa tranferencia é binária.
    CURLOPT_HEADER => 0, //não imprime o header.
  ));

  if(!$data = curl_exec($ch)){
    $arquivo=false;
  }else{
    //salva a imagem
    $fp = fopen($arquivo,'w');
    fwrite($fp, $data);
    fclose($fp);
  }
  curl_close ($ch);
  //retorna a imagem
  return $arquivo;
}

//Então vamos pegar a imagem
//$img = recebe_imagem("http://www.receita.fazenda.gov.br/scripts/srf/intercepta/captcha.aspx?opt=image", "receita.gif");
$img = recibe_imagen_sunat("http://www.sunat.gob.pe/cl-ti-itmrconsruc/captcha?accion=image&nmagic=1", "receita.gif");
if($img==false){
  $img = recibe_imagen_sunat("http://ww1.sunat.gob.pe/cl-ti-itmrconsruc/captcha?accion=image&nmagic=1", "receita.gif");
}
if (file_exists("../sunat/receita.gif")) {//this can also be a png or jpg

    //Set the content-type header as appropriate
    $imageInfo = getimagesize($img);
    switch ($imageInfo[2]) {
        case IMAGETYPE_JPEG:
            header("Content-Type: image/jpg");
            break;
        case IMAGETYPE_GIF:
            header("Content-Type: image/gif");
            break;
        case IMAGETYPE_PNG:
            header("Content-Type: image/png");
            break;
       default:
            break;
    }

    // Set the content-length header
    header('Content-Length: ' . filesize($img));

    // Write the image bytes to the client
    readfile($img);
  }


//E criar o formulário que mostra a imagem + o campo de inserção do CNPJ
/*print "<img src='{$img}' />" .
      '<form action="rastreo.php" method="POST">
         captcha
         <input size="8" maxlength="4" name="vletras">
         cnpj
         <input size="16" maxlength="11" name="vruc">
         <input type="submit">
      </form>';*/
?>
