<?php
require_once 'src/class/constantes/Constantes.php';
require_once 'src/class/modelo/Cabina.php';
require_once 'src/class/logica/VerificadorDeItensPorCabina.php';
require_once 'src/class/factory/CabinaFactory.php';

use PHPUnit\Framework\TestCase;

class VerificadorDeItensPorCabinaTest extends TestCase {
	private $verificador;
	private $cabinaFactory;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp();
		$this->cabinaFactory = new CabinaFactory();
		$this->verificador = new VerificadorDeItensPorCabina();
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->cabinaFactory = null;
		$this->verificador = null;
	}

	public function testCruzetaDeveSerOK() {
		$cabinaAtego = new Cabina("﻿", "", Constantes::ATEGO, "", "", "", "", "", "", "", "", "", "", "", "");
		$cabinaAxorC = new Cabina("﻿", "", Constantes::AXOR_C, "", "", "", "", "", "", "", "", "", "", "", "");
		$cabinaAxorR = new Cabina("﻿", "", Constantes::AXOR_R, "", "", "", "", "", "", "", "", "", "", "", "");
		$cabinaAtron = new Cabina("﻿", "", Constantes::ATRON, "", "", "", "", "", "", Constantes::BRASIL, "", "", "",
								"", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 18; $i++)
			array_push($confirmacoesDosApertos, Constantes::CONFIRMACAO);
		
		$cabinaAtego->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabinaAxorC->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabinaAxorR->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabinaAtron->setConfirmacoesDosApertos($confirmacoesDosApertos);
		
		$cabinaAtego = $verificador->verificar($cabinaAtego);
		$cabinaAxorC = $verificador->verificar($cabinaAxorC);
		$cabinaAxorR = $verificador->verificar($cabinaAxorR);
		$cabinaAtron = $verificador->verificar($cabinaAtron);
		
		$this->assertEquals(Constantes::CONFIRMACAO, $cabinaAtego->getItemDeVerificacao()->getCruzeta());
		$this->assertEquals(Constantes::CONFIRMACAO, $cabinaAxorC->getItemDeVerificacao()->getCruzeta());
		$this->assertEquals(Constantes::CONFIRMACAO, $cabinaAxorR->getItemDeVerificacao()->getCruzeta());
		$this->assertEquals(Constantes::CONFIRMACAO, $cabinaAtron->getItemDeVerificacao()->getCruzeta());
	}

	public function testCruzetaDeveSerNOK() {
		$cabinaAtego = new Cabina("﻿", "", Constantes::ATEGO, "", "", "", "", "", "", "", "", "", "", "", "");
		$cabinaAxorC = new Cabina("﻿", "", Constantes::AXOR_C, "", "", "", "", "", "", "", "", "", "", "", "");
		$cabinaAxorR = new Cabina("﻿", "", Constantes::AXOR_R, "", "", "", "", "", "", "", "", "", "", "", "");
		$cabinaAtron = new Cabina("﻿", "", Constantes::ATRON, "", "", "", "", "", "", Constantes::BRASIL, "", "", "",
								"", "");
		// $verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 18; $i++)
			array_push($confirmacoesDosApertos, Constantes::CONFIRMACAO);
		
		$confirmacoesDosApertos[0] = Constantes::NEGACAO;
		
		$cabinaAtego->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabinaAxorC->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabinaAxorR->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabinaAtron->setConfirmacoesDosApertos($confirmacoesDosApertos);
		
		$cabinaAtego = $this->verificador->verificar($cabinaAtego);
		$cabinaAxorC = $this->verificador->verificar($cabinaAxorC);
		$cabinaAxorR = $this->verificador->verificar($cabinaAxorR);
		$cabinaAtron = $this->verificador->verificar($cabinaAtron);
		
		$this->assertEquals(Constantes::NEGACAO, $cabinaAtego->getItemDeVerificacao()->getCruzeta());
		$this->assertEquals(Constantes::NEGACAO, $cabinaAxorC->getItemDeVerificacao()->getCruzeta());
		$this->assertEquals(Constantes::NEGACAO, $cabinaAxorR->getItemDeVerificacao()->getCruzeta());
		$this->assertEquals(Constantes::NEGACAO, $cabinaAtron->getItemDeVerificacao()->getCruzeta());
	}

	public function testCruzetaDeveSerNA() {
		$cabinaAtron = new Cabina("﻿", "", Constantes::ATRON, "", "", "", "", "", "", "", "", "", "", "", "");
		$cabinaAccelo = new Cabina("﻿", "", Constantes::ACCELO, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 18; $i++)
			array_push($confirmacoesDosApertos, Constantes::CONFIRMACAO);
		
		$cabinaAtron = $verificador->verificar($cabinaAtron);
		$cabinaAccelo = $verificador->verificar($cabinaAtron);
		
		$this->assertEquals(Constantes::SEM_APLICACAO, $cabinaAtron->getItemDeVerificacao()->getCruzeta());
		$this->assertEquals(Constantes::SEM_APLICACAO, $cabinaAtron->getItemDeVerificacao()->getCruzeta());
	}

	public function testPremontagemDaSuspensaoAtegoDeveSerOK() {
		$cabina = new Cabina("﻿", "", Constantes::ATEGO, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 8; $i++)
			array_push($confirmacoesDosApertos, Constantes::CONFIRMACAO);
		
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Constantes::CONFIRMACAO, $cabina->getItemDeVerificacao()->getPreSuspensao());
	}

	public function testPremontagemDaSuspensaoAtegoDeveSerNOK() {
		$cabina = new Cabina("﻿", "", Constantes::ATEGO, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 8; $i++)
			array_push($confirmacoesDosApertos, Constantes::CONFIRMACAO);
		
		$confirmacoesDosApertos[3] = Constantes::NEGACAO;
		
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Constantes::NEGACAO, $cabina->getItemDeVerificacao()->getPreSuspensao());
	}

	public function testPreMontagemDaSuspensaoAxorDeveSerOK() {
		$cabina = new Cabina("﻿", "", Constantes::AXOR_R, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 18; $i++)
			array_push($confirmacoesDosApertos, Constantes::CONFIRMACAO);
		
		$confirmacoesDosApertos[9] = Constantes::NEGACAO;
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Constantes::CONFIRMACAO, $cabina->getItemDeVerificacao()->getPreSuspensao());
	}

	public function testPreMontagemDaSuspensaoAxorDeveSerNOKSeFaltarApertoLE() {
		$cabina = new Cabina("﻿", "", Constantes::AXOR_R, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina(); // 6 7 8
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 18; $i++)
			array_push($confirmacoesDosApertos, Constantes::CONFIRMACAO);
		
		$confirmacoesDosApertos[9] = Constantes::NEGACAO;
		$confirmacoesDosApertos[6] = Constantes::NEGACAO;
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Constantes::NEGACAO, $cabina->getItemDeVerificacao()->getPreSuspensao());
	}

	public function testPreMontagemDaSuspensaoAxorDeveSerNOKSeFaltarApertoLD() {
		$cabina = new Cabina("﻿", "", Constantes::AXOR_R, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 18; $i++)
			array_push($confirmacoesDosApertos, Constantes::CONFIRMACAO);
		
		$confirmacoesDosApertos[9] = Constantes::NEGACAO;
		$confirmacoesDosApertos[7] = Constantes::NEGACAO;
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Constantes::NEGACAO, $cabina->getItemDeVerificacao()->getPreSuspensao());
	}

	public function testPreMontagemDaSuspensaoAxorDeveSerNOKSeFaltarAperto150Nm() {
		$cabina = new Cabina("", "", Constantes::AXOR_R, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 18; $i++)
			array_push($confirmacoesDosApertos, Constantes::CONFIRMACAO);
		
		$confirmacoesDosApertos[8] = Constantes::NEGACAO;
		$confirmacoesDosApertos[9] = Constantes::NEGACAO;
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Constantes::NEGACAO, $cabina->getItemDeVerificacao()->getPreSuspensao());
	}

	public function testPreSuspensaoFL6DeveSerOK() {
		$cabina = $this->cabinaFactory->getCabina(Constantes::AXOR_R, Constantes::FL6);
		$cabina = $this->verificador->verificar($cabina);
		$this->assertEquals(Constantes::CONFIRMACAO, $cabina->getItemDeVerificacao()->getPreSuspensaoFL6());
	}

	public function testPreSuspensaoFL6DeveRetornarConferir() {
		$cabina = $this->cabinaFactory->getCabina(Constantes::AXOR_R, Constantes::FL6);
		$cabina->setVerificacaoDeAperto(9, Constantes::NEGACAO);
		
		$cabina = $this->verificador->verificar($cabina);
		$this->assertEquals(Constantes::CONFERIR, $cabina->getItemDeVerificacao()->getPreSuspensaoFL6());
	}

	public function testSuspensaoAxorDeveSerOK() {
		$cabina = new Cabina("", "", Constantes::AXOR_R, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 18; $i++)
			array_push($confirmacoesDosApertos, Constantes::CONFIRMACAO);
		
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Constantes::CONFIRMACAO, $cabina->getItemDeVerificacao()->getSuspensao());
	}

	public function testSuspensaoAxorDeveSerNOK() {
		$cabina = new Cabina("", "", Constantes::AXOR_R, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 18; $i++)
			array_push($confirmacoesDosApertos, Constantes::CONFIRMACAO);
		
		$confirmacoesDosApertos[14] = Constantes::NEGACAO;
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Constantes::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
		
		$cabina->getConfirmacoesDosApertos()[15] = Constantes::NEGACAO;
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Constantes::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
		
		$cabina->getConfirmacoesDosApertos()[16] = Constantes::NEGACAO;
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Constantes::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
		
		$cabina->getConfirmacoesDosApertos()[17] = Constantes::NEGACAO;
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Constantes::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
	}

	public function testSuspensaoAxorFL6DeveSerOK() {
		$cabinaAxorFL6 = $this->cabinaFactory->getCabina(Constantes::AXOR_R, Constantes::FL6);
		
		$cabinaAxorFL6 = $this->verificador->verificar($cabinaAxorFL6);
		$this->assertEquals(Constantes::CONFIRMACAO, $cabinaAxorFL6->getItemDeVerificacao()->getSuspensao());
	}

	public function testSuspensaoAxorFL6DeveSerConfirmar() {
		$cabina = $this->cabinaFactory->getCabina(Constantes::AXOR_R, Constantes::FL6);
		$cabina->setVerificacaoDeAperto(10, Constantes::NEGACAO);
		$cabina->setVerificacaoDeAperto(11, Constantes::NEGACAO);
		$cabina->setVerificacaoDeAperto(12, Constantes::NEGACAO);
		$cabina->setVerificacaoDeAperto(13, Constantes::NEGACAO);
		
		$cabina = $this->verificador->verificar($cabina);
		$this->assertEquals(Constantes::CONFERIR, $cabina->getItemDeVerificacao()->getSuspensao());
	}

	public function testSuspensaoAcceloDeveSerOK() {
		$cabina = new Cabina("", "", Constantes::ACCELO, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i <= 5; $i++)
			array_push($confirmacoesDosApertos, Constantes::CONFIRMACAO);
		
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Constantes::CONFIRMACAO, $cabina->getItemDeVerificacao()->getSuspensao());
	}

	public function testSuspensaoAcceloDeveSerNOK() {
		$cabina = new Cabina("", "", Constantes::ACCELO, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i <= 5; $i++)
			array_push($confirmacoesDosApertos, Constantes::CONFIRMACAO);
		
		$confirmacoesDosApertos[2] = Constantes::NEGACAO;
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Constantes::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
		
		$cabina->getConfirmacoesDosApertos()[3] = Constantes::NEGACAO;
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Constantes::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
		
		$cabina->getConfirmacoesDosApertos()[4] = Constantes::NEGACAO;
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Constantes::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
		
		$cabina->getConfirmacoesDosApertos()[5] = Constantes::NEGACAO;
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Constantes::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
	}

	public function testSuspensaoAtegoDeveSerOK() {
		$cabina = new Cabina("", "", Constantes::ATEGO, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i <= 7; $i++)
			array_push($confirmacoesDosApertos, Constantes::CONFIRMACAO);
		
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Constantes::CONFIRMACAO, $cabina->getItemDeVerificacao()->getSuspensao());
	}

	public function testSuspensaoAtegoDeveSerNOK() {
		$cabina = new Cabina("", "", Constantes::ATEGO, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i <= 7; $i++)
			array_push($confirmacoesDosApertos, Constantes::CONFIRMACAO);
		
		$confirmacoesDosApertos[4] = Constantes::NEGACAO;
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Constantes::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
		
		$cabina->getConfirmacoesDosApertos()[5] = Constantes::NEGACAO;
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Constantes::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
		
		$cabina->getConfirmacoesDosApertos()[6] = Constantes::NEGACAO;
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Constantes::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
		
		$cabina->getConfirmacoesDosApertos()[7] = Constantes::NEGACAO;
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Constantes::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
	}

	public function testSuspensaoTodosOsVeiculosDeveSerOK() {
		$cabinaAtego = new Cabina("﻿", "", Constantes::ATEGO, "", "", "", "", "", "", "", "", "", "", "", "");
		$cabinaAxorC = new Cabina("﻿", "", Constantes::AXOR_C, "", "", "", "", "", "", "", "", "", "", "", "");
		$cabinaAxorR = new Cabina("﻿", "", Constantes::AXOR_R, "", "", "", "", "", "", "", "", "", "", "", "");
		$cabinaAccelo = new Cabina("﻿", "", Constantes::ACCELO, "", "", "", "", "", "", "", "", "", "", "", "");
		
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 18; $i++)
			array_push($confirmacoesDosApertos, Constantes::CONFIRMACAO);
		
		$cabinaAtego->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabinaAxorC->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabinaAxorR->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabinaAccelo->setConfirmacoesDosApertos($confirmacoesDosApertos);
		
		$cabinaAtego = $verificador->verificar($cabinaAtego);
		$cabinaAxorC = $verificador->verificar($cabinaAxorC);
		$cabinaAxorR = $verificador->verificar($cabinaAxorR);
		$cabinaAccelo = $verificador->verificar($cabinaAccelo);
		
		$this->assertEquals(Constantes::CONFIRMACAO, $cabinaAtego->getItemDeVerificacao()->getSuspensao());
		$this->assertEquals(Constantes::CONFIRMACAO, $cabinaAxorC->getItemDeVerificacao()->getSuspensao());
		$this->assertEquals(Constantes::CONFIRMACAO, $cabinaAxorR->getItemDeVerificacao()->getSuspensao());
		$this->assertEquals(Constantes::CONFIRMACAO, $cabinaAccelo->getItemDeVerificacao()->getSuspensao());
	}

	public function testPedalAtronDeveSerOK() {
		$cabinaAtron = new Cabina("﻿", "", Constantes::ATRON, "", "", "", "", "", "", "", "", "", "", "", "");
		$confirmacoes = array("OK", "OK");
		$cabinaAtron->setConfirmacoesDosApertos($confirmacoes);
		$verificador = new VerificadorDeItensPorCabina();
		$cabinaAtron = $verificador->verificar($cabinaAtron);
		$this->assertEquals(Constantes::CONFIRMACAO, $cabinaAtron->getItemDeVerificacao()->getPedalAtron());
	}

	public function testPedalAtronDeveSerNOK() {
		$cabinaAtron = new Cabina("﻿", "", Constantes::ATRON, "", "", "", "", "", "", "", "", "", "", "", "");
		$confirmacoes = array("OK", "N/A");
		$cabinaAtron->setConfirmacoesDosApertos($confirmacoes);
		$verificador = new VerificadorDeItensPorCabina();
		$cabinaAtron = $verificador->verificar($cabinaAtron);
		$this->assertEquals(Constantes::NEGACAO, $cabinaAtron->getItemDeVerificacao()->getPedalAtron());
	}
}