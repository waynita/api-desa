<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Family;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class FamilyReportController extends Controller
{
    protected $Data = [];
    protected $Module = 'Penduduk';
    protected $Title = 'LAPORAN PINDAH DESA SELANGNANGKA';
    protected $SubTitle = 'PERIODE : ';

    protected $StartRowTitle = 1;
    protected $StartRowSubTitle = 2;

    protected $StartRowHeader = 3;
    protected $EndRowHeader = 4;
    protected $StartColumnHeader = 'A';
    protected $EndColumnHeader = 'M';

    protected $StartRowValue = 5;

    public function Anything($request)
    {
        $spreadsheet = new Spreadsheet();
        $From = $request->get('from');
        $End = $request->get('end');
        $sheet = $spreadsheet->getActiveSheet();
        $this->Data = [
            "NO", // A
            "KARTU KELUARGA", // B
            "ALAMAT", // C
            "RT / RW", // D
            "PROVINSI", // E
            "KECAMATAN", // F
            "DESA", // G
            "KEPALA KELUARGA", // H
            "NAMA", // I
            "NIK", // J
            "HUBUNGAN", // K
            "STATUS", // L
            "TANGGAL SISTEM" // M
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
        $Data = $User = Family::select(
            // family
            'family.id as id',
            'family.number_family as number_family',
            'family.head_id as head_id',
            'family.village as village_family',
            'family.neighbourhood as neighbourhood_family',
            'family.hamlet as hamlet_family',
            'family.sub_districts as sub_districts_family',
            'family.districts as districts_family',
            'family.province as province_family',
            'family.created_at as created_at',

            // user
            'users.id as user_id',
            'users.name as name',

            // head
            'user.name as head',

            // Population
            "population.nik as nik",
            "population.place_of_birth as place_of_birth",
            "population.gender as gender",
            "population.village as village",
            "population.neighbourhood as neighbourhood",
            "population.hamlet as hamlet",
            "population.religion as religion",
            "population.relation as relation",
            "population.married as married",
            "population.occupation as occupation",
            "population.status as status",
        )->leftjoin('users', 'users.family_id', 'family.id')
        ->join('population', 'users.id', 'population.user_id')
        ->join('users as user', 'user.id', 'family.head_id')
        ->whereBetween('family.created_at', [$From, $End])
        ->get();

        if (isset($Data)) {
            foreach ($Data as $Value) {
                $sheet->setCellValue('A'.$this->StartRowValue, $Number++);
                $sheet->setCellValue('B'.$this->StartRowValue, $Value->number_family);
                $sheet->setCellValue('C'.$this->StartRowValue, $Value->village_family);
                $sheet->setCellValue('D'.$this->StartRowValue, $Value->neighbourhood_family . ' / ' . $Value->hamlet_family);
                $sheet->setCellValue('E'.$this->StartRowValue, $Value->province_family);
                $sheet->setCellValue('F'.$this->StartRowValue, $Value->districts_family);
                $sheet->setCellValue('G'.$this->StartRowValue, $Value->sub_districts_family);
                $sheet->setCellValue('H'.$this->StartRowValue, $Value->head);
                $sheet->setCellValue('I'.$this->StartRowValue, $Value->name);
                $sheet->setCellValue('J'.$this->StartRowValue, "'".$Value->nik);
                $sheet->setCellValue('K'.$this->StartRowValue, $Value->relation);
                $sheet->setCellValue('L'.$this->StartRowValue, $Value->status);
                $sheet->setCellValue('M'.$this->StartRowValue, $Value->created_at);

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
                $sheet->getStyle('M'.$this->StartRowValue.':M'.$this->StartRowValue)->applyFromArray($styleCenter)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                $this->StartRowValue++;
            }
        }
        $writer = new Xlsx($spreadsheet);
        $FileName = 'report/keluarga-' . Carbon::now() . '.xlsx';
        $writer->save($FileName);
        return $FileName;
    }
}
