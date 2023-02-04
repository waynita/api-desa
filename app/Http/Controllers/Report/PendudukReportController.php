<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Population;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PendudukReportController extends Controller
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
    protected $EndColumnHeader = 'L';

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
        $Data = Population::select("population.*", "users.name as name", "users.birthdate as birthdate", "family.number_family as number_family")
            ->join('users', 'users.id', 'population.user_id')
            ->leftJoin('family', 'users.family_id', 'family.id')
            ->whereBetween('population.created_at', [$From, $End])->get(); 

        if (isset($Data)) {
            foreach ($Data as $Value) {
                $sheet->setCellValue('A'.$this->StartRowValue, $Number++);
                $sheet->setCellValue('B'.$this->StartRowValue, $Value->name);
                $sheet->setCellValue('C'.$this->StartRowValue, "'".$Value->nik);
                $sheet->setCellValue('D'.$this->StartRowValue, $Value->place_of_birth . ", ". $Value->birthdate);
                $sheet->setCellValue('E'.$this->StartRowValue, ($Value->gender == 'l') ? "Laki-Laki" : "Wanita");
                $sheet->setCellValue('F'.$this->StartRowValue, $Value->address);
                $sheet->setCellValue('G'.$this->StartRowValue, $Value->married);
                $sheet->setCellValue('H'.$this->StartRowValue, $Value->occupation);
                $sheet->setCellValue('I'.$this->StartRowValue, $Value->number_family);
                $sheet->setCellValue('J'.$this->StartRowValue, $Value->religion);
                $sheet->setCellValue('K'.$this->StartRowValue, $Value->status);
                $sheet->setCellValue('L'.$this->StartRowValue, $Value->created_at);

                $sheet->getStyle('A'.$this->StartRowValue.':A'.$this->StartRowValue)->applyFromArray($styleCenter)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         	    $sheet->getStyle('B'.$this->StartRowValue.':B'.$this->StartRowValue)->applyFromArray($styleCenter)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         	    $sheet->getStyle('C'.$this->StartRowValue.':C'.$this->StartRowValue)->applyFromArray($styleCenter)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         	    $sheet->getStyle('D'.$this->StartRowValue.':D'.$this->StartRowValue)->applyFromArray($styleCenter)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         	    $sheet->getStyle('E'.$this->StartRowValue.':E'.$this->StartRowValue)->applyFromArray($styleCenter)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         	    $sheet->getStyle('F'.$this->StartRowValue.':F'.$this->StartRowValue)->applyFromArray($styleCenter)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         	    $sheet->getStyle('G'.$this->StartRowValue.':G'.$this->StartRowValue)->applyFromArray($styleCenter)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         	    $sheet->getStyle('H'.$this->StartRowValue.':H'.$this->StartRowValue)->applyFromArray($styleCenter)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         	    $sheet->getStyle('I'.$this->StartRowValue.':I'.$this->StartRowValue)->applyFromArray($styleCenter)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         	    $sheet->getStyle('J'.$this->StartRowValue.':J'.$this->StartRowValue)->applyFromArray($styleCenter)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
         	    $sheet->getStyle('K'.$this->StartRowValue.':K'.$this->StartRowValue)->applyFromArray($styleCenter)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('L'.$this->StartRowValue.':L'.$this->StartRowValue)->applyFromArray($styleCenter)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $this->StartRowValue++;
            }
        }
        $writer = new Xlsx($spreadsheet);
        $FileName = 'report/kependudukan-' . Carbon::now() . '.xlsx';
        $writer->save($FileName);
        return $FileName;
    }
}
