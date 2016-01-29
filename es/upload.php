<?php
/**
*
* @package Upload Extensions
* @copyright (c) 2014 - 2015 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)
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
	'ACP_UPLOAD_EXT_TITLE'				=> 'Subida de Extensiones',
	'ACP_UPLOAD_EXT_CONFIG_TITLE'		=> 'Subida de extensiones',
	'ACP_UPLOAD_EXT_DESCRIPTION'		=> 'Instalar/Actualizar/Borrar extensiones, gestionar sus archivos ZIP y más sin necesidad de utilizar FTP.',
	'ACP_UPLOAD_EXT_TITLE_EXPLAIN'		=> 'Subida de Extensiones le permite subir archivos zip de extensiones, o borrar carpetas de extensiones del servidor.<br />Con esta extensión se puede instalar/actualizar/borrar extensiones sin utilizar FTP. Si ya existe la extensión subida, está se actualizará con los archivos subidos.',
	'ACP_UPLOAD_EXT_HELP'				=> 'Subida de Extensiones: Guía de Uso',
	'UPLOAD'							=> 'Subir',
	'BROWSE'							=> 'Navegar...',
	'EXTENSION_UPLOAD'					=> 'Subir una extensión',
	'EXTENSION_UPLOAD_EXPLAIN'			=> 'Aquí puede subir un paquete ZIP de extensión, que contiene los archivos necesarios para realizar la instalación desde el equipo local, o desde un servidor remoto. “Subida de Extensiones” hará el intento de descomprimir el archivo y tenerlo listo para la instalación.<br />Elija un archivo, o escriba un enlace en los siguientes campos.',
	'EXT_UPLOAD_ERROR'					=> 'La extensión no se ha subido.',
	'EXT_UPLOAD_INIT_FAIL'				=> 'Se produjo un error al iniciar el proceso de subida de la extensión.',
	'EXT_NOT_WRITABLE'					=> array(
		'error'		=> 'No se puede escribir en el directorio ext/. Esto es requerido por “Subida de Extensiones” para que funcione correctamente.',
		'solution'	=> 'Por favor, ajuste sus permisos y/o la configuración, y vuelva a intentarlo.',
	),
	'EXT_TMP_NOT_WRITABLE'				=> array(
		'error'		=> 'No se puede escribir en el directorio ext/boardtools/upload/tmp/. Esto es requerido por “Subida de Extensiones” para que funcione correctamente.',
		'solution'	=> 'Por favor, ajuste sus permisos y/o la configuración, y vuelva a intentarlo.',
	),
	'EXT_ALLOW_URL_FOPEN_DISABLED'		=> array(
			'error'		=> 'El ajuste allow_url_fopen debe estar habilitado, para cargar la información de un recurso remoto.',
			'solution'	=> 'Por favor, confirme que el ajuste allow_url_fopen está habilitado en su php.ini y vuelva a intentarlo.',
	),
	'EXT_OPENSSL_DISABLED'				=> array(
			'error'		=> 'La extensión openssl debe estar habilitada para cargar la información de un recurso https.',
			'solution'	=> 'Por favor, confirme que la extensión openssl está habilitada en su php.ini y vuelva a intentarlo.',
	),
	'NO_UPLOAD_FILE'					=> array(
		'error'		=> 'No se ha especificado un archivo, o se produjo un error durante el proceso de subida.',
		'solution'	=> 'Por favor, confirme que intenta subir un archivo zip de extensión verdadera y vuelva a intentarlo.',
	),
	'NOT_AN_EXTENSION'					=> 'El archivo zip subido no es una extensión de phpBB. El archivo no se ha guardado en el servidor.',
	'EXT_ACTION_ERROR'					=> 'La acción solicitada no se puede realizar para la extensión phpBB seleccionada.<br />Nota: “Subida de Extensiones” puede ser gestionado sólo a través del Administrador de extensiones estándar.',

	'SOURCE'							=> 'Fuente',
	'EXTENSION_UPDATE_NO_LINK'			=> 'No se proporciona el enlace de descarga.',
	'EXTENSION_TO_BE_ENABLED'			=> 'Subida de Extensiones se desactivará durante el proceso de actualización, y habilitado de nuevo después de la actualización.',
	'EXTENSION_UPLOAD_UPDATE'			=> 'Actualizar la extensión',
	'EXTENSION_UPLOAD_UPDATE_EXPLAIN'	=> '“Subida de Extensiones” realizará la subida desde el enlace que se muestra a continuación.',

	'EXTENSION_UPLOADED'				=> 'La extensión “%s” ha sido actualizada correctamente.',
	'EXTENSIONS_AVAILABLE'				=> 'Extensiones desinstaladas',
	'EXTENSIONS_UPLOADED'				=> 'Extensiones subidas',
	'EXTENSIONS_UNAVAILABLE'			=> 'Extensiones rotas',
	'EXTENSIONS_UNAVAILABLE_EXPLAIN'	=> 'Las extensiones listadas a continuación están subidas en su foro, pero están rotas debido a algunas razones y es por eso que no están disponibles, y no se pueden habilitar en su foro. Por favor, revise los archivos correctamente y utilice la herramienta limpiadora de extensiones si desea eliminar los archivos de extensiones rotas desde el servidor.',
	'EXTENSION_BROKEN'					=> 'Extensión rota',
	'EXTENSION_BROKEN_ENABLED'			=> '¡Esta extensión rota está habilitada!',
	'EXTENSION_BROKEN_DISABLED'			=> '¡Esta extensión rota está deshabilitada!',
	'EXTENSION_BROKEN_TITLE'			=> '¡Esta extensión está rota!',
	'EXTENSION_BROKEN_DETAILS'			=> 'Haga clic aquí para ver los detalles.',
	'EXTENSION_BROKEN_EXPLAIN'			=> '<strong>Algunos datos de esta extensión están guardados en el servidor.</strong> Por favor, revise qué esta roto en está extensión. Puede que tenga que preguntar a los desarrolladores de extensiones para conseguir ayuda, y utilizar FTP para cambiar algunos archivos (o usted puede subir una nueva versión con correcciones). Entonces usted será capaz de gestionar la extensión de nuevo.<br /><h3>Lo que puede hacer:</h3><br /><strong>Actualizar una extensión rota.</strong><br /><ul><li>Asegúrese de que la extensión está deshabilitada (haga clic en el conmutador si es necesario).</li><li>Averigüe si hay una nueva versión de la extensión disponible. Trate de subirla.</li><li>Si el problema no se resuelve, puede preguntar a los desarrolladores de la extensión en busca de ayuda.</ul><strong>o</strong><br /><br /><strong>Eliminar la extensión rota por completo.</strong><br /><ul><li>Asegúrese de que la extensión está deshabilitada (haga clic en el conmutador si es necesario).</li><li>Asegúrese de que se borran los datos de la extensión (haga clic en el botón de basura si es necesario).</li><li>Elimine los archivos de la extensión mediante el uso de la herramienta limpiadora de extensiones.</ul>',

	'EXTENSION_UPLOADED_ENABLE'			=> 'Habilitar la extensión subida',
	'ACP_UPLOAD_EXT_UNPACK'				=> 'Descomprimir la extensión',
	'ACP_UPLOAD_EXT_CONT'				=> 'Contenido del paquete “%s”',

	'EXT_LIST_DOWNLOAD'					=> 'Descargar lista completa',
	'EXT_LIST_DOWNLOAD_ENGLISH'			=> 'Usar nombres de estado en Inglés',
	'EXT_LIST_DOWNLOAD_GROUP'			=> 'Grupo por',
	'EXT_LIST_DOWNLOAD_GROUP_STANDARD'	=> 'subido/roto',
	'EXT_LIST_DOWNLOAD_GROUP_DISABLED'	=> 'habilitado/deshabilitado/roto',
	'EXT_LIST_DOWNLOAD_GROUP_PURGED'	=> 'habilitado/deshabilitado/desinstalado/roto',
	'EXT_LIST_DOWNLOAD_SHOW'			=> 'Incluir nombres',
	'EXT_LIST_DOWNLOAD_SHOW_FULL'		=> 'mostrar nombres y nombres limpios',
	'EXT_LIST_DOWNLOAD_SHOW_CLEAN'		=> 'sólo nombres limpios',
	'EXT_LIST_DOWNLOAD_SHOW_NAME'		=> 'sólo mostrar los nombres',
	'EXT_LIST_DOWNLOAD_TITLE'			=> 'Lista completa de las extensiones subidas',
	'EXT_LIST_DOWNLOAD_FOOTER'			=> 'Generado por Subida de Extensiones',

	'EXT_ROW_ENABLED'					=> 'habilitado',
	'EXT_ROW_DISABLED'					=> 'deshabilitado',
	'EXT_ROW_UNINSTALLED'				=> 'desinstalado',
	'EXT_ROWS_ENABLED'					=> 'Habilitado:',
	'EXT_ROWS_DISABLED'					=> 'Deshabilitado:',
	'EXT_ROWS_UNINSTALLED'				=> 'Desinstalado:',
	'EXT_ROWS_UPLOADED'					=> 'Subido:',
	'EXT_ROWS_BROKEN'					=> 'Roto:',

	'EXTENSION_DELETE'					=> 'Borrar extensión',
	'EXTENSION_DELETE_CONFIRM'			=> '¿Está seguro de querer borrar la extensión “%s”?',
	'EXTENSIONS_DELETE_CONFIRM'			=> array(
		2	=> '¿Está seguro de querer borrar las extensiones <strong>%1$s</strong>?',
	),
	'EXT_DELETE_SUCCESS'				=> 'La extensión ha sido borrada correctamente.',
	'EXTS_DELETE_SUCCESS'				=> 'Las extensiones han sido borradas correctamente.',
	'EXT_DELETE_ERROR'					=> 'No se ha especificado un archivo, o se produjo un error durante el borrado.',
	'EXT_DELETE_NO_FILE'				=> 'No se ha especificado un archivo para el borrado.',
	'EXT_CANNOT_BE_PURGED'				=> 'Los datos de la extensión habilitada no pueden ser purgados. Debe deshabilitar la extensión para poder purgar sus datos.',

	'EXTENSION_ZIP_DELETE'				=> 'Borrar archivo zip',
	'EXTENSION_ZIP_DELETE_CONFIRM'		=> '¿Está seguro de querer borrar el archivo zip “%s”?',
	'EXTENSIONS_ZIP_DELETE_CONFIRM'		=> array(
		2	=> '¿Está seguro de querer borrar los archivos <strong>%1$s</strong> zip?',
	),
	'EXT_ZIP_DELETE_SUCCESS'			=> 'El archivo zip de la extensión ha sido borrado correctamente.',
	'EXT_ZIPS_DELETE_SUCCESS'			=> 'Los archivos zip de las extensiones han sido borrados correctamente.',
	'EXT_ZIP_DELETE_ERROR'				=> 'No se ha especificado un archivo, o se produjo un error durante el borrado.',

	'ACP_UPLOAD_EXT_ERROR_DEST'			=> 'No hay vendedor o carpeta de destino en el archivo zip subido. El archivo no se ha guardado en el servidor.',
	'ACP_UPLOAD_EXT_ERROR_COMP'			=> 'composer.json no se encontró en el archivo zip subido. El archivo no se ha guardado en el servidor.',
	'ACP_UPLOAD_EXT_ERROR_NOT_SAVED'	=> 'El archivo no se ha guardado en el servidor.',
	'ACP_UPLOAD_EXT_ERROR_TRY_SELF'		=> '“Subida de Extensiones” se puede actualizar sólo por el Updater especial o desde el FTP.',
	'ACP_UPLOAD_EXT_WRONG_RESTORE'		=> 'Se produjo un error durante la actualización de una extensión instalada. Intente actualizar de nuevo.',

	'DEVELOPER'							=> 'Desarrollador',
	'DEVELOPERS'						=> 'Desarrolladores',

	'EXT_UPLOAD_SAVE_ZIP'				=> 'Guardar archivo zip subido',
	'CHECKSUM'							=> 'Comprobación',
	'RESTORE'							=> 'Restaurar',
	'ZIP_UPLOADED'						=> 'Paquetes zip de extensiones subidos',
	'EXT_ENABLE'						=> 'Habilitar',
	'EXT_ENABLE_DISABLE'				=> 'Habilitar/Deshabilitar la extensión',
	'EXT_ENABLED'						=> 'La extensión ha sido habilitada correctamente.',
	'EXT_DISABLED'						=> 'La extensión ha sido deshabilitada correctamente.',
	'EXT_PURGE'							=> 'Purgar datos de la extensión',
	'EXT_PURGED'						=> 'Los datos de la extensión han sido purgados correctamente.',
	'EXT_UPLOADED'						=> 'La subida se ha realizado correctamente.',
	'EXT_UPDATE_ENABLE'					=> 'Haga clic en el conmutador para habilitar la extensión.',
	'EXT_UPDATE_CHECK_FILETREE'			=> 'Por favor, compruebe el árbol de archivos de la extensión.',
	'EXT_UPDATE_ERROR'					=> 'El proceso de actualización tuvo errores.',
	'EXT_UPDATE_TIMEOUT'				=> 'Tiempo de espera del proceso de actualización.',
	'EXT_UPDATES_AVAILABLE'				=> 'Actualizaciones disponibles',
	'EXT_UPDATE_METHODS_TITLE'			=> 'Métodos de actualización disponibles',
	'EXT_UPLOAD_UPDATE_METHODS'			=> 'Puede actualizar la extensión mediante la adopción de una de las acciones posibles:<ul><li><strong>Método de actualizador.</strong> Subida de Extensiones se puede actualizar con el Actualizador de Subida de Extensiones. Confirmar si esta herramienta ya está disponible. A menos que tenga esta herramienta, usted tendrá que utilizar el segundo método.</li><li><strong>Método FTP.</strong> Subida de Extensiones se puede actualizar de forma estándar. Descargar nuevos archivos a su PC (haga clic en el botón de abajo), deshabilite la extensión en el Administrador de extensiones estándar, copie los nuevos archivos usando un cliente FTP y habilite la extensión en el Administrador de extensiones estándar.</li></ul>',
	'EXT_UPDATED'						=> 'La actualización se ha realizado correctamente.',
	'EXT_UPDATED_LATEST_VERSION'		=> 'actualizada a la última versión',
	'EXT_SAVED_OLD_ZIP'					=> '<strong>NOTA:</strong> la versión anterior de la extensión se guarda en el archivo <strong>%s</strong> en su servidor. Revise el módulo “Administrador de archivos ZIP”.',
	'EXT_RESTORE_LANGUAGE'				=> '<strong>Un directorio de idioma está ausente en la versión actualizada de la extensión.</strong> Puede restaurar el directorio %s desde el archivo zip guardado de la versión anterior. Entonces es posible que tenga que actualizar los archivos de los directorios para la compatibilidad con la nueva versión actualizada de la extensión.',
	'EXT_RESTORE_LANGUAGES'				=> '<strong>Algunos directorios de idioma están ausentes en la versión actualizada de la extensión.</strong> Puede restaurar los directorios %1$s y %2$s desde su archivo zip guardado de la versión anterior. Entonces es posible que tenga que actualizar los archivos de los directorios para la compatibilidad con la nueva versión actualizada de la extensión.',
	'EXT_LANGUAGES_RESTORED'			=> 'El proceso de restauración se ha completado correctamente.',
	'EXT_SHOW_DESCRIPTION'				=> 'Mostrar la descripción de la extensión',
	'EXT_UPLOAD_BACK'					=> '« Volve a Subida de Extensiones',
	'EXT_RELOAD_PAGE'					=> 'Recargar la página',
	'EXT_REFRESH_PAGE'					=> 'Refrescar la página',
	'EXT_REFRESH_NOTICE'				=> 'El menú de navegación puede ser obsoleto.',

	'ERROR_COPY_FILE'					=> 'El intento de copiar el archivo “%1$s” en la ubicación “%2$s” ha fallado.',
	'ERROR_CREATE_DIRECTORY'			=> 'El intento de crear el directorio “%s” ha fallado.',
	'ERROR_REMOVE_DIRECTORY'			=> 'El intento de eliminar el directorio “%s” ha fallado.',
	'ERROR_CHECKSUM_MISMATCH'			=> 'El %s-hash del archivo subido difiere de la comprobación proporcionada. El archivo no se ha guardado en el servidor.',
	'ERROR_ZIP_NO_COMPOSER'				=> 'composer.json no se encontró en el paquete zip solicitado.',
	'ERROR_DIRECTORIES_NOT_RESTORED'	=> 'El proceso de restauración no se pudo completar debido a errores.',
	'ERROR_LANGUAGE_UNKNOWN_STRUCTURE'	=> 'La estructura del paquete de idioma subido no es reconocido. El archivo no se ha guardado en el servidor.',
	'ERROR_LANGUAGE_NO_EXTENSION'		=> 'El nombre de la extensión no se ha especificado para el paquete de idioma.',
	'ERROR_LANGUAGE_NOT_DEFINED'		=> 'El código ISO del idioma debe ser definido para la subida correcta del paquete de idioma. Por favor, complete el campo necesario del formulario y vuelva a intentarlo.',

	'ACP_UPLOAD_EXT_DIR'				=> 'Ruta de almacenamiento de los paquetes zip de extensiones',
	'ACP_UPLOAD_EXT_DIR_EXPLAIN'		=> 'Ruta de su directorio raíz de su phpBB, por ejemplo <samp>ext</samp>.<br />Puede cambiar esta ruta para almacenar los paquetes zip en una carpeta especial (por ejemplo, si desea permitir a los usuarios descargar los archivos, puede cambiarlo a <em>descargas</em>, y si desea prohibir esas descargas, se puede cambiar a la ruta que es superior en un nivel de la raíz de tu sitio web http (o puede crear una carpeta con el adecuado archivo .htaccess )).',

	'ACP_UPLOAD_EXT_UPDATED'			=> 'La extensión instalada se ha actualizado.',
	'ACP_UPLOAD_EXT_UPDATED_EXPLAIN'	=> 'Ha subido un archivo zip de una extensión ya instalada. Esa extensión <strong>se desactivará automáticamente</strong> para hacer que el proceso de actualización más seguro. Ahora por favor, <strong>compruebe</strong> si los archivos subidos son correctos y <strong>habilite</strong> la extensión si todavía desea utilizarla en el foro.',

	'ACP_UPLOAD_EXT_NO_CHECKSUM_TITLE'	=> 'No se proporcionó la comprobación para el archivo subido.',
	'ACP_UPLOAD_EXT_NO_CHECKSUM'		=> 'Subida de Extensiones ha sido incapaz de realizar los controles de seguridad porque la <strong>comprobación no se proporcionó</strong> para el archivo zip subido. La comprobación se utiliza para asegurarse de que el archivo subido no está dañado y no es comprometido.',

	'VALID_PHPBB_EXTENSIONS'			=> 'Extensiones validadas',
	'SHOW_VALID_PHPBB_EXTENSIONS'		=> 'Mostrar extensiones validadas',
	'VALID_PHPBB_EXTENSIONS_TITLE'		=> 'Puede descargar extensiones validadas de la CDB de phpBB.com o echar un vistazo en sus páginas.',
	'VALID_PHPBB_EXTENSIONS_EMPTY_LIST'	=> 'No hay extensiones sugeridas por el momento. Por favor, revise las actualizaciones para Subida de Extensiones.',
	'POSSIBLE_SOLUTIONS'				=> 'Posibles soluciones',

	'ACP_UPLOAD_EXT_MANAGER_EXPLAIN'	=> 'El Administrador de extensiones de Subida de Extensiones es una herramienta en su foro phpBB, que le permite administrar todas las extensiones y ver información acerca de ellas.',
	'ACP_UPLOAD_ZIP_TITLE'				=> 'Administración de archivos ZIP',
	'ACP_UPLOAD_UNINSTALLED_TITLE'		=> 'Borrar extensiones',

	'EXT_DETAILS_README'				=> 'Léame',
	'EXT_DETAILS_CHANGELOG'				=> 'Registro de cambios',
	'EXT_DETAILS_LANGUAGES'				=> 'Idiomas',
	'EXT_DETAILS_FILETREE'				=> 'Árbol de archivos',
	'EXT_DETAILS_TOOLS'					=> 'Herramientas',

	'DEFAULT'							=> 'por defecto',
	'EXT_LANGUAGE_ISO_CODE'				=> 'Código ISO',
	'EXT_LANGUAGES'						=> 'Paquetes de idiomas subidos',
	'EXT_LANGUAGES_UPLOAD'				=> 'Subir un paquete de idioma',
	'EXT_LANGUAGES_UPLOAD_EXPLAIN'		=> 'Aquí puede subir un paquete comprimido que contiene los archivos de idioma necesarios para esta extensión desde su equipo local o en un servidor remoto. “Subida de Extensiones” hará el intento de descomprimir los archivos y moverlos a la ubicación correcta.<br />Elija un archivo o escriba un enlace en los campos siguientes.<br />No se olvide de especificar el código de idioma ISO en el campo correspondiente a continuación (por ejemplo: <strong>en</strong>).<br /><strong>¡IMPORTANTE!</strong> Su directorio de idioma actual de extensión con ese código ISO se borrará si existe, <strong>si no existe el archivo zip, se creará</strong>.',
	'EXT_LANGUAGE_UPLOADED'				=> 'El paquete de idioma “%s” ha sido subido correctamente.',
	'EXT_LANGUAGE_DELETE_CONFIRM'		=> '¿Está seguro de querer borrar el paquete de idioma “%s”?',
	'EXT_LANGUAGES_DELETE_CONFIRM'		=> array(
		2	=> 'Está seguro de querer borrar los paquetes de idiomas <strong>%1$s</strong>?',
	),
	'EXT_LANGUAGE_DELETE_SUCCESS'		=> 'El paquete de idioma de la extensión ha sido borrado correctamente.',
	'EXT_LANGUAGES_DELETE_SUCCESS'		=> 'Los paquetes de idioma de las extensiones han sido borrados correctamente.',
	'EXT_LANGUAGE_DELETE_ERROR'			=> 'No se ha especificado un archivo, o se produjo un error durante el borrado.',

	'EXT_TOOLS_DOWNLOAD_TITLE'			=> 'Descargar el paquete de extensión',
	'EXT_TOOLS_DOWNLOAD'				=> 'Puede descargar un archivo ZIP correctamente embalado de extensión a su PC. También puede optar por eliminar el sufijo de la versión de desarrollo (por ejemplo, para acortar el tiempo de preparación de la extensión para el CDB).',
	'EXT_TOOLS_DOWNLOAD_DELETE_SUFFIX'	=> 'Borrar el sufijo de desarrollo si existe',
	'EXT_DOWNLOAD_ERROR'				=> 'El intento de descargar la extensión “%s” ha fallado.',

	'EXT_LOAD_ERROR'					=> 'Error de carga',
	'EXT_LOAD_TIMEOUT'					=> 'Tiempo de espera de carga',
	'EXT_LOAD_ERROR_EXPLAIN'			=> 'Se ha producido un error durante el proceso de carga.',
	'EXT_LOAD_ERROR_SHOW'				=> 'Mostrar los errrores ocurridos',
	'EXT_LOAD_SOLUTIONS'				=> 'Por favor, consulte los archivos de registro de error en el servidor, elimine el problema y vuelva a intentarlo.',

	'UPLOAD_DESCRIPTION_UPLOAD'			=> 'Subir extensiones phpBB',
	'UPLOAD_DESCRIPTION_UPLOAD_CDB'		=> 'CDB en phpBB.com',
	'UPLOAD_DESCRIPTION_UPLOAD_LOCAL'	=> 'PC Local',
	'UPLOAD_DESCRIPTION_UPLOAD_REMOTE'	=> 'Servidor remoto',
	'UPLOAD_DESCRIPTION_UPDATE'			=> 'Actualizar extensiones phpBB',
	'UPLOAD_DESCRIPTION_UPDATE_ABOUT'	=> 'Puede actualizar cualquiera de las extensiones ya subidas. La extensión que desee actualizar, se desactivará automáticamente para que las actualizaciones sean seguras.',
	'UPLOAD_DESCRIPTION_MANAGE'			=> 'Gestionar extensiones phpBB',
	'UPLOAD_DESCRIPTION_MANAGE_ACTIONS'	=> 'Instalar/desinstalar cualquier extensión',
	'UPLOAD_DESCRIPTION_MANAGE_LANG'	=> 'Subir y gestionar paquetes de idiomas de extensiones',
	'UPLOAD_DESCRIPTION_MANAGE_DETAILS'	=> 'Ver detalles y árbol de archivos',
	'UPLOAD_DESCRIPTION_DESIGN'			=> 'Interfaz interactiva',
	'UPLOAD_DESCRIPTION_DESIGN_ABOUT'	=> 'Puede llevar a cabo acciones más rápidamente debido a la funcionalidad de JavaScript. Mensajes coloridos e información sobre herramientas le ayudarán en la toma de las decisiones correctas.',
	'UPLOAD_DESCRIPTION_ZIP'			=> 'Gestionar archivos ZIP',
	'UPLOAD_DESCRIPTION_ZIP_SAVE'		=> 'Guardar zips en un directorio de su elección',
	'UPLOAD_DESCRIPTION_ZIP_UNPACK'		=> 'Descomprimir un archivo zip para instalar una extensión',
	'UPLOAD_DESCRIPTION_ZIP_DOWNLOAD'	=> 'Descargar paquetes zip propios de extensiones',
	'UPLOAD_DESCRIPTION_CLEANER'		=> 'Herramienta limpiadora de extensiones',
	'UPLOAD_DESCRIPTION_CLEANER_ABOUT'	=> 'Puede eliminar los directorios de extensiones y/o archivos zip de extensiones del servidor.',
));
