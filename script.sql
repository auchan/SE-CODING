USE [master]
GO
/****** Object:  Database [TM4]    Script Date: 2014/6/7 22:40:29 ******/
CREATE DATABASE [TM4]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'TM4', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL11.MSSQLSERVER\MSSQL\DATA\TM4.mdf' , SIZE = 5120KB , MAXSIZE = UNLIMITED, FILEGROWTH = 1024KB )
 LOG ON 
( NAME = N'TM4_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL11.MSSQLSERVER\MSSQL\DATA\TM4_log.ldf' , SIZE = 1024KB , MAXSIZE = 2048GB , FILEGROWTH = 10%)
GO
ALTER DATABASE [TM4] SET COMPATIBILITY_LEVEL = 110
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [TM4].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [TM4] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [TM4] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [TM4] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [TM4] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [TM4] SET ARITHABORT OFF 
GO
ALTER DATABASE [TM4] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [TM4] SET AUTO_CREATE_STATISTICS ON 
GO
ALTER DATABASE [TM4] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [TM4] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [TM4] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [TM4] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [TM4] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [TM4] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [TM4] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [TM4] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [TM4] SET  DISABLE_BROKER 
GO
ALTER DATABASE [TM4] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [TM4] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [TM4] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [TM4] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [TM4] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [TM4] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [TM4] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [TM4] SET RECOVERY FULL 
GO
ALTER DATABASE [TM4] SET  MULTI_USER 
GO
ALTER DATABASE [TM4] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [TM4] SET DB_CHAINING OFF 
GO
ALTER DATABASE [TM4] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [TM4] SET TARGET_RECOVERY_TIME = 0 SECONDS 
GO
EXEC sys.sp_db_vardecimal_storage_format N'TM4', N'ON'
GO
USE [TM4]
GO
/****** Object:  StoredProcedure [dbo].[admin_look_order]    Script Date: 2014/6/7 22:40:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create proc [dbo].[admin_look_order]
as
select  o.order_id, table_name, datetime, foodname, foodprice, food_num, totalprice, order_state
from [order]as o inner join food_in_order as fio 
		on o.order_id = fio.order_id, food, [table] as t
where food_id = foodid and o.table_id = t.table_id
order by order_id desc

GO
/****** Object:  StoredProcedure [dbo].[cooker_call_num]    Script Date: 2014/6/7 22:40:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create proc [dbo].[cooker_call_num]
as
	select count(call_state) as callnum
	from cooker_call
	where call_state = 0

GO
/****** Object:  StoredProcedure [dbo].[cust_look_order]    Script Date: 2014/6/7 22:40:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create proc [dbo].[cust_look_order](@uid int)
as
select  o.order_id, table_name, datetime, foodname, foodprice, food_num, totalprice, order_state
from [order]as o inner join food_in_order as fio 
		on o.order_id = fio.order_id, food, [table] as t
where food_id = foodid and o.table_id = t.table_id and owner_id = @uid
order by order_id desc

GO
/****** Object:  StoredProcedure [dbo].[customer_call_num]    Script Date: 2014/6/7 22:40:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create proc [dbo].[customer_call_num]
as
	select count(call_state) as callnum
	from customer_call
	where call_state <> 1

GO
/****** Object:  StoredProcedure [dbo].[del_zero_food]    Script Date: 2014/6/7 22:40:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create proc [dbo].[del_zero_food]
as 
	delete from food_in_order
	where food_num = 0

GO
/****** Object:  StoredProcedure [dbo].[load_order]    Script Date: 2014/6/7 22:40:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create proc [dbo].[load_order] (@tid int)
as
	select order_id, food_id, food_num, foodname, foodprice, food_state, process
	from food_in_order inner join food on food_id = foodid
	where order_id in (
		select top 1 order_id
		from [order]
		where table_id = @tid and order_state = 0)

GO
/****** Object:  StoredProcedure [dbo].[load_order_via_oid]    Script Date: 2014/6/7 22:40:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create proc [dbo].[load_order_via_oid] (@oid int)
as	
	select order_id, food_id, food_num, foodname, food_state, process
	from food_in_order inner join food on food_id = foodid
	where order_id = @oid

GO
/****** Object:  StoredProcedure [dbo].[order_look_food]    Script Date: 2014/6/7 22:40:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create proc [dbo].[order_look_food](@oid int)
as
	select foodname as fname, food_num as fnum
	from food_in_order inner join food on food_id = foodid
	where order_id = @oid

GO
/****** Object:  StoredProcedure [dbo].[read_cust_req]    Script Date: 2014/6/7 22:40:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
create proc [dbo].[read_cust_req]
as
	select table_id, datetime, call_state
	from customer_call
	where call_state <> 1

GO
/****** Object:  Table [dbo].[cooker_call]    Script Date: 2014/6/7 22:40:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[cooker_call](
	[ccid] [int] IDENTITY(1,1) NOT NULL,
	[datetime] [datetime] NULL,
	[call_state] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[ccid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[customer]    Script Date: 2014/6/7 22:40:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[customer](
	[uid] [int] NOT NULL,
	[email] [varchar](64) NULL,
	[phonenumber] [varchar](15) NULL,
	[regdate] [numeric](10, 0) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[customer_call]    Script Date: 2014/6/7 22:40:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[customer_call](
	[table_id] [int] NULL,
	[datetime] [datetime] NULL,
	[call_state] [int] NULL
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[food]    Script Date: 2014/6/7 22:40:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[food](
	[foodid] [int] IDENTITY(1,1) NOT NULL,
	[foodname] [varchar](32) NOT NULL,
	[foodprice] [float] NOT NULL,
	[foodtype] [int] NOT NULL,
	[picurl] [varchar](50) NULL,
	[descrip] [varchar](100) NULL,
PRIMARY KEY CLUSTERED 
(
	[foodid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[food_in_order]    Script Date: 2014/6/7 22:40:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[food_in_order](
	[order_id] [int] NOT NULL,
	[food_id] [int] NOT NULL,
	[food_num] [int] NULL,
	[food_state] [int] NULL,
	[process] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[order_id] ASC,
	[food_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[order]    Script Date: 2014/6/7 22:40:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[order](
	[order_id] [int] IDENTITY(1,1) NOT NULL,
	[datetime] [datetime] NULL,
	[order_state] [int] NULL,
	[totalprice] [float] NULL,
	[owner_id] [int] NULL,
	[table_id] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[order_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[staff]    Script Date: 2014/6/7 22:40:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[staff](
	[uid] [int] NOT NULL,
	[name] [char](16) NULL,
	[sex] [tinyint] NULL,
	[age] [tinyint] NULL,
	[phonenumber] [varchar](15) NULL,
	[regdate] [numeric](10, 0) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[table]    Script Date: 2014/6/7 22:40:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[table](
	[table_id] [int] NOT NULL,
	[table_name] [varchar](40) NULL,
	[table_state] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[table_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[user]    Script Date: 2014/6/7 22:40:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[user](
	[uid] [int] IDENTITY(1,1) NOT NULL,
	[username] [char](16) NOT NULL,
	[password] [char](32) NOT NULL,
	[type] [tinyint] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[uid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[user_have_order]    Script Date: 2014/6/7 22:40:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[user_have_order](
	[uid] [int] NOT NULL,
	[oid] [int] NOT NULL,
	[finished] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[uid] ASC,
	[oid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
ALTER TABLE [dbo].[customer] ADD  DEFAULT ('0') FOR [regdate]
GO
ALTER TABLE [dbo].[food_in_order] ADD  DEFAULT ((1)) FOR [food_num]
GO
ALTER TABLE [dbo].[food_in_order] ADD  DEFAULT ((0)) FOR [food_state]
GO
ALTER TABLE [dbo].[staff] ADD  DEFAULT ('0') FOR [regdate]
GO
ALTER TABLE [dbo].[user_have_order] ADD  DEFAULT ((0)) FOR [finished]
GO
ALTER TABLE [dbo].[customer]  WITH CHECK ADD  CONSTRAINT [FK_customer_uid_user] FOREIGN KEY([uid])
REFERENCES [dbo].[user] ([uid])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[customer] CHECK CONSTRAINT [FK_customer_uid_user]
GO
ALTER TABLE [dbo].[food_in_order]  WITH CHECK ADD  CONSTRAINT [FK_food_in_order] FOREIGN KEY([order_id])
REFERENCES [dbo].[order] ([order_id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[food_in_order] CHECK CONSTRAINT [FK_food_in_order]
GO
ALTER TABLE [dbo].[staff]  WITH CHECK ADD  CONSTRAINT [FK_staff_uid_user] FOREIGN KEY([uid])
REFERENCES [dbo].[user] ([uid])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[staff] CHECK CONSTRAINT [FK_staff_uid_user]
GO
USE [master]
GO
ALTER DATABASE [TM4] SET  READ_WRITE 
GO
