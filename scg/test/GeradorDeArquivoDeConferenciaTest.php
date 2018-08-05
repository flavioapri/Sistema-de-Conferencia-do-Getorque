<?php
require_once 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;

/**
 * GeradorDeArquivoDeConferencia test case.
 */
class GeradorDeArquivoDeConferenciaTest extends TestCase {
	private $listaDeCabinas;

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp();
		$this->listaDeCabinas = GeradorDeListaDeCabinas::gerar();
	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->listaDeCabinas = null;
	}

	/**
	 * Tests GeradorDeArquivoDeConferencia::gerar()
	 */
	public function testExtrairDataDaConferencia() {
		$data = GeradorDeArquivoDeConferencia::extrairDataDaConferencia($listaDeCabinas);
		$this->assertAttributeEquals("30-10-2017", $data);
	}
}

