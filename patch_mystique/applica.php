#!/usr/bin/php
<?php
if (isset($_SERVER['REMOTE_ADDR'])) die();


define( 'LISTA_FILENAME', 'lista');
define( 'DIR_PATCHES', realpath(dirname(__FILE__) ) . '/' );

define( 'ROSSO', "\033[01;31m" );
define( 'VERDE', "\033[01;32m" );
define( 'GIALLO', "\033[01;33m" );
define( 'BLU', "\033[01;33m" );
define( 'BIANCO', "\033[01;37m" );
define( 'COL_DEFAULT', "\033[0m" );

$cur_dir = realpath(dirname(__FILE__));

/*
se scrivo una dir, mi deve applicare su quella dir.
se scrivo uppa, mi deve esportare, applicare e uppare.
se non scrivo niente, deve esportare e applicare.
*/
if ( empty($argv[1]) || $argv[1] == 'uppa') {
	echo `rm -rf $cur_dir/mystique`;
	echo `cd ~/informatica/themes/mystique/mystique-latest/ && svn export . $cur_dir/mystique`;
	define( 'DIR_MYSTIQUE', realpath("$cur_dir/mystique") . '/' );
}

if ( !defined('DIR_MYSTIQUE') ) {
	$path = realpath( $argv[1] );
	if (!$path) {
		echo "Directory {$argv[1]} non valida.\n";
		exit;
	}
	define( 'DIR_MYSTIQUE', $path . '/' );
}






register_shutdown_function('stampa_lista_file_patchati');

$lista = file_get_contents( LISTA_FILENAME );
$lista = explode("\n", $lista);

$muoio = false;
$file_patchati = array();
foreach ($lista as $patch) {
	if (!$patch) continue; // Scarto eventuali linee vuote

	if (! is_file(DIR_PATCHES . $patch)) {
		echo GIALLO . "Patch $patch mancante." . COL_DEFAULT . "\n";
		continue;
	}
	echo "Applico $patch... ";
	unset($output);
	unset($return);
	$comando = "cd " . DIR_MYSTIQUE . " && patch -p0  < " . DIR_PATCHES . $patch;
	exec("$comando 2>&1", $output, $return);
	$nuovi_file_patchati = get_lista_patchati($output);
	$file_patchati = array_merge($file_patchati, $nuovi_file_patchati);
	$file_patchati = array_unique($file_patchati);

	if ($return == 0) {
		// tutto ok
		echo VERDE . "ok" . COL_DEFAULT . "\n";
	}
	else {
		echo ROSSO . "ERRORE" . COL_DEFAULT . ":\n";
		echo implode("\n", $output);
		echo "\n";
		$muoio = true;
		exit;
	}
}




function upload() {
	global $muoio, $file_patchati, $cur_dir, $argv;
	if ($muoio) return;

	/******* UPLOAD *********/
	if (!isset($argv[1]) || $argv[1] != 'uppa') return;
	if (!is_file("$cur_dir/.credenziali.php")) return;
	require_once ("$cur_dir/.credenziali.php");

	$comandi = '';
	foreach ($file_patchati as $f) {
		$dir = dirname($f);
		$comandi .= "put -O www/wp-content/themes/mystique/$dir " . DIR_MYSTIQUE . "$f;";
	}
	echo "== Carico i files sul sito ==\n\n";

	echo `lftp -e "$comandi;exit" -u $user,$pass $host`;
	echo "\n\n";
}





function stampa_lista_file_patchati() {
	global $file_patchati;
	echo "\n== Lista file patchati ==\n\n";
	
	foreach ($file_patchati as $f) {
		echo "» $f\n";
	}
	echo "\n";
	upload();
}

function get_lista_patchati($output) {
	$file_patchati = array();
	$file_rejected = array();
	foreach ($output as $line) {
		if (preg_match("/patching file (.+)$/", $line, $match)) {
			$file_patchati[] = $match[1];
		}
		else if (preg_match("/saving rejects to file (.+).rej/", $line, $match)) {
			$file_rejected[] = $match[1];
		}
	}

	return array_diff($file_patchati, $file_rejected);
}

?>
