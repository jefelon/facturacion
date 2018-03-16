<?php
 
//$d=$_GET['data']; $modwidth=$_GET['modwidth'];  
$params = array(
    array('data','20479676861|1|006|9881|368.54|2416.00|2016-10-20|6|20220724809|||'),array('compaction',4),array('modwidth',1),
    array('info',false),array('columns',8),array('errlevel',5),
    array('showtext',false),array('height',3),
    array('showframe',false),array('truncated',false),
    array('vertical',false) ,
    array('backend','IMAGE'), array('file',''),
    array('scale',2), array('pswidth','') );
 
$n=count($params);
$s='';
for($i=0; $i < $n; ++$i ) {
    $v  = $params[$i][0];
    if( empty($_GET[$params[$i][0]]) ) {
        $$v = $params[$i][1];
    }
    else
        $$v = $_GET[$params[$i][0]];
    $s .= $v.'='.urlencode($$v).'&';
}
/*
if( $data=="" ) {
    die( "<h3> Error. Please enter data to be encoded and press 'Ok'.</h3>");
}
elseif( strlen($data)>1000 ) {
    die( "<h3> Error. To many input characters must be < 1000" );
}
elseif( $columns < 2 || $columns > 30 ) {
    die( "<h4> Error. Columns must be in range [2, 30]</h4>" );
}
elseif($scale < 0.2 || $scale > 15 )  {
    die( "<h4> Error. Scale must be in range [0.2, 15]</h4>" );
}*/
 
//echo "s=$s<p>";
 
?>
 
<!doctype html public "-//W3C//DTD HTML 4.0 Frameset//EN">
<html>
<body>
<?php
    echo "<img src=\"generate.php?$s\" name=barcode>";
?>
</body>
</html>