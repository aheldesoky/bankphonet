<?php

class system {

	function __construct()
	{
		//Database Object
		global $db;
		$this->db=$db;
	}

	/**
	 *
	 * @return database record
	 */
	public function get_last_update (){
		
		return $this->db->select_record ('system',false,false,false,"datetime1 DESC");
	}
	
	/**
	 *	insert last update
	 * @param type $key
	 * @return type 
	 */
	public function update ($key)
	{
		$data['last_update_id'] = $key;
		$data['datetime1'] = date('Y-m-d H:i:s A');
		
		return $this->db->insert ('system',$data);
	}
}
?>
