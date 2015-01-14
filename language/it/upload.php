<?php
/**
*
* @package Upload Extensions
* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_UPLOAD_EXT_TITLE'				=> 'Carica estensione',
	'ACP_UPLOAD_EXT_CONFIG_TITLE'		=> 'Carica estensione',
	'ACP_UPLOAD_EXT_TITLE_EXPLAIN'		=> 'Carica estensione permette di caricare il file zip di un\'estensione o di cancellarle dal server.<br />Con quest\'estensione, è possibile installare, aggiornare o rimuovere i file zip delle estensioni senza l\'uso del server FTP. Se l\'estensione da caricare è già installata, viene aggiornata coi file caricati.',
	'UPLOAD'							=> 'Carica',
	'BROWSE'							=> 'Apri',
	'EXTENSION_UPLOAD'					=> 'Carica estensione',
	'EXTENSION_UPLOAD_EXPLAIN'			=> 'Qui è possibile caricare il file zip di un\'estensione contenente i file necessari all\'installazione dal proprio computer o da un server remoto. “Carica estensione” proverà ad estrarre i file per l\'installazione.<br />Scegli un file o specifica l\'indirizzo del file da installare qui in basso.',
	'EXT_UPLOAD_INIT_FAIL'				=> 'Errore nell\'inizializzazione del processo di caricamento.',
	'EXT_NOT_WRITABLE'					=> 'La cartella ext/ è di sola lettura. Perché “Carica estensione” funzioni, è necessario che sia scrivibile. Correggere i permessi o le impostazioni e riprovare.',
	'EXT_UPLOAD_ERROR'					=> 'Estensione non caricata. Assicurarsi di avere un file zip di estensione corretto e riprovare.',
	'NO_UPLOAD_FILE'					=> 'Nessun file specificato o errore di caricamento.',
	'NOT_AN_EXTENSION'					=> 'Il file zip caricato non è un\'estensione per phpBB. Il file non è stato salvato sul server.',

	'EXTENSION_UPLOADED'				=> 'L\'estensione “%s” è stata caricata.',
	'EXTENSIONS_AVAILABLE'				=> 'Estensioni disponibili',
	'EXTENSION_INVALID_LIST'			=> 'Elenco estensioni',
	'EXTENSION_UPLOADED_ENABLE'			=> 'Abilita l\'estensione caricata',
	'ACP_UPLOAD_EXT_UNPACK'				=> 'Estrai estensione',
	'ACP_UPLOAD_EXT_CONT'				=> 'Contenuto del pacchetto: %s',

	'EXTENSION_DELETE'					=> 'Rimuovi estensione',
	'EXTENSION_DELETE_CONFIRM'			=> 'Sei sicuro di voler rimuovere l\'estensione “%s”?',
	'EXT_DELETE_SUCCESS'				=> 'L\'estensione è stata rimossa.',
	'EXT_DELETE_ERROR'					=> 'Nessun file specificato o errore durante la rimozione.',

	'EXTENSION_ZIP_DELETE'				=> 'Rimuovi file zip',
	'EXTENSION_ZIP_DELETE_CONFIRM'		=> 'Sei sicuro di voler rimuovere il file zip “%s”?',
	'EXT_ZIP_DELETE_SUCCESS'			=> 'Il file zip dell\'estensione è stato rimosso.',
	'EXT_ZIP_DELETE_ERROR'				=> 'Nessun file specificato o errore durante la rimozione.',

	'ACP_UPLOAD_EXT_ERROR_DEST'			=> 'Nessuna cartella di destinazione o vendor specificata nel file zip caricato. Il file non è stato salvato.',
	'ACP_UPLOAD_EXT_ERROR_COMP'			=> 'File composer.json non trovato nel file zip caricato. Il file non è stato salvato.',
	'ACP_UPLOAD_EXT_ERROR_NOT_SAVED'	=> 'Il file non è stato salvato.',
	'ACP_UPLOAD_EXT_WRONG_RESTORE'		=> 'Si è verificato un errore durante l\'aggiornamento d un\'estensione installata. Si prega di riprovare.',

	'UPLOAD_EXTENSIONS_DEVELOPERS'		=> 'Sviluppatori',

	'SHOW_FILETREE'						=> '<< Mostra struttura file >>',
	'HIDE_FILETREE'						=> '>> Nascondi struttura file <<',

	'EXT_UPLOAD_SAVE_ZIP'				=> 'Salva file zip caricato',
	'ZIP_UPLOADED'						=> 'File zip dell\'estensione caricato',
	'EXT_ENABLE'						=> 'Abilita',
	'EXT_UPLOADED'						=> 'caricata',
	'EXT_UPDATED'						=> 'aggiornata',
	'EXT_UPDATED_LATEST_VERSION'		=> 'aggiornata all\'ultima versione',
	'EXT_UPLOAD_BACK'					=> '« Torna a Carica estensione',

	'ACP_UPLOAD_EXT_DIR'				=> 'Percorso di salvataggio dei file zip di estensione',
	'ACP_UPLOAD_EXT_DIR_EXPLAIN'		=> 'Percorso nella cartella principale di phpBB, per esempio <samp>ext</samp>.<br />È possibile cambiare il percorso di salvataggio dei file zip di estensione specificando una cartella speciale (ad esempio, se si vuole permettere agli utenti di scaricare questi file, è possibile cambiarla in <em>download</em>; se invece si vuole impedire i download, è possibile specificare un percorso superiore di un livello rispetto alla cartella principale del proprio sito web (oppure creare una cartella con un apposito file .htaccess)).',

	'ACP_UPLOAD_EXT_UPDATED'			=> 'L\'estensione installata è stata aggiornata.',
	'ACP_UPLOAD_EXT_UPDATED_EXPLAIN'	=> 'È stata caricata un\'estensione già installata. Quest\'estensione <strong>è stata automaticamente disabilitata</strong> per la sicurezza del processo di aggiornamento. <strong>Controllare</strong> la correttezza dei file caricati e <strong>riabilitare</strong> l\'estensione qualora debba ancora essere usata.',

	'VALID_PHPBB_EXTENSIONS'			=> 'Archivio ufficiale phpbb.com',
));
