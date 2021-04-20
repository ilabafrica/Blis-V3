<?php

namespace App\Models;

use TCPDF;
use Auth;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma.
 * More Devs	 - Derrick Rono|Anthony Ereng|Emmanuel Kitsao.
 */

class PatientReportPDF extends TCPDF
{
    //Pdf Header
    public function Header()
    {
/*
        if ($this->page == 1) {
            // Logo
            $image_file = 'ilabafrica.jpg';
            $this->Image($image_file, 75, 10, 50, '', 'JPG', '', '', false, 300, '', false, false, 0, false, false, false);
            $this->ln();
            // Set font
            $this->SetFont('helvetica', 'B', 20);

            $this->SetMargins(PDF_MARGIN_LEFT, 50, PDF_MARGIN_RIGHT);
        } else {
            $this->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        }
*/
/*
        if ($this->page == 1) {
            $this->writeHTML(\View::make('reportHeader', $this->getTestRequestInformation()), 0, false, 'C', 0, '', 0, false, 'M', 'M');
            $this->SetHeaderMargin(100);
            $this->SetMargins(PDF_MARGIN_LEFT, 99, PDF_MARGIN_RIGHT);
        } else {
            $this->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        }
*/
    }

    public function Footer()
    {
        // Class 'App\Models\DateTime' not found
        // $now = new DateTime();
        // $printTime = $now->format('Y-m-d H:i');

/*
        //Position at 15mm at the bottom
        $this->SetY(-15);
        //Set font
        $this->SetFont('helvetica', 'I', 8);
        //set page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
        // $this->Cell(0, 10, "Printed by: ".Auth::user()->name." Date: ".$printTime, 0, false, 'R', 0, '', 0, false, 'T', 'M');
*/
        $printTime = date('Y-m-d H:i');

        // Position at 15 mm from bottom
        $this->SetY(-15);

        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // $this->Cell(0, 10, "Printed by: ".Auth::user()->name." on Date: ".$printTime, 0, false, 'L', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 10, "Printed at: ".$printTime, 0, false, 'L', 0, '', 0, false, 'T', 'M');
            // $patient->created_by = Auth::user()->id;

        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }

    // Specimen table
    public function SpecimenTable($header, $specimen)
    {
        // Colors, line width and bold font
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = [35, 35, 42, 42, 35];
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
        $this->Cell($w[0], 6, $specimen->specimenType->name, '1', 0, 'L', $fill);
        $this->Cell($w[1], 6, $specimen->collectedBy->name, '1', 0, 'L', $fill);
        $this->Cell($w[2], 6, $specimen->time_collected, '1', 0, 'L', $fill);
        $this->Cell($w[3], 6, $specimen->time_received, '1', 0, 'L', $fill);
        $this->Cell($w[4], 6, $specimen->status->name, '1', 0, 'L', $fill);
        $fill = ! $fill;
    }

    // Results table
    public function ResultsTable($header, $results)
    {
        // Colors, line width and bold font
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(0, 0, 128);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = [35, 35, 42, 42, 25];
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
        foreach ($results as $result) {
            $this->Cell($w[0], 6, $result->id, '1', 0, 'L', $fill);
            $this->Cell($w[1], 6, $result->measure->name, '1', 0, 'L', $fill);
            $this->Cell($w[2], 6, $result->result, '1', 0, 'R', $fill);
            $this->Cell($w[3], 6, $result->time_entered, '1', 0, 'R', $fill);
            $this->Cell($w[4], 6, $result->status, '1', 0, 'R', $fill);
            $this->Ln();
            $fill = ! $fill;
        }
    }

    Public function getTestRequestInformation()
    {
        return ['place holder'];
    }


}
