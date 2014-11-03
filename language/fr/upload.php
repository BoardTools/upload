<?php
/**
*
* @package Upload Extensions
* French translation by Mathieu M. (www.html-edition.com)
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
'ACP_UPLOAD_EXT_TITLE'	=> 'Télécharger des extensions',
'ACP_UPLOAD_EXT_CONFIG_TITLE'	=> 'Télécharger des extensions',
'ACP_UPLOAD_EXT_TITLE_EXPLAIN'	=> 'Télécharger des extensions vous permet d\'installer des extensions au format zip ou supprimer des  extensions du serveur.<br />Grâce à cette extension, vous pouvez installer / mettre à jour / supprimer des extensions sans utiliser de FTP. Si vous téléchargez une extension déjà présente, elle sera mise à jour par les fichiers envoyés.',
'UPLOAD'	=> 'Télécharger',
'BROWSE'	=> 'Parcourir...',
'EXTENSION_UPLOAD'	=> 'Télécharger l\'extension',
'EXTENSION_UPLOAD_EXPLAIN'	=> 'Ici, vous pouvez télécharger une archive d\'extension zippée qui contient les fichiers nécessaires à son installation depuis votre ordinateur ou un serveur distant. “Télécharger des extensions” essaiera ensuite de dézipper l\'archive pour l\'installer.<br />Choisir une archive ou saisir une URL dans les champs ci-dessus.',
'EXT_UPLOAD_INIT_FAIL'	=> 'Une erreur s\'est produite durant l\'installation de l\'extension.',
'EXT_NOT_WRITABLE'	=> 'Le dossier ext/ n\'est pas disponible en écriture. Cela est nécessaire au bon fonctionnement de “Télécharger des extensions”. Veuillez vérifier vos permissions ou vos réglages et réessayer.',
'EXT_UPLOAD_ERROR'	=> 'L\'extension n\'a pas été téléchargée. Veuillez vérifier que vous téléchargez la bonne archive d\'extension et recommencez.',
'NO_UPLOAD_FILE'	=> 'Aucun fichier n\'a été spécifié ou il y a eu une erreur pendant le téléchargement.',
'NOT_AN_EXTENSION'	=> 'L\'archive téléchargée n\'est pas une extension pour phpBB. L\'archive n\'a pas été sauvegardée sur le serveur.',
'EXTENSION_UPLOADED'	=> 'L\'extension “%s” a été téléchargée avec succès.',
'EXTENSIONS_AVAILABLE'	=> 'Extensions disponibles',
'EXTENSION_INVALID_LIST'	=> 'Liste des extensions',
'EXTENSION_UPLOADED_ENABLE'	=> 'Activer l\'extension téléchargée',
'ACP_UPLOAD_EXT_UNPACK'	=> 'Décompresser l\'extension',
'ACP_UPLOAD_EXT_CONT'	=> 'Contenu de l\'archive: %s',
'EXTENSION_DELETE'	=> 'Supprimer l\'extension',
'EXTENSION_DELETE_CONFIRM'	=> 'Êtes-vous certain(e) de vouloir supprimer l\'extension “%s” ?',
'EXT_DELETE_SUCCESS'	=> 'L\'extension a été supprimée avec succès.',
'EXTENSION_ZIP_DELETE'	=> 'Supprimer l\'archive',
'EXTENSION_ZIP_DELETE_CONFIRM'	=> 'Êtes-vous certain(e) de vouloir supprimer l\'archive “%s”?',
'EXT_ZIP_DELETE_SUCCESS'	=> 'L\'archive a été supprimée avec succès.',
'ACP_UPLOAD_EXT_ERROR_DEST'	=> 'Aucun dossier de destination n\'a été trouvé dans l\'archive. Celle-ci n\'a pas été sauvegardée sur le serveur.',
'ACP_UPLOAD_EXT_ERROR_COMP'	=> 'Le fichier composer.json n\'a pas été trouvé dans l\'archive. Celle-ci n\'a pas été sauvegardée sur le serveur.',
'ACP_UPLOAD_EXT_ERROR_NOT_SAVED'	=> 'L\'archive n\'a pas été sauvegardée sur le serveur.',
'ACP_UPLOAD_EXT_WRONG_RESTORE'	=> 'Une erreur s\'est produite pendant la mise à jour d\'une extension installée. Veuillez recommencer une nouvelle fois.',
'UPLOAD_EXTENSIONS_DEVELOPERS'	=> 'Développeurs',
'SHOW_FILETREE'	=> '<< Montrer le contenu de l\'archive >>',
'HIDE_FILETREE'	=> '>> Cacher le contenu de l\'archive <<',
'EXT_UPLOAD_SAVE_ZIP'	=> 'Sauvegarder l\'archive téléchargée',
'ZIP_UPLOADED'	=> 'Archives d\'extensions téléchargées',
'EXT_ENABLE'	=> 'Activer',
'EXT_UPLOADED'	=> 'téléchargée',
'EXT_UPDATED'	=> 'mise à jour',
'EXT_UPDATED_LATEST_VERSION'	=> 'mise à jour vers la dernière version',
'EXT_UPLOAD_BACK'	=> '« Retourner vers Télécharger des extensions',
'ACP_UPLOAD_EXT_DIR'	=> 'Chemin vers le dossier de sauvegardes des archives d\'extensions téléchargées',
'ACP_UPLOAD_EXT_DIR_EXPLAIN'	=> 'Chemin depuis la racine de votre installation phpBB, i.e. <samp>ext</samp>.<br />Vous pouvez modifier ce chemin vers un dossier spécifique (par exemple, si vous souhaitez autoriser les utilisateurs à télécharger ces archives, vous pouvez le modifier pour <em>downloads</em>, et si vous souhaitez interdire ces téléchargements, vous pouvez le modifier par le chemin se situant un niveau au-dessus de la racine http de votre site (ou vous pouvez créer un dossier avec le fichier .htaccess adéquat)).',
'ACP_UPLOAD_EXT_UPDATED'	=> 'L\'extension a bien été mise à jour.',
'ACP_UPLOAD_EXT_UPDATED_EXPLAIN'	=> 'Vous avez téléchargé une archive pour une extension déjà installée. Cette extension <strong>a été désactivée automatiquement</strong> pour assurer une mise à jour plus sûre. Veuillez maintenant <strong>vérifier</strong> si l\'archive téléchargée est correcte puis <strong>activer</strong> l\'extension si vous souhaitez toujours l\'utiliser sur votre forum.',
));
