<?php

namespace Transporte;

use PHPUnit\Framework\TestCase;

class TransporteTest extends TestCase {

	//Test Class Tarjeta
	public function testTarjeta() {

		//Test Function Recargar (290)
		$tarjeta = New Tarjeta(1);
		$tarjeta->recargar(290);
		$this->assertEquals($tarjeta->saldo(), 340, "Cargo 290 y me dan 340");

		//Test Function Recargar (544)
		$tarjeta1 = New Tarjeta(2);
		$tarjeta1->recargar(544);
		$this->assertEquals($tarjeta1->saldo(), 680, "Cargo 544 y me dan 680");

		//Test Function Recargar (Random)
		$tarjeta2 = New Tarjeta(3);
		$tarjeta2->recargar(90);
		$this->assertEquals($tarjeta2->saldo(), 90, "Cargo 90 y me dan 90");

		//Test Function Saldo
		$tarjeta3 = New Tarjeta(4);
		$tarjeta3->saldo = 100;
		$saldo_aux = $tarjeta3->saldo();
		$this->assertEquals($saldo_aux, $tarjeta3->saldo, "El saldo es 100");

		//Test Function Pagar (Tarjeta comun, primer colectivo)
		$colectivoK = new Colectivo("Linea K", "Semtur");
		$tarjeta->pagar($colectivoK, "2016/06/30 22:50");
		$this->assertEquals($tarjeta->saldo(), 331.50, "Descuento un viaje normal");

		//Test Function Pagar (Tarjeta comun, segundo colectivo con trasbordo)
		$colectivo120 = new Colectivo("120", "Semtur");
		$tarjeta->pagar($colectivo120, "2016/06/30 23:10");
		$this->assertEquals($tarjeta->saldo(), 328.86, "Trasbordo");

		//Test Function Pagar (Tarjeta comun, mismo colectivo que el anterior)
		$tarjeta->pagar($colectivo120, "2016/06/30 23:20");
		$this->assertEquals($tarjeta->saldo(), 320.36, "Mismo colectivo, sin trasbordo");

		//Test Function Pagar (Tarjeta comun, colectivo cualquiera)
		$tarjeta->pagar($colectivoK, "2016/07/01 01:50");
		$this->assertEquals($tarjeta->saldo(), 311.86, "Descuento un viaje normal");

		//Test Function Pagar (Tarjeta comun, primer viaje plus)
		$tarjeta4 = new Tarjeta(5);
		$this->assertEquals($tarjeta4->saldo(), 0, "Nueva tarjeta sin saldo");
		$colectivo144Negro = new Colectivo("144 Negro", "Rosario Bus");
		$tarjeta4->pagar($colectivo144Negro, "2016/06/30 22:50");
		$this->assertEquals($tarjeta4->saldo(), -8.50, "Primer viaje plus gastado");

		//Test Function Pagar (Tarjeta comun, segundo viaje plus)
		$tarjeta4->pagar($colectivo144Negro, "2016/06/30 23:59");
		$this->assertEquals($tarjeta4->saldo(), -17, "Segundo viaje plus gastado");

		//Test Function Pagar (Tarjeta comun, sin viajes plus)
		$this->assertEquals($tarjeta4->pagar($colectivo144Negro, "2016/07/03 14:50"), "Tarjeta sin saldo", "No quedan viajes plus");

		//Test Function Viajes
		$this->assertEquals($tarjeta->viajesRealizados(), 4, "4 viajes realizados");
	}

	//Test class MedioBoleto
	public function testMedio() {

		//Test Function Recargar (Medio Boleto)
		$medio = new MedioBoleto(1);
		$medio->recargar(290);

		//Test Function Pagar (Medio Boleto)
		$colectivo142Rojo = new Colectivo("142 rojo", "Rosario Bus");
		$medio->pagar($colectivo142Rojo, "2016/06/30 20:00");
		$this->assertEquals($medio->saldo(), 335.75, "Descuento medio boleto");

		//Test Function Pagar (Medio Boleto con trasbordo)
		$colectivo143Rojo = new Colectivo("143 rojo", "Rosario Bus");
		$medio->pagar($colectivo143Rojo, "2016/06/30 20:30");
		$this->assertEquals($medio->saldo(), 334.43, "Medio boleto y trasbordo");
	}

	//Test Class Bicicleta
	public function testBicicleta() {

		$tarjeta5 = new Tarjeta(6);
		$tarjeta5->recargar(290);

		//Test Function Pagar (Bicicleta con tarjeta comun)
		$bici = new Bicicleta(123);
		$tarjeta5->pagar($bici, "2016/06/30 20:00");
		$this->assertEquals($tarjeta5->saldo(), 328, "Descuento bicicleta");

		//Test Function Nombre
		$this->assertEquals($bici->nombre(), 123, "Patente de la bicicleta")

		$medio1 = new MedioBoleto(2);
		$medio1->recargar(290);

		//Test Function Pagar (Bicicleta con medio)
		$bici1 = new Bicicleta(456);
		$medio1->pagar($bici1, "2016/06/30 20:00");
		$this->assertEquals($medio1->saldo(), 334, "Descuento bicicleta con medio");
	}

	//Test Class Transporte
	public function testTransporte() {

		//Test Function tipo (Colectivo)
		$colectivo102 = new Colectivo("102", "Rosario Bus");
		$this->assertEquals($colectivo102->tipo(), "Colectivo");

		//Test Function tipo (Bicicleta)
		$bici2 = new Bicicleta("789");
		$this->assertEquals($bici2->tipo(), "Bicicleta");
	}

	//Test Class Viaje
	public function testViaje() {

		$viaje = new Viaje("Colectivo", 8.50, "144 Negro", "27/09/16 14:44");
		//Test Function Tipo
		$tipo = $viaje->tipo();
		$this->assertEquals($tipo, "Colectivo");

		//Test Function Monto
		$monto = $viaje->monto();
		$this->assertEquals($monto, 8.50, "8.50");

		//Test Function Transporte
		$transporte = $viaje->transporte();
		$this->assertEquals($transporte, "144 Negro");

		//Test Function Tiempo
		$tiempo = $viaje->tiempo();
		$this->assertEquals($tiempo, "27/09/16 14:44");
	}

	//Test Class Colectivo
	public function testColectivo() {

		$colectivo143 = new Colectivo("143 Negro", "Rosario Bus");
		$nombre = $colectivo143->nombre();
		$this->assertEquals($nombre, "143 Negro");
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
	
