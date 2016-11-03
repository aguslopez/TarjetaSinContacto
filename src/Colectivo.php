<?php

namespace Transporte;

class Colectivo extends Transporte {
	public $nombre;
	public $linea;
	public $tipo;

	public function __construct($linea, $nombre) {
		$this->tipo = "Colectivo";
		$this->nombre = $nombre;
		$this->linea = $linea;
	}
	
}
