<?php

namespace Transporte;

use PHPUnit\Framework\TestCase;

class TransporteTest extends TestCase {

	//Test Class Tarjeta
	public function testTarjeta() {

		//Test Function Recargar (500)
		$tarjeta = New Tarjeta(1);
		$tarjeta->recargar(500);
		$this->assertEquals($tarjeta->saldo(), 640, "Cargo 500 y me dan 640");

		//Test Function Recargar (272)
		$tarjeta1 = New Tarjeta(2);
		$tarjeta1->recargar(272);
		$this->assertEquals($tarjeta1->saldo(), 320, "Cargo 272 y me dan 320");

		//Test Function Pagar (Tarjeta comun, primer colectivo)
 		$colectivoK = new Colectivo("Linea K", "Semtur");
 		$tarjeta1->pagar($colectivoK, "2016/06/30 20:50");
 		$this->assertEquals($tarjeta1->saldo(), 312, "Descuento un viaje normal");
 
 		//Test Function Pagar (Tarjeta comun, segundo colectivo con trasbordo)
 		$colectivo120 = new Colectivo("120", "Semtur");
 		$tarjeta1->pagar($colectivo120, "2016/06/30 21:10");
 		$this->assertEquals($tarjeta1->saldo(), 309.34, "Trasbordo");

		//Test Function Pagar (Tarjeta comun, mismo colectivo que el anterior)
		$tarjeta1->pagar($colectivo120, "2016/06/30 23:20");
		$this->assertEquals($tarjeta1->saldo(), 301.34, "Mismo colectivo, sin trasbordo");

		//Test Function Pagar (Tarjeta comun, colectivo cualquiera)
		$tarjeta1->pagar($colectivoK, "2016/07/01 01:50");
		$this->assertEquals($tarjeta1->saldo(), 293.34, "Descuento un viaje normal");

		//Test Function Pagar (Tarjeta comun, primer viaje plus)
		$tarjeta4 = new Tarjeta(5);
		$this->assertEquals($tarjeta4->saldo(), 0, "Nueva tarjeta sin saldo");
		$colectivo144Negro = new Colectivo("144 Negro", "Rosario Bus");
		$tarjeta4->pagar($colectivo144Negro, "2016/06/30 22:50");
		$this->assertEquals($tarjeta4->saldo(), -8, "Primer viaje plus gastado");

		//Test Function Pagar (Tarjeta comun, segundo viaje plus)
		$tarjeta4->pagar($colectivo144Negro, "2016/06/30 23:59");
		$this->assertEquals($tarjeta4->saldo(), -16, "Segundo viaje plus gastado");

		//Test Function Pagar (Tarjeta comun, sin viajes plus)
		$this->assertEquals($tarjeta4->pagar($colectivo144Negro, "2016/07/03 14:50"), "Tarjeta sin saldo", "No quedan viajes plus");
		
		$tarjeta4->recargar(270);
		$this->assertEquals($tarjeta4->saldo(), 254, "Se descontaron los plus");
		
		//Test Function Viajes
		$this->assertEquals($tarjeta1->viajesRealizados(), 4, "4 viajes realizados");
	}

	//Test class MedioBoleto
	public function testMedio() {

		//Test Function Recargar (Medio Boleto)
		$medio = new MedioBoleto(1);
		$medio->recargar(272);

		//Test Function Pagar (Medio Boleto)
		$colectivo142Rojo = new Colectivo("142 rojo", "Rosario Bus");
		$medio->pagar($colectivo142Rojo, "2016/06/30 20:00");
		$this->assertEquals($medio->saldo(), 316, "Descuento medio boleto");

		//Test Function Pagar (Medio Boleto con trasbordo)
		$colectivo143Rojo = new Colectivo("143 rojo", "Rosario Bus");
		$medio->pagar($colectivo143Rojo, "2016/06/30 20:30");
		$this->assertEquals($medio->saldo(), 314.67, "Medio boleto y trasbordo");
	}
	
	//Test Class Pase Libre
	public function testPaseLibre() {
		
		//Test Function Pagar con Pase Libre
		$pase = new PaseLibre(1);
		$colectivo135 = new Colectivo("135", "Rosario Bus");
		$pase->pagar($colectivo135, "2016/06/30 20:00");
		$this->assertEquals($pase->saldo(), 0, "Pase libre");
	}

	//Test Class Bicicleta
	public function testBicicleta() {

		$tarjeta5 = new Tarjeta(6);
		$tarjeta5->recargar(272);

		//Test Function Pagar (Bicicleta con tarjeta comun)
		$bici = new Bicicleta(123);
		$tarjeta5->pagar($bici, "2016/06/30 20:00");
		$this->assertEquals($tarjeta5->saldo(), 308, "Descuento bicicleta");

		//Test Function Nombre
		$this->assertEquals($bici->nombre(), 123, "Patente de la bicicleta");

		$medio1 = new MedioBoleto(2);
		$medio1->recargar(272);

		//Test Function Pagar (Bicicleta con medio)
		$bici1 = new Bicicleta(456);
		$medio1->pagar($bici1, "2016/06/30 20:00");
		$this->assertEquals($medio1->saldo(), 314, "Descuento bicicleta con medio");
	}

	//Test Class Boleto
	public function testBoleto() {

		$boleto = new Boleto(1234, "Normal", 340, "144 Negro", "2016/06/30 20:00");
		//Test Function idTarjeta
		$this->assertEquals($boleto->idTarjeta(), 1234, "Id de la tarjeta");

		//Test Function tipoBoleto
		$this->assertEquals($boleto->tipoBoleto(), "Normal", "Tipo de boleto");

		//Test Function saldo
		$this->assertEquals($boleto->saldo(), 340, "Saldo restante");

		//Test Function Linea
		$this->assertEquals($boleto->Linea(), "144 Negro", "Linea de colectivo");

		//Test Function fechaHora
		$this->assertEquals($boleto->fechaHora(), "2016/06/30 20:00", "Fecha y hora");
	}
}
	
