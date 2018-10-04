<tr>
    <input type="hidden" name="hdd_com_prov_id[]" value="<?php echo $_POST['hdd_com_prov_id']?>" >
    <td><input type="text"  size="20" name="lote_num[]" value="<?php echo $_POST['txt_lote_num']?>" readonly/></td>
    <td><input type="text"  size="10" name="lote_fecfab[]" value="<?php echo $_POST['txt_lote_fecfab']?>" readonly /></td>
    <td><input type="text"  size="10" name="lote_fecven[]" value="<?php echo $_POST['txt_lote_fecven']?>" readonly /></td>
    <td><input type="text"  size="10" name="sto_num[]" value="<?php echo $_POST['txt_lote_sto_num']?>" readonly /></td>
    <td><a class="btn_eliminar" onClick="eliminar_fila_producto_proveedor($(this))"> Eliminar Proveedor</a></td>
</tr>