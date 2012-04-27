<?PHP
/**
@file es.php
Definicion de etiquetas en lenguaje: español
Se definen etiquetas que permitan cambiar cualquier momento de idioma, en el tiempo
*/

//include_once("settings.es.php");
//include_once("menu.es.php");
//include_once("mensajes.es.php");
###########################
##	GENERAL         ##
###########################
/*----comun */
	define('_nombresistema','inf-131');
	define('_fueraservicio','Esta Web por tareas de mantenimiento esta cerrada.<br /> Vuelve pasados unos minutos. Gracias!');
	define('_no_disponible','Esta Web, temporalmente, no esta disponible.<br /> Contacta con el administrador. Gracias!');
	define('_cerrarsesion','Cerrando Sesion');
/*----titulos*/
	define('_titulo','.: INF-131 :.');
/*----BUSQUEDA----*/	
	define('_men_buscar','Buscar');
	define('_men_nuevo','Nuevo');
	define('_men_cargar','<img src="graficos/select.png" width=18 border=0>');
	define('_men_imprimir','Imprimir');
	define('_men_cerrar','Cerrar');
	define('_men_salir','Salir');
/*----BUSQUEDA AJAX----*/	
	define('_ajax_msg','Mensaje del Sistema');
	define('_ajax_msg1','Registros</b> de');	
	define('_ajax_msg2','Ordenados por:');
	define('_ajax_msg3','Datos para la Generaci&oacute;n');
	define('_ajax_msg4','Seleccione el un Rango de Fechas o solo una Fecha Inicial y luego presione el Bot&oacute;n "Generar"');
	define('_ajax_msg5','No Exsite Ningun');
	define('_ajax_msg6','Con los datos Proporcionados...');
	
	define('_ajax_msg_alu','Escriba los nombres de los Alumnos y luego presione el Bot&oacute;n "Guardar"');
	
	define('_ajax_asc','Ascendentemente');
	define('_ajax_des','Descendentemente');
	define('_ajax_fecha','Fecha:');
	define('_ajax_fecha1','A Fecha :');
	define('_ajax_personal','Nombre del Personal :');
	
/*----FORMULARIO----*/
	define('_men_enviar','Guardar');
	define('_men_limpiar','Limpiar');
	define('_men_continuar','Continuar');
	define('_men_el_campo','El campo ');
	define('_men_requerido',' es requerido');
	define('_men_insertados','Datos Insertados Correctamente...');
	define('_men_modificados','Datos Modificados Correctamente...');
	define('_men_eliminado','Registro Eliminado Correctamente...');	
/*----PAGINACION----*/
	define('_men_encontrados','Registros'); 
	define('_men_pag_inicio','Primera Pagina');
	define('_men_pag_anterior','Anterior');
	define('_men_pag_siguiente','Siguiente');
	define('_men_pag_ultimo','Ultima Pagina');
/*----DIAS----*/
	define('_dia1','Lunes');
	define('_dia2','Martes');
	define('_dia3','Miercoles');
	define('_dia4','Jueves');
	define('_dia5','Viernes');
	define('_dia6','Sabado');
	define('_dia7','Domingo');
/*----VARIOS----*/
	define('_msg_comp','Llene todos los campos marcados con (*)');
	define('_msg_estado','Habilitado:');//Usado para estados
	define('_msg_obs','Observaci&oacute;n:');
	define('_msg_fecini','Fecha Inicio:');
	define('_msg_fecfin','Fecha Fin:');
	define('_msg_horini','Hora In:');

	define('_men_seleccione',"Seleccione");//Usado para Combos
	define('_men_esperando',"Esperando");
	define('_men_generar','Generar');
	define('_men_carga_arbol','Cargando...');
	define('_men_pdf','Version PDF');
	
	define( '_404', 'Disculpe la pagina solicitada no se puede encontrar.' );// Site paina no encontrada
	define( '_404_RTS', 'Volver al sitio');
/*----OPCION----*/
	define('_men_R','Ver');
	define('_men_A','Agregar');
	define('_men_W','Modificar');
	define('_men_K','Eliminar');
	//define('_men_X','Ejecutar');
	define('_men_X','Asignaci&oacute;n Alumno');
	define('_men_P','Imprimir');
	define('_men_N','Registro Notas');
###########################
##	LOGIN					##
###########################
        /*
	define("_titulo_login",'Ingreso de Usuarios');//Definicion del Titulo
	define("_name_login","  Nombre de Usuario:  ");//Definicion del Nombre de Usuario
	define("_codigo_login","  Codigo de Acceso: ");//Definicion del Codigo de Acceso
	define('_ingreso','Ingresar');//Definicion de Ingreso
	define('_cancelar','Cancelar');//Definicion de Cancelar
        */
###########################
##	MENU             ##
###########################
define('_men_menu','Menu');
define('_men_login','Inicio');
define('_men_adm','Administraci&oacute;n'); 
	define('_men_modu','Modulos');
	define('_men_per','Permisos');
	define('_men_usuario','Usuarios');	
	define('_men_gru','Grupos de Usuarios');
	define('_men_personal','Persona');	
	define('_men_gusu','Grupos/Usuarios');
define('_men_registro','Registro');
	define('_men_Otros','Otros');
		define('_men_reg_especie','Especie');
define('_men_cam_contra','Cambio Contrase&ntilde;a');
define('_men_reportes','Reportes');
###########################
##	MODULOS          ##
###########################
##$$$$$	ADMINISTRACION		$$$$$##
	
##################### OTROS###############################
	###########	Especie		####################
	define('_reg_especie_bus_titulo','Busqueda de Especies');
	define('_reg_especie_ing_titulo','Ingreso de Especies');
	define('_reg_especie_nom','Nombre de la Especie:');
	define('_reg_especie_des','Descripci&oacute;n de la Especie:');

###########	Reporte SQL		####################
define('_repsql_gen','Generar Query con Tabla: ');

###########	Modulo			####################
define('_mo_titulo_busqueda','Busqueda de Modulo');
define('_mo_titulo','Modulos');
define('_ele_id','ID');
define('_ele_tipo','Tipo');
define('_ele_descripcion','Descripci&oacute;n');
define('_ele_estado','Estado');
define('_ele_origen','Raiz');
define('_ele_icono','Icono');
###########	Grupo			####################
define('_gru_titulo_busqueda','Busqueda de Grupos');
define('_gru_titulo','Grupos');
define('_gru_id','Nombre');
define('_gru_observaciones','Descripci&oacute;n del Grupo');
###########	Usuario			####################
define('_usu_titulo_busqueda','Busqueda de Usuario');
define('_usu_titulo','Usuario');
define('_usu_id','Nombre del Usuario');
define('_usu_per_id','C&oacute;digo de Persona');
define('_usu_password','C&oacute;digo de Acceso');
define('_usu_conf_password1','Nuevo Codigo de Acceso ');
define('_usu_conf_password2','Confirmar Codigo de Acceso ');
define('_usu_nombre_completo','Nombre Completo');
###########	Grupo-Usuario		####################
define('_gusu_titulo_busqueda','Busqueda de Grupos de Usuario');
define('_gusu_titulo','Grupo-Usuarios');
define('_gusu_gru_id','Grupo');
define('_gusu_usu_id','Usuario');
###########	Permiso			####################
define('_per_titulo_busqueda','Busqueda de Permisos');
define('_per_titulo','Permisos');
define('_per_id','Permiso');
define('_per_gru_id','Grupo');
define('_per_mod_id','Modulo');
define('_per_permiso','Tipo Permiso');
###########	Persona			####################
define('_personal_titulo_busqueda','Busqueda de Personal');
define('_personal_titulo','Modificaci&oacute;n de los datos de personal');
define('_personal_titulo_ver','Datos de PERSONAL');
define('_personal_ci','C.I.:');
define('_personal_nombres','Nombres:');
define('_personal_appaterno','1er.Apellido:');
define('_personal_apmaterno','2do.Apellido:');
define('_personal_fechanac','Fecha de Nacimiento:');
define('_personal_direccion','Direccion Domicilio:');
define('_personal_tefono','Telefono Domicilio:');
define('_personal_celular','Celular:');

###########	Cambio de Contraseña	####################
define('_men_cam_contra1','Cambio Contrase&ntilde;a');
define('_usu_titulo_agregar','Cambio Contrase&ntilde;a');
define('_men_passa','Contrase&ntilde;a Anterior');
define('_men_passn','Contrase&ntilde;a Nueva');
define('_men_passc','Confirmar Contrase&ntilde;a Nueva');
define('_men_alerta','MENSAJE:');
define('_men_alerta_mensaje','ATENCI&Oacute;N:');

/*----Para el Modulo Login*/
define("_titulo_login",'Verificacion de Usuario');
define('_num_pag','Numero de Paginas');
define("_name_login","Nombre de Usuario :");
define("_codigo_login","Codigo de Acceso :");
define("_men_nombre_usuario_invalido","<br>Nombre de Usuario Invalido");
define('_ingreso','Ingreso'); 
define('_cancelar','Cancelar'); 
/*----mensajes por opcion en ad_opcion*/

define('_men_no_existe_registro','No existe el registro');
define('_men_campo_invalido','Campo invalido');
define('_men_agregatetemp','Inicio');
define('_men_config','Opciones'); 
define('_men_email','@ E-mail'); 
define('_men_radio','# Radio'); 
define('_men_volver','Volver');
define('_men_css','CSS Entorno');
define('_men_datagen','Datos Generales');
define('_men_agregate','Inicio'); 
define('_men_data_gen','Datos Generales'); 
define('_men_principal','Inicio');

define('_men_no_encontrado','Modulo no Encontrado');
define('_men_acceso_denegado','<br><br><center>No tiene permisos suficientes para ejecutar este modulo</center>');
define('_men_no_instanciado','Objeto de Session no instanciado');
define('_men_no_existe_objeto','El objeto de Session no existe');
define('_men_admin','Administracion de Usuarios');

define('_men_componente_desaparecido','Lo lamento pero el componente no ha sido encontrado');
define('_men_usuario_no_valido','Usuario no registrado o Invalido');

define('_men_mod_no_existe','<H2>Error Modulo!!</H2><br>El modulo no existe o no ha sido encontrado!!!<br><br>');
?>