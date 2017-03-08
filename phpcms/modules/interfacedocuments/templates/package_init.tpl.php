<?php
defined('IN_ADMIN') or exit('No permission resources.');
$show_dialog = 1;
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
    <div class="table-list">
        <table width="100%" cellspacing="0">
            <thead>
            <tr>
                <th width="220" align="center">接口包名</th>
                <th width='220' align="center">接口描述</th>
                <th width="12%" align="center"><?php echo L('operations_manage')?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (is_array($infos)){
                foreach ($infos as $d){
                        ?>
                        <tr>
                            <td align="center" width="220"><?php echo $d['name']?></td>
                            <td align="center"><?php echo $d['description']?></td>
                            <td align="center">
                                <a href="?m=interfacedocuments&c=interface_package&a=edit&id=<?php echo $d['id'] ?>"><font color="red">编辑</font></a>
                                <a href="?m=interfacedocuments&c=interface_package&a=create_word&id=<?php echo $d['id'] ?>"><font color="red">下载word</font></a>
                            </td>
                        </tr>

                        <?php

                }
            }
            ?>
            </tbody>
        </table>
    </div>
    <div id="pages"><?php echo $pages?></div>
</div>

</body>
</html>