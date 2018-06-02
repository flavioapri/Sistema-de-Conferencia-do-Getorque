<?php
require_once 'class/Cabina.php';

class PosicaoDosApertos {
	const SUSP_FRONTAL_ATEGO_LE = 4;
	const SUSP_FRONTAL_ATEGO_LD = 5;
	const SUSP_INTERNA_ATEGO_LE = 6;
	const SUSP_INTERNA_ATEGO_LD = 7;
	const SUSP_INTERNA_AXOR_LE = 14;
	const SUSP_INTERNA_AXOR_LD = 15;
	const SUSP_FRONTAL_AXOR_LE = 16;
	const SUSP_FRONTAL_AXOR_LD = 17;
	const SUSP_INTERNA_AXOR_FL6_LE = 10;
	const SUSP_INTERNA_AXOR_FL6_LD = 11;
	const SUSP_FRONTAL_AXOR_FL6_LE = 12;
	const SUSP_FRONTAL_AXOR_FL6_LD = 13;
	const SUSP_FRONTAL_ACCELO_LE = 2;
	const SUSP_FRONTAL_ACCELO_LD = 3;
	const SUSP_INTERNA_ACCELO_LE = 4;
	const SUSP_INTERNA_ACCELO_LD = 5;
	const QTD_POSICOES_APERTOS_SUSP = 4;

	public static function getPosicaoDosApertos(Cabina $cabina) {
		if(func_num_args() === 2 && func_get_arg(1) === Constantes::FL6)
			return array(self::SUSP_INTERNA_AXOR_FL6_LE, self::SUSP_INTERNA_AXOR_FL6_LD,
						self::SUSP_FRONTAL_AXOR_FL6_LE, self::SUSP_FRONTAL_AXOR_FL6_LD);
		
		switch($cabina->getBaumuster()) {
			case Constantes::ATEGO :
				return array(self::SUSP_FRONTAL_ATEGO_LE, self::SUSP_FRONTAL_ATEGO_LD, self::SUSP_INTERNA_ATEGO_LE,
							self::SUSP_INTERNA_ATEGO_LD);
			case Constantes::AXOR_R :
				return array(self::SUSP_INTERNA_AXOR_LE, self::SUSP_INTERNA_AXOR_LD, self::SUSP_FRONTAL_AXOR_LE,
							self::SUSP_FRONTAL_AXOR_LD);
			case Constantes::AXOR_C :
				return array(self::SUSP_INTERNA_AXOR_LE, self::SUSP_INTERNA_AXOR_LD, self::SUSP_FRONTAL_AXOR_LE,
							self::SUSP_FRONTAL_AXOR_LD);
			case Constantes::ACCELO :
				return array(self::SUSP_FRONTAL_ACCELO_LE, self::SUSP_FRONTAL_ACCELO_LD,
							self::SUSP_INTERNA_ACCELO_LE, self::SUSP_INTERNA_ACCELO_LD);
		}
	}
}

