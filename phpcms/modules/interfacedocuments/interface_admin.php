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

        $interface_packages_data = $this->package_db->select('disabled=0', '*');
        $interface_packages= array();
        if ( is_array($interface_packages_data) && count($interface_packages_data) > 0 ) {
            foreach ($interface_packages_data as $key => $value) {
                $interface_packages[$value['id']] = $value;
            }
        }

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
        if ( strlen($info['name']) == 0 ||  !$this->op->check_package_name($_POST['info']['name'], $info['id'])) {
            showmessage('接口名称已存在');
        } else {
            $info['name']= trim($info['name']);
        }

        if ( strlen($info['request_url']) == 0 || !isUrl($info['request_url'])) {
            showmessage('请输入正确的URL');
        } else {
            $info['request_url'] = trim($info['request_url']);
        }

        return $info;
    }

    private function check_header($header) {
        foreach ($header as $key=>$value) {
            if (strlen($value['header_key']) == 0 && strlen($value['header_value']) ==0){
                continue;
            } elseif (strlen($value['header_key']) == 0 || strlen($value['header_value']) == 0) {
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

            if ($value['param_type'] == 3 && strlen($value['enum_string']) == 0) {
                showmessage('Request Param 中 Enum 值不能为空');
            }

            if (strlen($value['param_key']) == 0){
                continue;
            } else {
                $param[$key]['param_key'] = trim($value['param_key']);
            }
        }

        return $param;
    }

    public function edit() {
        $interface_packages_data = $this->package_db->select('disabled=0', '*');
        $interface_packages= array();
        if ( is_array($interface_packages_data) && count($interface_packages_data) > 0 ) {
            foreach ($interface_packages_data as $key => $value) {
                $interface_packages[$value['id']] = $value;
            }
        }

        $interface_info = $this->interface_db->get_one(array('id'=>$_GET['id']));

        $interface_header = $this->interface_header_db->select(array('interface_id' => $_GET['id']));
        $interface_param = $this->interface_parameter_db->select(array('interface_id' => $_GET['id']));

        if ( isset($_POST['dosubmit']) ) {
            $info_id = $_POST['info']['id'];
            $interface_info_edit = $this->check_interface_info($_POST['info']);
            $interface_header_edit = $this->check_header($_POST['info_header']);
            $interface_param_edit = $this->check_parameter($_POST['info_param']);

            $this->interface_db->update($interface_info_edit, array('id' => $info_id));
            if ( $info_id ) {

                $this->interface_header_db->delete(array('interface_id' => $info_id));
                $this->interface_parameter_db->delete(array('interface_id' => $info_id));

                foreach ($interface_header_edit as $key => $value) {
                    $value['interface_id'] = $info_id;
                    $this->interface_header_db->insert($value);
                }

                foreach ($interface_param_edit as $key => $value) {
                    $value['interface_id'] = $info_id;
                    $this->interface_parameter_db->insert($value);
                }

                showmessage('修改成功','?m=interfacedocuments&c=interface_admin&a=lists');
            } else {
                showmessage('修改失败');
            }

        } else {
            include $this->admin_tpl('interface_admin_edit');
        }


    }

    public function detail() {
        $interface_packages_data = $this->package_db->select('disabled=0', '*');
        $interface_packages= array();
        if ( is_array($interface_packages_data) && count($interface_packages_data) > 0 ) {
            foreach ($interface_packages_data as $key => $value) {
                $interface_packages[$value['id']] = $value;
            }
        }

        $interface_info = $this->interface_db->get_one(array('id'=>$_GET['id']));

        $interface_header = $this->interface_header_db->select(array('interface_id' => $_GET['id']));
        $interface_param = $this->interface_parameter_db->select(array('interface_id' => $_GET['id']));

        if ( isset($_POST['dosubmit']) ) {
            if ( is_array($interface_header) && count($interface_header) > 0 ) {
                foreach ($interface_header as $key => $value) {
                    $interface_header[$key]['header_value'] = $_POST['info_header'][$key+1]['header_value'];
                }
            }

            if ( is_array($interface_param) && count($interface_param) > 0 ) {
                foreach ($interface_param as $key => $value) {
                    if ( $value['param_type'] != 3) {
                        $interface_param[$key]['param_default_value'] = $_POST['info_param'][$key+1]['param_default_value'];
                    } else {
                        $interface_param[$key]['param_default_value'] = $_POST['info_param'][$key+1]['enmu_select'];
                    }

                }
            }
            $response_string = $this->send_http_request($interface_info, $interface_header, $interface_param);
        }

        include $this->admin_tpl('interface_admin_detail');
    }

    private function send_http_request($info, $header, $param) {

        $ch = curl_init();

        $url = $info['request_url'];
        $param_array = array();
        if ( is_array($param) && count($param) > 0 ) {
            foreach ($param as $key => $value) {
                $param_array[] = $value['param_key'] . '=' . $value['param_default_value'];
            }
        }
        if ( $info['request_method'] == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);    // post 提交方式

            $params = implode('&', $param_array);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        } else {
            $url = $url . '?' . implode('&', $param_array);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $headers = array(
            'User-Agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9) Gecko/2008052906 Firefox/3.0',
        );
        if(is_array($header) && count($header) > 0) {
            foreach ($header as $key => $value) {
                $headers[] = $value['header_key'] . ':' . $value['header_value'];
            }
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $output = curl_exec($ch);

        curl_close($ch);

        return $output;
    }
}
?>