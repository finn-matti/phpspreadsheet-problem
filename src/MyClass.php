<?php

namespace PhpSpreadSheetProblem;

use PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\IWriter;

class MyClass
{

    public Spreadsheet $spreadsheet;
    public Worksheet $worksheet;
    public IWriter $writer;
    public Spreadsheet $readSheet;

    public function __invoke()
    {
        Cell::setValueBinder(new AdvancedValueBinder());
        $this->spreadsheet = new Spreadsheet();
        $this->worksheet = $this->spreadsheet->getActiveSheet();
        $this->worksheet->setCellValueByColumnAndRow(1, 1, '0.93');
        $this->worksheet->getStyleByColumnAndRow(1, 1)
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
        $this->writer = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
        $this->writer->save('test.xlsx');
        $this->readSheet = IOFactory::load('test.xlsx');
        echo($this->readSheet->getActiveSheet()->getCell('A1')->getValue() . "\n");
        echo($this->readSheet->getActiveSheet()->getCell('A1')->getFormattedValue() . "\n");
    }
}
