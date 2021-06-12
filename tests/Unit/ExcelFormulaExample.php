<?php

namespace Tests\Unit;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PHPUnit\Framework\TestCase;

class ExcelFormulaExample extends TestCase
{
  public function testSimpleCalc()
  {
    $spreadsheet = new Spreadsheet();
    $calculation = $spreadsheet->getCalculationEngine();
    $this->assertEquals(3, $calculation->calculateFormula('=SUM(1, 2)'));
  }

  public function testSheetCalc()
  {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A10', '=SUM(A1:A4)');

    $sheet->setCellValue('A1', 1);
    $sheet->setCellValue('A2', 2);
    $sheet->setCellValue('A3', 3);
    $sheet->setCellValue('A4', '=A2 * A3');

    // 念の為計算キャッシュをクリアしてから計算結果を取得する
    $spreadsheet->getCalculationEngine()->disableCalculationCache();
    $this->assertEquals(12, $sheet->getCell('A10')->getCalculatedValue());
  }
}
