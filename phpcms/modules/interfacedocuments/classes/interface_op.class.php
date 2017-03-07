<?php
defined('IN_PHPCMS') or exit('No permission resources.');

//定义在后台
define('IN_ADMIN',true);
class interface_op {
	public function __construct() {
		$this->interface_package = pc_base::load_model('interface_package_model');
        $this->interface_db = pc_base::load_model('interface_model');
	}
	/*
	 * 检查包名是否重复
	 */	
	public function check_package_name($name) {
        $name =  trim($name);
		if ($this->interface_package->get_one(array('name'=>$name),'id')){
			return false;
		}
		return true;
	}

	public function check_interface_name($name){
        $name =  trim($name);
        if ($this->interface_db->get_one(array('name'=>$name),'id')){
            return false;
        }
        return true;
    }
}
?>