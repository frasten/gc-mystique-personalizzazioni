#!/usr/bin/php
<?php

if (isset($_SERVER['REMOTE_ADDR'])) die();

$cur_dir = realpath(dirname(__FILE__));

echo `rm -rf mystique`;
echo `cd ~/informatica/themes/mystique/mystique-latest/ && svn export . $cur_dir/mystique`;
echo `cd patch_mystique && ./applica.php $cur_dir/mystique`;

?>
