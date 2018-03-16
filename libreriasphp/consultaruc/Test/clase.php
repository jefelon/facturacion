<?php
	class Sunat{
		var $cc;  //Class cUrl
		var $path;
		function __construct()
		{
			$this->path = dirname(__FILE__);
			$this->cc = new cURL(true,'http://www.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias',$this->path.'/cookies.txt');
		}

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


		function ProcesaNumRand()
		{
			$data = array(
				"accion"=>"random"
			);
			$url="http://www.sunat.gob.pe/cl-ti-itmrconsruc/captcha";
			$numRand = $this->cc->post($url,$data);
			return $numRand;
		}

		function BuscaDatosSunat($ruc)
		{
			$captcha = $this->ProcesaNumRand();
			if($ruc != "" && $captcha!=false)
			{
				$data = array(
					//"accion" => "consPorTipdoc",
					//"tipdoc" =>1, //DNI
					"nroRuc" => $ruc,
					"accion" => "consPorRuc",
					"numRnd" => $captcha
				);

				$url = "http://www.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias";
				$Page = $this->cc->post($url,$data);	
				return $Page;
			}
		}
	}
?>
