<?php
/**
 * 管理员后台会员组操作类
 */

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);

class interface_package extends admin {

    private $db;

    function __construct() {
        parent::__construct();
        $this->package_db = pc_base::load_model('interface_package_model');
        $this->op = pc_base::load_app_class('interface_op');
    }

    public function init() {
        $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
        $infos = $this->package_db->listinfo($where = 'disabled=0',$order = 'sort DESC',$page, $pages = '13');
        $pages = $this->package_db->pages;
        include $this->admin_tpl('package_init');
    }

    public function add() {
        if(isset($_POST['dosubmit'])) {
            $info = array(
                'sort' => 0,
                'disabled' => 0,
                'cr_date' => time(),
            );
            if(!$this->op->check_package_name($_POST['info']['name'])){
                showmessage('包名已经存在');
            } else {
                $info['name'] = $_POST['info']['name'];
            }

            $info['description'] = trim($_POST['info']['description']);

            $this->package_db->insert($info);
            if($this->package_db->insert_id()){
                showmessage('成功','?m=interfacedocuments&c=interface_package');
            }
        } else {
            include $this->admin_tpl('package_add');
        }
    }

    public function edit() {
        if(isset($_POST['dosubmit'])) {
            $id = $_POST['info']['id'] ;
            if(!$this->op->check_package_name($_POST['info']['name'], $id)){
                showmessage('包名已经存在');
            } else {
                $info['name'] = $_POST['info']['name'];
            }

            $info['description'] = trim($_POST['info']['description']);

            $this->package_db->update($info, array('id' => $id));

            showmessage('修改成功','?m=interfacedocuments&c=interface_package');
        } else {

            $id = $_GET['id'];
            $result = $this->package_db->get_one(array('id'=>$id));

            include $this->admin_tpl('package_edit');
        }
    }
}
?>