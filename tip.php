<?php
#文本框省略显示
	overflow: hidden;
	text-overflow: ellipsis;
	white-space: nowrap; //文本不换行，这样超出一行的部分被截取，显示...
	
	//可以给定容器宽度限制，超出部分省略
	max-width: 110px;
	overflow: hidden;
	text-overflow: ellipsis;
	white-space: nowrap;

	overflow: hidden;
	text-overflow: ellipsis;
	display: -webkit-box;
	-webkit-line-clamp: 3;
	-webkit-box-orient: vertical;

// 获得零点的时间戳
$time = strtotime(date('Ymd'));
// 获得今天24点的时间戳
$time = strtotime(date('Ymd')) + 86400;
//php获取本月起始时间戳和结束时间戳
$beginThismonth=mktime(0,0,0,date('m'),1,date('Y'));
$endThismonth=mktime(23,59,59,date('m'),date('t'),date('Y'));

#数组分页显示
/**
 * 数组分页函数 核心函数 array_slice
 * 用此函数之前要先将数据库里面的所有数据按一定的顺序查询出来存入数组中
 * $count  每页多少条数据
 * $page  当前第几页
 * $array  查询出来的所有数组
 * order 0 - 不变   1- 反序
 */
function page_array($count,$page,$array,$order){
  global $countpage; #定全局变量
  $page=(empty($page))?'1':$page; #判断当前页面是否为空 如果为空就表示为第一页面 
    $start=($page-1)*$count; #计算每次分页的开始位置
  if($order==1){
   $array=array_reverse($array);
  }  
  $totals=count($array); 
  $countpage=ceil($totals/$count); #计算总页面数
  $pagedata=array();
 $pagedata=array_slice($array,$start,$count);
  return $pagedata; #返回查询数据
}
/**
 * 分页及显示函数
 * $countpage 全局变量，照写
 * $url 当前url
 */
function show_array($countpage,$url){
   $page=empty($_GET['page'])?1:$_GET['page'];
 if($page > 1){
   $uppage=$page-1;
 }else{
  $uppage=1;
 }
 if($page < $countpage){
   $nextpage=$page+1;
 
 }else{
   $nextpage=$countpage;
 }
    $str='<div style="border:1px; width:300px; height:30px; color:#9999CC">';
 $str.="<span>共 {$countpage} 页 / 第 {$page} 页</span>";
 $str.="<span><a href='$url?page=1'>  首页 </a></span>";
 $str.="<span><a href='$url?page={$uppage}'> 上一页 </a></span>";
 $str.="<span><a href='$url?page={$nextpage}'>下一页 </a></span>";
 $str.="<span><a href='$url?page={$countpage}'>尾页 </a></span>";
 $str.='</div>';
 return $str;
}


js使用history.back返回表单数据丢失的主要原因就是使用了session_start();的原因，该函数会强制当前页面不被缓存。
  https://blog.csdn.net/qinchaoguang123456/article/details/29852881