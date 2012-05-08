<?PHP

/* IMAGENES A MOSTRAR */
//Definicion de parametros graficos
define('_lib_verificacion', 'graficos/construccion.gif');
define('_img_cabecera', 'graficos/header.jpg');
define('_img_atras', 'graficos/back.png');
define('_img_imprimir', 'graficos/impresora.gif');
define('_img_cerrar', 'graficos/delete.png');
define('_img_construyendo', 'graficos/construccion.gif');
define('_img_pdf', 'graficos/pdf.png');
//Definicion de parametros de botones de menu
define('_img_ver', '<img src="graficos/see.gif" width=15 border=0>');
define('_img_notag', '<img src="graficos/notas.gif" width=15 border=0>'); #§§§§§Leinad§§§§§#
define('_img_pensumg', '<img src="graficos/pensum.gif" width=15 border=0>'); #§§§§§Leinad§§§§§#
define('_img_horariog', '<img src="graficos/horario.gif" width=15 border=0>'); #§§§§§Leinad§§§§§#
define('_img_pagog', '<img src="graficos/pagos.gif" width=15 border=0>'); #§§§§§Leinad§§§§§#
define('_img_deudag', '<img src="graficos/deudas.gif" width=15 border=0>'); #§§§§§Leinad§§§§§#
// address of images for facu
define('_img_addfac', '<img alt=\"Facultades\" src="graficos/plan1.gif" width=15 border=0>');
define('_img_newfac', '<img alt=\"Facultades\" src="graficos/newfacu.jpg" width=15 border=0>');
// address of images for horario
define('_img_horario1', 'graficos/horarios.gif');
define('_img_horario', '<img alt=\"Horario\" src="graficos/horario.jpg" width=15 border=0>');
// address of images for carrera
define('_img_addcar', '<img alt=\"Horario\" src="graficos/update.png" width=15 border=0>');
define('_img_modificar', '<img src="graficos/addedit.png" width=20 border=0>');
define('_img_eliminar', '<img src="graficos/delete.png" width=18 border=0>');
define('_img_ejecutar', '<img src="graficos/see.png" width=18 border=0>');
define('_img_cargar', '<img src="graficos/select.png" width=18 border=0>');
define('_img_mail', 'graficos/grupos.png');
define('_img_radio', 'graficos/iconos/radio.ico');
define('_img_biblio', 'graficos/iconos/biblioteca.ico');
define('_img_pag_nacional', 'graficos/iconos/pagnacional.gif');
define('_img_pag_regional', 'graficos/iconos/sede.gif');
define('_img_inicial', 'graficos/logomejor.png');
define('_img_insc', 'graficos/addins.gif');
define('_img_modinsc', 'graficos/addinsmod.gif');
define('_img_fuerafec', 'graficos/addinsout.gif');
// address of images for estudiante

define('_img_nuevo1', 'graficos/nuevo1.png');
define('_img_modificar1', 'graficos/query.png');
define('_img_nothist', 'graficos/addedit.png');
define('_img_inscribir', 'graficos/open.gif');
define('_img_pagos', 'graficos/exec.png');
define('_img_pensum', 'graficos/templatemanager.png');
define('_img_boleta', 'graficos/b_print.png');
define('_img_acta', 'graficos/13.gif');
// imagenes para registros

define('_img_asignar', '<img src="graficos/asignar.png" width=18 border=0>');
define('_img_compromiso', '<img src="graficos/doc.png" width=18 border=0>');
define('_img_comunicado', '<img src="graficos/comunicado.png" width=18 border=0>');
define('_img_habil', '<img src="graficos/exec.png" width=18 border=0>');

// confirmación y rechazo de urrhh recuperación de horarios
define('_img_aceptar', '<img src="graficos/apro.png" width=18 border=0>');
define('_img_rechazar', '<img src="graficos/rech.png" width=18 border=0>');

# constantes para las imagenes
abstract class ImageConfig {
    /**
     * Array para definir las dimensiones de las imagenes y sus prefijos
     * 
     * @access public
     * @static
     */
    public static $ImageSizes = array( 'large' => array( 300 , 250 ) , 'medium' => array( 200 , 132 ) );
}
?>