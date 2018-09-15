<tr>
    <input type="hidden" name="hdd_com_prov_id[]" value="<?php echo $_POST['hdd_com_prov_id']?>" >
    <td><input type="text"  size="20" name="proveedor[]" value="<?php echo $_POST['txt_com_prov_nom']?>" readonly/></td>
    <td><input type="text"  size="10" name="catmin[]" value="<?php echo $_POST['txt_cat_min']?>" readonly /></td>
    <td><input type="text"  size="10" name="desc[]" value="<?php echo $_POST['txt_desc_prov']?>" readonly /></td>
    <td><input type="text"  size="10" name="desde[]" value="<?php echo $_POST['txt_fecha_ini']?>" readonly /></td>
    <td><input type="text"  size="10" name="hasta[]" value="<?php echo $_POST['txt_fecha_fin']?>" readonly /></td>
    <td><a class="btn_eliminar" onClick="eliminar_fila_producto_proveedor($(this))"> Eliminar Proveedor</a></td>
</tr>