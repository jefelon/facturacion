<?php
class cEncarte{
	function verificar_catalogo_encarte($cat_id,$enc_est){
	$sql="SELECT tb_encartedetalle_despor, tb_encartedetalle_preven2 
	FROM tb_catalogo ct
	INNER JOIN tb_encartedetalle ed ON ct.tb_catalogo_id = ed.tb_catalogo_id
	INNER JOIN tb_encarte e ON ed.tb_encarte_id = e.tb_encarte_id
	WHERE ct.tb_catalogo_id=$cat_id 
	and e.tb_encarte_est='$enc_est'; ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>