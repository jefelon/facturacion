<?php
require_once ("../../config/Cado.php");
require_once ("cCatalogoimagen.php");
$oCatalogoimagen = new cCatalogoimagen();

$dts=$oCatalogoimagen->mostrar_slaider($_POST['cat_id']);
$dt = mysql_fetch_array($dts);
    $catimg_id =$dt['tb_catalogoimagen_id'];
    $des=$dt['tb_catalogoimagen_des'];               
mysql_free_result($dts);

?>

<script type="text/javascript">
$(function() {  

}); 
</script>

<script type="text/javascript" src="../../js/Slidershow/jssor.slider.min.js"></script>
<script>
jssor_1_slider_init = function() {
    
    var jssor_1_SlideshowTransitions = [
      {$Duration:1200,$Opacity:2}
    ];
    
    var jssor_1_options = {
      $AutoPlay: true,
      $SlideshowOptions: {
        $Class: $JssorSlideshowRunner$,
        $Transitions: jssor_1_SlideshowTransitions,
        $TransitionsOrder: 1
      },
      $ArrowNavigatorOptions: {
        $Class: $JssorArrowNavigator$
      },
      $BulletNavigatorOptions: {
        $Class: $JssorBulletNavigator$
      }
    };
    
    var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);
    
    //responsive code begin
    //you can remove responsive code if you don't want the slider scales while window resizing
    function ScaleSlider() {
        var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
        if (refSize) {
            refSize = Math.min(refSize, 600);
            jssor_1_slider.$ScaleWidth(refSize);
        }
        else {
            window.setTimeout(ScaleSlider, 30);
        }
    }
    ScaleSlider();
    $Jssor$.$AddEvent(window, "load", ScaleSlider);
    $Jssor$.$AddEvent(window, "resize", ScaleSlider);
    $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
    //responsive code end
};
</script>

<style>

/* jssor slider bullet navigator skin 05 css */
/*
.jssorb05 div           (normal)
.jssorb05 div:hover     (normal mouseover)
.jssorb05 .av           (active)
.jssorb05 .av:hover     (active mouseover)
.jssorb05 .dn           (mousedown)
*/
.jssorb05 {
    position: absolute;
}
.jssorb05 div, .jssorb05 div:hover, .jssorb05 .av {
    position: absolute;
    /* size of bullet elment */
    width: 16px;
    height: 16px;
    background: url('../../files/catalogoimagen/b05.png') no-repeat;
    overflow: hidden;
    cursor: pointer;
}
.jssorb05 div { background-position: -7px -7px; }
.jssorb05 div:hover, .jssorb05 .av:hover { background-position: -37px -7px; }
.jssorb05 .av { background-position: -67px -7px; }
.jssorb05 .dn, .jssorb05 .dn:hover { background-position: -97px -7px; }

/* jssor slider arrow navigator skin 12 css */
/*
.jssora12l                  (normal)
.jssora12r                  (normal)
.jssora12l:hover            (normal mouseover)
.jssora12r:hover            (normal mouseover)
.jssora12l.jssora12ldn      (mousedown)
.jssora12r.jssora12rdn      (mousedown)
*/
.jssora12l, .jssora12r {
    display: block;
    position: absolute;
    /* size of arrow element */
    width: 30px;
    height: 46px;
    cursor: pointer;
    background: url('../../files/catalogoimagen/a12.png') no-repeat;
    overflow: hidden;
}
.jssora12l { background-position: -16px -37px; }
.jssora12r { background-position: -75px -37px; }
.jssora12l:hover { background-position: -136px -37px; }
.jssora12r:hover { background-position: -195px -37px; }
.jssora12l.jssora12ldn { background-position: -256px -37px; }
.jssora12r.jssora12rdn { background-position: -315px -37px; }
</style>

<div style="padding:0px; margin:0px; background-color:#fff;font-family:Arial, sans-serif">

    <div id="jssor_1" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 600px; height: 300px; overflow: hidden; visibility: hidden;">
        <!-- Loading Screen -->
        <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
            <div style="position:absolute;display:block;background:url('../../images/loadingf11.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
        </div>

        <div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 600px; height: 300px; overflow: hidden;">
            
            <?php
            // para mostrar las galerias de imagenes
            $dts2=$oCatalogoimagen->mostrar_imagenfile($catimg_id);
            $num_rows= mysql_num_rows($dts2);
            
            while($dt2 = mysql_fetch_array($dts2))
            {
            ?>
                <div data-p="112.50" style="display: none;">                            
                        <img data-u="image" src="<?php echo $dt2['tb_catalogoimagenfile_url']?>" />                               
                </div>           
              
            <?php
            }
            mysql_free_result($dts2);
            ?>            
        
        </div>
        <!-- Bullet Navigator -->
        <div data-u="navigator" class="jssorb05" style="bottom:16px;right:16px;" data-autocenter="1">
            <!-- bullet navigator item prototype -->
            <div data-u="prototype" style="width:16px;height:16px;"></div>
        </div>
        <!-- Arrow Navigator -->
        <span data-u="arrowleft" class="jssora12l" style="top:0px;left:0px;width:30px;height:46px;" data-autocenter="2"></span>
        <span data-u="arrowright" class="jssora12r" style="top:0px;right:0px;width:30px;height:46px;" data-autocenter="2"></span>
    </div>
    <script>
        jssor_1_slider_init();
    </script>
</div>

<style>
    body{font:12px/1.2 Verdana, sans-serif; padding:0 10px;}
  /*  a:link, a:visited{text-decoration:none; color:#416CE5; border-bottom:1px solid #416CE5;}*/
    h2{font-size:13px; margin:15px 0 0 0;}
</style>

<link rel="stylesheet" href="../../js/colorbox/example1/colorbox.css" />
<script src="../../js/colorbox/jquery.js"></script>
<script> var $j = jQuery.noConflict(true); </script>
<script src="../../js/colorbox/jquery.colorbox.js"></script>
<script>
    $(document).ready(function(){
        //Examples of how to assign the Colorbox event to elements
        $(".group1").colorbox({rel:'group1'});
        $(".group2").colorbox({rel:'group2', transition:"fade"});
        $(".group3").colorbox({rel:'group3', transition:"none", width:"75%", height:"75%"});
        $(".group4").colorbox({rel:'group4', slideshow:true});
        $(".ajax").colorbox();
        $(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
        $(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
        $(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
        $(".inline").colorbox({inline:true, width:"50%"});
        $(".callbacks").colorbox({
            onOpen:function(){ alert('onOpen: colorbox is about to open'); },
            onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
            onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
            onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
            onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
        });

        $('.non-retina').colorbox({rel:'group5', transition:'none'})
        $('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});
        
        //Example of preserving a JavaScript event for inline calls.
        $("#click").click(function(){ 
            $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
            return false;
        });
    });
</script>

<hr>
<p>
<?php
// para mostrar los lightbox de imagenes
$dts3=$oCatalogoimagen->mostrar_imagenfile($catimg_id);
$num_rows= mysql_num_rows($dts3);

while($dt3 = mysql_fetch_array($dts3))
{ 
?>

    <a class="group1" href="<?php echo $dt3['tb_catalogoimagenfile_url']?>">
        <img data-u="image" src="<?php echo $dt3['tb_catalogoimagenfile_url']?>" width="50" height="50" />    
    </a>

<?php   
} mysql_free_result($dts3); 
?>     
</p>
  


<fieldset>
    <legend>Descripción del Producto</legend>
    <?php echo $des; ?>
</fieldset>



<fieldset>
    <legend>Productos Relacionados</legend>

<table cellspacing="1" id="tabla_catalogo_imagen" class="tablesorter">
    <thead>
        <tr>                
            <th align="right">CODIGO</th>
            <th>NOMBRE</th>
            <th align="right" nowrap>PRECIO S/.</th>
        </tr>
    </thead>
<?php
// para mostrar los productos por catalogo imagen
$dts1=$oCatalogoimagen->mostrar_todo_det($catimg_id);
$num_rows= mysql_num_rows($dts1);

if($num_rows>=1){
?>  
    <tbody>
    <?php

    while($dt = mysql_fetch_array($dts1)){
    ?>
        <tr class="even">
            <td><?php echo $dt['tb_presentacion_cod']?></td>
            <td><?php echo $dt['tb_producto_nom']?></td>
            <td align="right"><?php echo $dt['tb_catalogo_preven']?></td>           
        </tr>
    <?php
        }
        mysql_free_result($dts1);
    ?>
    </tbody>
<?php
}
?>
</table>

</fieldset>