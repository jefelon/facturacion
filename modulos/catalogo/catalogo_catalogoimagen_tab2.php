<script>	
    $(function() {
        $( "#div_venta_tab1" ).tabs();
		
		/*$("#productos").click(function(){
			catalogo_venta();
		});*/
		
		/*$("#servicios").click(function(){
			catalogo_servicio();
		});*/
    });
</script>
<div id="div_venta_tab1">
    <ul>
        <li><a id="productos" href="#div_tab_producto">Productos</a></li>
        <?php /*?><li><a id="servicios" href="#div_tab_servicio">Servicios</a></li><?php */?>
    </ul>
    <div id="div_tab_producto">
        Productos
    </div>
    <?php /*?>
    <div id="div_tab_servicio">
        Servicios
    </div>
    <?php */?>
</div>