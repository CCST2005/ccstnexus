<?php

namespace App\Imports;

use PhpOffice\PhpSpreadsheet\IOFactory;

class YourExcelImport
{
    public $data = [];

    public function import($rows)
    {
        // Load the second sheet (index 1) from the uploaded Excel file
        $spreadsheet = IOFactory::load($rows->getRealPath());
        $sheet = $spreadsheet->getSheet(0); // Adjust the index accordingly

        // Loop through the rows and process the values
        $counting = 0;
        foreach ($sheet->getRowIterator() as $row) {
            $counting++;
            $rowData = [];
            foreach ($row->getCellIterator() as $cell) {
                $value = $cell->getCalculatedValue(); // Use getCalculatedValue to get the result of the formula
                // if ($value !== null && $value !== '') {
                    $rowData[] = $value;
                
            }
            if (!empty($rowData) && $counting >= 1) {
                $this->data[] = $rowData;
            }
        }
    }
}
