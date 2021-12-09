<?php
/*

	Clase PHP CompraEnSanJuan v0.4
	==============================
	Clase PHP para actualizar estado y precio de un producto específico.
	
	Creada para el libre uso de CompraEnSanJuan.com
	
	MundoChip - webs.mundochip.com.ar
	
*/

class CompraEnSanJuan {

	var $usuario;
	var $clave;
	var $url_cpsj = "https://www.compraensanjuan.com/";
	var $url_api = "util/act.php";
	var $url_consulta = "busqueda_codigo.php";

	function CompraEnSanJuan($usuario, $clave) {
		$this->usuario = $usuario;
		$this->clave = $clave;
	}

	public function activar($anuncio) {
		$param = '&act=A';
		return $this->enviar($anuncio, $param);
	}

	public function suspender($anuncio) {
		$param = '&act=S';
		return $this->enviar($anuncio, $param);
	}

	public function nuevo_precio($anuncio, $precio) {
		$param  = '&pre='.round($precio*100);
		return $this->enviar($anuncio, $param);
	}

	public function actualizar($anuncio, $suspendido, $precio) {
		$param  = '&pre='.round($precio*100);
		$param .= '&act='.($suspendido ? 'S' : 'A');
		return $this->enviar($anuncio, $param);
	}

	
	public function consultar($anuncio) {
		$opts = ['http' => [
			'method' => 'POST',
			'header' => 'Content-type: application/x-www-form-urlencoded',
			'content' => http_build_query(['c1' => $anuncio])
		]];
		$context = stream_context_create($opts);
		$ret = file_get_contents($this->url_cpsj.$this->url_consulta, false, $context);
		$ret = str_replace("'", '"', $ret); //reemplazo las comillas
		$ret = $this->GetBetween('<html>','Denunciar este anuncio', $ret); //extraigo solo el cuerpo
		$ret = mb_convert_encoding($ret, 'UTF-8', 'windows-1252');

		$dev = [];
		$dev['url'] = trim($this->GetBetween('https://facebook.com/sharer.php?u=','"', $ret));
		$dev['titulo'] = trim($this->GetBetween('<title>',' - Comprá en San Juan', $ret));
		$temp = strip_tags(str_replace('<i class="fas fa-angle-right">',' /// ', $this->GetBetween('<p class="aviso-categoria-start">','</p>', $ret)));
		$dev['categorias'] =  array_filter(explode(" /// ", $temp));
		$dev['precio'] = trim(str_replace(array('$',' ','.',','), array('','','','.'),$this->GetBetween('<h3 class="text-center precio">','</h3>', $ret)));
		$dev['visitas'] = (strpos($ret, '<p class="visitas m-0">Visitas:') ? trim(strip_tags($this->GetBetween('<p class="visitas m-0">Visitas:','</p>', $ret))) : false);
		$dev['publicado'] = (strpos($ret, '<p class="publicado m-0">Publicado:') ? trim(strip_tags($this->GetBetween('<p class="publicado m-0">Publicado:','</p>', $ret))) : false);
		$dev['actualizado'] = (strpos($ret, '<p class="actualizado m-0">Actualizado:') ? trim(strip_tags($this->GetBetween('<p class="actualizado m-0">Actualizado:','</p>', $ret))) : false);
		$dev['suspendido'] = (strpos($ret, '<p class="text red fs-1 m-0"><b>Suspendido:') ? trim(strip_tags($this->GetBetween('<p class="text red fs-1 m-0"><b>Suspendido:','</p>', $ret))) : false);
		$dev['baja'] = (strpos($ret, '<p class="text red fs-1_1 m-0"><b>Baja:') ? trim(strip_tags($this->GetBetween('<p class="text red fs-1_1 m-0"><b>Baja:','</p>', $ret))) : false);

		return $dev;
	}

	private function enviar($anuncio, $parametros) {
		// armo la direccion del pedido a cpsj;
		$dir = $this->url_cpsj.$this->url_api;
		$dir .= '?usr='.urlencode($this->usuario);
		$dir .= '&pas='.urlencode($this->clave);
		$dir .= '&pub='.urlencode($anuncio);
		$dir .= $parametros;
		
		$ret = file_get_contents($dir); //envio el pedido
		
		$ret = strip_tags($ret); //elimino las marcas html <br>
		$ret = trim($ret); //elimino las nuevas lineas
		$ret = str_replace(' ', '', $ret); //elimino los espacios	
		$rets = explode("-", $ret); //separo el resultado

		if ((count($rets)==2) && ($rets[0]==$anuncio) && ($rets[1]=='ACTUALIZADO')) {
			return true;
		} else {
			return false;
		}
	}
	
	private function GetBetween($var1="",$var2="",$pool){
		$temp = stripos($pool,$var1)+strlen($var1);
		$res = substr($pool,$temp,strlen($pool));
		$dd=stripos($res,$var2);
		if($dd == 0) $dd = strlen($res);
		return substr($res,0,$dd);
	}

}

?>