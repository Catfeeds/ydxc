<?php
/**
 * @Author: Marte
 * @Date:   2017-02-16 15:42:25
 * @Last Modified by:   Marte
 * @Last Modified time: 2017-02-19 17:20:51
 */
function smarty_modifier_modcolor($string,$color){
    return '<font color="'.$color.'">'.$string.'</font>';
}

 create table user_zhu(
    id mediumint unsigned  primary key auto_increment,
    usename char(20) not null default '',
    gender char(1) not null default '',
    weight tinyint unsigned default '0',
    birth Date not null default '1999-12-31',
    salary decimal(8,2) default '0',
    lastlogin int unsigned default '0'
    ) engine= myisam default charset=utf8;
    -

    create table uesr_fu(
    id mediumint unsigned primary key auto_increment,
    usename char(20) not null default '',
    intro varchar(1500) not null default ''
    ) engine= myisam default charset=utf8;