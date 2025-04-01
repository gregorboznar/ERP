<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Facades\Storage;

class CreateScpMeasurementTemplate extends Command
{
  protected $signature = 'app:create-scp-measurement-template';
  protected $description = 'Creates a sample Excel template for SCP Measurements';

  public function handle()
  {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set title and header styles
    $sheet->setCellValue('A1', 'SCP MEASUREMENTS REPORT');
    $sheet->mergeCells('A1:E1');

    $sheet->getStyle('A1')->applyFromArray([
      'font' => [
        'bold' => true,
        'size' => 16,
      ],
      'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
      ],
    ]);

    // Add some explanatory text
    $sheet->setCellValue('A3', 'This template is used for exporting SCP Measurements data.');
    $sheet->setCellValue('A4', 'Data will be inserted starting from row 10.');
    $sheet->setCellValue('A5', 'Any formulas or calculations in other cells will be preserved.');

    // Table headers
    $headers = ['Date & Time', 'Operator', 'Series Number', 'Product Name', 'Measurements'];
    foreach ($headers as $index => $header) {
      $column = chr(65 + $index); // A, B, C, etc.
      $sheet->setCellValue($column . '9', $header);

      // Style headers
      $sheet->getStyle($column . '9')->applyFromArray([
        'font' => [
          'bold' => true,
        ],
        'fill' => [
          'fillType' => Fill::FILL_SOLID,
          'startColor' => [
            'rgb' => 'DDDDDD',
          ],
        ],
        'borders' => [
          'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
          ],
        ],
      ]);

      // Auto-size columns
      $sheet->getColumnDimension($column)->setAutoSize(true);
    }

    // Add some example formulas in cells that won't be overwritten
    $sheet->setCellValue('G3', 'Statistics:');
    $sheet->setCellValue('G4', 'Total Count:');
    $sheet->setCellValue('H4', '=COUNTA(A10:A1000)');

    $sheet->setCellValue('G5', 'Average:');
    $sheet->setCellValue('H5', '=AVERAGEIF(E10:E1000,"<>")');

    $sheet->setCellValue('G6', 'Max:');
    $sheet->setCellValue('H6', '=MAX(E10:E1000)');

    $sheet->setCellValue('G7', 'Min:');
    $sheet->setCellValue('H7', '=MIN(E10:E1000)');

    // Empty rows where data will be inserted
    for ($i = 10; $i < 30; $i++) {
      // Add light borders to the data area
      $sheet->getStyle('A' . $i . ':E' . $i)->applyFromArray([
        'borders' => [
          'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => 'CCCCCC'],
          ],
        ],
      ]);
    }

    // Create the directory if it doesn't exist
    if (!Storage::exists('templates')) {
      Storage::makeDirectory('templates');
    }

    // Save the template file
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $templatePath = storage_path('app/templates/scp-template2.xlsx');
    $writer->save($templatePath);

    $this->info('Excel template created successfully at: ' . $templatePath);

    return Command::SUCCESS;
  }
}
