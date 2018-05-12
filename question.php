<?php 
<?php
# URL重写问题
PHP5.5以上
[ Apache ]规则这一行：
RewriteRule ^(.*)$ index.php/$1 [QSA,PT,L]
导致No input file specified.
需要修改成：
RewriteRule ^(.*)$ index.php [L,E=PATH_INFO:$1]

php_uname() — 返回运行 PHP 的系统的有关信息。


#Thinkphp5
	判断条件查询的分页是否有数据，paginate方法需要使用返回值的 isEmpty() 方法判断；
#wechat 开发过程中的问题
  1. 微信素材管理中，永久的视频素材的群发无需进行文档中的额外请求post得到的media_id，上传得到的media_id就可进行群发功能。
  2. 根据标签的群发接口，只能单独的标签进行群发。
