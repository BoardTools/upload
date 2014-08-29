<?php
/**
*
* @package Upload Extensions
* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
* @translate in German by Michel_61 (http://www.phpbb.de)
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
	'ACP_UPLOAD_EXT_TITLE'				=> 'Erweiterungen hochladen und aktivieren',
	'ACP_UPLOAD_EXT_CONFIG_TITLE'		=> 'Erweiterungen hochladen',
	'ACP_UPLOAD_EXT_TITLE_EXPLAIN'		=> 'Hier können, anstatt über einen FTP Zugang, Zip-Archive vom PC hochgeladen, als Erweiterung installiert und/oder gelöscht und Updates installiert werden.',
	'UPLOAD'							=> 'hochladen',
	'BROWSE'							=> 'Zeige Inhalt',
	'EXTENSION_UPLOAD'					=> 'Erweiterung hochladen',
	'EXTENSION_UPLOAD_EXPLAIN'			=> 'Das Zip-Archiv einer Erweiterung enthält alle notwendigen Dateien um nach dem Hochladen des Archives eine Installation durchführen zu können. Dazu wird das Zip-Archiv nach dem Hochladen vom eigenen PC auf dem Server in das durch die Erweiterung vorgegebene Verzeichnis entpackt. <br />BEMERKUNG: Nicht jeder Server, beispielsweise auch github.com, unterstützt das Hochladen auf diesem Wege. (Servereinstellungen prüfen falls notwendig)<br />Hierunter im leeren Feld den Pfad zum Zip-Archiv eingeben.',
	'EXT_UPLOAD_INIT_FAIL'				=> 'Es gab einen Fehler bei der Initialisierung der Erweiterung Upload-Prozess.',
	'EXT_NOT_WRITABLE'					=> 'Das ext/ Verzeichnis ist nicht beschreibbar. Für das Hochladen von Dateien ist es erforderlich die Verzeichnissrechte entsprechend einzustellen und anzupassen. Danach den Vorgang wiederholen.',
	'EXT_UPLOAD_ERROR'					=> 'Die Erweiterung wurde nicht hochgeladen. Bitte das Zip-Archiv auf Echtheit und Vollständigkeit überprüfen und erneut versuchen.',
	'NO_UPLOAD_FILE'					=> 'Keine Datei angegeben, oder es gab einen Fehler beim Hochladen.',
	'NOT_AN_EXTENSION'					=> 'Das hochgeladene Zip-Archiv ist keine phpBB-Erweiterung. Die Dateien wurde nicht auf dem Server gespeichert.',

	'EXTENSION_UPLOADED'				=> 'Erweiterung “%s” wurde erfolgreich hochgeladen.',
	'EXTENSIONS_AVAILABLE'				=> 'verfügbaren Erweiterungen',
	'EXTENSION_INVALID_LIST'			=> 'Erweiterungsliste',
	'EXTENSION_UPLOADED_ENABLE'			=> 'Aktiviere die hochgeladene Erweiterung.',
	'ACP_UPLOAD_EXT_UNPACK'				=> 'Erweiterung entpacken',
	'ACP_UPLOAD_EXT_CONT'				=> 'Inhalt des Zip-Archivs: %s',

	'EXTENSION_DELETE'					=> 'Erweiterung Löschen',
	'EXTENSION_DELETE_CONFIRM'			=> 'Bist du sicher das du die Erweiterung “%s” löschen möchtest?',
	'EXT_DELETE_SUCCESS'				=> 'Erweiterung erfolgreich gelöscht.',

	'EXTENSION_ZIP_DELETE'				=> 'Zip-Archiv Löschen',
	'EXTENSION_ZIP_DELETE_CONFIRM'		=> 'Bist du sicher das du das Zip-Archiv “%s” löschen möchtest?',
	'EXT_ZIP_DELETE_SUCCESS'			=> 'Zip-Archiv erfolgreich gelöscht.',

	'ACP_UPLOAD_EXT_ERROR_DEST'			=> 'Kein Anbieter oder Zielordner in der hochgeladenen ZIP-Datei. Die Datei wurde nicht auf dem Server gespeichert.',
	'ACP_UPLOAD_EXT_ERROR_COMP'			=> 'Die Datei composer.json wurde nicht in der hochgeladenen Zip-Datei gefunden. Die Dateien wurden nicht auf dem Server gespeichert.',

	'UPLOAD_EXTENSIONS_DEVELOPERS'		=> 'Entwickler',

	'SHOW_FILETREE'						=> '<< Verzeichnis anzeigen >>',
	'HIDE_FILETREE'						=> '>> Verzeichnis ausblenden <<',

	'ziperror'		=> array(
		'10'		=> 'Datei existiert bereits.',
		'21'		=> 'Zip-Archiv inkonsistent.',
		'18'		=> 'falsches Argument.',
		'14'		=> 'Malloc failure.',
		'9'			=> 'Falsche, oder fehlende Datei.',
		'19'		=> 'Dies ist kein Zip-Archiv.',
		'11'		=> 'Datei kann nicht geöffnet werden.',
		'5'			=> 'Fehler beim lesen der Datei.',
		'4'			=> 'Fehler bei der Dateisuche.'
	),

	'EXT_UPLOAD_SAVE_ZIP'				=> 'Hochgeladenes Zip-Archiv speichern',
	'ZIP_UPLOADED'						=> 'Zip-Archiv der Erweiterung hochgeladen',
	'EXT_ENABLE'						=> 'Aktivieren',
	'EXT_UPLOADED'						=> 'Hochgeladen',
	'EXT_UPLOAD_BACK'					=> '« Zurück zum hochladen von Erweiterungen',
));
