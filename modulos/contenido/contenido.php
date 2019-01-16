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
		  <li><a href="../marca/">Marcas</a></li>
		  <li><a href="../unidad/">Unidades de Medida</a></li>
		  <li><a href="../producto/">Productos</a></li>
		  <li><a href="../servicio/">Servicios</a></li>
		  <li><a href="../transporte/">Transporte</a></li>
		  <li><a href="../conductor/">Condutor</a></li>
	    </ul>
	  </li>
	  <li class="topmenu"><span><a href="#" >Ventas</a></span>
	    <ul>
		  <li><a href="../puntoventa/">Puntos de Venta</a></li>
		  <li><a href="../horario/">Horarios</a></li>
		  <li><a href="../usuarios/usuario_vista_ven.php" >Vendedores</a></li>
		  <li><a href="../talonario/">Talonarios</a></li>
		  <li><a href="../talonarionc/">Talonario Nota Crédito</a></li>
		  <li><a href="../talonariond/">Talonario Nota Débito</a></li>
		  <li><a href="../clientes/">Clientes</a></li>
		  <li><a href="../tarjeta/">Tarjetas</a></li>
		  <li><a href="../cuentacorriente/">Cuenta Corriente</a></li>
	    </ul>
	  </li>
	  <li class="topmenu"><span><a href="#" >Compras</a></span>
	    <ul>
	  		<li><a href="../proveedor/">Proveedores</a></li>
	 		<li><a href="../almacen/">Almacenes</a></li>
	    </ul>
	  </li>
	  <li class="topmenu"><span><a href="#" >Caja</a></span>
	    <ul>
	  		<li><a href="../cuentas/">Cuentas - Caja General</a></li>
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
	  <li class="separator">_____________________</li>
	  <li><a href="../venta/venta_vista_adm.php">Ventas</a></li>
	  <li><a href="../venta/venta_vista.php">Registrar Venta</a></li>
	  <li><a href="../guia/guia_vista_adm.php">Guia</a></li>
	  <li class="separator">----------------------</li>
	  <li><a href="../notacredito/">Nota de Crédito</a></li>
	  <li class="separator">----------------------</li>
	  <li><a href="../notadebito/">Nota de Débito</a></li>
	  <li class="separator">----------------------</li>
	  <li><a href="../resumenboleta/">Resumen Diario de Boletas</a></li>
	  <li><a href="../comunicacionbaja/">Comunicación de Baja</a></li>
	  <li class="separator">----------------------</li>
	  <li><a href="../contingencia/">Resumen de Contingencia</a></li>
	  <li class="separator">----------------------</li>
	  <li><a href="../clientecuenta/">Estado de Cuenta Clientes</a></li>
	  <li><a href="../cuentasxcobrar/">Cuentas por Cobrar</a></li>
	  <li><a href="../cuentasxcobrar/pago_vista.php">Pagos Cuentas por Cobrar</a></li>
	  <li class="separator">_____________________</li>
	  <li><a href="../traspaso/">Traspaso</a></li>
	  <li class="separator">_____________________</li>
	  <li><a href="../notalmacen/">Nota de Almacén</a></li>
	  <li class="separator">_____________________</li>
	  <li><a href="../cotizacion/cotizacion_vista_adm.php">Cotizaciones</a></li>
	  <li><a href="../cotizacion/cotizacion_vista.php">Registrar Cotizaciones</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#" >Consultas</a>
  	<ul>
	  <li><a href="../catalogo/">Catálogo de Productos</a></li>
	  <li><a href="../kardex/">Kardex de Productos</a></li>
	  <li><a href="../historial/">Historial de Productos</a></li>
	  <li class="separator">_________________________</li>
	  <li><a href="../venta_cst/">Ventas - Artículos</a></li>
	  <li><a href="../venta/venta_vista_reparto.php">Venta Reparto</a></li>
	 <li><a href="../venta/venta_vista_garantia.php">Buscar Garantía</a></li>
	</ul>
  </li>
	<li class="topmenu"><a href="#" >Gráficos</a>
  	<ul>
        <li><a href="../grafico" >Volumen de ventas</a>
	</ul>
  </li>
  <li class="topmenu"><a href="#" >Caja</a>
  	<ul>
  	  <li class="separator">_________GENERAL________</li>
  	  <li><a href="../cajadetalle">Apertura y Cierre</a></li>

	  <li><a href="../ingreso/">Ingresos</a></li>
	  <li><a href="../egreso/">Egresos</a></li>
	  <li><a href="../transferencia/">Transferencias</a></li>
	  <li class="separator">---------------------</li>
	  <li><a href="../flujocaja/caja_vista.php">Consulta Caja</a></li>

	</ul>
  </li>
   <li class="topmenu"><a href="#">Contable</a>
	<ul>
      <li class="topmenu"><a href="../contable/contable_vista_ple.php">PLE - 5.1.0.0 (Actualizado el 01.03.2018)</a></li>
	  <li><a href="../contable/registro_compras.php">Contable1</a></li>
	  <li><a href="../contable/registro_compras.php">Contable2</a></li>
       <li><a href="../contable/contable_vista_registro.php">Informes Contables</a></li>
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
	  <li><a href="../traspaso/">Traspaso</a></li>
      <li class="separator">-----------------------</li>
	  <li><a href="../clientecuenta/">Estado de Cuenta Clientes</a></li>
	  <li><a href="../cuentasxcobrar/">Cuentas por Cobrar</a></li>
	  <li><a href="../cuentasxcobrar/pago_vista.php">Pagos Cuentas por Cobrar</a></li>
	  <li class="separator">-----------------------</li>
	  <li><a href="../venta/venta_vista_adm.php">Ventas General</a></li>
	  <li><a href="../ventanota/venta_vista_adm.php">Notas de Venta General</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#" >Consultas</a>
  	<ul>
	  <li><a href="../kardex/">Kardex de Productos</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#" >Caja</a>
  	<ul>
	  <li><a href="../ingreso/">Ingresos</a></li>
	  <li><a href="../egreso/">Egresos</a></li>
		<li><a href="../transferencia/">Transferencias</a></li>
	  <li class="separator">---------------------</li>
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
	  <li><a href="../compra/">Compras</a></li>
	  <li class="separator">_____________________</li>
	  <li><a href="../venta/">Registrar Venta</a></li>
	  <li><a href="../traspaso/">Transferencias</a></li>
		<li class="separator">-----------------------</li>
		<li><a href="../clientecuenta/">Estado de Cuenta Clientes</a></li>
		<li><a href="../cuentasxcobrar/pago_vista.php">Pagos Cuentas por Cobrar</a></li>
	  <li class="separator">-----------------------</li>
	  <li><a href="../venta/venta_vista_adm.php">Ventas General</a></li>
	  <li><a href="../ventanota/venta_vista_adm.php">Notas de Venta General</a></li>
	  <li class="separator">----------------------</li>
	  <li><a href="../resumenboleta/">Resumen Diario de Boletas</a></li>
	  <li><a href="../comunicacionbaja/">Comunicación de Baja</a></li>
	  <li class="separator">----------------------</li>
	  <li><a href="../contingencia/">Resumen de Contingencia</a></li>
	  <li class="separator">----------------------</li>
	  <li><a href="../notacredito/">Nota de Crédito</a></li>
	  <li class="separator">----------------------</li>
	  <li><a href="../notadebito/">Nota de Débito</a></li>
	  <li class="separator">------------------</li>
	  <li><a href="../documento/">Documento</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#" >Consultas</a>
  	<ul>
	  <li><a href="../catalogo/">Catálogo de Productos</a></li>
	  <li><a href="../kardex/">Kardex de Productos</a></li>
		<li class="separator">_________________________</li>
		<li><a href="../venta_cst/">Ventas - Artículos</a></li>
		<li><a href="../clientes/">Clientes</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#" >Caja</a>
  	<ul>
	  <li><a href="../ingreso/">Ingresos</a></li>
	  <li><a href="../egreso/">Egresos</a></li>
		<li><a href="../transferencia/">Transferencias</a></li>
	  <li class="separator">---------------------</li>
	  <li><a href="../flujocaja/caja_vista.php">Consulta Caja</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#">Opciones</a>
	<ul>
	  <li><a href="../usuarios/usuario_datos_vista.php">Modificar Mis Datos</a></li>
	  <li><a href="../horario/horario_vendedor.php">Horario</a></li>
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
        if($_SESSION['usuario_id']==8)$menu= $menu_contador;
        break;
  case 3:
        $menu= $menu_vendedor;
        //if($_SESSION['usuario_id']==8)$menu= $menu_contador;
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
		<a href="http://www.a-zetasoft.com" target="_blank">Sistema de Ventas. INTICAP www.a-zetasoft.com</a>
	</div>
	';
	return $footer;
}

}
?>