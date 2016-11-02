<?php

namespace Transporte;

use PHPUnit\Framework\TestCase;

class TransporteTest extends TestCase {
	public $transporte;
	public $viaje;
	public $colectivo;
	public $patente;

	public function setUp() {
		$this->transporte = new Transporte();
		$this->viaje = new Viaje("Colectivo", 8.50, "144 Negro", "27/09/16 14:44");
		$this->colectivo = new Colectivo("144 Negro", "Rosario Bus");
		$this->bicicleta = new Bicicleta(1234);
		$this->tarjeta = new Tarjeta();
		$this->medioBoleto = new MedioBoleto();
		$this->paseLibre = new PaseLibre();
	}

	//Test Class Transporte
	public function testTransporte() {
		$this->transporte->tipo = "Colectivo";
		$type = $this->transporte->tipo();
		$this->assertEquals($type, $this->transporte->tipo);
	}

	//Test Class Viaje
	public function testViaje() {
		//Test Function Tipo
		$tipo = $this->viaje->tipo();
		$this->assertEquals($tipo, "Colectivo");

		//Test Function Monto
		$monto = $this->viaje->monto();
		$this->assertEquals($monto, 8.50);

		//Test Function Transporte
		$transporte = $this->viaje->transporte();
		$this->assertEquals($transporte, "144 Negro");

		//Test Function Tiempo
		$tiempo = $this->viaje->tiempo();
		$this->assertEquals($tiempo, "27/09/16 14:44");
	}

	//Test Class Colectivo
	public function testColectivo() {
		$nombre = $this->colectivo->nombre();
		$this->assertEquals($nombre, "144 Negro");
	}

	//Test Class Bicicleta
	public function testBicicleta() {
		$patente = $this->bicicleta->nombre();
		$this->assertEquals($patente, 1234);
	}

	//Test Class Tarjeta
	public function testTarjeta() {
		//Test Function Saldo
		$this->tarjeta->saldo = 100;
		$saldo_aux = $this->tarjeta->saldo();
		$this->assertEquals($saldo_aux, $this->tarjeta->saldo);
		
		//Test Function Recargar sin beneficio
		$this->tarjeta->saldo = 0;
		$this->tarjeta->recargar(30);
		$this->assertEquals($this->tarjeta->saldo, 30);
		
		$this->tarjeta->saldo = 0;
		$this->tarjeta->recargar(700);
		$this->assertEquals($this->tarjeta->saldo, 700);

		//Test Function Recargar 290
		$this->tarjeta->saldo = 0;
		$this->tarjeta->recargar(290);
		$this->assertEquals($this->tarjeta->saldo, 340);
		
		//Test Function Recargar 544
		$this->tarjeta->saldo = 0;
		$this->tarjeta->recargar(544);
		$this->assertEquals($this->tarjeta->saldo, 680);
		
		//Test Function Pagar (Con tarjeta comun) -> Colectivo
		$saldo_inicial = $this->tarjeta->saldo();
		$this->tarjeta->pagar($this->colectivo, "2016/06/30 22:50");
		$saldo_final = $saldo_inicial - 8.50;
		$this->assertEquals($saldo_final, $this->tarjeta->saldo);

		//Test Function Pagar (Trasbordo) -> Colectivo
		$trasbordo = new Colectivo("135", "Rosario Bus");
		$saldo_inicial = $this->tarjeta->saldo();
		$this->tarjeta->pagar($trasbordo, "2016/06/30 23:10");
		$saldo_final = $saldo_inicial - 2.81;
		$this->assertEquals($saldo_final, $this->tarjeta->saldo);

		//Test Function Pagar (Con medio boleto) -> Colectivo
		$this->medioBoleto->recargar(290);
		$saldo_inicial = $this->medioBoleto->saldo();
		$this->medioBoleto->pagar($this->colectivo, "2016/06/30 23:10");
		$saldo_final = $saldo_inicial - 4.25;
		$this->assertEquals($saldo_final, $this->medioBoleto->saldo);

		//Test Function Pagar (Con pase libre) -> Colectivo
		$saldo_inicial = $this->paseLibre->saldo();
		$this->paseLibre->pagar($this->colectivo, "2016/06/30 23:10");
		$saldo_final = $saldo_inicial;
		$this->assertEquals($saldo_final, $this->paseLibre->saldo);

		//Test Function Pagar -> Bicicleta
		$saldo_inicial = $this->tarjeta->saldo();
		$this->tarjeta->pagar($this->bicicleta, "2016/06/30 23:10");
		$saldo_final = $saldo_inicial - 12;
		$this->assertEquals($saldo_final, $this->tarjeta->saldo);

		//Test Function ViajesRealizados 
		$this->tarjeta->viajes = 3;
		$viajes = $this->tarjeta->viajesRealizados();
		$this->assertEquals($viajes, $this->tarjeta->viajes);
	}
}
