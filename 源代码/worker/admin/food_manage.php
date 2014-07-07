<html>
<head>
	<meta charset='gb2312'>
	<title>admin</title>
	<base href="../../" />
	<link rel="stylesheet" type="text/css" href="easyui/themes/metro/easyui.css">
	<link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
	<script type="text/javascript" src="easyui/jquery.min.js"></script>
	<script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
</head>
<body>
<?php
session_start();
//����Ƿ��¼����û��¼��ת���¼����
if(!isset($_SESSION['admin'])){
    header("Location:/worker");
    exit();
}

?>
<div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newFood()">��Ӳ�Ʒ</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editFood()">�޸Ĳ�Ʒ��Ϣ</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyFood()">ɾ����Ʒ</a>
</div>
<table id="dg" class="easyui-datagrid"  url='Action/admin/get_food.php' toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true">
    <thead>
        <tr>
            <th data-options="field:'fid'">foodid</th>
			<th data-options="field:'fname'">foodname</th>
			<th data-options="field:'fprice'" style="display:none;">foodprice</th>
			<th data-options="field:'ftype'">foodtype</th>
            <th data-options="field:'picurl'">picurl</th>
            <th data-options="field:'descrip'">description</th>
        </tr>
    </thead>
 
</table>    
<div id="dlg" class="easyui-dialog" style="width:400px;height:300px;padding:10px 20px"
		closed="true" buttons="#dlg-buttons">
	<div class="ftitle">Food Information</div>
	<form id="fm" method="post" novalidate>
		<table>
			<tr>
				<td class="label">����:</td>
				<td><input name="fname" type="text"  class="easyui-validatebox" required="true"></input></td>
			</tr>
			<tr>
				<td class="label">�۸�:</td>
				<td><input name="fprice" type="text"  class="easyui-validatebox" required="true"></input></td>
			</tr>
			<tr>
				<td class="label">����:</td>
				<td>
					<select id="ftype" class="easyui-combobox" name="ftype" style="width:150px;" >
					<option value="01">�����Ƽ�</option>
					<option value="02">������ɫ</option>
					<option value="03">���ó�</option>
					<option value="04">��Ĳ��ó�</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>ͼƬ:</td>
				<td><input name="picurl" type="text"  class="easyui-validatebox" required="true"></input></td>
			</tr>
			<tr>
				<td class="label">����:</td>
				<td><input name="descrip" type="text"></input></td>
			</tr>
		</table>
	</form>
</div>
<div id="dlg-buttons">
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveFood()">Save</a>
	<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancel</a>
</div>
<script type="text/javascript">
	var url;
	function newFood(){
		$('#dlg').dialog('open').dialog('setTitle','New Food');
		$('#fm').form('clear');
		url = 'Action/AddFoodAction.php';
	}
	function editFood(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$('#dlg').dialog('open').dialog('setTitle','Edit Food');
			$('#fm').form('load',row);
			url = 'Action/EditFoodAction.php?fid='+row.fid;
		}
	}
	function saveFood(){
		$('#fm').form('submit',{
			url: url,
			onSubmit: function(){
				return $(this).form('validate');
			},
			success: function(result){
				var result = eval('('+result+')');
				if (result.successMsg){
					$.messager.show({
						title: 'Success',
						msg: result.successMsg
					});				
				}
				if (result.errorMsg){
					$.messager.show({
						title: 'Error',
						msg: result.errorMsg
					});
				} else {
					$('#dlg').dialog('close');        // close the dialog
					$('#dg').datagrid('reload');    // reload the user data
				}
			}
		});
	}
	function destroyFood(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$.messager.confirm('Confirm','Are you sure you want to destroy this food?',function(r){
				if (r){
					$.post('Action/DeleteFoodAction.php',{fid:row.fid},function(result){
						if (result.success){
							$('#dg').datagrid('reload');    // reload the user data
						} else {
							$.messager.show({    // show error message
								title: 'Error',
								msg: result.errorMsg
							});
						}
					},'json');
				}
			});
		}
	}
</script>
</body>
</html>