<?php

if(isset($_POST['uid']) && isset($_POST['cid']) && isset($_POST['nid']) && isset($_POST['duration']))
{
	//$data = array('message' => "in main");
date_default_timezone_set ('Asia/Kolkata');
$uid  = 1237;
$c_id  = 1996312;
$n_id  = 1996314;
$total_duration = "0030";
//$uid  = intval($_POST['uid']);
//$c_id  = intval($_POST['cid']);
//$n_id  = intval($_POST['nid']);
//$total_duration = "data" ;
$date = date('Y-m-d H:i:s');

/**$query1 = "SELECT * FROM {videotracker} WHERE (uid='".$uid."' && c_id='".$c_id."' && n_id='".$n_id."')";
$result = db_query($query1);
if(mysql_num_rows($result)>0)
{
 $query2 = "UPDATE {videotracker} SET last_watched_on='".$date."' WHERE (uid='".$uid."' && c_id='".$c_id."' && n_id='".$n_id."')";
 
 $result = db_query($query2);
 
 if(!$result){
  $data = array('success' => FALSE);
 }
 else{
  $data = array('success' => TRUE);
 }
}
else{
		*/
		$query2 = "INSERT INTO {videotracker}
	    (uid,
	    c_id,
	    n_id)
	    VALUES
	    ('".$uid."','".$c_id."','".$n_id."')";
	 
 
 $result = db_query($query2);

 
 if(FALSE)
 {
  $data = array('success' => FALSE);
 }
 else
 {
  $data = array('success' => TRUE);
 }
//}
echo json_encode($data);
}

?>