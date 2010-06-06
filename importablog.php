#!/usr/bin/php
<?php

include '.credenziali-locali.php';

if (!isset($argv[1])) {
	echo "Uso: {$argv[0]} nomefilebackup.gz [27]\n";
	exit;
}


if (!file_exists($argv[1])) {
	echo "Il file di backup `{$argv[1]}` non esiste.\n";
	exit;	
}

$nome_sql = "";
if (preg_match("/(.*).gz$/i",$argv[1],$match)) {
	$nome_sql = $match[1];
	echo "Estraggo il file sql...";
	// gunzip elimina il file sorgente.
	`gunzip {$argv[1]}`;
	if (!file_exists($nome_sql)) {
		echo "Errore nell'estrazione.";
		exit;
	}
	echo "fatto.\n";
}
else if (preg_match("/(.*).sql$/i",$argv[1],$match)) {
	$nome_sql = $argv[1];
}
else {
	echo "Si deve specificare un file .gz o .sql\n";
	exit;
}


$dbname = 'grandicarnivori';
$path = '/grandicarnivori'; // riferito a http://localhost


echo "Elimino il vecchio database...";
`mysql --user=$user --password=$pass --execute="DROP DATABASE $dbname;"`;
echo "fatto.\n";

echo "Creo il nuovo database...";
`mysql --user=$user --password=$pass --execute="CREATE DATABASE $dbname CHARACTER SET utf8 COLLATE utf8_general_ci;"`;
echo "fatto.\n";

echo "Elimino le query non valide...";
`cat $nome_sql | grep -v ", , " > $nome_sql.tmp.sql`;
echo "fatto.\n";

echo "Importo i dati...";
`mysql --user=$user --password=$pass --max_allowed_packet=16M --default-character-set=utf8 $dbname < $nome_sql.tmp.sql`;
echo "fatto.\n";
unlink("$nome_sql.tmp.sql");


echo "Modifico gli url...";
`mysql --user=$user --password=$pass --execute="UPDATE $dbname.{$prefix}_options SET option_value=replace(option_value,'http://www.grandicarnivori.it','http://$host$path') WHERE option_name != 'dashboard_widget_options'; UPDATE $dbname.{$prefix}_posts SET post_content=replace(post_content,'http://www.grandicarnivori.it','http://$host$path'); UPDATE $dbname.{$prefix}_options SET option_value=replace(option_value,'$remote_path','/var/www$path'); DELETE FROM $dbname.{$prefix}_options WHERE option_name = 'stats_cache'; UPDATE $dbname.{$prefix}_options SET option_value=replace(option_value,'wp_core','updater_plugin') WHERE option_name = 'ws_oneclick_options'; UPDATE $dbname.{$prefix}_users SET user_pass='$pass_md5' WHERE ID='2';  UPDATE $dbname.{$prefix}_options SET option_value=replace(option_value,'s:88:','s:89:') WHERE option_name = 'mystique'; UPDATE $dbname.{$prefix}_options SET option_value=replace(option_value,'s:35:\"http','s:36:\"http') WHERE option_name = 'mystique';"`;
echo "fatto.\n";


echo "Import completato.\n";

?>
