<?php

namespace Transporte;

class Viaje {
	public $tipo;
	public $monto;
	public $transporte;
	public $fechaHora;

	public function __construct($tipo, $monto, $transporte, $fechaHora) {
		$this->tipo = $tipo;
		$this->monto = $monto;
		$this->transporte = $transporte;
		$this->fechaHora = $fechaHora;
	}

	public function tipo() {
		return $this->tipo;
	}

	public function monto() {
		return $this->monto;
	}

	public function transporte() {
		return $this->transporte;
	}

	public function fechaHora() {
		return $this->fechaHora;
	}
}