DELETE FROM `tb_venta`;
DELETE FROM `tb_ventadetalle`;
DELETE FROM `tb_ventapago`;
DELETE FROM `tb_clientecuenta`;
DELETE FROM `tb_ingreso`;
DELETE FROM `tb_cotizaciondetalle`;
DELETE FROM `tb_cotizacion`;
DELETE FROM `tb_resumenboletadetalle`;
DELETE FROM `tb_compradetalle`;
DELETE FROM `tb_compra`;
DELETE FROM `tb_notalmacendetalle`;
DELETE FROM `tb_notalmacen`;
DELETE FROM `tb_resumenboleta`;
DELETE FROM `tb_proveedor`;
DELETE FROM `tb_egreso`;
DELETE FROM `tb_preciodetalle`;
DELETE FROM `tb_notacredito`;
DELETE FROM `tb_notacreditodetalle`;
DELETE FROM `tb_notadebito`;
DELETE FROM `tb_notadebitodetalle`;
DELETE FROM `tb_combaja`;
DELETE FROM `tb_combajadetalle`;
DELETE FROM `tb_traspaso`;
DELETE FROM `tb_traspasodetalle`;
DELETE FROM `tb_servicio`;
DELETE FROM `tb_presentacion`;
DELETE FROM `tb_producto`;
DELETE FROM `tb_catalogo`;
DELETE FROM `tb_stock`;
DELETE FROM `tb_kardex`;
DELETE FROM `tb_kardexdetalle`;
DELETE FROM `tb_cliente`;
DELETE FROM `tb_guia`;
DELETE FROM `tb_guiadetalle`;	
DELETE FROM `tb_guiapagonota`;
DELETE FROM `tb_combaja`;
DELETE FROM `tb_combajadetalle`;
DELETE FROM `tb_productoproveedor`;
DELETE FROM `tb_lote`;
DELETE FROM `tb_compradetalle_lote`;
DELETE FROM `tb_ventadetalle_lote`;
DELETE FROM `tb_letras`;
DELETE FROM `tb_detallelistaprecio`;
DELETE FROM `tb_tipocambio`;
DELETE FROM `tb_cajadetalle`;
DELETE FROM `tb_talonarionc`;
DELETE FROM `tb_talonariond`;
DELETE FROM `tb_compracosto`;
UPDATE `tb_caja` SET `tb_caja_estado` = '0' ;