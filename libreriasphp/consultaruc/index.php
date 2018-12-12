<?php
// function buscar() {
//         $('input[name=razon]').val('');
//         $('input[name=nom]').val('');
//         $('#direccion').val('');
//         $('#telmovil').val('');
//         $.post('../sunat/index.php', {vruc: $('.ruc').val(), vtipod: $('input[name=tipod]').val()}, function(data, textStatus){
//           if(data == null){
//             alert('Intente nuevamente...Sunat');
//           }
//           if(data.length==1){
//             alert(data[0]);
//           }else{
//             $('input[name=razon]').val(data['RazonSocial']);
//             $('input[name=nom]').val(data['RazonSocial']);
//             $('#direccion').val(data['Direccion']);
//             $('#telmovil').val(data['Telefonos']);
//           }
//     		},"json");
//         //porsunat();
//         //recargaImagen();
//       }

    require ("curl.php");
    require ("sunat.php");
    $cliente = new Sunat();
    $ruc = $_POST['vruc'];
    $vtipod = $_POST['vtipod'];//ruc=6 dni =?
    if(strpbrk($vtipod, '016')){
      $ruc = $cliente->autoruc($ruc);
    }
    echo json_encode( $cliente->BuscaDatosSunat($ruc), JSON_PRETTY_PRINT );
?>
