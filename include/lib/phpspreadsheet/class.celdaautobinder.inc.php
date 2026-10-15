<?php

use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\IValueBinder;

/**
 * Binder de valores para los reportes.
 * Reproduce el comportamiento del antiguo XlsxGen:
 *  - valores numéricos (numéricos o cadenas is_numeric) -> celda numérica (para que las SUM funcionen)
 *  - cadenas que inician con "=" -> fórmula
 *  - todo lo demás -> texto (nunca convierte fechas)
 */
if (!class_exists('CeldaAutoBinder', false))
{
	class CeldaAutoBinder implements IValueBinder
	{
		public function bindValue(Cell $cell, mixed $value): bool
		{
			if ($value === null)
			{
				$cell->setValueExplicit(null, DataType::TYPE_NULL);
			}
			elseif (is_numeric($value))
			{
				$cell->setValueExplicit($value + 0, DataType::TYPE_NUMERIC);
			}
			elseif (is_string($value) && strlen($value) > 1 && $value[0] === '=')
			{
				$cell->setValueExplicit($value, DataType::TYPE_FORMULA);
			}
			else
			{
				$cell->setValueExplicit((string)$value, DataType::TYPE_STRING);
			}

			return true;
		}
	}

	Cell::setValueBinder(new CeldaAutoBinder());
}
