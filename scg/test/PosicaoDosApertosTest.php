<?php
require_once '../src/class/PosicaoDosApertos.php';

use PHPUnit\Framework\TestCase;

class PosicaoDosApertosTest extends TestCase {
	
	/**
	 *
	 * @var PosicaoDosApertos
	 */
	private $posicaoDosApertos;
	private $cabinaAtego;
	private $cabinaAxorC;
	private $cabinaAxorR;
	private $cabinaAccelo;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp();
		$this->posicaoDosApertos = new PosicaoDosApertos();
		$this->cabinaAtego = new Cabina("﻿", "", Constantes::ATEGO, "", "", "", "", "", "", "", "", "", "", "", "");
		$this->cabinaAxorC = new Cabina("﻿", "", Constantes::AXOR_C, "", "", "", "", "", "", "", "", "", "", "", "");
		$this->cabinaAxorR = new Cabina("﻿", "", Constantes::AXOR_R, "", "", "", "", "", "", "", "", "", "", "", "");
		$this->cabinaAccelo = new Cabina("﻿", "", Constantes::ACCELO, "", "", "", "", "", "", "", "", "", "", "", "");
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->posicaoDosApertos = null;
		$this->cabinaAtego = null;
		$this->cabinaAxorC = null;
		$this->cabinaAxorR = null;
		$this->cabinaAccelo = null;
		$this->posicaoDosApertos = null;
	}

	public function testDeveRetornarValores() {
		$this->assertArraySubset(array(4, 5, 6, 7), PosicaoDosApertos::getPosicaoDosApertos($this->cabinaAtego));
		$this->assertArraySubset(array(14, 15, 16, 17), PosicaoDosApertos::getPosicaoDosApertos($this->cabinaAxorC));
		$this->assertArraySubset(array(14, 15, 16, 17), PosicaoDosApertos::getPosicaoDosApertos($this->cabinaAxorR));
		$this->assertArraySubset(array(2, 3, 4, 5), PosicaoDosApertos::getPosicaoDosApertos($this->cabinaAccelo));
	}
}

