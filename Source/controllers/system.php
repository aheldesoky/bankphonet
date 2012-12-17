<?php
require_once 'system/database/updates.php';
require_once 'models/system.php';
$sys = new system();


if($action == 'update')
{
	if(!$oUser->admin)
		go_to ();
	//Get Record of last update !
	$last_update = $sys->get_last_update ();
	echo "<div>Last Update : ";
	echo $last_update['last_update_id']. " @ ". $last_update['datetime1'];
	echo '</div>';
	
	
	//Check if this key is exist in array
	if(key_exists( $last_update['last_update_id'],$updates))
	{
		//Slice Updates
		$new_updates = array_slice($updates,$last_update['last_update_id']+1,count($updates),true); //Slice with old keys
		}else{
		$new_updates = $updates; //First time To run script
	}
	
	
		
		//Run Updates 
			foreach($new_updates as $key=>$upd)
			{
				if(!empty($upd)){
					$up = $db->execute ($upd);
					$lkey = $key;
				}
				
			}
			//Update Sytsem table
			if($lkey)
				$sys->update ($lkey);
			
			if($up)
					echo 'System Updated ! thank You !';
				else
					echo 'There are some thing wrong or there are no new changes!';
		
		
	
}

?>
