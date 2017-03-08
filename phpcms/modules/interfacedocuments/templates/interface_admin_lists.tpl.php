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

<form name="myform" action="?m=interfacedocuments&c=interface_admin&a=init" method="post" onsubmit="checkuid();return false;">
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
            <a href="?m=interfacedocuments&c=interface_admin&a=edit&id=<?php echo $v['id']?>">编辑</a>
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
function edit(id, name) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'<?php echo L('edit').L('member')?>《'+name+'》',id:'edit',iframe:'?m=member&c=member&a=edit&userid='+id,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;d.document.getElementById('dosubmit').click();return false;}, function(){window.top.art.dialog({id:'edit'}).close()});
}
function move() {
	var ids='';
	$("input[name='userid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:'<?php echo L('plsease_select').L('member')?>',lock:true,width:'200',height:'50',time:1.5},function(){});
		return false;
	}
	window.top.art.dialog({id:'move'}).close();
	window.top.art.dialog({title:'<?php echo L('move').L('member')?>',id:'move',iframe:'?m=member&c=member&a=move&ids='+ids,width:'700',height:'500'}, function(){var d = window.top.art.dialog({id:'move'}).data.iframe;d.$('#dosubmit').click();return false;}, function(){window.top.art.dialog({id:'move'}).close()});
}

function checkuid() {
	var ids='';
	$("input[name='userid[]']:checked").each(function(i, n){
		ids += $(n).val() + ',';
	});
	if(ids=='') {
		window.top.art.dialog({content:'<?php echo L('plsease_select').L('member')?>',lock:true,width:'200',height:'50',time:1.5},function(){});
		return false;
	} else {
		myform.submit();
	}
}

//-->
</script>
</body>
</html>