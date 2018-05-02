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