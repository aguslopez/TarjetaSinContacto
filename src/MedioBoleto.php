<?php

namespace Transporte;

class MedioBoleto extends Tarjeta {
	public function __construct($id) {
		$this->id = $id;
		$this->viajesPlus = 0;
		$this->boletoColectivo = 4;
		$this->boletoBici = 6;
		$this->saldo = 0;
		$this->trasbordo = (float)((int)($this->boletoColectivo/3*100)/100);
	}	
}
