<?php

namespace app\components\bookings\exceptions;


class AvailabilityException extends \RuntimeException
{


	public static function forNoWeek()
	{
		return new static("A data selecionada não está atribuída a uma semana de horário do ano letivo.");
	}


	public static function forNoPeriods()
	{
		return new static("Não há períodos disponíveis para a data selecionada.");
	}


	public static function forHoliday($holiday = NULL)
	{
		if (!is_object($holiday)) {
			return new static('A data que você selecionou é durante um feriado.');
		}

		$format = 'A data que você selecionou é durante um feriado: %s: %s - %s';
		$start = $holiday->date_start->format('d/m/Y');
		$end = $holiday->date_end->format('d/m/Y');
		$str = sprintf($format, $holiday->name, $start, $end);
		return new static($str);
	}
}
