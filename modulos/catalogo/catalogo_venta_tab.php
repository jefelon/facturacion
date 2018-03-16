<script>	
    $(function() {
        $( "#div_venta_tab" ).tabs();
		
		/*$("#productos").click(function(){
			catalogo_venta();
		});*/
		
		/*$("#servicios").click(function(){
			catalogo_servicio();
		});*/
    });
</script>
<div id="div_venta_tab">
    <ul>
        <li><a id="productos" href="#div_tab_producto">Productos</a></li>
        <li><a id="servicios" href="#div_tab_servicio">Servicios</a></li>        
    </ul>
    <div id="div_tab_producto">
        Productos
    </div>
    <div id="div_tab_servicio">
        Servicios
    </div>
</div>