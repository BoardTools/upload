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
	'EXTENSION_UPLOAD_EXPLAIN'			=> 'Das Zip-Archiv einer Erweiterung enthält alle notwendigen Dateien um nach dem Hochladen des Archives eine Installation durchführen zu können. Dazu wird das Zip-Archiv nach dem Hochladen vom eigenen PC auf dem Server in das durch die Erweiterung vorgegebene Verzeichnis entpackt.<br />Hierunter im leeren Feld den Pfad zum Zip-Archiv eingeben.',
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
	'ACP_UPLOAD_EXT_ERROR_NOT_SAVED'	=> 'Die Dateien wurden nicht auf dem Server gespeichert.',
	'ACP_UPLOAD_EXT_WRONG_RESTORE'		=> 'An error occurred during the update of an installed extension. Try to update it again.', // to translate

	'UPLOAD_EXTENSIONS_DEVELOPERS'		=> 'Entwickler',

	'SHOW_FILETREE'						=> '<< Verzeichnis anzeigen >>',
	'HIDE_FILETREE'						=> '>> Verzeichnis ausblenden <<',

	'EXT_UPLOAD_SAVE_ZIP'				=> 'Hochgeladenes Zip-Archiv speichern',
	'ZIP_UPLOADED'						=> 'Zip-Archiv der Erweiterung hochgeladen',
	'EXT_ENABLE'						=> 'Aktivieren',
	'KEEP_EXT'						=> 'Keep extension',
	'EXT_UPLOADED'						=> 'Hochgeladen',
	'EXT_UPDATED'						=> 'updated', // to translate
	'EXT_UPDATED_LATEST_VERSION'		=> 'updated to the latest version', // to translate
	'EXT_UPLOAD_BACK'					=> '« Zurück zum hochladen von Erweiterungen',

	'ACP_UPLOAD_EXT_DIR'				=> 'Extensions\' zip packages storage path', // to translate
	'ACP_UPLOAD_EXT_DIR_EXPLAIN'		=> 'Path under your phpBB root directory, e.g. <samp>ext</samp>.<br />You can change this path to store zip packages in a special folder (for example, if you want to let users download those files, you can change it to <em>downloads</em>, and if you want to prohibit those downloads, you can change it to the path that is upper by one level than http root of your website (or you can create a folder with the appropriate .htaccess file)).', // to translate

	'ACP_UPLOAD_EXT_UPDATED'			=> 'The installed extension was updated.', // to translate
	'ACP_UPLOAD_EXT_UPDATED_EXPLAIN'	=> 'You have uploaded a zip file for an already installed extension. That extension <strong>was disabled automatically</strong> to make the update process safer. Now please <strong>check</strong> whether the uploaded files are correct and <strong>enable</strong> the extension if it still should be used on the board.', // to translate
));
