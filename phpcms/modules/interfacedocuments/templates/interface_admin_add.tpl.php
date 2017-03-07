<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_validator = true;
include $this->admin_tpl('header', 'admin'); ?>
<div class="pad_10">
    <div class="common-form">
        <form name="myform" action="?m=interfacedocuments&c=interface_admin&a=add" method="post" id="myform">
            <table width="100%" class="table_form contentWrap">
                <tr>
                    <td width="80">所属包</td>
                    <td>
                        <select name="info[interface_package_id]">
                            <?php
                            if (is_array($interface_packages)){
                                foreach ($interface_packages as $d) {
                                    ?>
                                    <option value='<?php echo $d['id'] ?>' <?php if(isset($_GET['interface_package_id']) && $_GET['interface_package_id']==$d['id']){?>selected<?php }?>><?php echo $d['name'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>接口名称</td>
                    <td><input style="width: 466px;" type="test" name="info[name]" class="input-text" id="name" value=""></input>
                    </td>
                </tr>
                <tr>
                    <td>Request URL</td>
                    <td><input style="width: 466px;" type="test" name="info[request_url]" class="input-text" id="request_url" value=""></input>
                    </td>
                </tr>
                <tr>
                    <td>Request Method</td>
                    <td>
                        <select name="info[request_method]">
                            <option value="POST">POST</option>
                            <option value="GET">GET</option>
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
                <tr id="header_key_1">

                    <td><input style="width: 466px;" type="test" name="info_header[1][header_key]" class="input-text" id="info_header[1][header_key]" value=""></input>
                    </td>

                    <td><input style="width: 466px;" type="test" name="info_header[1][header_value]" class="input-text" id="info_header[1][header_value]" value=""></input>
                        <a id="add_header" href="javascript:;">add header</a></td>
                    </td>
                </tr>
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

