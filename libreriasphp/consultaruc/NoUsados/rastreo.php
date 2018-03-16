<?php
$vurl = "http://www.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias";
$vruc = $_POST['vruc'];
$vletras = $_POST['vletras'];
$vtipod = $_POST['vtipod'];
$vres = array();
if(strpbrk($vtipod, '016')){
  $vruc = autoruc($vruc);
}

$data = recibe_registro_sunat($vurl, $vruc, $vletras, $vtipod);
if($data == false){
  $data = recibe_registro_sunat("http://ww1.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias", $vruc, $vletras);
}
if($data == false){
  $vres = null;
}else{
  if (preg_match("/<title>(.+)<\/title>/i", $data, $mat)){
    $posicion_coincidencia = strrpos($mat[1], 'Documento');
    if ($posicion_coincidencia === false) {
      $posicion_coincidencia = strrpos($mat[1], '.:: Pagina');
      if ($posicion_coincidencia === false) {
        $vres = parseTable($data);
      }else{
        $vres = array('Intente Nuevamente');
      }
    }else{
      $vres = array('No registrado en la Sunat');
    }
  }
}
echo json_encode($vres);
//echo utf8_decode( json_encode($vres));


/*if (preg_match("/<title>.:: Pagina.*<\/title>/siU", $data)) {
  //Então volta pro nosso formulário para preenchimento dos dados.
  //Estava com preguiça de pensar algo mais útil, então fiz esse só de exemplo mesmo.
  $host  = $_SERVER['HTTP_HOST'];
  $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
  $extra = 'receita.php';
  header("Location: http://$host$uri/$extra");
  return;
}*/
//return $data;
function autoruc($vruc){
  if (strlen(trim($vruc))==8){
    $cdni; $nvalor1; $nvalor2; $nvalor3; $i;
    $nvalor1 = 0;
    $cdni = '10'.trim($vruc);
    if (strlen($cdni)==10){
      $anum = array(5,4,3,2,7,6,5,4,3,2);
      for ($i = 0; $i <= 9; $i++) {
        $nvalor1 = $nvalor1+((int)(substr($cdni, $i, 1)))*$anum[$i];
      }
       $nvalor2 = ($nvalor1 % 11);
       $nvalor3 = 11-$nvalor2;
       $vruc = '10'.trim($vruc).substr(str_pad(trim(((string) ($nvalor3==10 ? 0 : ($nvalor3==10 ? 9 : $nvalor3)))), 2, '0',STR_PAD_LEFT), 1, 1);
     }else{
       $vruc = $vruc;
    }
  }
  return $vruc;
}

function recibe_registro_sunat($vurl, $vruc, $vletras, $vtipod) {
  // Pega os valores dos campos que foram enviados pelo formulário
  // *sem validação mesmo, é só pra exemplo tá?


  #Coisas importantes para dizer ao $ch logo mais

  //IMPORTANTE que o caminho esteja correto e tenha permissão CHMOD 777
  $cookie = $_SERVER['DOCUMENT_ROOT'].'/sisgescom/sunat/receita.txt';
  //$cookie = 'http://gcodiar.com/sisgescom/sisgescom/sunat/receita.txt';
    // não sei.. coloquei pra garantir
  $reffer = "http://google.com";

  //sempre é bom ter para garantir a entrada do seu serviço
  $agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";

  //url da receita que valida o formulário

  //dados do POST do formulário da receita.
  //** Muito importante entender os formulários que você esteja trabalhando **
  //os campos NESTA EXATA ordem funcionaram legal ;)

  if(strpbrk($vtipod, '016')){
    $post_fields = "accion=consPorRuc&nroRuc={$vruc}&codigo={$vletras}";
  }else{
    $post_fields = "accion=consPorTipdoc&nroRuc={$vruc}&codigo={$vletras}";
  }

  //agora sim.. 1, 2, 3 VALENDO!
  $ch = curl_init();

  curl_setopt_array($ch, array(
    CURLOPT_URL => $vurl, //sem isso, seu cURL é imprestável
    CURLOPT_POST => 1, //afirmo que ele irá fazer um POST
    CURLOPT_POSTFIELDS => $post_fields, //quais são os campos que estarei enviando ao valida.asp?
    CURLOPT_USERAGENT => $agent, //ahh é importante sempre ter né =D
    CURLOPT_REFERER => $reffer, //não sei.. coloquei pra garantir
    CURLOPT_COOKIEFILE => $cookie, //lembra dos cookies que guardamos qndo digitamos o captcha?
    CURLOPT_COOKIEJAR => $cookie,  //então, precisamos deles :)
    CURLOPT_FOLLOWLOCATION => 1, // não quero explicar, mas é importante. pesquisa ae depois ;)
    CURLOPT_RETURNTRANSFER => 1, // quer ver os dados? então sempre ative esta opção no seu script
    CURLOPT_HEADER => 0, // sem header
  ));

  $result = curl_exec($ch);
  curl_close($ch);
  return $result;
}

function parseTable($html)
{
  // Find the table
  preg_match("/<table.*?>.*?<\/[\s]*table>/s", $html, $table_html);

  // Iterate each row
  preg_match_all("/<tr.*?>(.*?)<\/[\s]*tr>/s", $table_html[0], $matches);

  $result = array();

  foreach ($matches[1] as $k => $line) {
    preg_match_all('#<td[^>]*>(.*?)</td>#is', $line, $cell);

    foreach ($cell[1] as $cel) {
        $result[$k][] = utf8_encode(trim($cel));
    }
  }
  return $result;
}
?>
