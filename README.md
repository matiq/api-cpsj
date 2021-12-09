# Clase PHP CompraEnSanJuan

![Logo Comprá en San Juan](https://www.compraensanjuan.com/img/logo_navbar.png)

Clase PHP para actualizar estado y precio de un producto específico.

Creada para uso libre en <https://www.compraensanjuan.com>.

Hecha por [MundoChip](https://webs.mundochip.com.ar)


### Disclamer

Esta clase fue diseñada externamente a **Comprá En San Juan** 
y sin relación con dicho sitio web. 

**Comprá en San Juan** no se responsabiliza por el correcto 
funcionamiento de la misma, ni por los errores que pudieran 
producirse por el mal funcionamiento de la misma. 

El mal uso o abuso de la api proporcionada está sujeto a ser 
sancionado por **Comprá en San Juan** (a través de suspensión 
de cuentas, borrado de publicaciones, y cualquier otra medida 
que sea necesaria para mantener el correcto funcionamiento de 
la plataforma), sin necesidad de dar aviso previo.

Para más información, consultar los Términos y Condiciones de 
uso de por **Comprá en San Juan** en 
<https://www.compraensanjuan.com/terminos_condiciones.php>.


## Instalación

Copiar el archivo compraensanjuan.class.php del repositorio 
en el directorio de la aplicación.


## Inicialización

```php
include('compraensanjuan.class.php');
$usuario = 'usuario@email.com'; //establecer el e-mail del usuario
$clave = 'abc123'; //establecer la contraseña del usuario
$cpsj = new CompraEnSanJuan($usuario, $clave);
```


## Funciones

Todas las funciones devuelven TRUE si el articulo se actualizo 
correctamente. Caso contrario, devuelven FALSE. 

Ejemplo: 
```php
if( $cpsj->activar($anuncio) ) {
	echo 'El articulo se activó correctamente.';
} else {
	echo 'El articulo no pudo ser activado.';
}
```

A todas las funciones hay que pasarles el código del anuncio 
a actualizar. Se puede hacer individualmente, o así:
```php
$anuncio = '0000000'; //código del anuncio
```


### Funciones disponibles
```php
$cpsj->activar($anuncio);
//Establece el estado del anuncio a Activado

$cpsj->suspender($anuncio);
//Establece el estado del anuncio a Suspendido

$cpsj->nuevo_precio($anuncio, $precio); 
// Establece un nuevo precio para el anuncio seleccionado, a través 
// del parámetro $precio, que deberá ser en formato numérico-decimal
// estándar de PHP, es decir 120.50 (usando un punto como separador
// de miles).

$cpsj->actualizar($anuncio, $suspendido, $precio); 
// Idem que la funcion nuevo_precio(), pero le agrega el parametro
// $suspendido de tipo boolean (verdadero o falso). Si se establece
// a true, se pone el articulo como suspendido, si se establece a
// false, se activa el articulo.

$cpsj->consultar($anuncio); 
// Devuelve un array con los datos del anuncio seleccionado. El 
// resultado es el siguiente: Array (
//     [titulo] => String del titulo
//     [categorias] => Array (
//         [0] => Cat1
//         [1] => Subcat2
//         [2] => Subcat...
//     )
//     [suspendido] => True/False
//     [precio_normal] => 0.00
// 
```


## Changelog
Listado de cambios y actualizaciones del script.

#### [0.0.1] - 2014-07-25
- Version inicial

#### [0.0.2] - 2014/07/26
- Se agrega la posibilidad de consultar los datos del producto 
  directamente desde la api, mediante la funcion: 
  `$cpsj->consultar($anuncio);` (ver documentación).

#### [0.0.3] - 2021/11/30
- Deshabilitado el uso de $precio_desc ya que CompraEnSanJuan 
  discontinuó este parámetro.
- Por cambios en la UI la función consultar queda desactivada. 

#### [0.0.4] - 2021/12/09
- Habilitada nuevamente la función consultar. 
- Actualizada la documentación. 
