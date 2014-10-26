<?php
/**
* upload.php [Estonian]
* @package Upload Extensions
* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
* @copyright (c) 2014 Upload Extensions Estonian language pack version 0.1 by http://www.phpbbeesti.com/
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'ACP_UPLOAD_EXT_TITLE'				=> 'Lae üles laiendusi',
	'ACP_UPLOAD_EXT_CONFIG_TITLE'		=> 'Lae üles laiendusi',
	'ACP_UPLOAD_EXT_TITLE_EXPLAIN'		=> 'Lae üles laiendusi lubab sul üles laadida laiendusite zip faile või kustutada laienduste kauste serverist.<br />Selle laiendusega sa saad paigaldada/uuendada/kustutada laiendusi ilma, et peaksid kasutama FTP\'d. Kui aga üles laetud laiendus juba eksisteerib, siis seda uuendatakse üles laetud failidega.',
	'UPLOAD'							=> 'Lae üles',
	'BROWSE'							=> 'Sirvi...',
	'EXTENSION_UPLOAD'					=> 'Lae üles laiendus',
	'EXTENSION_UPLOAD_EXPLAIN'			=> 'Siin saad üles laadida kokku pakitud .zip faile. “Lae üles laiendusi” pakib selle ise lahti, ning seadistab selle sulle paigaldamiseks valmis.<br />Vali fail arvutist või kirjuta veebilehe aadress all olevale väljale.',
	'EXT_UPLOAD_INIT_FAIL'				=> 'Tekkis viga, kui alustati laienduse üles laadimise protsessi.',
	'EXT_NOT_WRITABLE'					=> 'ext/ kaust ei ole kirjutatav. See on nõutud, et “Lae üles laiendusi” töötaks korralikult. Palun kohanda antud seadistust, ning proovi uuesti.',
	'EXT_UPLOAD_ERROR'					=> 'Laiendust ei laetud üles. Palun veendu, et laadisid üles õige laienduse .zip faili ja proovi uuesti.',
	'NO_UPLOAD_FILE'					=> 'Ühtegi faili pole määratud või tekkis viga üles laadimise protsessi jooksul.',
	'NOT_AN_EXTENSION'					=> 'Üles laetud .zip fail ei ole phpBB laiend. Faili ei salvestatud serverisse.',

	'EXTENSION_UPLOADED'				=> 'Laiend “%s” on edukalt üles laetud.',
	'EXTENSIONS_AVAILABLE'				=> 'Saadaval laiendused',
	'EXTENSION_INVALID_LIST'			=> 'Laienduste nimekiri',
	'EXTENSION_UPLOADED_ENABLE'			=> 'Luba üles laetud laiendused',
	'ACP_UPLOAD_EXT_UNPACK'				=> 'Paki lahti laiendus',
	'ACP_UPLOAD_EXT_CONT'				=> 'Paki sisu: %s',

	'EXTENSION_DELETE'					=> 'Kustuta laiendus',
	'EXTENSION_DELETE_CONFIRM'			=> 'Oled sa kindel, et soovid kustutada “%s” laienduse?',
	'EXT_DELETE_SUCCESS'				=> 'Laiendus on edukalt kustutatud.',

	'EXTENSION_ZIP_DELETE'				=> 'Kustuta zip fail',
	'EXTENSION_ZIP_DELETE_CONFIRM'		=> 'Oled sa kindel, et soovid kustutada .zip faili - “%s”?',
	'EXT_ZIP_DELETE_SUCCESS'			=> 'Laiendi zip fail on edukalt kustutatud.',

	'ACP_UPLOAD_EXT_ERROR_DEST'			=> 'Vendor\'it või kausta sihtkohta üles laaditud zip failil pole. Faili ei salvestatud serverisse.',
	'ACP_UPLOAD_EXT_ERROR_COMP'			=> 'composer.json ei leitud üles laetud .zip failist. Faili ei salvestatud serverisse.',

	'UPLOAD_EXTENSIONS_DEVELOPERS'		=> 'Arendajad',

	'SHOW_FILETREE'						=> '<< Näita faili puud >>',
	'HIDE_FILETREE'						=> '>> Peida faili puu <<',

	'ziperror'		=> array(
		'10'		=> 'Fail on juba olemas.',
		'21'		=> 'Zip arhiiv on vastuolus.',
		'18'		=> 'Vigane argument.',
		'14'		=> 'Malloc ebaõnnestus.',
		'9'			=> 'Ei leitud sellist faili.',
		'19'		=> 'Tegemist ei ole .zip arhiiviga.',
		'11'		=> 'Faili ei saa avada.',
		'5'			=> 'Loe veateadet.',
		'4'			=> 'Otsi viga.'
	),

	'EXT_UPLOAD_SAVE_ZIP'				=> 'Salvesta üles laetud .zip fail',
	'ZIP_UPLOADED'						=> '.zip arhiiv on üles laetud',
	'EXT_ENABLE'						=> 'Luba',
	'EXT_UPLOADED'						=> 'üles laetud',
	'EXT_UPLOAD_BACK'					=> '« Tagasi Lae üles laiendusi lehele',
));
