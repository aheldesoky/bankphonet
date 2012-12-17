<?php
include __DIR__ . "/../interfaces/iCMS.php";

class cms implements iCMS{
    
    
    public function __construct(Cdb $db) {
        $this->db = $db; //DB OBJECT
    }

    /**
     * Create CMS page
     * @param array $data 
     */
    public function createPage ($data){
        return $this->db->insert ('cms',$data);
    }
    
    /**
     * Edit CMS page
     * @param integer $id
     * @param array $data 
     */
    public function editPage ($name,$data){
        return $this->db->update ('cms',$data,"name = '$name'");
    }

    public function deletePage ($name)
    {
        return $this->db->delete ('cms',"name ='$name'");
    }
    /**
     * Get CMS One page
     * @param integer $id 
     */
    public function getPage ($name){
        global $local;
        $custom_fields = "title_$local as title,description_$local as description,image1,image2,description_ar,description_en,title_ar,title_en";
        return $this->db->select_record('cms', "name='$name'", false, $custom_fields);
    }

    /**
     * Get all cms pages
     * @param integer $count 
     */
    public function getAllPages ($count = false,$page =false){
        global $local;
        $custom_fields = "title_$local as title,description_$local as description,image1,image2";
        return $this->db->select('cms',false, false, $custom_fields,'id DESC');

    }
    
    /**
     * Count all pages for pagination 
     */
    public function getAllPagesCount (){}
}

?>
