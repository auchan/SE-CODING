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
if(!isset($_SESSION['username'])){
    header("Location:worker.html");
    exit();
}else if ($_SESSION['usertype'] != 4) {
	echo 'û�з���Ȩ�ޣ�';
	exit();
}
?>
<div id="toolbar">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">���Ա��</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">�޸�Ա������</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">ɾ��Ա��</a>
</div>
<table id="dg" class="easyui-datagrid"  url='Action/admin/get_staff.php' toolbar="#toolbar" pagination="true"
            rownumbers="true" fitColumns="true" singleSelect="true">
    <thead>
        <tr>
            <th data-options="field:'uid'">uid</th>
			<th data-options="field:'username'">username</th>
			<th data-options="field:'password'">password</th>
			<th data-options="field:'usertype'">usertype</th>
            <th data-options="field:'name'">name</th>
            <th data-options="field:'sex'">sex</th>
			<th data-options="field:'age'">age</th>
			<th data-options="field:'phonenumber'">phonenumber</th>
			<th data-options="field:'regdate'">regdate</th>
        </tr>
    </thead>
 
</table>    
    <div id="dlg" class="easyui-dialog" style="width:400px;height:350px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
        <div class="ftitle">User Information</div>
        <form id="fm" method="post" novalidate>
            <table>
                <tr>
                    <td class="label">�û���:</td>
                    <td><input name="username" type="text"  class="easyui-validatebox" required="true"></input></td>
                </tr>
                <tr>
                    <td class="label">����:</td>
                    <td><input name="password" type="text"  class="easyui-validatebox" required="true"></input></td>
                </tr>
				<tr>
					<td class="label">Ա������:</td>
					<td>
						<select id="usertype" class="easyui-combobox" name="usertype" style="width:150px;" >
						<option value="00">��ѡ��</option>
						<option value="02">ǰ̨</option>
						<option value="03">���</option>
						</select>
					</td>
				</tr>
                <tr>
                    <td>����:</td>
                    <td><input name="name" type="text"  class="easyui-validatebox" required="true"></input></td>
                </tr>
				<tr>
					<td class="label">�Ա�:</td>
					<td>
						<select id="sex" class="easyui-combobox" name="sex" style="width:150px;">
						<option value="-1">��ѡ��</option>
						<option value="00">Ů</option>
						<option value="01">��</option>
						</select>
					</td>
                </tr>
				<tr>
                    <td>����:</td>
                    <td><input name="age" type="text"></input></td>
                </tr>
				<tr>
                    <td>�绰����:</td>
                    <td><input name="phonenumber" type="text"></input></td>
                </tr>
            </table>
        </form>
    </div>
    <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveUser()">Save</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">Cancel</a>
    </div>
<script type="text/javascript">
	var url;
	function newUser(){
		$('#dlg').dialog('open').dialog('setTitle','New Staff');
		$('#fm').form('clear');
		url = 'Action/AddStaffAction.php';
	}
	function editUser(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$('#dlg').dialog('open').dialog('setTitle','Edit User');
			$('#fm').form('load',row);
			url = 'Action/EditStaffAction.php?uid='+row.uid;
		}
	}
	function saveUser(){
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
	function destroyUser(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			$.messager.confirm('Confirm','Are you sure you want to destroy this user?',function(r){
				if (r){
					$.post('Action/DeleteStaffAction.php',{uid:row.uid},function(result){
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