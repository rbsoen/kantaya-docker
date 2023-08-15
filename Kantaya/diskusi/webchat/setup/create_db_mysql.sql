-- Tabela USER
drop database if exists chat;
create database chat;

create table chat.user (
uid integer auto_increment primary key, 
name varchar(20), 
last timestamp, 
rid integer, 
pass varchar(64))
type=heap;


-- Tabela ROOM

create table chat.room (
rid integer auto_increment primary key, 
name varchar(20), 
descript varchar(255), 
typ varchar(1),
adminid integer)
type=heap;

-- Tabela MESSAGE

create table chat.message (
time timestamp,
rid integer,
send_id integer,
rcpt_id integer,
message text)
type=heap;

-- Tabela SESSION
create table chat.session (
uid integer,
time timestamp,
skey varchar(64),
ip varchar(16))
type=heap;

grant all privileges on chat.* to chat_user@localhost 
identified by 'webpass';

--
insert into chat.user values (1, 'admin', 0, 0, PASSWORD('admin'));


insert into chat.room values (null, 'General', 'This is default room', 'N', 100);
insert into chat.room values (null, 'Special', 'This room is for private messages...', 'P', 200);
