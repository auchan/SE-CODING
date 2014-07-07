use [TM4]
go
/* 
 * Role：管理员
 * 账号: admin
 * 密码：tm4
 * 类型号：4
 */
insert into [user]
    values('admin', 'c2224b68cb83141211c683c251fc30e1', 4)
go
/*
 * 1. 桌位号
 * 2. 桌位名称
 * 3. 桌位状态
 */
insert into [table]
	values (1, '1号桌', 0),
		   (2, '2号桌', 0),
		   (3, '3号桌', 0),
		   (4, '4号桌', 0),
		   (5, '5号桌', 0)
go
