<?php
/*
	Clase PHP CompraEnSanJuan
	==============================
	Clase PHP para actualizar estado y precio de un producto específico.
	Creada para el libre uso de CompraEnSanJuan.com
	CoreUNO - www.coreuno.com
	
	----------------------------------------------
	Este DEMO suspende el articulo introducido.
	----------------------------------------------
*/

// Parametros
$usuario = 'escribi_tu_mail_aqui'; //establecer el e-mail del usuario
$clave = 'escribi_tu_clave_aqui'; //establecer la contraseña del usuario
$anuncio = 'escribi_un_cod_de_articulo'; //código del anuncio

// Inicialización
include('compraensanjuan.class.php');
$cpsj = new CompraEnSanJuan($usuario, $clave);

// Actuar
$resultado = $cpsj->suspender($anuncio);
if( $resultado ) {
	echo 'OK';
} else {
	echo 'ERROR';
}

?>