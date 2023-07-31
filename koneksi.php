<?php 
//simulasi : $db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.225.200)(PORT = 1521)))(CONNECT_DATA=(SID=simdbbks)))"; 
$db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.240.193)(PORT = 1521)))(CONNECT_DATA=(SID=simbgr)))"; 
$conn = oci_connect('simbgr', 'simbgr',$db);
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

if (!$conn) {
   echo "Koneksi database oracle bermasalah <br/>";
}
//include ('../log.php');
?>
