<?php
session_start();
//require_once ("../formatos/formatos.php");
	$y=date('Y');
	$m=date('m');
	$d=date('d');
	
	$fec1="$d-$m-$y";
	
	//$d=ultimoDia($m,$y);
	$fec2="$d-$m-$y";
	//$fec2="$d-$m-$y";
	
	//$punven_id=$_SESSION['puntoventa_id'];
	
?>
<script type="text/javascript">
	$('#btn_filtrar').button({
		icons: {primary: "ui-icon-search"},
		text: false
	});
	$('#btn_resfil').button({
		icons: {primary: "ui-icon-arrowrefresh-1-w"},
		text: false
	});
	
function cmb_fil_cli_id()
{	
	$.ajax({
		type: "POST",
		url: "../clientes/cmb_cli_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			//cli_id: "<?php //echo $cli_id?>"
		}),
		beforeSend: function() {
			$('#cmb_fil_cli_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){			
			$('#cmb_fil_cli_id').html(html);
		}
	});
}

function cmb_fil_ven_ven()
{	
	$.ajax({
		type: "POST",
		url: "../usuarios/cmb_use_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			usugru_id: '2,3'
		}),
		beforeSend: function() {
			$('#cmb_fil_ven_ven').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_ven_ven').html(html);
		}
	});
}
function cmb_punven_id(idf)
{	
	$.ajax({
		type: "POST",
		url: "../puntoventa/cmb_punven_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			punven_id: idf
		}),
		beforeSend: function() {
			$('#cmb_fil_ven_punven').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_ven_punven').html(html);
		},
		complete: function(){
			//venta_tabla();
		}
	});
}
function cmb_ven_doc()
{	
	$.ajax({
		type: "POST",
		url: "../documento/cmb_doc_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			doc_tip:	'2',
			doc_id: '<?php echo $doc_id?>',
			vista:	'<?php echo $_POST['action']?>'
		}),
		beforeSend: function() {
			$('#cmb_fil_ven_doc').html('<option value="">Cargando...</option>');
        },
		success: function(html){			
			$('#cmb_fil_ven_doc').html(html);
		}
	});
}
    function cmb_vehiculo()
    {
        $.ajax({
            type: "POST",
            url: "../vehiculo/cmb_veh_id.php",
            async:false,
            dataType: "html",
            beforeSend: function() {
                $('#cmb_fil_veh').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_fil_veh').html(html);

            },
            complete: function(){

            }
        });
    }
    /**
     * Secure Hash Algorithm (SHA256)
     * http://www.webtoolkit.info/
     * Original code by Angel Marin, Paul Johnston
     **/

    function SHA256(s){
        var chrsz = 8;
        var hexcase = 0;

        function safe_add (x, y) {
            var lsw = (x & 0xFFFF) + (y & 0xFFFF);
            var msw = (x >> 16) + (y >> 16) + (lsw >> 16);
            return (msw << 16) | (lsw & 0xFFFF);
        }

        function S (X, n) { return ( X >>> n ) | (X << (32 - n)); }
        function R (X, n) { return ( X >>> n ); }
        function Ch(x, y, z) { return ((x & y) ^ ((~x) & z)); }
        function Maj(x, y, z) { return ((x & y) ^ (x & z) ^ (y & z)); }
        function Sigma0256(x) { return (S(x, 2) ^ S(x, 13) ^ S(x, 22)); }
        function Sigma1256(x) { return (S(x, 6) ^ S(x, 11) ^ S(x, 25)); }
        function Gamma0256(x) { return (S(x, 7) ^ S(x, 18) ^ R(x, 3)); }
        function Gamma1256(x) { return (S(x, 17) ^ S(x, 19) ^ R(x, 10)); }

        function core_sha256 (m, l) {
            var K = new Array(0x428A2F98, 0x71374491, 0xB5C0FBCF, 0xE9B5DBA5, 0x3956C25B, 0x59F111F1, 0x923F82A4, 0xAB1C5ED5, 0xD807AA98, 0x12835B01, 0x243185BE, 0x550C7DC3, 0x72BE5D74, 0x80DEB1FE, 0x9BDC06A7, 0xC19BF174, 0xE49B69C1, 0xEFBE4786, 0xFC19DC6, 0x240CA1CC, 0x2DE92C6F, 0x4A7484AA, 0x5CB0A9DC, 0x76F988DA, 0x983E5152, 0xA831C66D, 0xB00327C8, 0xBF597FC7, 0xC6E00BF3, 0xD5A79147, 0x6CA6351, 0x14292967, 0x27B70A85, 0x2E1B2138, 0x4D2C6DFC, 0x53380D13, 0x650A7354, 0x766A0ABB, 0x81C2C92E, 0x92722C85, 0xA2BFE8A1, 0xA81A664B, 0xC24B8B70, 0xC76C51A3, 0xD192E819, 0xD6990624, 0xF40E3585, 0x106AA070, 0x19A4C116, 0x1E376C08, 0x2748774C, 0x34B0BCB5, 0x391C0CB3, 0x4ED8AA4A, 0x5B9CCA4F, 0x682E6FF3, 0x748F82EE, 0x78A5636F, 0x84C87814, 0x8CC70208, 0x90BEFFFA, 0xA4506CEB, 0xBEF9A3F7, 0xC67178F2);
            var HASH = new Array(0x6A09E667, 0xBB67AE85, 0x3C6EF372, 0xA54FF53A, 0x510E527F, 0x9B05688C, 0x1F83D9AB, 0x5BE0CD19);
            var W = new Array(64);
            var a, b, c, d, e, f, g, h, i, j;
            var T1, T2;

            m[l >> 5] |= 0x80 << (24 - l % 32);
            m[((l + 64 >> 9) << 4) + 15] = l;

            for ( var i = 0; i<m.length; i+=16 ) {
                a = HASH[0];
                b = HASH[1];
                c = HASH[2];
                d = HASH[3];
                e = HASH[4];
                f = HASH[5];
                g = HASH[6];
                h = HASH[7];

                for ( var j = 0; j<64; j++) {
                    if (j < 16) W[j] = m[j + i];
                    else W[j] = safe_add(safe_add(safe_add(Gamma1256(W[j - 2]), W[j - 7]), Gamma0256(W[j - 15])), W[j - 16]);

                    T1 = safe_add(safe_add(safe_add(safe_add(h, Sigma1256(e)), Ch(e, f, g)), K[j]), W[j]);
                    T2 = safe_add(Sigma0256(a), Maj(a, b, c));

                    h = g;
                    g = f;
                    f = e;
                    e = safe_add(d, T1);
                    d = c;
                    c = b;
                    b = a;
                    a = safe_add(T1, T2);
                }

                HASH[0] = safe_add(a, HASH[0]);
                HASH[1] = safe_add(b, HASH[1]);
                HASH[2] = safe_add(c, HASH[2]);
                HASH[3] = safe_add(d, HASH[3]);
                HASH[4] = safe_add(e, HASH[4]);
                HASH[5] = safe_add(f, HASH[5]);
                HASH[6] = safe_add(g, HASH[6]);
                HASH[7] = safe_add(h, HASH[7]);
            }
            return HASH;
        }

        function str2binb (str) {
            var bin = Array();
            var mask = (1 << chrsz) - 1;
            for(var i = 0; i < str.length * chrsz; i += chrsz) {
                bin[i>>5] |= (str.charCodeAt(i / chrsz) & mask) << (24 - i % 32);
            }
            return bin;
        }

        function Utf8Encode(string) {
            string = string.replace(/\r\n/g,'\n');
            var utftext = '';

            for (var n = 0; n < string.length; n++) {

                var c = string.charCodeAt(n);

                if (c < 128) {
                    utftext += String.fromCharCode(c);
                }
                else if((c > 127) && (c < 2048)) {
                    utftext += String.fromCharCode((c >> 6) | 192);
                    utftext += String.fromCharCode((c & 63) | 128);
                }
                else {
                    utftext += String.fromCharCode((c >> 12) | 224);
                    utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                    utftext += String.fromCharCode((c & 63) | 128);
                }

            }

            return utftext;
        }

        function binb2hex (binarray) {
            var hex_tab = hexcase ? '0123456789ABCDEF' : '0123456789abcdef';
            var str = '';
            for(var i = 0; i < binarray.length * 4; i++) {
                str += hex_tab.charAt((binarray[i>>2] >> ((3 - i % 4)*8+4)) & 0xF) +
                    hex_tab.charAt((binarray[i>>2] >> ((3 - i % 4)*8 )) & 0xF);
            }
            return str;
        }

        s = Utf8Encode(s);
        return binb2hex(core_sha256(str2binb(s), s.length * chrsz));
    }

$(function() {
	
	var dates = $( "#txt_fil_ven_fec1, #txt_fil_ven_fec2" ).datepicker({
		//defaultDate: "+1w",
		maxDate:"+0D",
		changeMonth: true,
		numberOfMonths: 1,
		dateFormat: 'dd-mm-yy',
		onSelect: function( selectedDate ) {
			var option = this.id == "txt_fil_ven_fec1" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
	
	//cmb_fil_cli_id();
	cmb_ven_doc();
	cmb_fil_ven_ven();
	cmb_punven_id(<?php echo $punven_id?>);
    cmb_vehiculo();
	
	$( "#txt_fil_cli" ).autocomplete({
   		minLength: 1,
   		source: "../clientes/cliente_complete_nom.php",
		select: function(event, ui){
			$("#hdd_fil_cli_id").val(ui.item.id);														
		}
    });
	
	$("#txt_fil_cli").change(function(){
		var cli=$("#txt_fil_cli").val();
		if(cli=="")$("#hdd_fil_cli_id").val('');
	});
	
	$('#cmb_fil_ven_doc').change(function(e) {
        venta_tabla();
    });
	$('#cmb_fil_ven_ven').change(function(e) {
        venta_tabla();
    });
	$('#cmb_fil_ven_punven').change(function(e) {
        venta_tabla();
    });
	$('#cmb_fil_ven_est').change(function(e) {
        venta_tabla();
    });
	
	$('#chk_ven_anu').change( function() {
        var clave ="2a3cb3534d10f3eecaea1dae2029cf689cb1e1cfc7c56f94a324ae16b7f2efad";
        var sign = prompt("Contraseña para anular.");

        if (clave == SHA256(sign)) {
            venta_tabla();
        }
        else {
            alert("Contraseña incorrecta.")
            window.location.reload();
        }
	});
    $('#cmb_fil_veh').change(function(e) {
        venta_tabla();
    });
	
});
</script>
<style>
/*label {
	display:inline-block;
    width: 150px; 
}*/
</style>
<form name="for_fil_ven" id="for_fil_ven" target="_blank" action="" method="post">
<input name="hdd_modo" id="hdd_modo" type="hidden" value="venta_tabla_adm.php">
<fieldset><legend>Filtro de Venta</legend>
	
    <label for="txt_fil_ven_fec1">Fecha entre:</label>
    <input name="txt_fil_ven_fec1" type="text" id="txt_fil_ven_fec1" value="<?php echo $fec1?>" size="8" readonly>
    <label for="txt_fil_ven_fec2">-</label>
    <input name="txt_fil_ven_fec2" type="text" id="txt_fil_ven_fec2" value="<?php echo $fec2?>" size="8" readonly>
    
  <!--  <label for="cmb_fil_cli_id">Cliente:</label>
	<select name="cmb_fil_cli_id" id="cmb_fil_cli_id">
    </select>-->
    
    <label for="cmb_fil_ven_doc">Doc:</label>
    <select name="cmb_fil_ven_doc" id="cmb_fil_ven_doc">
    </select>
    
    <input type="hidden" id="hdd_fil_cli_id" name="hdd_fil_cli_id" />
    
    <label for="txt_fil_cli_id">Cliente:</label>
    <input type="text" id="txt_fil_cli" name="txt_fil_cli" size="40" />
    
    <label for="cmb_fil_ven_est">Estado:</label>
	<select name="cmb_fil_ven_est" id="cmb_fil_ven_est">
	  <option value="">-</option>
	  <option value="CANCELADA" selected>CANCELADA</option>
	  <option value="ANULADA">ANULADA</option>
    </select>

    <label for="cmb_fil_veh">Vehículo:</label>
    <select name="cmb_fil_veh" id="cmb_fil_veh">
    </select>
    <br>
    <label for="cmb_fil_ven_ven">Vendedor:</label>
	<select name="cmb_fil_ven_ven" id="cmb_fil_ven_ven">
    </select>
    <label for="cmb_fil_ven_punven">Punto Venta:</label>
    <select name="cmb_fil_ven_punven" id="cmb_fil_ven_punven">
    </select>
    <label for="chk_fil_ven_may" title="Venta Mayorista">Venta Mayorista<input name="chk_fil_ven_may" id="chk_fil_ven_may" type="checkbox" value="1"></label>
    <label for="chk_ven_anu" title="Activar para anular venta.">Anular<input name="chk_ven_anu" id="chk_ven_anu" type="checkbox" value="1"></label>
  	<a href="#" onClick="venta_tabla()" id="btn_filtrar">Filtrar</a>
    <a href="#" onClick="venta_filtro()" id="btn_resfil">Restablecer</a>
</fieldset>
</form>