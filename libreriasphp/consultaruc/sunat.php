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
			$rtn1 = array();
			$rtn = array('Intente Nuevamente. Posible error con el Servidor Sunat');
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
				//$Page = str_replace("ñ", "n", $Page);
				$Page = str_replace("	", "", $Page);
				$Page = str_replace("<!--", "", $Page);
				$Page = str_replace("-->", "", $Page);
				$Page = utf8_encode($Page);
				$patron='/<input type="hidden" name="desRuc" value="(.*)">/';
				$output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
				if(isset($matches[0]))
				{
					//$RS = str_replace('"','', ($matches[0][1]));
					$rtn1 = array("RUC"=>$ruc,"RazonSocial"=>trim($matches[0][1]));
				}
				$busca=array(
					"Ruc" 					=> "N&uacute;mero de RUC",
					"RazonSocial"			=> "N&uacute;mero de RUC",
					"Tipo" 					=> "Tipo Contribuyente",
					"Inscripcion" 			=> "Fecha de Inscripci&oacute;n",
					"Estado" 				=> "Estado del Contribuyente",
					"Condicion" 			=> "Condici&oacute;n del Contribuyente",
					"Direccion" 			=> "Direcci&oacute;n del Domicilio Fiscal",
					"SistemaEmision" 		=> "Sistema de Emisi&oacute;n de Comprobante",
					"ActividadExterior"		=> "Actividad de Comercio Exterior",
					"SistemaContabilidad" 	=> "Sistema de Contabilidad",
					"Oficio" 				=> "Profesi&oacute;n u Oficio",
					//"ActividadEconomica" 	=> "Actividad\(es\) Econ&oacute;mica\(s\)",
					"EmisionElectronica" 	=> "Emisor electr&oacute;nico desde",
					"PLE" 					=> "Afiliado al PLE desde",
					"Telefonos"				=> "Tel&eacute;fono\(s\)"
				);

				$rtn = array();
				foreach($busca as $i=>$v)
				{
					$patron='/<td class="bgn" colspan=1>'.$v.':[ ]*<\/td>[ ]*\r\n[ ]*<td class="bg" colspan=[1|3]+>(.*)<\/td>/';
					$output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
					if(isset($matches[0]))
					{
						$rtn[$i] = trim(preg_replace( "[\s+]"," ", ($matches[0][1]) ) );
					}
				}
				//OBETENER REPRESENTANTE LEGAL
				$data = array(
					"nroRuc" => $ruc,
					"accion" => "getRepLeg",
					"desRuc" => ""
				);

				$url = "http://www.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias";
				$Page = $this->cc->post($url,$data);
				$patron='/<td class=bg align="left">[ ]*\r\n[ ]*(.*) [ ]*<\/td>/';
				$Page = str_replace("	", "", $Page);
				$Page = utf8_encode($Page);
				$output = preg_match_all($patron, $Page, $matches, PREG_SET_ORDER);
				if(isset($matches[0]))
				{
					$rtn['Contacto'] = trim(preg_replace( "[\s+]"," ", ($matches[0][1]) ) );
				}
				//FINALIZA OBETENER REPRESENTANTE LEGAL
				if(isset($rtn1['RUC'])){
					$rtn['Ruc'] = $rtn1['RUC'];
				}
				if(isset($rtn1['RazonSocial'])){
					$rtn['RazonSocial'] = $rtn1['RazonSocial'];
				}
			}
			if(empty($rtn)){
				$rtn = array('No registrado en la Sunat');
			}
			return $rtn;
		}
	}
?>
