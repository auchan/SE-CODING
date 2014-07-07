文件/文件夹说明：

* script.sql     建库脚本
* db_init.sql    数据库初始化脚本
* 源代码/        网站的所有文件

服务器环境说明：

* Windows 7 / Windows Server 2008
* Microsoft SQL Server 2008 +
* PHP 5.5
* IIS / Apache
	
安装配置：

	1. 安装数据库 - Microsoft SQL Server 2008 或以后版本
	2. 安装 IIS 或 Apache
	3. 安装 PHP
	4. 运行 script.sql
	5. 运行 db_init.sql
	6. 设置 ODBC, 连接的数据库名称为：TM4
	7. 修改 “源代码/" 目录下conn.php 的内容，odbc_connet的第一个
		参数填写： ODBC 名称，第二个参数填写：数据库用户名，第三个参数填写：数据库密码
	8. 完成。

使用说明：
	
* 网站主界面：http://localhost/
* 管理员/员工登陆: http://localhost/worker/