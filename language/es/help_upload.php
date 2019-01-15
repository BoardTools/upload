<?php
/**
*
* @package Upload Extensions
* @copyright (c) 2014 - 2019 Igor Lavrov (https://github.com/LavIgor) and John Peskens (http://ForumHulp.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

// Some characters you may want to copy&paste:
// ’ » “ ” …

$help = array(
	array(
		0 => '--',
		1 => 'Módulos Generales'
	),
	array(
		0 => '¿Que puedo hacer con la característica “Subir una extensión”?',
		1 => 'Usted podrá subir las extensiones desde diferentes fuentes, sin la necesidad de utilizar un cliente FTP. Al subir una extensión que ya existe en su foro, su antigua versión se guarda automáticamente en el directorio especificado en su foro - revise el módulo “Administración de archivo ZIP”. También puede guardar el archivo zip de la versión actualmente subido de la extensión - marque la opción “Guardar archivo zip subido” antes del proceso de subida. Puede asegurarse de que sube un paquete zip de extensión verdadero si especifica su comprobación en el campo del formulario correspondiente.'
	),
	array(
		0 => 'Cuál es la diferencia entre el “Administrador de Extensiones de Subida de Extensiones” y el “Administrador de Extensiones” estándar?',
		1 => 'Al igual que el “Administrador de Extensiones” estándar, “Administrador de Extensiones de Subida de Extensiones” es una herramienta en su foro phpBB que le permite administrar todas las extensiones, y ver información acerca de ellas. Pero se puede determinar como una “versión mejorada” del módulo estándar.<br /><br /><strong>Beneficios clave:</strong><ul><li>Todas las extensiones subidas se ordenan alfabéticamente, no importa si están habilitadas, deshabilitadas o desinstaladas. La excepción: extensiones rotas.</li><li>Las extensiones rotas se muestran por separado en la misma página del “Administrador de Extensiones” por debajo de la lista de extensiones normales. Las razones de la falta de disponibilidad se muestran para cada extensión rota. Se añade un mensaje de advertencia detallada a esas razones cuando se instala la extensión rota, o tiene algunos datos guardados en la base de datos. Puede hacer clic en la fila de cualquier extensión rota para ver sus detalles de la misma manera que es aplicable para otras extensiones.</li><li>Cualquier extensión (si no es una rota) se puede activar con un solo clic en el conmutador que se muestra a la izquierda de su nombre en la lista.</li></ul>'
	),
	array(
		0 => '¿Por qué necesito el módulo “Administración de archivos ZIP ”?',
		1 => 'A veces puede encontrar útil poder ahorrar archivos de extensiones o compartirlos. Los archivos pueden ser versiones antiguas de extensiones subidas (que se empaquetan de forma automática por la seguridad de datos), cualquier paquete que usted ha elegido para guardar marcando la opción “Guardar archivo zip subido” antes del proceso de subida, o cualquier archivo zip de extensiones que se almacenan en el directorio especificado (vea la pregunta “¿Dónde puedo especificar el directorio para guardar los archivos zip de extensiones?” abajo). Tiene posibilidades para desempaquetar, descargar y borrar esos paquetes.'
	),
	array(
		0 => '¿Cómo puedo usar el módulo “Borrar extensiones”?',
		1 => 'El módulo “Borrar extensiones” le permite eliminar los archivos de extensiones desinstaladas de su servidor, para que pueda terminar la desinstalación completa sin usar FTP. Cuando no necesite una extensión más, puede eliminarla de su foro por completo. Para ello es necesario realizar los siguientes pasos:<ul><li>Primero se debe asegurar que realmente no necesita dicha extensión específica. Se recomienda que haga algunas copias de seguridad de archivos, y base de datos antes de cualquier borrado.</li><li>A continuación, vaya a “Administrador de Extensiones de Subida de Extensiones”, encontre la extensión que desea eliminar y asegúrese de que está deshabilitada: haga clic en el conmutador de esa extensión <em>si el conmutador está verde</em>.</li><li>Asegúrese de que se eliminan los datos de esa extensión: <em>si se muestra el botón de cubo de basura de esa extensión</em>, haga clic en él y confirme la acción.</li><li>Después de navegar al módulo “Borrar extensiones”, haga clic en el enlace “Borrar extensión” que será mostrado en la fila de su extensión y confirme la acción.</li></ul>'
	),
	array(
		0 => '--',
		1 => 'Proceso de Subida'
	),
	array(
		0 => '¿Cómo puedo subir extensiones validadas de la CDB de phpBB.com?',
		1 => 'En la página principal de Subida de Extensiones, haga clic en el enlace “Mostrar extensiones validadas”. Seleccione la extensión que desea subir y haga clic en el botón “Descargar” en la fila de esa extensión. Nota: juego de palabras: la extensión se <em>descargará</em> desde el recurso remoto y <em>subido</em> a su servidor.'
	),
	array(
		0 => '¿Cómo puedo realizar una subida de otros recursos remotos?',
		1 => 'Copie el enlace <strong>directo</strong> del paquete zip de la extensión (si el enlace no es desde el sitio Web phpBB.com, se debe terminar con <code>.zip</code>) en el campo dedicado del formulario “Subir una extensión” y haga clic en el botón “Subir”.'
	),
	array(
		0 => '¿Cómo puedo subir una extensión de mi PC local?',
		1 => 'Para ello haga clic en el botón “Navegar...” en el formulario “Subir una extensión”, seleccione el archivo zip de la extensión en el equipo, y haga clic en el botón “Subir”.'
	),
	array(
		0 => 'He copiado el enlace al paquete zip de la extensión en el campo, y hago clic en el botón “Subir”, pero veo un error. ¿Qué hay de malo en el enlace?',
		1 => 'Para ser capaz de subir la extensión, debe asegurarse de que se cumplan las siguientes condiciones:<ol><li>El enlace debe ser <strong>directo</strong>: para la subida de recursos ajenos a phpBB.com debe tener <code>.zip</code> al final.</li><li>El enlace debe conducir al <strong>archivo zip</strong> de la extensión, no a su página de descripción.</li></ol>'
	),
	array(
		0 => '¿Qué es la comprobación? ¿Dónde puedo verlo?',
		1 => 'La comprobación se utiliza para verificar la integridad del archivo subido. Se comprueba para asegurarse de que el archivo en el servidor remoto y el archivo subido al servidor son los mismos. La comprobación por lo general se obtiene del mismo recurso en el que se almacena el archivo original.'
	),
	array(
		0 => '--',
		1 => 'Administrador de Extensiones de Subida de Extensiones'
	),
	array(
		0 => '¿Cómo utilizar el “Administrador de Extensiones de Subida de Extensiones”?',
		1 => 'El estado de cada extensión se visualiza como un conmutador.<ul><li>Un conmutador verde significa que la extensión está habilitada. Al hacer clic en un conmutador verde la extensión será <strong>deshabilitada</strong>.</li><li>Un conmutador rojo significa que la extensión está deshabilitada. Al hacer clic en el conmutador rojo la extensión será <strong>habilitada</strong>.</li><li>Si la extensión tiene un conmutador rojo está desactivada, pero hay algunos datos de extensiones guardados en la base de datos, a continuación tiene la opción de eliminar esos datos haciendo clic en un contenedor de basura cerca del conmutador.<br /><em>Al hacer clic en el contenedor de basura, es una manera de desinstalar la extensión de la base de datos. Si desea eliminar los archivos de la extensión del servidor, tendrá que utilizar la Herramienta limpiadora de extensiones.</em></li></ul><br />También puede volver a comprobar todas las versiones de las extensiones haciendo clic en el botón correspondiente, o configurar los ajustes de verificación de versión igual que en el “Administrador de Extensiones” estándar.'
	),
	array(
		0 => '¿Qué pasa con las extensiones rotas? ¿Las puedo desinstalar?',
		1 => '¡Si, por supuesto! Las extensiones rotas serán mostradas en “Administrador de Extensiones de Subida de Extensiones” por debajo de la lista de extensiones normales. Puede ver las razones por las que las extensiones están rotas, y si tienen algunos datos guardados en la base de datos. Haga clic en una fila de una extensión rota para ver sus detalles y para gestionarla.'
	),
	array(
		0 => 'El botón de activación de una extensión es de color gris. ¿Por qué?',
		1 => 'El botón gris del conmutador significa que no se puede realizar ninguna acción con esa extensión por el momento. Probablemente otra acción que ya está en curso. También Subida de Extensiones no puede desactivarse a si mismo - por eso el botón también es gris.'
	),
	array(
		0 => '--',
		1 => 'Página de detalles de la extensión'
	),
	array(
		0 => '¿Qué información se muestra para mis extensiones?',
		1 => 'La información mostrada depende de varias circunstancias.<ul><li>Descripción general proporcionada por los desarrolladores de extensiones en el archivo <code>composer.json</code> (o un mensaje de advertencia si la extensión está rota).</li><li>El número de versión de la extensión (si no está rota).</li><li>El contenido del archivo <code>README.md</code> (si existe en el directorio de extensiones).</li><li>El contenido del archivo <code>CHANGELOG.md</code> (si existe en el directorio de extensiones).</li><li>Paquetes de idiomas subidos para la extensión.</li><li>El árbol de archivos para la extensión y el contenido de sus archivos.</li></ul>'
	),
	array(
		0 => '¿Qué puedo hacer yo con la extensión en la página de detalles?',
		1 => 'Será capaz de:<ul><li>Habilitar la extensión si el conmutador es de color rojo.</li><li>Deshabilitar la extensión si el conmutador es de color verde.</li><li>Eliminar datos de la extensión de la base de datos si se muestra el botón rojo del cubo de la basura.</li><li>Comprobar el estado de la versión actual de la extensión, si el enlace al archivo de comprobación de versión existe por los desarrolladores de extensiones. Si la versión extensiones se muestra en una burbuja verde - la extensión está actualizada. Si la burbuja es roja - la extensión no está actualizada. De lo contrario - la información comprobación de versión no se podrá obtener.</li><li>Recibe una actualización para la extensión si ve una rueda dentada, cerca de la burbuja versión extensiones. Haga clic en la rueda dentada: si se muestra el botón “Actualizar” - entonces podrá hacer clic en él, confirme la acción de Subida de Extensiones y actualizará su extensión. También puede ver el anuncio de la versión, haga clic en el botón correspondiente si el enlace es proporcionado por los desarrolladores de extensiones. <strong>NOTA:</strong> si JavaScript está desactivado en su navegador, los botones se encuentran en el interior del bloque de la sección de detalles de extensión.</li><li>Administrar paquetes de idioma de extensiones. Puede subir un nuevo paquete de idioma para la extensión - vea la pregunta de abajo “¿Qué paquetes de idioma puedo subir para una extensión?”. También puede eliminar algunos paquetes de idiomas ya instalados.</li><li>Descargue el paquete de extensión (vea la pregunta de abajo “¿Cuál es el propósito de la característica “Descargar extensión empaquetada”?”).</li></ul>'
	),
	array(
		0 => '¿Qué paquetes de idioma puedo subir para una extensión?',
		1 => 'Puede subir los paquetes zip que contengan archivos de idioma para la extensión si los paquetes tienen una de las siguientes estructuras:<ul><li><code>ZIP_FILE_ROOT/language_files</code>, o</li><li><code>ZIP_FILE_ROOT/single_directory/language_files</code>, o</li><li><code>ZIP_FILE_ROOT/single_directory/language_ISO_code/language_files</code>.</li></ul><br />Para obtener más información sobre el proceso de subida véase la sección arriba de “Proceso de Subida”.'
	),
	array(
		0 => '¿Cuál es el propósito de la característica “Descargar extensión empaquetada”?',
		1 => 'Subida de Extensiones le permite descargar los paquetes zip propios de cualquier extensión subidos en su foro, a su PC local. También puede marcar la opción de eliminar el sufijo de la versión de desarrollo - esta acción puede ayudar, por ejemplo, para acortar el tiempo de preparación de la extensión para el CDB. Vaya a la página de detalles de extensión y haga clic en el botón “Herramientas”. A continuación se mostrará el botón “Descargar”.'
	),
	array(
		0 => '--',
		1 => 'Administración de archivo ZIP'
	),
	array(
		0 => '¿Dónde puedo especificar el directorio para guardar los archivos zip de extensiones?',
		1 => 'Navegue hasta el <code>PCA -> General -> Configuración del Servidor -> Configuración del Servidor -> Configuración de Ruta -> Ruta de almacenamiento de paquetes zip de extensiones</code>.'
	),
	array(
		0 => '¿Cómo puedo eliminar los paquetes zip de varias extensiones a la vez?',
		1 => 'Primero asegúrese de que realmente necesita para llevar a cabo dicha acción; se recomienda hacer las copias de seguridad necesarias. A continuación, vaya al módulo “Administración de archivos ZIP”, marque las opciones en las filas de los paquetes zip que desea borrar, haga clic en el botón “Borrar marcados” y confirme su acción.'
	),
	array(
		0 => '--',
		1 => 'Herramienta Limpiadora de Extensiones'
	),
	array(
		0 => '¿Que es la “Herramienta limpiadora de extensiones”?',
		1 => '“Herramienta limpiadora de extensiones” es el nombre del módulo de “Borrar extensiones” de Subida de Extensiones a veces se utiliza en su documentación.'
	),
	array(
		0 => 'Una extensión se instala en mi foro, pero no puedo borrarla. ¿Por qué?',
		1 => 'La extensión que desea eliminar se debe deshabilitar y sus datos deben ser eliminados de la base de datos antes de utilizar la “Herramienta limpiadora de extensiones”. Vea la pregunta anterior “¿Cómo puedo usar el módulo “Borrar extensiones”?”.'
	),
	array(
		0 => '¿Cómo puedo eliminar varias extensiones a la vez?',
		1 => 'Primero asegúrese de que realmente necesita para llevar a cabo dicha acción; se recomienda hacer las copias de seguridad necesarias. A continuación, vaya al módulo “Borrar Extensiones”, marque las opciones en las filas de los paquetes zip que desea borrar, haga clic en el botón “Borrar marcados” y confirme su acción. <strong>¡Esas extensiones no se guardarán como archivos zip! Sus directorios serán eliminados del servidor por completo.</strong>'
	),
	array(
		0 => '--',
		1 => 'Interfaz Interactiva'
	),
	array(
		0 => '¿Cuáles son los beneficios de la funcionalidad de JavaScript?',
		1 => 'Las páginas cargan más rápido, los elementos de diseño se cambian rápidamente cuando se interactúa con ellos, información sobre herramientas es mostrada para ayudarle. Todas estas características le permite ahorrar tiempo y que sólo están disponibles si JavaScript está activado en su navegador.'
	),
);
