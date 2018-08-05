<?php
require_once 'vendor/autoload.php';
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
		$cabinaAtego = new Cabina("﻿", "", Baumuster::ATEGO, "", "", "", "", "", "", "", "", "", "", "", "");
		$cabinaAxorC = new Cabina("﻿", "", Baumuster::AXOR_C, "", "", "", "", "", "", "", "", "", "", "", "");
		$cabinaAxorR = new Cabina("﻿", "", Baumuster::AXOR_R, "", "", "", "", "", "", "", "", "", "", "", "");
		$cabinaAtron = new Cabina("﻿", "", Baumuster::ATRON, "", "", "", "", "", "", Pais::BRASIL, "", "", "",
								"", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 18; $i++)
			array_push($confirmacoesDosApertos, Anotacao::CONFIRMACAO);
		
		$cabinaAtego->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabinaAxorC->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabinaAxorR->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabinaAtron->setConfirmacoesDosApertos($confirmacoesDosApertos);
		
		$cabinaAtego = $verificador->verificar($cabinaAtego);
		$cabinaAxorC = $verificador->verificar($cabinaAxorC);
		$cabinaAxorR = $verificador->verificar($cabinaAxorR);
		$cabinaAtron = $verificador->verificar($cabinaAtron);
		
		$this->assertEquals(Anotacao::CONFIRMACAO, $cabinaAtego->getItemDeVerificacao()->getCruzeta());
		$this->assertEquals(Anotacao::CONFIRMACAO, $cabinaAxorC->getItemDeVerificacao()->getCruzeta());
		$this->assertEquals(Anotacao::CONFIRMACAO, $cabinaAxorR->getItemDeVerificacao()->getCruzeta());
		$this->assertEquals(Anotacao::CONFIRMACAO, $cabinaAtron->getItemDeVerificacao()->getCruzeta());
	}

	public function testCruzetaDeveSerNOK() {
		$cabinaAtego = new Cabina("﻿", "", Baumuster::ATEGO, "", "", "", "", "", "", "", "", "", "", "", "");
		$cabinaAxorC = new Cabina("﻿", "", Baumuster::AXOR_C, "", "", "", "", "", "", "", "", "", "", "", "");
		$cabinaAxorR = new Cabina("﻿", "", Baumuster::AXOR_R, "", "", "", "", "", "", "", "", "", "", "", "");
		$cabinaAtron = new Cabina("﻿", "", Baumuster::ATRON, "", "", "", "", "", "", Pais::BRASIL, "", "", "",
								"", "");
		// $verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 18; $i++)
			array_push($confirmacoesDosApertos, Anotacao::CONFIRMACAO);
		
		$confirmacoesDosApertos[0] = Anotacao::NEGACAO;
		
		$cabinaAtego->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabinaAxorC->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabinaAxorR->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabinaAtron->setConfirmacoesDosApertos($confirmacoesDosApertos);
		
		$cabinaAtego = $this->verificador->verificar($cabinaAtego);
		$cabinaAxorC = $this->verificador->verificar($cabinaAxorC);
		$cabinaAxorR = $this->verificador->verificar($cabinaAxorR);
		$cabinaAtron = $this->verificador->verificar($cabinaAtron);
		
		$this->assertEquals(Anotacao::NEGACAO, $cabinaAtego->getItemDeVerificacao()->getCruzeta());
		$this->assertEquals(Anotacao::NEGACAO, $cabinaAxorC->getItemDeVerificacao()->getCruzeta());
		$this->assertEquals(Anotacao::NEGACAO, $cabinaAxorR->getItemDeVerificacao()->getCruzeta());
		$this->assertEquals(Anotacao::NEGACAO, $cabinaAtron->getItemDeVerificacao()->getCruzeta());
	}

	public function testCruzetaDeveSerNA() {
		$cabinaAtron = new Cabina("﻿", "", Baumuster::ATRON, "", "", "", "", "", "", "", "", "", "", "", "");
		$cabinaAccelo = new Cabina("﻿", "", Baumuster::ACCELO, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 18; $i++)
			array_push($confirmacoesDosApertos, Anotacao::CONFIRMACAO);
		
		$cabinaAtron = $verificador->verificar($cabinaAtron);
		$cabinaAccelo = $verificador->verificar($cabinaAtron);
		
		$this->assertEquals(Anotacao::SEM_APLICACAO, $cabinaAtron->getItemDeVerificacao()->getCruzeta());
		$this->assertEquals(Anotacao::SEM_APLICACAO, $cabinaAtron->getItemDeVerificacao()->getCruzeta());
	}

	public function testPremontagemDaSuspensaoAtegoDeveSerOK() {
		$cabina = new Cabina("﻿", "", Baumuster::ATEGO, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 8; $i++)
			array_push($confirmacoesDosApertos, Anotacao::CONFIRMACAO);
		
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Anotacao::CONFIRMACAO, $cabina->getItemDeVerificacao()->getPreSuspensao());
	}

	public function testPremontagemDaSuspensaoAtegoDeveSerNOK() {
		$cabina = new Cabina("﻿", "", Baumuster::ATEGO, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 8; $i++)
			array_push($confirmacoesDosApertos, Anotacao::CONFIRMACAO);
		
		$confirmacoesDosApertos[3] = Anotacao::NEGACAO;
		
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Anotacao::NEGACAO, $cabina->getItemDeVerificacao()->getPreSuspensao());
	}

	public function testPreMontagemDaSuspensaoAxorDeveSerOK() {
		$cabina = new Cabina("﻿", "", Baumuster::AXOR_R, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 18; $i++)
			array_push($confirmacoesDosApertos, Anotacao::CONFIRMACAO);
		
		$confirmacoesDosApertos[9] = Anotacao::NEGACAO;
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Anotacao::CONFIRMACAO, $cabina->getItemDeVerificacao()->getPreSuspensao());
	}

	public function testPreMontagemDaSuspensaoAxorDeveSerNOKSeFaltarApertoLE() {
		$cabina = new Cabina("﻿", "", Baumuster::AXOR_R, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina(); // 6 7 8
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 18; $i++)
			array_push($confirmacoesDosApertos, Anotacao::CONFIRMACAO);
		
		$confirmacoesDosApertos[9] = Anotacao::NEGACAO;
		$confirmacoesDosApertos[6] = Anotacao::NEGACAO;
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Anotacao::NEGACAO, $cabina->getItemDeVerificacao()->getPreSuspensao());
	}

	public function testPreMontagemDaSuspensaoAxorDeveSerNOKSeFaltarApertoLD() {
		$cabina = new Cabina("﻿", "", Baumuster::AXOR_R, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 18; $i++)
			array_push($confirmacoesDosApertos, Anotacao::CONFIRMACAO);
		
		$confirmacoesDosApertos[9] = Anotacao::NEGACAO;
		$confirmacoesDosApertos[7] = Anotacao::NEGACAO;
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Anotacao::NEGACAO, $cabina->getItemDeVerificacao()->getPreSuspensao());
	}

	public function testPreMontagemDaSuspensaoAxorDeveSerNOKSeFaltarAperto150Nm() {
		$cabina = new Cabina("", "", Baumuster::AXOR_R, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 18; $i++)
			array_push($confirmacoesDosApertos, Anotacao::CONFIRMACAO);
		
		$confirmacoesDosApertos[8] = Anotacao::NEGACAO;
		$confirmacoesDosApertos[9] = Anotacao::NEGACAO;
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Anotacao::NEGACAO, $cabina->getItemDeVerificacao()->getPreSuspensao());
	}

	public function testPreSuspensaoFL6DeveSerOK() {
		$cabina = $this->cabinaFactory->getCabina(Baumuster::AXOR_R, Code::FL6);
		$cabina = $this->verificador->verificar($cabina);
		$this->assertEquals(Anotacao::CONFIRMACAO, $cabina->getItemDeVerificacao()->getPreSuspensaoFL6());
	}

	public function testPreSuspensaoFL6DeveRetornarConferir() {
		$cabina = $this->cabinaFactory->getCabina(Baumuster::AXOR_R, Code::FL6);
		$cabina->setVerificacaoDeAperto(9, Anotacao::NEGACAO);
		
		$cabina = $this->verificador->verificar($cabina);
		$this->assertEquals(Anotacao::CONFERIR, $cabina->getItemDeVerificacao()->getPreSuspensaoFL6());
	}

	public function testSuspensaoAxorDeveSerOK() {
		$cabina = new Cabina("", "", Baumuster::AXOR_R, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 18; $i++)
			array_push($confirmacoesDosApertos, Anotacao::CONFIRMACAO);
		
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Anotacao::CONFIRMACAO, $cabina->getItemDeVerificacao()->getSuspensao());
	}

	public function testSuspensaoAxorDeveSerNOK() {
		$cabina = new Cabina("", "", Baumuster::AXOR_R, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 18; $i++)
			array_push($confirmacoesDosApertos, Anotacao::CONFIRMACAO);
		
		$confirmacoesDosApertos[14] = Anotacao::NEGACAO;
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Anotacao::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
		
		$cabina->getConfirmacoesDosApertos()[15] = Anotacao::NEGACAO;
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Anotacao::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
		
		$cabina->getConfirmacoesDosApertos()[16] = Anotacao::NEGACAO;
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Anotacao::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
		
		$cabina->getConfirmacoesDosApertos()[17] = Anotacao::NEGACAO;
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Anotacao::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
	}

	public function testSuspensaoAxorFL6DeveSerOK() {
		$cabinaAxorFL6 = $this->cabinaFactory->getCabina(Baumuster::AXOR_R, Code::FL6);
		
		$cabinaAxorFL6 = $this->verificador->verificar($cabinaAxorFL6);
		$this->assertEquals(Anotacao::CONFIRMACAO, $cabinaAxorFL6->getItemDeVerificacao()->getSuspensao());
	}

	public function testSuspensaoAxorFL6DeveSerConfirmar() {
		$cabina = $this->cabinaFactory->getCabina(Baumuster::AXOR_R, Code::FL6);
		$cabina->setVerificacaoDeAperto(10, Anotacao::NEGACAO);
		$cabina->setVerificacaoDeAperto(11, Anotacao::NEGACAO);
		$cabina->setVerificacaoDeAperto(12, Anotacao::NEGACAO);
		$cabina->setVerificacaoDeAperto(13, Anotacao::NEGACAO);
		
		$cabina = $this->verificador->verificar($cabina);
		$this->assertEquals(Anotacao::CONFERIR, $cabina->getItemDeVerificacao()->getSuspensao());
	}

	public function testSuspensaoAcceloDeveSerOK() {
		$cabina = new Cabina("", "", Baumuster::ACCELO, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i <= 5; $i++)
			array_push($confirmacoesDosApertos, Anotacao::CONFIRMACAO);
		
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Anotacao::CONFIRMACAO, $cabina->getItemDeVerificacao()->getSuspensao());
	}

	public function testSuspensaoAcceloDeveSerNOK() {
		$cabina = new Cabina("", "", Baumuster::ACCELO, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i <= 5; $i++)
			array_push($confirmacoesDosApertos, Anotacao::CONFIRMACAO);
		
		$confirmacoesDosApertos[2] = Anotacao::NEGACAO;
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Anotacao::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
		
		$cabina->getConfirmacoesDosApertos()[3] = Anotacao::NEGACAO;
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Anotacao::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
		
		$cabina->getConfirmacoesDosApertos()[4] = Anotacao::NEGACAO;
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Anotacao::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
		
		$cabina->getConfirmacoesDosApertos()[5] = Anotacao::NEGACAO;
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Anotacao::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
	}

	public function testSuspensaoAtegoDeveSerOK() {
		$cabina = new Cabina("", "", Baumuster::ATEGO, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i <= 7; $i++)
			array_push($confirmacoesDosApertos, Anotacao::CONFIRMACAO);
		
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Anotacao::CONFIRMACAO, $cabina->getItemDeVerificacao()->getSuspensao());
	}

	public function testSuspensaoAtegoDeveSerNOK() {
		$cabina = new Cabina("", "", Baumuster::ATEGO, "", "", "", "", "", "", "", "", "", "", "", "");
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i <= 7; $i++)
			array_push($confirmacoesDosApertos, Anotacao::CONFIRMACAO);
		
		$confirmacoesDosApertos[4] = Anotacao::NEGACAO;
		$cabina->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Anotacao::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
		
		$cabina->getConfirmacoesDosApertos()[5] = Anotacao::NEGACAO;
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Anotacao::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
		
		$cabina->getConfirmacoesDosApertos()[6] = Anotacao::NEGACAO;
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Anotacao::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
		
		$cabina->getConfirmacoesDosApertos()[7] = Anotacao::NEGACAO;
		$cabina = $verificador->verificar($cabina);
		$this->assertEquals(Anotacao::NEGACAO, $cabina->getItemDeVerificacao()->getSuspensao());
	}

	public function testSuspensaoTodosOsVeiculosDeveSerOK() {
		$cabinaAtego = new Cabina("﻿", "", Baumuster::ATEGO, "", "", "", "", "", "", "", "", "", "", "", "");
		$cabinaAxorC = new Cabina("﻿", "", Baumuster::AXOR_C, "", "", "", "", "", "", "", "", "", "", "", "");
		$cabinaAxorR = new Cabina("﻿", "", Baumuster::AXOR_R, "", "", "", "", "", "", "", "", "", "", "", "");
		$cabinaAccelo = new Cabina("﻿", "", Baumuster::ACCELO, "", "", "", "", "", "", "", "", "", "", "", "");
		
		$verificador = new VerificadorDeItensPorCabina();
		$confirmacoesDosApertos = array();
		for($i = 0; $i < 18; $i++)
			array_push($confirmacoesDosApertos, Anotacao::CONFIRMACAO);
		
		$cabinaAtego->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabinaAxorC->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabinaAxorR->setConfirmacoesDosApertos($confirmacoesDosApertos);
		$cabinaAccelo->setConfirmacoesDosApertos($confirmacoesDosApertos);
		
		$cabinaAtego = $verificador->verificar($cabinaAtego);
		$cabinaAxorC = $verificador->verificar($cabinaAxorC);
		$cabinaAxorR = $verificador->verificar($cabinaAxorR);
		$cabinaAccelo = $verificador->verificar($cabinaAccelo);
		
		$this->assertEquals(Anotacao::CONFIRMACAO, $cabinaAtego->getItemDeVerificacao()->getSuspensao());
		$this->assertEquals(Anotacao::CONFIRMACAO, $cabinaAxorC->getItemDeVerificacao()->getSuspensao());
		$this->assertEquals(Anotacao::CONFIRMACAO, $cabinaAxorR->getItemDeVerificacao()->getSuspensao());
		$this->assertEquals(Anotacao::CONFIRMACAO, $cabinaAccelo->getItemDeVerificacao()->getSuspensao());
	}

	public function testPedalAtronDeveSerOK() {
		$cabinaAtron = new Cabina("﻿", "", Baumuster::ATRON, "", "", "", "", "", "", "", "", "", "", "", "");
		$confirmacoes = array("OK", "OK");
		$cabinaAtron->setConfirmacoesDosApertos($confirmacoes);
		$verificador = new VerificadorDeItensPorCabina();
		$cabinaAtron = $verificador->verificar($cabinaAtron);
		$this->assertEquals(Anotacao::CONFIRMACAO, $cabinaAtron->getItemDeVerificacao()->getPedalAtron());
	}

	public function testPedalAtronDeveSerNOK() {
		$cabinaAtron = new Cabina("﻿", "", Baumuster::ATRON, "", "", "", "", "", "", "", "", "", "", "", "");
		$confirmacoes = array("OK", "N/A");
		$cabinaAtron->setConfirmacoesDosApertos($confirmacoes);
		$verificador = new VerificadorDeItensPorCabina();
		$cabinaAtron = $verificador->verificar($cabinaAtron);
		$this->assertEquals(Anotacao::NEGACAO, $cabinaAtron->getItemDeVerificacao()->getPedalAtron());
	}
}