<?php 
session_start();
require_once ("Cado.php");	
require_once ("Clases/cKardex.php");	
$oKardex = new cKardex();
$rs = $oKardex->mostrar_datos_producto($_POST['cat_id']);	
$num_rows = mysql_num_rows($rs);
?>
<fieldset>
	<legend>DETALLE KARDEX POR ALMACEN</legend><?php
	if($num_rows > 0){
		while($dt = mysql_fetch_array($rs)){			
			$alm = $dt['tb_almacen_nom'];//establecimiento			
			$cod = $dt['tb_presentacion_cod'];//codigo de la existencia			
			$cat = $dt['tb_categoria_nom'];//tipo
			$nom = $dt['tb_producto_nom'];//descripcion
			$precos = $dt['tb_catalogo_precos'];//descripcion
		}	
	}				
	?>
<input type="hidden" name="hdd_cat_sel_id" id="hdd_cat_sel_id" value="<?php echo $_POST['cat_id']?>" />
    <table>
    <?php /*?>
    	<tr>
        	<td align="right"><strong>RUC:</strong></td>
            <td><?php echo $_SESSION['empresa_ruc']?>
            </td>
        </tr><?php */?>
        
        <tr>
        	<td align="right"><strong>RAZÓN SOCIAL:</strong></td>
            <td><?php echo $_SESSION['empresa_nombre']?></td>
        </tr>
        
        <tr>
        	<td align="right"><strong>Establecimiento:</strong></td>
            <td><?php echo $alm?></td>
        </tr>
        
        <tr>
        	<td align="right"><strong>Código de la Existencia:</strong></td>
            <td><?php echo $cod?></td>
        </tr>
        
        <tr>
        	<td align="right"><strong>Tipo:</strong></td>
            <td><?php echo $cat?></td>
        </tr>
        
        <tr>
        	<td align="right"><strong>Descripción:</strong></td>
            <td><?php echo $nom?></td>
        </tr>
        <?php /*?>
        <tr>
        	<td align="right"><strong>Método de Valuación:</strong></td>
            <td>Promedio</td>
        </tr><?php */?>
    </table>
</fieldset>