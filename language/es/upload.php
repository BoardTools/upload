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
	'ACP_UPLOAD_EXT_TITLE'				=> 'Subir Extensiones',
	'ACP_UPLOAD_EXT_CONFIG_TITLE'		=> 'Subir Extensiones',
	'ACP_UPLOAD_EXT_TITLE_EXPLAIN'		=> 'Upload Extensions le permite subir archivos zip de extensiones o eliminar extensiones de carpetas del servidor.<br />Con esta extensión puede instalar/actualizar/borras extensiones sin utilizar FTP. Si ya existe la extensión subida, se actualizará con los archivos subidos.',
	'UPLOAD'							=> 'Subir',
	'BROWSE'							=> 'Navegar...',
	'EXTENSION_UPLOAD'					=> 'Subir Extensión',
	'EXTENSION_UPLOAD_EXPLAIN'			=> 'Aquí puede cargar un paquete de extensión zip que contiene los archivos necesarios para realizar la instalación desde el equipo local o en un servidor remoto. “Upload Extensions” luego intentará descomprimir el archivo y tenerlo listo para la instalación.<br />Elija un archivo o escriba un enlace en los campos de abajo.',
	'EXT_UPLOAD_INIT_FAIL'				=> 'Se ha producido un error al inicializar el proceso de subida de la extensión.',
	'EXT_NOT_WRITABLE'					=> 'En el directorio ext/ no se puede escribir. Esto es requerido para que “Upload extension” funcione correctamente. Por favor, ajuste sus permisos y/o la configuración y vuelva a intentarlo.',
	'EXT_UPLOAD_ERROR'					=> 'La extensión no se ha subido. Por favor, confirma que cargue el archivo de extensión zip verdadera y vuelva a intentarlo.',
	'NO_UPLOAD_FILE'					=> 'No hay archivo especificado o se produjo un error durante el proceso de subida.',
	'NOT_AN_EXTENSION'					=> 'El archivo zip subido no es una extensión de phpBB. El archivo no se ha guardado en el servidor.',

	'EXTENSION_UPLOADED'				=> 'La extensión “%s” ha sido subida correctamente.',
	'EXTENSIONS_AVAILABLE'				=> 'Extensiones disponibles',
	'EXTENSION_INVALID_LIST'			=> 'Lista de Extensiones',
	'EXTENSION_UPLOADED_ENABLE'			=> 'Habilitar la extensión subida',
	'ACP_UPLOAD_EXT_UNPACK'				=> 'Descomprimir extensión',
	'ACP_UPLOAD_EXT_CONT'				=> 'Contenido del paquete: %s',

	'EXTENSION_DELETE'					=> 'Borrar extensión',
	'EXTENSION_DELETE_CONFIRM'			=> '¿Está seguro de querer borrar la extensión “%s”?',
	'EXT_DELETE_SUCCESS'				=> 'La extensión ha sido borrada correctamente.',
	'EXT_DELETE_ERROR'					=> 'No hay archivo especificado o se produjo un error durante el proceso de subida.',

	'EXTENSION_ZIP_DELETE'				=> 'Borrar archivo zip',
	'EXTENSION_ZIP_DELETE_CONFIRM'		=> '¿Está seguro de querer borrar el archivo zip “%s”?',
	'EXT_ZIP_DELETE_SUCCESS'			=> 'El archivo zip de la extensión ha sido borrado correctamente.',
	'EXT_ZIP_DELETE_ERROR'				=> 'No hay archivo especificado o se produjo un error durante el proceso de subida.',

	'ACP_UPLOAD_EXT_ERROR_DEST'			=> 'No hay ninguna carpeta vendor o destino en el archivo zip subido. El archivo no se ha guardado en el servidor.',
	'ACP_UPLOAD_EXT_ERROR_COMP'			=> 'composer.json no se encontró en el archivo zip subido. El archivo no se ha guardado en el servidor.',
	'ACP_UPLOAD_EXT_ERROR_NOT_SAVED'	=> 'El archivo no se ha guardado en el servidor.',
	'ACP_UPLOAD_EXT_WRONG_RESTORE'		=> 'Se produjo un error durante la actualización de una extensión instalada. Intente actualizar de nuevo.',

	'UPLOAD_EXTENSIONS_DEVELOPERS'		=> 'Desarrolladores',

	'SHOW_FILETREE'						=> '<< Mostrar árbol del archivo >>',
	'HIDE_FILETREE'						=> '>> Ocultar árbol del archivo <<',

	'EXT_UPLOAD_SAVE_ZIP'				=> 'Guardar archivo zip subido',
	'ZIP_UPLOADED'						=> 'Paquetes zip subidos de extensiones',
	'EXT_ENABLE'						=> 'Habilitar',
	'EXT_UPLOADED'						=> 'subidas',
	'EXT_UPDATED'						=> 'actualizadas',
	'EXT_UPDATED_LATEST_VERSION'		=> 'actualizadas a la última versión',
	'EXT_UPLOAD_BACK'					=> '« Volver a Upload Extensions',

	'ACP_UPLOAD_EXT_DIR'				=> 'Ruta de almacenamiento de paquetes zip de extensiones',
	'ACP_UPLOAD_EXT_DIR_EXPLAIN'		=> 'Ruta desde el directorio phpBB, por ejemplo <samp>ext</samp>.<br />Puede cambiar esta ruta para almacenar los paquetes zip en una carpeta especial (por ejemplo, si desea permitir que los usuarios descargan los archivos, puede cambiarlo a <em>descargas</em>, y si desea prohibir esas descargas, se puede cambiar a la ruta raíz del http a un ni9vel superior de su sitio web (o puede crear una carpeta con el archivo .htaccess apropiado)).',

	'ACP_UPLOAD_EXT_UPDATED'			=> 'La extensión instalada se ha actualizado.',
	'ACP_UPLOAD_EXT_UPDATED_EXPLAIN'	=> 'Ha subido un archivo zip para una extensión ya instalada. La extensión <strong>ha sido deshabilitada automáticamente</strong> para hacer más seguro el proceso de actualización. Ahora por favor <strong>compruebe</strong> si los archivos subidos son correctos y haga clic en <strong>habilitar</strong> la extensión si todavía quiere utilizarla en el foro.',

	'VALID_PHPBB_EXTENSIONS'			=> 'phpbb.com CDB',
));
