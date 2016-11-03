<?php

namespace Transporte;

class PaseLibre extends Tarjeta {
	public function __construct($id) {
		$this->id = $id;
		$this->boletoColectivo = 0;
		$this->boletoBici = 0;
		$this->trasbordo = 0;
		$this->saldo = 0;
	}
}