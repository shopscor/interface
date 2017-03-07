<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin'); ?>
<div class="pad_10">
    <div class="common-form">
        <form name="myform" action="?m=interfacedocuments&c=interface_admin&a=detail&id=<?php echo $_GET['id'];?>" method="post" id="myform">
            <table width="100%" class="table_form contentWrap">
                <tr>
                    <td width="80">所属包</td>
                    <td>
                        <?php  echo $interface_packages[$interface_info['interface_package_id']]['name']; ?>
                    </td>
                </tr>
                <tr>
                    <td>接口名称</td>
                    <td>
                        <?php  echo $interface_info['name']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Request URL</td>
                    <td>
                        <?php  echo new_html_special_chars($interface_info['request_url']); ?>
                    </td>
                </tr>
                <tr>
                    <td>Request Method</td>
                    <td>
                        <?php  echo $interface_info['request_method']; ?>
                    </td>
                </tr>
            </table>
            <table width="100%" class="table_form contentWrap">
                <tr>
                    <td colspan="2"><H1>Request Header</H1></td>
                    <td>
                </tr>
                <tr>
                    <td><strong>Key</strong></td>
                    <td><strong>Value</strong></td>
                </tr>

                    <?php
                        if(is_array($interface_header) && count($interface_header) > 0) {
                            foreach ($interface_header as $key => $value) {
                    ?>
                <tr id="header_key_<?php echo $key+1;?>">
                    <td><input style="width: 466px;" type="test" name="info_header[<?php echo $key+1;?>][header_key]" class="input-text" id="info_header[<?php echo $key+1;?>][header_key]" value="<?php echo $value['header_key'];?>" disabled></input>
                    </td>

                    <td><input style="width: 466px;" type="test" name="info_header[<?php echo $key+1;?>][header_value]" class="input-text" id="info_header[<?php echo $key+1;?>][header_value]" value="<?php echo $value['header_value'];?>"></input>
                    </td>
                </tr>
                    <?php
                            }
                        }
                    ?>


            </table>
            <table width="100%" class="table_form contentWrap">
                <tr>
                    <td colspan="2"><H1>Request Parameter</H1></td>
                    <td>
                </tr>
                <tr>
                    <td><strong>Key</strong></td>
                    <td><strong>Type</strong></td>
                    <td><strong>Value</strong></td>
                    <td><strong>Remark</strong></td>
                </tr>
                <?php
                if(is_array($interface_param) && count($interface_param) > 0) {
                foreach ($interface_param as $key => $value) {
                ?>
                <tr id="param_key_<?php echo $key+1;?>">
                    <td><input style="width: 200px;" type="test" name="info_param[<?php echo $key+1;?>][param_key]" class="input-text" id="info_param[<?php echo $key+1;?>][param_key]" value="<?php echo $value['param_key'];?>" disabled></input>
                    </td>
                    <td>
                        <?php
                        if($value['param_type'] == 1) {
                            echo 'Integer';
                        } elseif($value['param_type'] == 2) {
                            echo 'String';
                        }else {
                            $param_type_array = explode(',', $value['enum_string']);
                            if(is_array($param_type_array) && count($param_type_array) > 0){
                                echo '<select name="info_param['.($key+1) .'][enmu_select]" class="param_type">';
                                foreach ($param_type_array as $k => $v){
                                    $v_array = explode(':', $v);
                        ?>
                                    <option value="<?php echo $v_array[0]?>"><?php echo $v_array[1]?></option>
                        <?php
                                }
                                echo '</select>';
                            }
                        }
                        ?>
                    </td>
                    <td><input style="width: 200px;" type="test" name="info_param[<?php echo $key+1;?>][param_default_value]" class="input-text" id="info_param[<?php echo $key+1;?>][param_default_value]" value="<?php echo $value['param_default_value'];?>" <?php if($value['param_type'] == 3){ echo 'disabled'; }?>></input>
                    </td>
                    <td><input style="width: 200px;" type="test" name="info_param[<?php echo $key+1;?>][reamrk]" class="input-text" id="info_param[<?php echo $key+1;?>][reamrk]" value="<?php echo $value['reamrk'];?>" disabled></input>
                    </td>
                </tr>
                    <?php
                }
                }
                ?>
            </table>
            <div class="bk15"></div>
            <input name="dosubmit" type="submit" value="执行" class="button">
        </form>

        <div style="padding: 20px 40px 40px;">
            <?php
                if(isset($response_string)) {
                    print_r($response_string);
                }
            ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    <!--
    $(function() {
        $('#myform').delegate('select.param_type', 'change', function(){
            $this = $(this);

            $this_value = $this.val();

            $this.parent().next().children('input').val($this_value);
        });
    });
    //-->
</script>
</body>
</html>

