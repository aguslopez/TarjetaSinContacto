<?php

namespace Transporte;

class Tarjeta implements InterfaceTarjeta {
	public $id;
	public $viajes;
	public $saldo;
	public $descuento;
	public $trasbordo;
	public $ultimoColectivo;
	public $ultimaHora;
	public $viajesPlus;
	public $boletoColectivo;
	public $boletoBici;

	public function __construct($id) {
		$this->descuento = 1;
		$this->saldo = 0;
		$this->id = $id;
		$this->viajesPlus = 0;
		$this->boletoColectivo = 8;
		$this->boletoBici = 12;
		$this->trasbordo = (float)((int)($this->boletoColectivo/3*100)/100);
	}

	public function pagar(Transporte $transporte, $fechaHora) {
		//Si el transporte es un colectivo
		if ($transporte->tipo() == "Colectivo") {
			//Si ya no quedan viajes plus y no alcanza el saldo, muestra "Tarjeta sin saldo"
			if($this->viajesPlus == 2 && $this->saldo < $this->boletoColectivo) {
				return "Tarjeta sin saldo";
			}
			//Si quedan viajes plus pero no alcanza el saldo, pago con viaje plus
			if($this->viajesPlus < 2 && $this->saldo < $this->boletoColectivo) {
				$this->saldo -= $this->boletoColectivo;
				$this->viajesPlus += 1;
			}
			//Pago pasaje normal, pero reviso el trasbordo
			else if($this->saldo > $this->boletoColectivo){
				//Si me subí a un colectivo distinto al anterior
				if($transporte->linea != $this->ultimoColectivo) {
					//Si es el primer colectivo, pago pasaje normal
					if($this->viajes == 0) {
						$this->saldo -= $this->boletoColectivo;
					}
					//Si es el segundo colectivo, pago pasaje con trasbordo
					else {
						if(strtotime($fechaHora) - strtotime($this->ultimaHora) <= 3600) {
							$this->saldo -= $this->trasbordo;
						}
						//Sino, pago pasaje normal
						else {
							$this->saldo -= $this->boletoColectivo;
						}
					}
				}
				//Si me subo a un colectivo igual al anterior, pago pasaje normal
				else {
					$this->saldo -= $this->boletoColectivo;
				}
				$this->ultimoColectivo = $transporte->linea;
				$this->ultimaHora = $fechaHora;
				$this->viajes += 1;
			}
		}
		//Si el transporte es una bicicleta 
		else if($transporte->tipo() == "Bicicleta") {
			if(strtotime($fechaHora) - strtotime($this->ultimaHora) > 86400) {
				$this->saldo -= $this->boletoBici;
			}
			$this->viajes += 1;
		}
	}

	public function recargar($monto) {
		if ($monto < 272) {
			$this->saldo += $monto;
		}
		else if ($monto < 500) {
			$this->saldo = $this->saldo + $monto + 48;
		}
		else {
			$this->saldo = $this->saldo + $monto + 140;
		}

		$this->viajesPlus = 0;
	}

	public function saldo() { 
		return $this->saldo; 
	}

	public function viajesRealizados() { 
		return $this->viajes; 
	}
}

