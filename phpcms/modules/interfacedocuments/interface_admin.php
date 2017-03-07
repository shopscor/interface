<?php
set_time_limit(300);
defined('IN_PHPCMS') or exit('No permission resources.');

pc_base::load_app_class('admin','admin',0);
pc_base::load_app_func('util');
pc_base::load_sys_class('form', '', 0);
pc_base::load_sys_class('format','',0);

class interface_admin extends admin {
    public function __construct() {
        parent::__construct();
        $this->interface_db = pc_base::load_model('interface_model');
        $this->interface_header_db = pc_base::load_model('interface_header_model');
        $this->interface_parameter_db = pc_base::load_model('interface_param_model');
        $this->param_type_db = pc_base::load_model('interface_param_type_model');
        $this->package_db = pc_base::load_model('interface_package_model');
        $this->op = pc_base::load_app_class('interface_op');
    }

    public function lists() {

        $interface_packages = $this->package_db->select('disabled=0', '*');

        $page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
        $infos = $this->interface_db->listinfo($where = 'disabled=0',$order = 'sort DESC',$page, $page_size = '13');
        $pages = $this->interface_db->pages;

        include $this->admin_tpl("interface_admin_lists");
    }

    public function add() {
        if(isset($_POST['dosubmit'])) {
            $interface_info = $this->check_interface_info($_POST['info']);
            $interface_header = $this->check_header($_POST['info_header']);
            $interface_param = $this->check_parameter($_POST['info_param']);

            $interface_info['disabled'] = 0;
            $interface_info['cr_date'] = time();
//            var_dump($interface_info);
//            var_dump($interface_header);
//            var_dump($interface_param);die;
            $this->interface_db->insert($interface_info);
            $info_id = $this->interface_db->insert_id();
            if ( $info_id ) {
                foreach ($interface_header as $key => $value) {
                    $value['interface_id'] = $info_id;
                    $this->interface_header_db->insert($value);
                }

                foreach ($interface_param as $key => $value) {
                    $value['interface_id'] = $info_id;
                    $this->interface_parameter_db->insert($value);
                }

                showmessage('成功','?m=interfacedocuments&c=interface_admin&a=lists');
            } else {
                showmessage('添加失败');
            }
        } else {
            $interface_packages = $this->package_db->select('disabled=0', '*');
            include $this->admin_tpl('interface_admin_add');
        }
    }

    private function check_interface_info($info) {
        if ( strlen($info['name']) == '' ||  !$this->op->check_package_name($_POST['info']['name'])) {
            showmessage('接口名称已存在');
        } else {
            $info['name']= trim($info['name']);
        }

        if ( strlen($info['request_url']) == '' || !isUrl($info['request_url'])) {
            showmessage('请输入正确的URL');
        } else {
            $info['request_url'] = trim($info['request_url']);
        }

        return $info;
    }

    private function check_header($header) {
        foreach ($header as $key=>$value) {
            if (strlen($value['header_key']) == '' && strlen($value['header_value']) == ''){
                continue;
            } elseif (strlen($value['header_key']) == '' || strlen($value['header_value']) == '') {
                showmessage('Request Header 键值对必须都不为空');
            } else {
                $header[$key]['header_key'] = trim($value['header_key']);
                $header[$key]['header_value'] = trim($value['header_value']);
            }
        }

        return $header;
    }

    private function check_parameter($param) {
        foreach ($param as $key=>$value) {

            if ($value['param_type'] == 3 && strlen($value['enum_string']) == '') {
                showmessage('Request Param 中 Enum 值不能为空');
            }

            if (strlen($value['param_key']) == ''){
                continue;
            } else {
                $param[$key]['param_key'] = trim($value['param_key']);
            }
        }

        return $param;
    }
}
?>