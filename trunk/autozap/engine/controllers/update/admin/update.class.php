<?php
class controller_admin_update implements controller_interface 
{
    function run()
    {
        if(!isset($_FILES['xls']) or !isset($_POST['price_type']))
        {
            $this->showForm();
        }else
        {
            require_once EXCELREADER_DIR.'reader.php';
        }
        
        
        
    }
    
    function showForm()
    {
        
    }
    
    
}
?>