<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php include $this->admin_tpl('header', 'admin');?>
<div class="pad-lr-10">
<form name="searchform" action="" method="get" >
<input type="hidden" value="member" name="m">
<input type="hidden" value="member" name="c">
<input type="hidden" value="search" name="a">
<input type="hidden" value="879" name="menuid">
<table width="100%" cellspacing="0" class="search-form">
    <tbody>
		<tr>
		<td>
		<div class="explain-col">
            

				<select name="package_id">
					<option value='0' <?php if(isset($_GET['package_id']) && $_GET['package_id']==0){?>selected<?php }?>>All</option>
                    <?php
                    if (is_array($interface_packages)){
                        foreach ($interface_packages as $d) {
                            ?>
                            <option value='<?php echo $d['id'] ?>' <?php if(isset($_GET['package_id']) && $_GET['package_id']==$d['id']){?>selected<?php }?>><?php echo $d['name'] ?></option>
                            <?php
                        }
                    }
                    ?>
				</select>

				接口名称:
				
				<input name="keyword" type="text" value="<?php if(isset($_GET['keyword'])) {echo $_GET['keyword'];}?>" class="input-text" />
				<input type="submit" name="search" class="button" value="<?php echo L('search')?>" />
	</div>
		</td>
		</tr>
    </tbody>
</table>
</form>

<form class="myform" name="myform" action="?m=interfacedocuments&c=interface_admin&a=init" method="post" >
<div class="table-list">
<table width="100%" cellspacing="0">
	<thead>
		<tr>
			<th  align="left" width="20"><input type="checkbox" value="" id="check_box" onclick="selectall('userid[]');"></th>
			<th align="left">接口名称</th>
			<th align="left">包名</th>
			<th align="left">请求url</th>
			<th align="left"><?php echo L('operation')?></th>
		</tr>
	</thead>
<tbody>
<?php
	if(is_array($infos)){
	foreach($infos as $k=>$v) {
?>
    <tr>
		<td align="left"><input type="checkbox" value="<?php echo $v['id']?>" name="userid[]"></td>
		<td align="left"><?php echo $v['name']?></td>
        <td align="left"><?php echo $interface_packages[$v['interface_package_id']]['name']?></td>
		<td align="left"><?php echo new_html_special_chars($v['request_url'])?></td>


		<td align="left">
            <a href="?m=interfacedocuments&c=interface_admin&a=detail&id=<?php echo $v['id']?>">查看</a> |


            <a href="?m=interfacedocuments&c=interface_admin&a=edit&id=<?php echo $v['id']?>">编辑</a> |
            <a href="?m=interfacedocuments&c=interface_admin&a=delete&dosubmit=1&id=<?php echo $v['id']?>" onclick="confirm('<?php echo L('是否删除', array('message' => L('selected')));?>')">删除</a>
		</td>
    </tr>
<?php
	}
}
?>
</tbody>
</table>

<div class="btn">
<label for="check_box"><?php echo L('select_all')?>/<?php echo L('cancel')?></label> <input type="submit" class="button" name="dosubmit" value="<?php echo L('delete')?>" onclick="return confirm('<?php echo L('sure_delete')?>')"/>
<input type="submit" class="button" name="dosubmit" onclick="document.myform.action='?m=member&c=member&a=lock'" value="<?php echo L('lock')?>"/>
<input type="submit" class="button" name="dosubmit" onclick="document.myform.action='?m=member&c=member&a=unlock'" value="<?php echo L('unlock')?>"/>
<input type="button" class="button" name="dosubmit" onclick="move();return false;" value="<?php echo L('move')?>"/>
</div>

<div id="pages"><?php echo $pages?></div>
</div>
</form>
</div>
<script type="text/javascript">
<!--
//-->
</script>
</body>
</html>