<?php 
function printmenu()
{

$menu_superusuario=
'
<ul id="menu1" class="topmenu">
  <li class="topfirst"><a href="inicioAdmin.php">Principal</a></li>
  <li class="topmenu"><a href="#" >Operaciones</a>
	<ul>
	  <li><a href="vIngresos.php">Ingresos</a></li>
	  <li><a href="vGastos.php">Gastos</a></li>
	  <li>----------------</li>
	  <li><a href="vFacturas.php">Facturación</a></li>
	  <li>----------------</li>
	  <li><a href="vCompras.php">Orden de Compras</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="vFlujo.php" >Flujo de Gastos</a>
  	<ul>
	  <li><a href="vFlujo.php">Vista General</a></li>
	  <li><a href="vFlujoC.php">Vista Filtro</a></li>
	  <li><a href="vFacingresos.php">Ingresos por Facturas</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#">Personal</a>
	<ul>
	  <li><a href="frmPersonal.php?action=insertar">Agregar Personal</a></li>
	  <li><a href="vPersonal.php">Lista de Personal</a></li>
	  <li><a href="vPersonalD.php">Lista Detallada de Personal</a></li>
	  <li><a href="vBoletas.php">Lista Boletas</a></li>
	  <li><a href="vPlanilla.php">Ver Planilla</a></li>
	  <li><a href="vCts.php">Ver Cts</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#">Mantenimiento</a>
	<ul>
	  <li><a href="manCliente.php">Cliente</a></li>
	  <li><a href="manContratacion.php">Contratación</a></li>
	  <li><a href="#"><span>Cuentas</span></a>
	  	<ul>
		  <li><a href="manCuentas.php">Cuentas</a></li>
		  <li><a href="manCuentas_r.php">Cuentas Sustentación Caja</a></li>
		</ul>
	  </li>
	  <li><a href="manDestino.php">Destino</a></li>
	  <li><a href="manEmpresa.php">Empresa</a></li>
	  <li><a href="manEntfinanciera.php">Ent. Financiera</a></li>
	  <li><a href="#"><span>Formularios</span></a>
	  	<ul>
		  <li><a href="manForm.php?form=Compras">Compras</a></li>
		  <li><a href="manForm.php?form=Facturas">Facturas</a></li>
		  <li><a href="manForm.php?form=Gastos">Gastos</a></li>	
		  <li><a href="manForm.php?form=Gastos-R">Gastos-R</a></li>		  
		  <li><a href="manForm.php?form=Ingresos">Ingresos</a></li>
		  <li><a href="manForm.php?form=Ingresos-R">Ingresos-R</a></li>
		  <li><a href="manForm.php?form=Personal">Personal</a></li>
		  <li><a href="manForm.php?form=Prestamos">Prestamos</a></li>
		</ul>
	  </li>
	  <li><a href="#"><span>Formulas</span></a>
	  	<ul>
		  <li><a href="manFormula.php?ele=Personal">Personal</a></li>
		</ul>
	  </li>
	  <li><a href="manUsergrupo.php">Grupo de Usuarios</a></li>
	  <li><a href="manLocalidad.php">Localidad</a></li>
	  <li><a href="manOcupacion.php">Ocupación</a></li>
	  <li><a href="manProveedor.php">Proveedor</a></li>
	  <li><a href="manSispensiones.php">Sis. Pensiones</a></li>
	  <li><a href="manTaller.php">Taller</a></li>
	  <li><a href="manUbicacion.php">Ubicación</a></li>
	  <li><a href="manZona.php">Zona</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#" >Usuarios</a>
	<ul>
	  <li><a href="fiUser.php">Agregar Usuario</a></li>
	  <li><a href="vUsers.php" >Lista de Usuarios</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#">Opciones</a>
	<ul>
	  <li><a href="faUser.php?vista=1&amp;action=editar&amp;id_user='.$_SESSION['user_id'].'">Modificar Mis Datos</a></li>
	  <li><a href="faUserCla.php">Cambiar Contraseña</a></li>
	  <li><a href="frmSelempresa.php">Seleccionar Empresa</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="vSoporte.php">Ayuda</a>
  </li>
</ul>
';	

$menu_administrador=
'
<ul id="menu1" class="topmenu">
  <li class="topfirst"><a href="inicioAdmin.php">Principal</a></li>
  <li class="topmenu"><a href="#" >Operaciones</a>
	<ul>
	  <li><a href="vIngresos.php">Ingresos</a></li>
	  <li><a href="vGastos.php">Gastos</a></li>
	  <li>----------------</li>
	  <li><a href="vFacturas.php">Facturación</a></li>
	  <li>----------------</li>
	  <li><a href="vCompras.php">Orden de Compras</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="vFlujo.php" >Flujo de Gastos</a>
  	<ul>
	  <li><a href="vFlujo.php">Vista General</a></li>
	  <li><a href="vFlujoC.php">Vista Filtro</a></li>
	  <li><a href="vFacingresos.php">Ingresos por Facturas</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#" >Sustentación caja</a>
	<ul>
	  <li><a href="vIngresos_ra.php">Ingresos</a></li>
	  <li><a href="vGastos_ra.php">Gastos</a></li>
	  <li><a href="vSuscaja_ca.php">Cargar</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#">Personal</a>
	<ul>
	  <li><a href="frmPersonal.php?action=insertar">Agregar Personal</a></li>
	  <li><a href="vPersonal.php">Lista de Personal</a></li>
	  <li><a href="vPersonalD.php">Lista Detallada de Personal</a></li>
	  <li><a href="vBoletas.php">Lista Boletas</a></li>
	  <li><a href="vPlanilla.php">Ver Planilla</a></li>
	  <li><a href="vCts.php">Ver Cts</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#">Mantenimiento</a>
	<ul>
	  <li><a href="manCliente.php">Cliente</a></li>
	  <li><a href="manContratacion.php">Contratación</a></li>
	  <li><a href="#"><span>Cuentas</span></a>
	  	<ul>
		  <li><a href="manCuentas.php">Cuentas</a></li>
		  <li><a href="manCuentas_r.php">Cuentas Sustentación Caja</a></li>
		</ul>
	  </li>
	  <li><a href="manDestino.php">Destino</a></li>
	  <li><a href="manEmpresa.php">Empresa</a></li>
	  <li><a href="manEntfinanciera.php">Ent. Financiera</a></li>
	  <li><a href="#"><span>Formularios</span></a>
	  	<ul>
		  <li><a href="manForm.php?form=Compras">Compras</a></li>
		  <li><a href="manForm.php?form=Facturas">Facturas</a></li>
		  <li><a href="manForm.php?form=Gastos">Gastos</a></li>	
		  <li><a href="manForm.php?form=Gastos-R">Gastos-R</a></li>		  
		  <li><a href="manForm.php?form=Ingresos">Ingresos</a></li>
		  <li><a href="manForm.php?form=Ingresos-R">Ingresos-R</a></li>
		  <li><a href="manForm.php?form=Personal">Personal</a></li>
		  <li><a href="manForm.php?form=Prestamos">Prestamos</a></li>
		</ul>
	  </li>
	  <li><a href="#"><span>Formulas</span></a>
	  	<ul>
		  <li><a href="manFormula.php?ele=Personal">Personal</a></li>
		</ul>
	  </li>
	  <li><a href="manLocalidad.php">Localidad</a></li>
	  <li><a href="manOcupacion.php">Ocupación</a></li>
	  <li><a href="manProveedor.php">Proveedor</a></li>
	  <li><a href="manSispensiones.php">Sis. Pensiones</a></li>
	  <li><a href="manTaller.php">Taller</a></li>
	  <li><a href="manUbicacion.php">Ubicación</a></li>
	  <li><a href="manZona.php">Zona</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#" >Usuarios</a>
	<ul>
	  <li><a href="fiUser.php">Agregar Usuario</a></li>
	  <li><a href="vUsers.php" >Lista de Usuarios</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#">Opciones</a>
	<ul>
	  <li><a href="faUser.php?vista=1&amp;action=editar&amp;id_user='.$_SESSION['user_id'].'">Modificar Mis Datos</a></li>
	  <li><a href="faUserCla.php">Cambiar Contraseña</a></li>
	  <li><a href="frmSelempresa.php">Seleccionar Empresa</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="vSoporte.php">Ayuda</a>
  </li>
</ul>
';

$menu_ejecutor=
'
<ul id="menu1" class="topmenu">
  <li class="topfirst"><a href="inicioEjec.php">Principal</a></li>
  <li class="topmenu"><a href="#" >Operaciones</a>
	<ul>
	  <li><a href="vIngresos.php">Ingresos</a></li>
	  <li><a href="vGastos.php">Gastos</a></li>
	  <li>----------------</li>
	  <li><a href="vFacturas.php">Facturación</a></li>
	  <li>----------------</li>
	  <li><a href="vCompras.php">Orden de Compras</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="vFlujo.php" >Flujo de Gastos</a>
  	<ul>
	  <li><a href="vFlujo.php">Vista General</a></li>
	  <li><a href="vFlujoC.php">Vista Filtro</a></li>
	  <li><a href="vFacingresos.php">Ingresos por Facturas</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#">Personal</a>
	<ul>
	  <li><a href="frmPersonal.php?action=insertar">Agregar Personal</a></li>
	  <li><a href="vPersonal.php">Lista de Personal</a></li>
	  <li><a href="vPersonalD.php">Lista Detallada de Personal</a></li>
	  <li><a href="vBoletas.php">Lista Boletas</a></li>
	  <li><a href="vPlanilla.php">Ver Planilla</a></li>
	  <li><a href="vCts.php">Ver CTS</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#">Mantenimiento</a>
	<ul>
	  <li><a href="manCliente.php">Cliente</a></li>
	  <li><a href="manContratacion.php">Contratación</a></li>
	  <li><a href="manCuentas.php">Cuentas</a></li>
	  <li><a href="manDestino.php">Destino</a></li>
	  <li><a href="manEmpresa.php">Empresa</a></li>
	  <li><a href="manEntfinanciera.php">Ent. Financiera</a></li>
	  <li><a href="#"><span>Formularios</span></a>
	  	<ul>
		  <li><a href="manForm.php?form=Compras">Compras</a></li>
		  <li><a href="manForm.php?form=Facturas">Facturas</a></li>
		  <li><a href="manForm.php?form=Gastos">Gastos</a></li>		  
		  <li><a href="manForm.php?form=Ingresos">Ingresos</a></li>
		  <li><a href="manForm.php?form=Personal">Personal</a></li>
		  <li><a href="manForm.php?form=Prestamos">Prestamos</a></li>
		</ul>
	  </li>
	  <li><a href="#"><span>Formulas</span></a>
	  	<ul>
		  <li><a href="manFormula.php?ele=Personal">Personal</a></li>
		</ul>
	  </li>
	  <li><a href="manLocalidad.php">Localidad</a></li>
	  <li><a href="manOcupacion.php">Ocupación</a></li>
	  <li><a href="manProveedor.php">Proveedor</a></li>
	  <li><a href="manSispensiones.php">Sis. Pensiones</a></li>
	  <li><a href="manTaller.php">Taller</a></li>
	  <li><a href="manUbicacion.php">Ubicación</a></li>
	  <li><a href="manZona.php">Zona</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#">Opciones</a>
	<ul>
	  <li><a href="faUser.php?vista=1&amp;action=editar&amp;id_user='.$_SESSION['user_id'].'">Modificar Mis Datos</a></li>
	  <li><a href="faUserCla.php">Cambiar Contraseña</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="vSoporte.php">Ayuda</a>
  </li>
</ul>
';

$menu_representante=
'
<ul id="menu1" class="topmenu">
  <li class="topfirst"><a href="inicioResp.php">Principal</a></li>
  <li class="topmenu"><a href="#" >Operaciones</a>
	<ul>
	  <li><a href="vIngresos_r.php">Ingresos</a></li>
	  <li><a href="vGastos_r.php">Gastos</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#" >Sustentación caja</a>
	<ul>
	  <li><a href="vSuscaja_g.php">Guardar</a></li>
	  <li><a href="vSuscaja_c.php">Cargar</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="#">Opciones</a>
	<ul>
	  <li><a href="faUser.php?vista=1&amp;action=editar&amp;id_user='.$_SESSION['user_id'].'">Modificar Mis Datos</a></li>
	  <li><a href="faUserCla.php">Cambiar Contraseña</a></li>
	</ul>
  </li>
  <li class="topmenu"><a href="vSoporte.php">Ayuda</a>
  </li>
</ul>
';

switch ($_SESSION['usergrupo_id']) {
    case 1:
        echo $menu_superusuario;
        break;
	case 2:
        echo $menu_administrador;
        break;
    case 3:
        echo $menu_ejecutor;
        break;
	case 5:
        echo $menu_representante;
        break;
	/*default:
       	echo $menu_ejecutor;*/
	}

}

?>