<?php
require_once 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class CabinaTest extends TestCase {

	/**
	 * Tests Cabina->isNTC()
	 */
	public function testCabinaDeveSerNTC() {
		$cabinaAtego = new Cabina("﻿", "", Constantes::ATEGO, "", "", "", "", "", "", "", "", "", "", "", "");
		$cabinaAxorC = new Cabina("﻿", "", Constantes::AXOR_C, "", "", "", "", "", "", "", "", "", "", "", "");
		$cabinaAxorR = new Cabina("﻿", "", Constantes::AXOR_R, "", "", "", "", "", "", "", "", "", "", "", "");
		
		$this->assertEquals(TRUE, $cabinaAtego->isNTC());
		$this->assertEquals(TRUE, $cabinaAxorC->isNTC());
		$this->assertEquals(TRUE, $cabinaAxorR->isNTC());
	}

	/**
	 * Tests Cabina->isNTC()
	 */
	public function testCabinaNaoDeveSerNTC() {
		$cabinaAtron = new Cabina("﻿", "", Constantes::ATRON, "", "", "", "", "", "", "", "", "", "", "", "");
		$cabinaAccelo = new Cabina("﻿", "", Constantes::ACCELO, "", "", "", "", "", "", "", "", "", "", "", "");
		
		$this->assertNotEquals(TRUE, $cabinaAtron->isNTC());
		$this->assertNotEquals(TRUE, $cabinaAccelo->isNTC());
	}
}

