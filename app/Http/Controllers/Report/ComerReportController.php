<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Comer;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ComerReportController extends Controller
{
    protected $Data = [];
    protected $Module = 'Penduduk';
    protected $Title = 'LAPORAN PENDATANG DESA SELANGNANGKA';
    protected $SubTitle = 'PERIODE : ';

    protected $StartRowTitle = 1;
    protected $StartRowSubTitle = 2;

    protected $StartRowHeader = 3;
    protected $EndRowHeader = 4;
    protected $StartColumnHeader = 'A';
    protected $EndColumnHeader = 'G';

    protected $StartRowValue = 5;

    public function Anything($request)
    {
        $spreadsheet = new Spreadsheet();
        $From = $request->get('from');
        $End = $request->get('end');
        $sheet = $spreadsheet->getActiveSheet();
        $this->Data = [
            "NO",
            "NAMA",
            "NIK",
            "JENIS KELAMIN",
            "TANGGAL",
            "PELAPOR",
            "TANGGAL SISTEM"
        ];

        $styleCenter = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                
            )
        );

        $styleTitle = [
            'font' => [
                'bold' => true,
                'size' => 10,
                'color'     => array(
                   'rgb' => '000000'
                )
            ],
        ];
        $sheet->fromArray(
            $this->Data,
            null,
            'A'.$this->StartRowHeader
        );

        $sheet->mergeCells($this->StartColumnHeader . $this->StartRowTitle . ":" . $this->EndColumnHeader . $this->StartRowTitle)->getRowDimension('1')->setRowHeight(40);
        $sheet->getStyle($this->StartColumnHeader . $this->StartRowTitle, $this->Title)->getFont()->setSize(16);
        $sheet->getStyle($this->StartColumnHeader . $this->StartRowTitle)->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->setCellValue($this->StartColumnHeader . $this->StartRowTitle, $this->Title);

        $sheet->mergeCells($this->StartColumnHeader . $this->StartRowSubTitle . ":" . $this->EndColumnHeader . $this->StartRowSubTitle)->getRowDimension('1')->setRowHeight(35);
        $sheet->getStyle($this->StartColumnHeader . $this->StartRowSubTitle, $this->SubTitle)->getFont()->setSize(13);
        $sheet->getStyle($this->StartColumnHeader . $this->StartRowSubTitle)->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->setCellValue($this->StartColumnHeader . $this->StartRowSubTitle, $this->SubTitle . " " . $From . " - " . $End);

        foreach(range($this->StartColumnHeader , $this->EndColumnHeader) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
            $sheet->mergeCells($columnID . $this->StartRowHeader. ':' .$columnID . $this->EndRowHeader);
        }
        $sheet->getStyle($this->StartColumnHeader . $this->StartRowHeader . ':' . $this->EndColumnHeader . $this->EndRowHeader)->getAlignment()->setHorizontal('center')->setVertical('center');

        $sheet->getStyle($this->StartColumnHeader . $this->StartRowHeader . ':' . $this->EndColumnHeader . $this->EndRowHeader)->applyFromArray($styleTitle)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $Number = 1;
        $Data = Comer::select(
            'comer.id as id',
            'comer.nik as nik',
            'comer.name as name',
            'comer.gender as gender',
            'comer.date_of_come as date_of_come',
            'comer.whistleblower_id as whistleblower_id',
            // user
            'users.name as pelapor',
            'users.birthdate as birthdate',

            'comer.created_at as created_at',
            'comer.updated_at as updated_at'
            )->join("users", "comer.whistleblower_id", "users.id")
            ->whereBetween('comer.created_at', [$From, $End])
            ->get(); 

        if (isset($Data)) {
            foreach ($Data as $Value) {
                $sheet->setCellValue('A'.$this->StartRowValue, $Number++);
                $sheet->setCellValue('B'.$this->StartRowValue, $Value->name);
                $sheet->setCellValue('C'.$this->StartRowValue, "'".$Value->nik);
                $sheet->setCellValue('D'.$this->StartRowValue, ($Value->gender == 'l') ? "Laki-Laki" : "Wanita");
                $sheet->setCellValue('E'.$this->StartRowValue, Carbon::parse($Value->date_of_come)->format('Y-m-d'));
                $sheet->setCellValue('F'.$this->StartRowValue, $Value->pelapor);
                $sheet->setCellValue('G'.$this->StartRowValue, $Value->created_at);

                $sheet->getStyle('A'.$this->StartRowValue.':A'.$this->StartRowValue)->applyFromArray($styleCenter)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         	    $sheet->getStyle('B'.$this->StartRowValue.':B'.$this->StartRowValue)->applyFromArray($styleCenter)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         	    $sheet->getStyle('C'.$this->StartRowValue.':C'.$this->StartRowValue)->applyFromArray($styleCenter)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         	    $sheet->getStyle('D'.$this->StartRowValue.':D'.$this->StartRowValue)->applyFromArray($styleCenter)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         	    $sheet->getStyle('E'.$this->StartRowValue.':E'.$this->StartRowValue)->applyFromArray($styleCenter)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         	    $sheet->getStyle('F'.$this->StartRowValue.':F'.$this->StartRowValue)->applyFromArray($styleCenter)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         	    $sheet->getStyle('G'.$this->StartRowValue.':G'.$this->StartRowValue)->applyFromArray($styleCenter)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         	   $this->StartRowValue++;
            }
        }
        $writer = new Xlsx($spreadsheet);
        $FileName = 'report/pendatang-' . Carbon::now() . '.xlsx';
        $writer->save($FileName);
        return $FileName;
    }
}
