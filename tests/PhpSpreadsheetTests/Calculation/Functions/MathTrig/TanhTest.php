<?php

declare(strict_types=1);

namespace PhpOffice\PhpSpreadsheetTests\Calculation\Functions\MathTrig;

use PhpOffice\PhpSpreadsheet\Calculation\Calculation;

class TanhTest extends AllSetupTeardown
{
    #[\PHPUnit\Framework\Attributes\DataProvider('providerTanh')]
    public function testTanh(mixed $expectedResult, string $formula): void
    {
        $this->mightHaveException($expectedResult);
        $sheet = $this->getSheet();
        $sheet->setCellValue('A2', 1);
        $sheet->getCell('A1')->setValue("=TANH($formula)");
        $result = $sheet->getCell('A1')->getCalculatedValue();
        self::assertEqualsWithDelta($expectedResult, $result, 1E-6);
    }

    public static function providerTanh(): array
    {
        return require 'tests/data/Calculation/MathTrig/TANH.php';
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('providerTanhArray')]
    public function testTanhArray(array $expectedResult, string $array): void
    {
        $calculation = Calculation::getInstance();

        $formula = "=TANH({$array})";
        $result = $calculation->_calculateFormulaValue($formula);
        self::assertEqualsWithDelta($expectedResult, $result, 1.0e-14);
    }

    public static function providerTanhArray(): array
    {
        return [
            'row vector' => [[[0.76159415595577, 0.46211715726001, -0.76159415595577]], '{1, 0.5, -1}'],
            'column vector' => [[[0.76159415595577], [0.46211715726001], [-0.76159415595577]], '{1; 0.5; -1}'],
            'matrix' => [[[0.76159415595577, 0.46211715726001], [0.0, -0.76159415595577]], '{1, 0.5; 0, -1}'],
        ];
    }
}
