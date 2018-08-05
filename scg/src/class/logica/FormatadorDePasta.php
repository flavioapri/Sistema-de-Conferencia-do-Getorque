<?php

/*
 * Remove todos os arquivos de uma determinada pasta.
 */
class FormatadorDePasta {

	public static function removerArquivos() {
		$diretorio = 'C:\Users\Flavio\git\scg\uploads'; // Diretório para onde os arquivos são enviados
		$di = new RecursiveDirectoryIterator($diretorio, FilesystemIterator::SKIP_DOTS);
		$ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
		
		if(is_dir($diretorio)) {
			foreach($ri as $file)
				$file->isDir() ? rmdir($file) : unlink($file);
		}
	}
}