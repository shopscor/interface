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
                                <?php if ($modules[$d]['iscore']) {?><span style="color: #999"><?php echo L('ban')?></span><?php } else {?><a href="javascript:void(0);" onclick="if(confirm('<?php echo L('confirm', array('message'=>$modules[$d]['name']))?>')){uninstall('<?php echo $d?>');return false;}"><font color="red"><?php echo L('unload')?></font></a><?php }?>
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