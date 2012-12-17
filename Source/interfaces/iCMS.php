<?php

interface iCMS {
    
    /**
     * Create CMS page
     * @param array $data 
     */
    public function createPage ($data);
    
    /**
     * Edit CMS page
     * @param integer $id
     * @param array $data 
     */
    public function editPage ($id,$data);

    
    /**
     * Get CMS One page
     * @param integer $id 
     */
    public function getPage ($name);

    /**
     * Get all cms pages
     * @param integer $count 
     */
    public function getAllPages ($count = false,$page =false);
    
    /**
     * Count all pages for pagination 
     */
    public function getAllPagesCount ();
    
    
}

?>
