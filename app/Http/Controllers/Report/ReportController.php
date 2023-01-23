<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportController extends Controller
{
    protected $Data = [];
    protected $Module = 'Penduduk';
    protected $Title = 'LAPORAN KEPENDUDUKAN DESA SELANGNANGKA';
    protected $SubTitle = 'PERIODE : ';

    protected $StartRowTitle = 1;
    protected $StartRowSubTitle = 2;

    protected $StartRowHeader = 3;
    protected $EndRowHeader = 4;
    protected $StartColumnHeader = 'A';
    protected $EndColumnHeader = 'M';

    public function Anything()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $this->Data = [
            "NO",
            "ID",
            "NAMA",
            "NIK",
            "TEMPAT / TANGGAL LAHIR",
            "JENIS KELAMIN",
            "ALAMAT",
            "STATUS PERNIKAHAN",
            "PEKERJAAN",
            "KARTU KELUARGA",
            "AGAMA",
            "STATUS WARGA",
            "TANGGAL SISTEM"
        ];

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
        $sheet->setCellValue($this->StartColumnHeader . $this->StartRowSubTitle, $this->SubTitle);

        foreach(range($this->StartColumnHeader , $this->EndColumnHeader) as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
            $sheet->mergeCells($columnID . $this->StartRowHeader. ':' .$columnID . $this->EndRowHeader);
        }
        $sheet->getStyle($this->StartColumnHeader . $this->StartRowHeader . ':' . $this->EndColumnHeader . $this->EndRowHeader)->getAlignment()->setHorizontal('center')->setVertical('center');

        $sheet->getStyle($this->StartColumnHeader . $this->StartRowHeader . ':' . $this->EndColumnHeader . $this->EndRowHeader)->applyFromArray($styleTitle)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $writer = new Xlsx($spreadsheet);
        $writer->save(Carbon::now() . '.xlsx');
    }
}
