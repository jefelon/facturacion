function   validar2(texto) {
             x = true;
            if (!/^([A-Za-z0-9\\-\\.\\_])*$/.test(texto)){
                x = false;
             }
            return x;
}
function verificaDocumento(tipdoc, numdoc){
  // var form = document.mainForm;
  // var   tipdoc = form.tipdoc.value;
  // var    numdoc =form.search2.value;
   if (tipdoc=="1")
    {
      if (numdoc.length!=8 )
       {
          alert("El número de documento de identidad debe tener 8 dígitos");
          return false;
       }
	   else{
	      if ( !esnumero(numdoc) )
          {
             alert("El número de documento de identidad debe tener 8 dígitos");
             return false;
          }
	   }
    }
	return true;
}
function longitudmayor( campo, len ){
  return ( campo != null )? (campo.length > len) : false;
}

function eslongrucok(ruc){return ( ruc.length == 11 );}
function esnumero(campo){ return (!(isNaN( campo )));}
function esnulo(campo){ return (campo == null||campo=="");}
function esrucok(ruc){
  return (!( esnulo(ruc) || !esnumero(ruc) || !eslongrucok(ruc) || !valruc(ruc) ));
}

function trim(cadena){
  cadena2 = "";
  len = cadena.length;
  for ( var i=0; i <= len ; i++ ) if ( cadena.charAt(i) != " " ){cadena2+=cadena.charAt(i);	}
  return cadena2;
}
function valruc(valor){
  valor = trim(valor)
  if ( esnumero( valor ) ) {
    if ( valor.length == 8 ){
      suma = 0
      for (i=0; i<valor.length-1;i++){
        digito = valor.charAt(i) - '0';
        if ( i==0 ) suma += (digito*2)
        else suma += (digito*(valor.length-i))
      }
      resto = suma % 11;
      if ( resto == 1) resto = 11;
      if ( resto + ( valor.charAt( valor.length-1 ) - '0' ) == 11 ){
        return true
      }
    } else if ( valor.length == 11 ){
      suma = 0
      x = 6
      for (i=0; i<valor.length-1;i++){
        if ( i == 4 ) x = 8
        digito = valor.charAt(i) - '0';
        x--
        if ( i==0 ) suma += (digito*x)
        else suma += (digito*x)
      }
      resto = suma % 11;
      resto = 11 - resto

      if ( resto >= 10) resto = resto - 10;
      if ( resto == valor.charAt( valor.length-1 ) - '0' ){
        return true
      }
    }
  }
  return false
}
