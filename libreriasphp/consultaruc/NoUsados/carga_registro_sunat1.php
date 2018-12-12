<?php
//require_once('../initialize.php');
$vurl = "http://www.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias";
$vruc = $_POST['vruc'];
$vletras = $_POST['vletras'];

$html = recibe_registro_sunat($vurl, $vruc, $vletras);
var_dump($html);
exit();
if($html == false){
  $html = recibe_registro_sunat("http://ww1.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias", $vruc, $vletras);
}

if($html == false){
  return 0;
}else{
  if (preg_match("/<title>.:: Pagina.*<\/title>/siU", $html)){
    return 0;
  }else{
    return parseTable($html);
  }
}

function recibe_registro_sunat($vurl, $vruc, $vletras) {
  // Pega os valores dos campos que foram enviados pelo formulário
  // *sem validação mesmo, é só pra exemplo tá?


  #Coisas importantes para dizer ao $ch logo mais

  //IMPORTANTE que o caminho esteja correto e tenha permissão CHMOD 777
  $cookie = $_SERVER['DOCUMENT_ROOT'].'/sunat/receita.txt';

  // não sei.. coloquei pra garantir
  $reffer = "http://google.com";

  //sempre é bom ter para garantir a entrada do seu serviço
  $agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";

  //url da receita que valida o formulário

  //dados do POST do formulário da receita.
  //** Muito importante entender os formulários que você esteja trabalhando **
  //os campos NESTA EXATA ordem funcionaram legal ;)
  $post_fields = "accion=consPorRuc&nroRuc={$vruc}&codigo={$vletras}";

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
    CURLOPT_HEADER => 0 // sem header
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

  $atable = array();

  foreach ($matches[1] as $k => $line) {
    preg_match_all('#<td[^>]*>(.*?)</td>#is', $line, $cell);

    foreach ($cell[1] as $cell) {
        $atable[$k][] = trim($cell);
    }
  }
  return $atable;
}
?>
