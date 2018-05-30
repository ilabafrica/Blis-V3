<?php

namespace App\Models;
use \TCPDF;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma.
 * More Devs	 - Derrick Rono|Anthony Ereng|Emmanuel Kitsao.
 */

class BLISPDF extends TCPDF {
    //Pdf Header
    Public function Header(){
        if($this->page == 1){
            // Logo
            $image_file = 'ilabafrica.jpg';
            $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            // Set font
            $this->SetFont('helvetica', 'B', 20);
            // Title
            $this->Cell(0, 15, 'Sample Report', 0, false, 'C', 0, '', 0, false, 'M', 'M');

            $this->SetMargins(PDF_MARGIN_LEFT, 50, PDF_MARGIN_RIGHT);
        }else {

            $this->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
        }
    }


    Public function Footer(){
// Class 'App\Models\DateTime' not found
        // $now = new DateTime();
        // $printTime = $now->format('Y-m-d H:i');

        //Position at 15mm at the bottom
        $this->SetY(-15);
        //Set font
        $this->SetFont('helvetica', 'I', 8);
        //set page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
        // $this->Cell(0, 10, "Printed by: ".Auth::user()->name." Date: ".$printTime, 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}