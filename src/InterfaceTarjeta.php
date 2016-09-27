<?php

namespace Transporte;

interface InterfaceTarjeta {
	public function pagar(Transporte $transporte, $fechaHora);
 	public function recargar($monto);
 	public function saldo();
 	public function viajesRealizados();
}
