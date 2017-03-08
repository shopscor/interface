<?php
/**
 * 管理员后台会员组操作类
 */

defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_class('admin', 'admin', 0);

class interface_package extends admin {

    private $db;
    private $param_type = array(1=>'Integer', 2=>'String', 3=>'Enum');

    function __construct() {
        parent::__construct();
        $this->package_db = pc_base::load_model('interface_package_model');
        $this->op = pc_base::load_app_class('interface_op');

        $this->interface_db = pc_base::load_model('interface_model');
        $this->interface_header_db = pc_base::load_model('interface_header_model');
        $this->interface_parameter_db = pc_base::load_model('interface_param_model');
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

    public function create_word() {
        require_once VENDOR_PATH . 'PhpWord' . DIRECTORY_SEPARATOR . 'MyPHPWord.php';

        // 通过package id 获取所有的接口
        $package_id = $_GET['id'];
        $interface_packages_data = $this->package_db->get_one(array('id' => $package_id));

        // 获取包下的所有的接口
        $interface_info = $this->interface_db->select(array('interface_package_id'=>$package_id));

        if ( is_array($interface_info)  && count($interface_info) > 0 ) {
            $interface_id_array = array();
            $interfaces = array();
            foreach ($interface_info as $key => $value) {
                $interface_id_array[$value['id']] = $value['id'];
                $interfaces[$value['id']] = $value;
            }

            // 获取所有接口下的header
            $interface_header = $this->interface_header_db->select('interface_id IN (' . implode(',', $interface_id_array) .')');

            if (is_array($interface_header) && count($interface_header) > 0) {
                foreach ( $interface_header as $key => $value) {
                    if ( isset($interfaces[$value['interface_id']]) ) {
                        $interfaces[$value['interface_id']] ['headers'][] = $value;
                    }
                }
            }

            // 获取所有接口下的parametor
            $interface_param = $this->interface_parameter_db->select('interface_id IN (' . implode(',', $interface_id_array) .')');

            if (is_array($interface_param) && count($interface_param) > 0) {
                foreach ( $interface_param as $key => $value) {
                    if ( isset($interfaces[$value['interface_id']]) ) {
                        $interfaces[$value['interface_id']] ['params'][] = $value;
                    }
                }
            }

            $PHPWord = new MyPHPWord();

            //设置头部标题 包名
            $PHPWord->addText($interface_packages_data['name'], 'H1', 'CENTER');
            // 设置副标题
            $PHPWord->addText('-------'.$interface_packages_data['description'], 'NORMAL', 'RIGHT');

            $PHPWord->addPageBreak();

            // 循环设置所有接口
            foreach ($interfaces as $key => $value) {
                // 设置接口名称
                $PHPWord->addText($value['name'], 'H2', 'LEFT');

                //设置第二标题
                $PHPWord->addText('Request Url', 'H3', 'LEFT');
                $PHPWord->addTextBreak(1);

                $PHPWord->addText('Method : ' . $value['request_method'], 'NORMAL', 'LEFT');
                $PHPWord->addText('URL : ' . $value['request_url'], 'NORMAL', 'LEFT');

                //设置header
                $PHPWord->addText('HTTP HEADER', 'H3', 'LEFT');
                $PHPWord->addTextBreak(1);

                if ( isset($value['headers']) && is_array($value['headers']) && count($value['headers']) > 0 ) {
                    $headers_array = array(array('Key' , 'Value'));
                    foreach ($value['headers'] as $key_header => $value_header) {
                        $row = array( $value_header['header_key'] , $value_header['header_value']);

                        array_push($headers_array, $row);
                    }

                    $PHPWord->addTable($headers_array);
                }

                //设置param
                $PHPWord->addText('HTTP PARAM', 'H3', 'LEFT');
                $PHPWord->addTextBreak(1);

                if ( isset($value['params']) && is_array($value['params']) && count($value['params']) > 0 ) {
                    $params_array = array(array('Field' , 'Type', 'Desc'));
                    foreach ($value['params'] as $key_param => $value_param) {
                        if($value_param['param_type'] == 3) {
                            $row = array( $value_param['param_key'] , $this->param_type[$value_param['param_type']], $value_param['enum_string'] . '  ' . $value_param['reamrk']);
                        } else {
                            $row = array( $value_param['param_key'] , $this->param_type[$value_param['param_type']], $value_param['reamrk']);
                        }

                        array_push($params_array, $row);
                    }

                    $PHPWord->addTable($params_array);
                }

                $PHPWord->addPageBreak();
            }


            $PHPWord->downPHPWord($interface_packages_data['name']);
        } else {
            showmessage('此包下没有任何的接口');
        }



    }
}
?>