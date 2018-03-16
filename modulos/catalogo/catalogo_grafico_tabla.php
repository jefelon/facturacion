<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../catalogo/cCatalogo.php");
$oCatalogo = new cCatalogo();

$igv_dato=0.18;

require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();

require_once ("../formatos/formato.php");

if(isset($_POST['pro_cat']) and $_POST['pro_cat']>0)
{
	$dc=$_POST['pro_cat'].'';
	
	$dts2=$oCategoria->mostrar_por_idp($_POST['pro_cat']);
	$num_rows2= mysql_num_rows($dts2);
	if($num_rows2>0){
		while($dt2 = mysql_fetch_array($dts2)){
			
			$dc.=', '.$dt2['tb_categoria_id'];
			
			$dts3=$oCategoria->mostrar_por_idp($dt2['tb_categoria_id']);
			$num_rows3= mysql_num_rows($dts3);
			if($num_rows3>0){
				while($dt3 = mysql_fetch_array($dts3)){
					$dc.=', '.$dt3['tb_categoria_id'];			
				}
			mysql_free_result($dts3);
			}//fin nivel 3
					
		}
	mysql_free_result($dts2);
	}//fin nivel 2

//echo $dc;			
}
$dts1=$oCatalogo->catalogo_compra_filtro($_POST['pro_nom'],$_POST['pro_cod'],$dc,$_POST['pro_mar'],$_POST['pro_est'],$_POST['limit']);
$num_rows= mysql_num_rows($dts1);
?>
<script type="text/javascript">

$('.btn_agregar').button({	
	text: true
});

$(function() {		
	$("#tabla_producto").tablesorter({
		widgets: ['zebra', 'zebraHover'] ,
		widthFixed: true,
		headers: {
			2: { sorter: false}
			},
		//sortForce: [[0,0]],
		<?php if($num_rows>0){?>
		sortList: [[0,0]]
		<?php }?>
    });
}); 
</script>
        <table cellspacing="1" id="tabla_producto" class="tablesorter">
            <thead>
                <tr>
                  <!--<th>CODIGO</th>-->
                  <th>NOMBRE</th>                    
                    <th align="right" nowrap>PRECIO S/.</th>                   
                  <th width="50">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){?>
                        <tr>
                          <!--<td><?php //echo $dt1['tb_presentacion_cod']?></td>-->
                          <td><?php echo $dt1['tb_producto_nom']?></td>                            
                            <td align="right">
                            <span style="font-weight: bold;">
							<?php echo $dt1['tb_catalogo_preven']?>
                            </span>                           
                            <input name="txt_cat_preven_<?php echo $dt1['tb_catalogo_id']?>" type="hidden" id="txt_cat_preven_<?php echo $dt1['tb_catalogo_id']?>" value="<?php echo $dt1['tb_catalogo_preven']?>">
                    </td>                            
                            
                         
                           <td> 
                            <a class="btn_agregar" href="#sel" onClick="ver_grafico(<?php echo $dt1['tb_catalogo_id']?>)">Seleccionar</a>
                           
                            </td>
                        </tr>
                <?php
                	}
                mysql_free_result($dts1);
                ?>
                </tbody>
                <tr class="even">
                  <td colspan="3"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>
