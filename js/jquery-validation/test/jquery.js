(function() {

var parts = document.location.search.slice( 1 ).split( "&" ),
	length = parts.length,
	i = 0,
	current,
	version = "1.3.2",
	file = "http://code.jquery.com/jquery-git.js";

for ( ; i < length; i++ ) {
	current = parts[ i ].split( "=" );
	if ( current[ 0 ] === "jquery" ) {
		version = current[ 1 ];
		break;
	}
}

if (version != "git") {
	file = "../lib/jquery-" + version + ".js";
}


document.write( "<script src='../../../jquery-validation/test/" + file + "'></script>" );

})();
