<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_validator = true;
include $this->admin_tpl('header', 'admin'); ?>
<div class="pad_10">
    <div class="common-form">
        <form name="myform" action="?m=interfacedocuments&c=interface_package&a=edit" method="post" id="myform">
            <table width="100%" class="table_form contentWrap">
                <tr>
                    <td width="80">包名</td>
                    <td><input type="test" name="info[name]" class="input-text" id="name" value="<?php echo $result['name'];?>"></input></td>
                </tr>
                <tr>
                    <td>描述</td>
                    <td><input type="test" name="info[description]" class="input-text" id="description" value="<?php echo  $result['description'];?>"></input>
                    </td>
                </tr>
            </table>
            <div class="bk15"></div>
            <input name="info[id]" value="<?php echo $result['id'];?>" type="hidden">
            <input name="dosubmit" type="submit" value="<?php echo L('submit') ?>" class="button">
        </form>
    </div>
</div>
</body>
</html>

