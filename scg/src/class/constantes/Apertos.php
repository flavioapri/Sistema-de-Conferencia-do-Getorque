<?php
require_once 'src/class/modelo/Cabina.php';
require_once 'src/class/constantes/Constantes.php';

class Apertos {
	const POSICAO_SUSP_FRONTAL_ATEGO_LE = 4;
	const POSICAO_SUSP_FRONTAL_ATEGO_LD = 5;
	const POSICAO_SUSP_INTERNA_ATEGO_LE = 6;
	const POSICAO_SUSP_INTERNA_ATEGO_LD = 7;
	const POSICAO_SUSP_INTERNA_AXOR_LE = 14;
	const POSICAO_SUSP_INTERNA_AXOR_LD = 15;
	const POSICAO_SUSP_FRONTAL_AXOR_LE = 16;
	const POSICAO_SUSP_FRONTAL_AXOR_LD = 17;
	const POSICAO_SUSP_INTERNA_AXOR_FL6_LE = 10;
	const POSICAO_SUSP_INTERNA_AXOR_FL6_LD = 11;
	const POSICAO_SUSP_FRONTAL_AXOR_FL6_LE = 12;
	const POSICAO_SUSP_FRONTAL_AXOR_FL6_LD = 13;
	const POSICAO_SUSP_FRONTAL_ACCELO_LE = 2;
	const POSICAO_SUSP_FRONTAL_ACCELO_LD = 3;
	const POSICAO_SUSP_INTERNA_ACCELO_LE = 4;
	const POSICAO_SUSP_INTERNA_ACCELO_LD = 5;
	const POSICAO_CRUZETA = 0;
	const POSICAO_CABO_MASSA = 1;
	const POSICAO_VALVULA_NTC = 2;
	const POSICAO_VALVULA_SUPORTE = 0;
	const POSICAO_CONSOLE_SUPORTE = 1;
	const POSICAO_PEDALEIRA_AXOR = 3;
	const POSICAO_REAPERTO_PEDAL_AXOR = 4;
	const POSICAO_CILINDRO = 5;
	const POSICAO_PRE_SUSP_ATEGO = 3;
	const POSICAO_PRE_LE_AXOR = 6;
	const POSICAO_PRE_LD_AXOR = 7;
	const POSICAO_PRE_150NM_AXOR = 8;
	const POSICAO_PRE_AXOR_FL6 = 9;
	const POSICAO_PEDAL_ATRON = 1;
	const POSICAO_INICIAL_ARRAY_SUSP_ATEGO = 4;
	const POSICAO_INICIAL_ARRAY_SUSP_AXOR = 14;
	const POSICAO_INICIAL_ARRAY_SUSP_AXOR_FL6 = 10;
	const POSICAO_INICIAL_ARRAY_SUSP_ACCELO = 2;
	const QTD_TIPOS_SUSPENSAO = 4;
	const QTD_APERTOS_PRE_AXOR = 3;
	const QTD_APERTOS_PRE_AXOR_FL6 = 1;

	/**
	 * Retorna um array com as posições dos apertos de suspensão para cada tipo de cabina.
	 */
	public static function getRangeDeApertos(Cabina $cabina) {
		/*
		 * Se o método receber dois parâmetors e o segundo parâmetro informar que a cabina é FL6.
		 * Pode-se passar mais parâmetros do que o especificado na assinatura de um método.
		 * Foi usada esta implementação para não ter de se criar outro método especifico para casos de cabinas
		 * FL6.
		 */
		if(func_num_args() === 2 && func_get_arg(1) === Constantes::FL6)
			return array(self::POSICAO_SUSP_INTERNA_AXOR_FL6_LE, self::POSICAO_SUSP_INTERNA_AXOR_FL6_LD,
						self::POSICAO_SUSP_FRONTAL_AXOR_FL6_LE, self::POSICAO_SUSP_FRONTAL_AXOR_FL6_LD);
		
		switch($cabina->getBaumuster()) {
			case Constantes::ATEGO :
				return array(self::POSICAO_SUSP_FRONTAL_ATEGO_LE, self::POSICAO_SUSP_FRONTAL_ATEGO_LD,
							self::POSICAO_SUSP_INTERNA_ATEGO_LE, self::POSICAO_SUSP_INTERNA_ATEGO_LD);
			case Constantes::AXOR_R :
				return array(self::POSICAO_SUSP_INTERNA_AXOR_LE, self::POSICAO_SUSP_INTERNA_AXOR_LD,
							self::POSICAO_SUSP_FRONTAL_AXOR_LE, self::POSICAO_SUSP_FRONTAL_AXOR_LD);
			case Constantes::AXOR_C :
				return array(self::POSICAO_SUSP_INTERNA_AXOR_LE, self::POSICAO_SUSP_INTERNA_AXOR_LD,
							self::POSICAO_SUSP_FRONTAL_AXOR_LE, self::POSICAO_SUSP_FRONTAL_AXOR_LD);
			case Constantes::ACCELO :
				return array(self::POSICAO_SUSP_FRONTAL_ACCELO_LE, self::POSICAO_SUSP_FRONTAL_ACCELO_LD,
							self::POSICAO_SUSP_INTERNA_ACCELO_LE, self::POSICAO_SUSP_INTERNA_ACCELO_LD);
		}
	}
}

