<?php 
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
class cContenido{
	
function print_menu()
{
$menu_superusuario=
'
<ul id="menu1" class="topmenu">
  <li class="topfirst"><a href="../super/">Principal</a></li>
  <li class="topmenu"><a href="#" >Usuarios</a>
	<ul>
	  <li><a href="../usuarios/usuario_vista_sup.php" >Super Usuario</a></li>
	  <li><a href="../usuarios/usuario_vista_adm.php" >Administrador</a></li>
	  <li><a href="usuario_vista_eje.php" >Ejecutor</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#">Mantenimiento</a>
	<ul>
	  <li><a href="empresa_vista.php">Empresa</a></li>
	  <li><a href="ubigeo_vista.php">Ubigeo</a></li>
	  <li><a href="usuarioGrupo_vista.php">Grupo de Usuarios</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#">Opciones</a>
	<ul>
	  <li><a href="usuario_datos_vista.php">Modificar Mis Datos</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="../soporte/">Soporte</a>
  </li>
</ul>
';	

$menu_administrador=
'
<ul id="menu1" class="topmenu">
  <li class="topfirst"><a href="../administrador/">Principal</a></li>
  <li class="topmenu"><a href="#">Mantenimiento</a>
	<ul>
	  <li class="topmenu"><span><a href="#" >General</a></span>
	    <ul>
		  <li><a href="../documento/">Tipos de Documento</a></li>
		  <li><a href="../talonario/talonariointerno_vista.php">Talonario Interno</a></li>
		  <li><a href="../tipocambio/">Tipos de Cambio</a></li>
		  <li><a href="../formula/">Fórmulas</a></li>
		  <li><a href="../form/">Formularios</a></li>
		  <li><a href="../tipoperacion/">Tipos de Operación</a></li>
	    </ul>
	  </li>
	  <li class="topmenu"><span><a href="#" >Catálogo</a></span>
	    <ul>
		  <li><a href="../categoria/">Categorías</a></li>
		  <li><a href="../atributo/">Atributos</a></li>
		  <li><a href="../marca/">Marcas</a></li>
		  <li><a href="../unidad/">Unidades de Medida</a></li>
		  <li><a href="../producto/">Productos</a></li>
		  <li><a href="../servicio/" >Servicios</a></li>
	    </ul>
	  </li>
	  <li class="topmenu"><span><a href="#" >Compras</a></span>
	    <ul>
	  		<li><a href="../proveedor/">Proveedores</a></li>
	 		<li><a href="../almacen/">Almacenes</a></li>
	    </ul>
	  </li>
	  <li class="topmenu"><span><a href="#" >Ventas</a></span>
	    <ul>
		  <li><a href="../puntoventa/">Puntos de Venta</a></li>
		  <li><a href="../horario/">Horarios</a></li>
		  <li><a href="../usuarios/usuario_vista_ven.php" >Vendedores</a></li>
		  <li><a href="../talonario/">Talonarios</a></li>
		  <li><a href="../clientes/">Clientes</a></li>
		  <li><a href="../tarjeta/">Tarjetas</a></li>
		  <li><a href="../cuentacorriente/">Cuenta Corriente</a></li>
	    </ul>
	  </li>
	  <li class="topmenu"><span><a href="#" >Caja</a></span>
	    <ul>
	  		<li><a href="../cuentas/">Cuentas - Caja General</a></li>
			<li><a href="../cuentas_r/">Cuentas - Caja Terceros</a></li>
			<li><a href="../entfinanciera/">Ent. Financiera</a></li>
	    </ul>
	  </li>
	  <li class="topmenu"><span><a href="#" >Configuración</a></span>
	    <ul>
		  <li><a href="../empresa/">Empresa</a></li>
		  <li><a href="../usuarios/usuario_vista_adm.php" >Administrador</a></li>
		</ul>
	  </li>
	</ul>
  </li>
  <li class="topmenu"><a href="#" >Operaciones</a>
	<ul>
	  <li><a href="../compra/">Compras</a></li>
	  <li>_____________________</li>
	  <li><a href="../venta/venta_vista_adm.php">Ventas</a></li>
	  <li><a href="../venta/venta_vista.php">Registrar Venta</a></li>
	  <li>---------------------</li>
		<li><a href="../clientecuenta/">Estado de Cuenta Clientes</a></li>
		<li><a href="../cuentasxcobrar/">Cuentas por Cobrar</a></li>
		<li><a href="../cuentasxcobrar/pago_vista.php">Pagos Cuentas por Cobrar</a></li>
	  <li>---------------------</li>
	  <li><a href="../ventanota/venta_vista_adm.php">Notas de Venta</a></li>
	  <li><a href="../ventanota/venta_vista.php">Registrar Nota de Venta</a></li>
	  <li><a href="../ventacanje/">Nota de Venta - Canjeados</a></li>
	  <li>_____________________</li>
	  <li><a href="../traspaso/">Transferencias</a></li>
	  <li>_____________________</li>
	  <li><a href="../notalmacen/">Nota de Almacén</a></li>
		<li>_____________________</li>
	  <li><a href="../encarte/">Encarte</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#" >Consultas</a>
  	<ul>
	  <li><a href="../catalogo/">Catálogo de Productos</a></li>
	  <li><a href="../kardex/kardex_vista.php">Kardex de Productos</a></li>
	  <li><a href="../kardex/producto_historial_vista.php">Historial de Productos</a></li>
		<li>_________________________</li>
		<li><a href="../venta_cst/">Ventas - Artículos</a></li>
		<li><a href="../ventanota_cst/">Notas de Venta - Artículos</a></li>
		<li><a href="../clientes/">Clientes</a></li>
		<li>_________________________</li>
		<li><a href="../proveedor/">Proveedores</a></li>
	</ul>
  </li>
	<li class="topmenu"><a href="#" >Gráficos</a>
  	<ul>
	  <li><a href="../grafico/grafico_venta_vista.php">Volumen de ventas</a></li>
		<li><a href="../grafico/grafico_producto_vista.php">Productos</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#" >Caja</a>
  	<ul>
	<li>_________GENERAL________</li>
	  <li><a href="../ingreso/">Ingresos</a></li>
	  <li><a href="../gasto/">Gastos</a></li>
	  <li><a href="../transferencia/">Transferencias</a></li>
	  <li><a href="../transferencia_r/">Transferencias a Terceros</a></li>
	  <li>---------------------</li>
	  <li><a href="../flujocaja/caja_vista.php">Consulta Caja</a></li>
	  <li><a href="../flujocaja/">Flujo Caja</a></li>
	  <li>_________________________</li>
	  <li>________TERCEROS_______</li>
	  <li><a href="../ingreso_r/">Ingresos</a></li>
	  <li><a href="../gasto_r/">Gastos</a></li>
	  <li>---------------------</li>
	  <li><a href="../cuentasxpagar/">Cuentas por Pagar</a></li>
	  <li>---------------------</li>
	  <li><a href="../flujocaja_r/caja_vista.php">Consulta Caja</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#">Opciones</a>
	<ul>
	  <li><a href="../usuarios/usuario_datos_vista.php">Modificar Mis Datos</a></li>
	  <li><a href="../puntoventa/puntoventa_seleccionar.php">Seleccionar Empresa | Punto de Venta</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="../soporte/">Soporte</a>
  </li>
</ul>
';

$menu_vendedor=
'
<ul id="menu1" class="topmenu">
  <li class="topfirst"><a href="../vendedor/">Principal</a></li>
  <li class="topmenu"><a href="#" >Operaciones</a>
	<ul>
	  <li><a href="../venta/">Registrar Venta</a></li>
	  <li><a href="../ventanota/">Registrar Nota de Venta</a></li>
	  <li><a href="../traspaso/">Transferencias</a></li>
		<li>-----------------------</li>
		<li><a href="../clientecuenta/">Estado de Cuenta Clientes</a></li>
		<li><a href="../cuentasxcobrar/">Cuentas por Cobrar</a></li>
		<li><a href="../cuentasxcobrar/pago_vista.php">Pagos Cuentas por Cobrar</a></li>
	  <li>-----------------------</li>
	  <li><a href="../venta/venta_vista_adm.php">Ventas General</a></li>
	  <li><a href="../ventanota/venta_vista_adm.php">Notas de Venta General</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#" >Consultas</a>
  	<ul>
		<li><a href="../venta_cst/">Ventas - Artículos</a></li>
		<li><a href="../clientes/">Clientes</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#" >Caja</a>
  	<ul>
	  <li><a href="../ingreso/">Ingresos</a></li>
	  <li><a href="../gasto/">Gastos</a></li>
		<li><a href="../transferencia/">Transferencias</a></li>
	  <li>---------------------</li>
	  <li><a href="../flujocaja/caja_vista.php">Consulta Caja</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#">Opciones</a>
	<ul>
	  <li><a href="../usuarios/usuario_datos_vista.php">Modificar Mis Datos</a></li>
	  <li><a href="../horario/horario_vendedor.php">Horario</a></li>
	  <li><a href="../puntoventa/puntoventa_seleccionar.php">Seleccionar Punto de Venta</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="../soporte/">Soporte</a>
  </li>
</ul>
';

$menu_contador=
'
<ul id="menu1" class="topmenu">
  <li class="topfirst"><a href="../vendedor/">Principal</a></li>
  <li class="topmenu"><a href="#" >Operaciones</a>
	<ul>
	  <li><a href="../venta/">Registrar Venta</a></li>
	  <li><a href="../ventanota/">Registrar Nota de Venta</a></li>
	  <li><a href="../traspaso/">Transferencias</a></li>
		<li>-----------------------</li>
		<li><a href="../clientecuenta/">Estado de Cuenta Clientes</a></li>
		<li><a href="../cuentasxcobrar/pago_vista.php">Pagos Cuentas por Cobrar</a></li>
	  <li>-----------------------</li>
	  <li><a href="../venta/venta_vista_adm.php">Ventas General</a></li>
	  <li><a href="../ventanota/venta_vista_adm.php">Notas de Venta General</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#" >Consultas</a>
  	<ul>
  		<li><a href="../catalogo/">Catálogo de Productos</a></li>
	 	<li><a href="../kardex/kardex_vista.php">Kardex de Productos</a></li>
		<li><a href="../kardex/producto_historial_vista.php">Historial de Productos</a></li>
		<li>_________________________</li>
		<li><a href="../venta_cst/">Ventas - Artículos</a></li>
		<li><a href="../clientes/">Clientes</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#" >Caja</a>
  	<ul>
	  <li><a href="../ingreso/">Ingresos</a></li>
	  <li><a href="../gasto/">Gastos</a></li>
		<li><a href="../transferencia/">Transferencias</a></li>
	  <li>---------------------</li>
	  <li><a href="../flujocaja/caja_vista.php">Consulta Caja</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#">Opciones</a>
	<ul>
	  <li><a href="../usuarios/usuario_datos_vista.php">Modificar Mis Datos</a></li>
	  <li><a href="../horario/horario_vendedor.php">Horario</a></li>
	  <li><a href="../puntoventa/puntoventa_seleccionar.php">Seleccionar Punto de Venta</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="../soporte/">Soporte</a>
  </li>
</ul>
';

$menu_ejecutor=
'
<ul id="menu1" class="topmenu">
  <li class="topfirst"><a href="../ejecutor/">Principal</a></li>
  <li class="topmenu"><a href="#">Mantenimiento</a>
	<ul>
	  <li class="topmenu"><span><a href="#" >Caja</a></span>
	    <ul>
			<li><a href="../cuentas_r/">Cuentas - Caja Terceros</a></li>
			<li><a href="../entfinanciera/">Ent. Financiera</a></li>
	    </ul>
	  </li>
	</ul>
  </li>
  <li class="topmenu"><a href="#" >Caja</a>
  	<ul>
		<li>_________GENERAL________</li>
	  <li><a href="../ingreso/ingreso_vista_ejec.php">Ingresos</a></li>
	  <li><a href="../gasto/gasto_vista_ejec.php">Gastos</a></li>
	  <li>________TERCEROS_______</li>
	  <li><a href="../ingreso_r/">Ingresos</a></li>
	  <li><a href="../gasto_r/">Gastos</a></li>
	  <li>---------------------</li>
	  <li><a href="../cuentasxpagar/">Cuentas por Pagar</a></li>
	  <li>---------------------</li>
	  <li><a href="../flujocaja_r/caja_vista.php">Consulta Caja</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#">Opciones</a>
	<ul>
	  <li><a href="../usuarios/usuario_datos_vista.php">Modificar Mis Datos</a></li>
		<li><a href="../puntoventa/puntoventa_seleccionar.php">Seleccionar Empresa | Punto de Venta</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="../soporte/">Soporte</a>
  </li>
</ul>
';

switch ($_SESSION['usuariogrupo_id']) {
    case 1:
        $menu=$menu_superusuario;
        break;
	case 2:
        $menu= $menu_administrador;
        break;
  case 3:
        $menu= $menu_vendedor;
        if($_SESSION['usuario_id']==8)$menu= $menu_contador;
        break;
	case 4:
        $menu= $menu_ejecutor;
        break;
	/*default:
       	echo $menu_ejecutor;*/
	}
	
	return $menu;
}

function print_header()
{
	if($_SESSION["puntoventa_nom"]!="")$pv=" | ".$_SESSION["puntoventa_nom"];
$header=
	'
	<div class="menu_user">
	  <table class="tabla_menu_user">
		<tr class="datos_menu_user">
		  <td align="left">
			<img src="../../images/iconos/male_user.png" alt="usuario" width="14" height="14" border="0" align="top" />
				'.$_SESSION["usuario_nombre"].'
		  </td>
		  <td width="250" align="right">
			<img src="../../images/iconos/turquoise_button.png" alt="admin" width="14" height="14" border="0" align="top" />
				'.$_SESSION["usuariogrupo_nombre"].$pv.'
		  </td>
		  <td width="90" align="right" valign="middle">
		  <img src="../../images/iconos/shut_down.png" alt="Cerrar Sesion" width="14" height="14" border="0" align="top" />
			<a href="../usuarios/cerrar_sesion.php" title="Cerrar Sesión" tabindex="9999">FINALIZAR</a>
		  </td>
		</tr>
		<tr>
		  <td height="14" colspan="3" align="left" valign="middle">
			<div id="divmenu"> 
				'.$this->print_menu().'
			</div>
		  </td>
		</tr>
	  </table>
	</div>
	';
	return $header;
}

function print_footer()
{	
$footer=
	'
	';
	return $footer;
}
function print_footer2()
{	
$footer=
	'
    <div align="center">
		<a href="http://www.inticap.com" target="_blank">Sistema de Ventas. INTICAP www.inticap.com</a>
	</div>
	';
	return $footer;
}

}
?>