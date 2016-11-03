<?php

namespace Transporte;

class Boleto {
	public $fechaHora;
	public $tipoBoleto;
	public $saldo;
	public $linea;
	public $idTarjeta;

	public function __construct($idTarjeta, $tipoBoleto, $saldo, $linea, $fechaHora) {
		$this->idTarjeta = $idTarjeta;
		$this->tipoBoleto = $tipoBoleto;
		$this->saldo = $saldo;
		$this->linea = $linea;
		$this->fechaHora = $fechaHora;
	}

	public function idTarjeta() {
		return $this->idTarjeta;
	}

	public function tipoBoleto() {
		return $this->tipoBoleto;
	}

	public function saldo() {
		return $this->saldo;
	}

	public function linea() {
		return $this->linea;
	}

	public function fechaHora() {
		return $this->fechaHora;
	}
	
}