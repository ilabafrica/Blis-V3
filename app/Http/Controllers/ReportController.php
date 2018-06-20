<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS             - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead     - Emmanuel Kweyu.
 * Devs             - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */
use App\Models\BLISPDF;

class ReportController extends Controller
{
    public function index()
    {
        /*
        STEPS
        - move to the function now and make some samples
        -- still with no restrictions of authentication
        -- after that do some qgis
        */

        // create new PDF document
        $pdf = new BLISPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('eHealth Team');
        $pdf->SetTitle('Sample BLISPDF');
        $pdf->SetSubject('Sample Sample');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 011', PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
        $pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once dirname(__FILE__).'/lang/eng.php';
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('helvetica', '', 12);

        // add a page
        $pdf->AddPage();

        // ---------------------------------------------------------

        return $pdf->Output('sample.pdf', 'I');
    }

    public function users($from, $to)
    {
        /*
        for now put it outside authentication
        - routes, they are all get
        -- copy the fuctions and work out route names from them
        - copy th
        */

        // create new PDF document
        $pdf = new BLISPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('TCPDF Example 011');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 011', PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
        $pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once dirname(__FILE__).'/lang/eng.php';
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('helvetica', '', 12);

        // add a page
        $pdf->AddPage();

        // column titles
        $header = ['Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)'];

        // data loading
        $data = $pdf->LoadData('data/table_data_demo.txt');

        // print colored table
        $pdf->ColoredTable($header, $data);

        // ---------------------------------------------------------

        return $pdf->Output('example_011.pdf', 'I');
    }

    public function patients($from, $to)
    {
        //
    }

    public function visit($visit_id)
    {
        //
    }

    public function history($patient_id, $from, $to)
    {
        //
    }

    public function test($test_id)
    {
        //
    }

    public function dailyLog($from, $to)
    {
        // default is today
    }

    public function prevalence($testIds, $from, $to)
    {
        // default is today
    }

    public function counts($testIds, $from, $to)
    {
        // default is today
    }

    public function positivity($testIds, $from, $to)
    {
        // daily, monthly etc
    }

    public function turnAroundTime($testIds, $from, $to)
    {
        // daily, monthly etc
    }

    public function qualityControl($equipment_id, $from, $to)
    {
        // monthly default (previous month)
    }

    public function render($content, $name)
    {
        $pdf = new BLISPDF;
        $pdf->SetAutoPageBreak(true, 15);
        $pdf->AddPage();
        $pdf->SetFont('times', '', '11');
        $pdf->writeHTML($content, 'true', 'false', 'false', 'false', '');

        return $pdf->output($name.'.pdf');
    }

    // Load table data from file
    public function LoadData($file)
    {
        // Read file lines
        $lines = file($file);
        $data = [];
        foreach ($lines as $line) {
            $data[] = explode(';', chop($line));
        }

        return $data;
    }

    // Colored table
    public function ColoredTable($header, $data)
    {
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = [40, 35, 40, 45];
        $num_headers = count($header);
        for ($i = 0; $i < $num_headers; $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill = ! $fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}
