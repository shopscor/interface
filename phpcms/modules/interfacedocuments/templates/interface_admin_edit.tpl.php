<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_validator = true;
include $this->admin_tpl('header', 'admin'); ?>
<div class="pad_10">
    <div class="common-form">
        <form name="myform" action="?m=interfacedocuments&c=interface_admin&a=edit" method="post" id="myform">
            <input style="width: 466px;" type="hidden" name="info[id]" class="input-text" id="id" value="<?php echo $interface_info['id']?>">
            <table width="100%" class="table_form contentWrap">
                <tr>
                    <td width="80">所属包</td>
                    <td>
                        <select name="info[interface_package_id]">
                            <?php
                            if (is_array($interface_packages)){
                                foreach ($interface_packages as $d) {
                                    ?>
                                    <option value='<?php echo $d['id'] ?>' <?php if($interface_info['interface_package_id'] == $d['id']){?>selected<?php }?>><?php echo $d['name'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>接口名称</td>
                    <td><input style="width: 466px;" type="test" name="info[name]" class="input-text" id="name" value="<?php echo $interface_info['name']?>"></input>
                    </td>
                </tr>
                <tr>
                    <td>Request URL</td>
                    <td><input style="width: 466px;" type="test" name="info[request_url]" class="input-text" id="request_url" value="<?php echo $interface_info['request_url']?>"></input>
                    </td>
                </tr>
                <tr>
                    <td>Request Method</td>
                    <td>
                        <select name="info[request_method]">
                            <option value="POST" <?php if($interface_info['request_method'] == "POST"){?>selected<?php }?>>POST</option>
                            <option value="GET" <?php if($interface_info['request_method'] == "GET"){?>selected<?php }?>>GET</option>
                        </select>
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
                            <td><input style="width: 466px;" type="test" name="info_header[<?php echo $key+1;?>][header_key]" class="input-text" id="info_header[<?php echo $key+1;?>][header_key]" value="<?php echo $value['header_key'];?>"></input>
                            </td>

                            <td><input style="width: 466px;" type="test" name="info_header[<?php echo $key+1;?>][header_value]" class="input-text" id="info_header[<?php echo $key+1;?>][header_value]" value="<?php echo $value['header_value'];?>"></input>

                        <?php

                        if($key+1 == count($interface_header)) {
                            echo '<a id="add_header" href="javascript:;">add header</a></td>';
                        }

                        echo "</td></tr>";
                    }
                } else {
                ?>
                    <tr id="header_key_1">

                        <td><input style="width: 466px;" type="test" name="info_header[1][header_key]" class="input-text" id="info_header[1][header_key]" value=""></input>
                        </td>

                        <td><input style="width: 466px;" type="test" name="info_header[1][header_value]" class="input-text" id="info_header[1][header_value]" value=""></input>
                            <a id="add_header" href="javascript:;">add header</a></td>
                        </td>
                    </tr>

                    <?php
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
                    <td><strong>DefaultValue</strong></td>
                    <td><strong>Remark</strong></td>
                </tr>

                <?php
                if(is_array($interface_param) && count($interface_param) > 0) {
                    foreach ($interface_param as $key => $value) {
                        ?>
                        <tr id="param_key_<?php echo $key+1; ?>">
                            <td><input style="width: 200px;" type="test" name="info_param[<?php echo $key+1; ?>][param_key]" class="input-text" id="info_param[<?php echo $key+1; ?>][param_key]" value="<?php echo $value['param_key']?>"></input>
                            </td>
                            <td>
                                <select name="info_param[<?php echo $key+1; ?>][param_type]" class="param_type">
                                    <option value="1" <?php if($value['param_type'] == 1){?> selected <?php } ?>>Integer</option>
                                    <option value="2" <?php if($value['param_type'] == 2){?> selected <?php } ?>>String</option>
                                    <option value="3" <?php if($value['param_type'] == 3){?> selected <?php } ?>>Enum</option>
                                </select>

                                <?php
                                    if($value['param_type'] == 3) {
                                        echo '<input value="'.$value['enum_string'].'" class="enum_string input-text" type="input" name="info_param['.($key+1).'][enum_string]" placeholder="例如:1:名字,2:称呼">';
                                    }
                                ?>

                            </td>
                            <td><input style="width: 200px;" type="test" name="info_param[<?php echo $key+1; ?>][param_default_value]" class="input-text" id="info_param[<?php echo $key+1; ?>][param_default_value]" value="<?php echo $value['param_default_value']?>"></input>
                            </td>
                            <td><input style="width: 200px;" type="test" name="info_param[<?php echo $key+1; ?>][reamrk]" class="input-text" id="info_param[<?php echo $key+1; ?>][reamrk]" value="<?php echo $value['reamrk']?>"></input>
                                <?php
                                    if($key+1 == count($interface_param)) {
                                        echo '<a id="add_param" href="javascript:;">add param</a></td>';
                                    }
                                ?>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    ?>

                    <tr id="param_key_1">
                        <td><input style="width: 200px;" type="test" name="info_param[1][param_key]" class="input-text" id="info_param[1][param_key]" value=""></input>
                        </td>
                        <td>
                            <select name="info_param[1][param_type]" class="param_type">
                                <option value="1">Integer</option>
                                <option value="2">String</option>
                                <option value="3">Enum</option>
                            </select>
                        </td>
                        <td><input style="width: 200px;" type="test" name="info_param[1][param_default_value]" class="input-text" id="info_param[1][param_default_value]" value=""></input>
                        </td>
                        <td><input style="width: 200px;" type="test" name="info_param[1][reamrk]" class="input-text" id="info_param[1][reamrk]" value=""></input>
                            <a id="add_param" href="javascript:;">add param</a></td>
                        </td>
                    </tr>


                    <?php
                }
                ?>




            </table>
            <div class="bk15"></div>
            <input name="dosubmit" type="submit" value="<?php echo L('submit') ?>" class="button">
        </form>
    </div>
</div>
<script type="text/javascript">
    <!--
    $(function() {
        $('#myform').delegate('a#add_header', 'click', function(){
            $this_id = $(this).parent().parent().attr('id');
            $this_id_arr = $this_id.split('_');
            $curr_count = $this_id_arr[2];

            $next_count = parseInt($curr_count)+1 ;
            $add_html = '<tr id="header_key_'+$next_count+'"> <td><input style="width: 466px;" type="test" name="info_header['+$next_count+'][header_key]" class="input-text" id="info_header['+$next_count+'][header_key]" value=""></input> </td>  <td><input style="width: 466px;" type="test" name="info_header['+$next_count+'][header_value]" class="input-text" id="info_header['+$next_count+'][header_value]" value=""></input> <a id="add_header" href="javascript:;">add header</a></td> </td> </tr>';

            $parent = $(this).parent().parent();
            $parent.after($add_html);

            $(this).remove();
        });
        $('#myform').delegate('a#add_param', 'click', function() {
            $this_id = $(this).parent().parent().attr('id');
            $this_id_arr = $this_id.split('_');
            $curr_count = $this_id_arr[2];

            $next_count = parseInt($curr_count) + 1;

            $add_html = '<tr id="param_key_'+$next_count+'"><td><input style="width: 200px;" type="test" name="info_param['+$next_count+'][param_key]" class="input-text" id="info_param['+$next_count+'][param_key]" value=""></input> </td> <td><select name="info_param['+$next_count+'][param_type]"  class="param_type"> <option value="1">Integer</option> <option value="2">String</option> <option value="3">Enum</option> </select></td> <td><input style="width: 200px;" type="test" name="info_param['+$next_count+'][param_default_value]" class="input-text" id="info_param['+$next_count+'][param_default_value]" value=""></input> </td> <td><input style="width: 200px;" type="test" name="info_param['+$next_count+'][reamrk]" class="input-text" id="info_param['+$next_count+'][reamrk]" value=""></input> <a id="add_param" href="javascript:;">add param</a></td> </td></tr>';

            $parent = $(this).parent().parent();
            $parent.after($add_html);

            $(this).remove();
        });

        $('#myform').delegate('select.param_type', 'change', function(){
            $this = $(this);

            $this_id = $(this).parent().parent().attr('id');
            $this_id_arr = $this_id.split('_');
            $curr_count = $this_id_arr[2];

            if($this.val() == 3) {
                $text = '<input class="enum_string input-text" type="input" name="info_param['+$curr_count+'][enum_string]" placeholder="例如:1:名字,2:称呼">';
                $this.after($text);
            } else {
                $this.next('.enum_string').remove();
            }
        });
    });
    //-->
</script>
</body>
</html>

