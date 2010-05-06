#!/usr/bin/php
<?php
# svn export ~/informatica/themes/mystique/2.3/ mystique

// Uso: ./applica.php <path_mystique>

define( 'LISTA_FILENAME', 'lista');
define( 'DIR_PATCHES', realpath(dirname(__FILE__) ) . '/' );

define( 'ROSSO', "\033[01;31m" );
define( 'VERDE', "\033[01;32m" );
define( 'GIALLO', "\033[01;33m" );
define( 'BLU', "\033[01;33m" );
define( 'BIANCO', "\033[01;37m" );
define( 'COL_DEFAULT', "\033[0m" );


if ( empty($argv[1]) ) {
	echo "Uso: ./{$argv[0]} <PATH_MYSTIQUE>\n";
	exit;
}
$path = realpath( $argv[1] );
if (!$path) {
	echo "Directory {$argv[1]} non valida.\n";
	exit;
}

define( 'DIR_MYSTIQUE', $path . '/' );




register_shutdown_function('stampa_lista_file_patchati');

$lista = file_get_contents( LISTA_FILENAME );
$lista = explode("\n", $lista);


$file_patchati = array();
foreach ($lista as $patch) {
	if (!$patch) continue; // Scarto eventuali linee vuote
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
		exit;
	}
}


function stampa_lista_file_patchati() {
	global $file_patchati;
	echo "\n== Lista file patchati ==\n\n";
	
	foreach ($file_patchati as $f) {
		echo "» $f\n";
	}
	echo "\n";
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

	// 
}

?>
