<?php

namespace Transporte;

class Colectivo extends Transporte {
	public $nombre;
	public $linea;
	public $tipo;

	public function __construct($nombre, $linea) {
		$this->tipo = "Colectivo";
		$this->nombre = $nombre;
		$this->linea = $linea;
	}

	public function nombre() {
		return $this->nombre;
	}
	
}
