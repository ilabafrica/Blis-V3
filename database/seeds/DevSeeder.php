<?php

use App\User;
use App\Models\Role;
use App\Models\Gender;
use App\Models\Patient;
use App\Models\TestPhase;
use App\Models\TestStatus;
use App\Models\MeasureType;
use App\Models\SpecimenStatus;
use App\Models\Measure;
use App\Models\TestType;
use App\Models\Instrument;
use App\Models\MeasureRange;
use App\Models\SpecimenType;
use App\Models\TestTypeCategory;
use App\Models\GramStainRange;
use App\Models\RejectionReason;
use App\Models\DrugSusceptibilityMeasure;

use Illuminate\Database\Seeder;
class DevSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rejection_reasons_array = [
          ["name" => "Inadequate sample volume"],
          ["name" => "Haemolysed sample"],
          ["name" => "Specimen without lab request form"],
          ["name" => "No test ordered on  lab request form of sample"],
          ["name" => "No sample label or identifier"],
          ["name" => "Wrong sample label"],
          ["name" => "Unclear sample label"],
          ["name" => "Sample in wrong container"],
          ["name" => "Damaged/broken/leaking sample container"],
          ["name" => "Too old sample"],
          ["name" => "Date of sample collection not specified"],
          ["name" => "Time of sample collection not specified"],
          ["name" => "Improper transport media"],
          ["name" => "Sample type unacceptable for required test"],
          ["name" => "Other"],
        ];
        foreach ($rejection_reasons_array as $rejection_reason)
        {
            $rejection_reasons[] = RejectionReason::create($rejection_reason);
        }
        $this->command->info("rejection_reasons seeded");

        /* Specimen Types table */
        $specimenTypeAsciticTap = SpecimenType::create(["name" => "Ascitic Tap"]);
        $specimenTypeDriedBloodSpot = SpecimenType::create(["name" => "Dried Blood Spot"]);
        $specimenTypeNasalSwab = SpecimenType::create(["name" => "Nasal Swab"]);
        $specimenTypePleuralTap = SpecimenType::create(["name" => "Pleural Tap"]);
        $specimenTypeRectalSwab = SpecimenType::create(["name" => "Rectal Swab"]);
        $specimenTypeSemen = SpecimenType::create(["name" => "Semen"]);
        $specimenTypeSkin = SpecimenType::create(["name" => "Skin"]);
        $specimenTypeVomitus = SpecimenType::create(["name" => "Vomitus"]);// should this be kept given there is sputum
        $specimenTypeSynovialFluid = SpecimenType::create(["name" => "Synovial Fluid"]);
        $specimenTypeUrethralSmear = SpecimenType::create(["name" => "Urethral Smear"]);
        $specimenTypeVaginalSmear = SpecimenType::create(["name" => "Vaginal Smear"]);
        $specimenTypeWater = SpecimenType::create(["name" => "Water"]);

        // microb-able specimen types
        $specimenTypeStool = SpecimenType::create(["name" => "Stool"]);
        $specimenTypeCSF = SpecimenType::create(["name" => "CSF"]);
        $specimenTypeWoundSwab = SpecimenType::create(["name" => "Wound swab"]);
        $specimenTypePusSwab = SpecimenType::create(["name" => "Pus swab"]);
        $specimenTypeHVS = SpecimenType::create(["name" => "HVS"]);
        $specimenTypeEyeSwab = SpecimenType::create(["name" => "Eye swab"]);
        $specimenTypeEarSwab = SpecimenType::create(["name" => "Ear swab"]);
        $specimenTypeThroatSwab = SpecimenType::create(["name" => "Throat swab"]);
        $specimenTypeAspirates = SpecimenType::create(["name" => "Pus Aspirate"]);
        $specimenTypeBlood = SpecimenType::create(["name" => "Blood"]);
        $specimenTypeBAL = SpecimenType::create(["name" => "BAL"]);
        $specimenTypeSputum = SpecimenType::create(["name" => "Sputum"]);
        $specimenTypeUretheralSwab = SpecimenType::create(["name" => "Uretheral swab"]);
        $specimenTypeUrine = SpecimenType::create(["name" => "Urine"]);


        /* Test Categories table - These map on to the lab sections */
        $test_categories = TestTypeCategory::create(["name" => "PARASITOLOGY"]);
        $testTypeCategoryMicrobiology = TestTypeCategory::create(["name" => "MICROBIOLOGY"]);
        $testTypeCategoryHematology = TestTypeCategory::create(["name" => "HEMATOLOGY"]);
        $testTypeCategorySerology = TestTypeCategory::create(["name" => "SEROLOGY"]);
        $testTypeCategoryTransfusion = TestTypeCategory::create(["name" => "BLOOD TRANSFUSION"]);
        $this->command->info("Lab Sections seeded");

        $testTypeHIV = TestType::create(["name" => "HIV", "test_type_category_id" => $testTypeCategorySerology ->id]);
        $testTypeBS = TestType::create(["name" => "BS for mps", "test_type_category_id" => $test_categories->id]);
        $testTypeHB = TestType::create(["name" => "HB", "test_type_category_id" => $test_categories->id]);
        $testTypeUrinalysis = TestType::create(["name" => "Urinalysis", "test_type_category_id" => $test_categories->id]);
        $testTypeWBC = TestType::create(["name" => "WBC", "test_type_category_id" => $test_categories->id]);

        $this->command->info("test_types seeded");


        $testTypeGXM = TestType::create(["name" => "GXM", "test_type_category_id" => $test_categories->id]);
        $measureGXM = Measure::create(array("measure_type_id" => "4","test_type_id" => $testTypeGXM->id, "name" => "GXM", "unit" => ""));
        $measureBloodGroup = Measure::create(
            ["measure_type_id" => "2","test_type_id" => $testTypeGXM->id,
                "name" => "Blood Grouping",
                "unit" => ""]);
        MeasureRange::create(["measure_id" => $measureBloodGroup->id, "display" => "O-"]);
        MeasureRange::create(["measure_id" => $measureBloodGroup->id, "display" => "O+"]);
        MeasureRange::create(["measure_id" => $measureBloodGroup->id, "display" => "A-"]);
        MeasureRange::create(["measure_id" => $measureBloodGroup->id, "display" => "A+"]);
        MeasureRange::create(["measure_id" => $measureBloodGroup->id, "display" => "B-"]);
        MeasureRange::create(["measure_id" => $measureBloodGroup->id, "display" => "B+"]);
        MeasureRange::create(["measure_id" => $measureBloodGroup->id, "display" => "AB-"]);
        MeasureRange::create(["measure_id" => $measureBloodGroup->id, "display" => "AB+"]);
        $measureHB = Measure::create(["measure_type_id" => MeasureType::numeric, "test_type_id" => $testTypeHB->id,"name" => "HB",
            "unit" => "g/dL"]);

        $measuresUrinalysisData = [
            // Urine Microscopy
            ["measure_type_id" => "4", "test_type_id" => $testTypeUrinalysis->id,
                "name" => "Pus cells", "unit" => ""],
            ["measure_type_id" => "4", "test_type_id" => $testTypeUrinalysis->id,
                "name" => "S. haematobium", "unit" => ""],
            ["measure_type_id" => "4", "test_type_id" => $testTypeUrinalysis->id,
                "name" => "T. vaginalis", "unit" => ""],
            ["measure_type_id" => "4", "test_type_id" => $testTypeUrinalysis->id,
                "name" => "Yeast cells", "unit" => ""],
            ["measure_type_id" => "4", "test_type_id" => $testTypeUrinalysis->id,
                "name" => "Red blood cells", "unit" => ""],
            ["measure_type_id" => "4", "test_type_id" => $testTypeUrinalysis->id,
                "name" => "Bacteria", "unit" => ""],
            ["measure_type_id" => "4", "test_type_id" => $testTypeUrinalysis->id,
                "name" => "Spermatozoa", "unit" => ""],
            ["measure_type_id" => "4", "test_type_id" => $testTypeUrinalysis->id,
                "name" => "Epithelial cells", "unit" => ""],
            // Urine Chemistry
            ["measure_type_id" => "4", "test_type_id" => $testTypeUrinalysis->id,
                "name" => "Glucose", "unit" => ""],
            ["measure_type_id" => "4", "test_type_id" => $testTypeUrinalysis->id,
                "name" => "Ketones", "unit" => ""],
            ["measure_type_id" => "4", "test_type_id" => $testTypeUrinalysis->id,
                "name" => "Proteins", "unit" => ""],
            ["measure_type_id" => "4", "test_type_id" => $testTypeUrinalysis->id,
                "name" => "Blood", "unit" => ""],
            ["measure_type_id" => "4", "test_type_id" => $testTypeUrinalysis->id,
                "name" => "Bilirubin", "unit" => ""],
            ["measure_type_id" => "4", "test_type_id" => $testTypeUrinalysis->id,
                "name" => "Urobilinogen Phenlpyruvic acid", "unit" => ""],
            ["measure_type_id" => "4", "test_type_id" => $testTypeUrinalysis->id,
                "name" => "pH", "unit" => ""],
        ];

        foreach ($measuresUrinalysisData as $measureU) {
            $measuresUrinalysis[] = Measure::create($measureU);
        }

        $measuresWBCData = [
            ["measure_type_id" => MeasureType::numeric,
                "test_type_id" => $testTypeWBC->id,
                "name" => "WBC",
                "unit" => "x10³/µL"],
            ["measure_type_id" => MeasureType::numeric,
                "test_type_id" => $testTypeWBC->id,
                "name" => "Lym", "unit" => "L"],
            ["measure_type_id" => MeasureType::numeric,
                "test_type_id" => $testTypeWBC->id,
                "name" => "Mon", "unit" => "*"],
            ["measure_type_id" => MeasureType::numeric,
                "test_type_id" => $testTypeWBC->id,
                "name" => "Neu", "unit" => "*"],
            ["measure_type_id" => MeasureType::numeric,
                "test_type_id" => $testTypeWBC->id,
                "name" => "Eos", "unit" => ""],
            ["measure_type_id" => MeasureType::numeric,
                "test_type_id" => $testTypeWBC->id,
                "name" => "Baso", "unit" => ""],
        ];

        foreach ($measuresWBCData as $value) {
            $measuresWBC[] = Measure::create($value);
        }

        $measureRangesWBC = [
            ["measure_id" => $measuresWBC[0]->id, "age_min" => 0, "age_max" => 100, "gender_id" => Gender::both,
                "low" => 4, "high" => 11],
            ["measure_id" => $measuresWBC[1]->id, "age_min" => 0, "age_max" => 100, "gender_id" => Gender::both,
                "low" => 1.5, "high" => 4],
            ["measure_id" => $measuresWBC[2]->id, "age_min" => 0, "age_max" => 100, "gender_id" => Gender::both,
                "low" => 0.1, "high" => 9],
            ["measure_id" => $measuresWBC[3]->id, "age_min" => 0, "age_max" => 100, "gender_id" => Gender::both,
                "low" => 2.5, "high" => 7],
            ["measure_id" => $measuresWBC[4]->id, "age_min" => 0, "age_max" => 100, "gender_id" => Gender::both,
                "low" => 0, "high" => 6],
            ["measure_id" => $measuresWBC[5]->id, "age_min" => 0, "age_max" => 100, "gender_id" => Gender::both,
                "low" => 0, "high" => 2],
            ];

        foreach ($measureRangesWBC as $value) {
            MeasureRange::create($value);
        }

        $this->command->info("measures seeded");

        /* Measures table */
        $measureHIV = [
            [
                "measure_type_id" => "2",
                "test_type_id" => $testTypeHIV->id,
                "name" => "Screening",
                "unit" => "",
            ],
            [
                "measure_type_id" => "2",
                "test_type_id" => $testTypeHIV->id,
                "name" => "Confirmatory Test (Statpak)",
                "unit" => "",
            ],
            [
                "measure_type_id" => "2",
                "test_type_id" => $testTypeHIV->id,
                "name" => "Unigold",
                "unit" =>"",
            ],
        ];
        foreach($measureHIV as $measureH){
            Measure::create($measureH);
        }

        $measureBSforMPS = Measure::create([
            "measure_type_id" => "2",
            "test_type_id" => $testTypeBS->id,
            "name" => "BS for mps",
            "unit" => ""]);

        MeasureRange::create([
            "measure_id" => $measureBSforMPS->id,
            "display" => "No mps seen",
            // "interpretation" => "Negative",// todo: adapt to handle interpretation_id
        ]);
        MeasureRange::create([
            "measure_id" => $measureBSforMPS->id,
            "display" => "+",
            // "interpretation" => "Positive",// todo: adapt to handle interpretation_id
        ]);
        MeasureRange::create([
            "measure_id" => $measureBSforMPS->id,
            "display" => "++",
            // "interpretation" => "Positive",// todo: adapt to handle interpretation_id
        ]);
        MeasureRange::create([
            "measure_id" => $measureBSforMPS->id,

            "display" => "+++",
            // "interpretation" => "Positive",// todo: adapt to handle interpretation_id
        ]);

        /* test_type_mappings table */
        \DB::table('test_type_mappings')->insert(
            ["test_type_id" => $testTypeHIV->id, "specimen_type_id" => $specimenTypeBlood->id]);
        \DB::table('test_type_mappings')->insert(
            ["test_type_id" => $testTypeBS->id, "specimen_type_id" => $specimenTypeBlood->id]);
        \DB::table('test_type_mappings')->insert(
            ["test_type_id" => $testTypeGXM->id, "specimen_type_id" => $specimenTypeBlood->id]);
        \DB::table('test_type_mappings')->insert(
            ["test_type_id" => $testTypeHB->id, "specimen_type_id" => $specimenTypeBlood->id]);
        \DB::table('test_type_mappings')->insert(
            ["test_type_id" => $testTypeHB->id, "specimen_type_id" => $specimenTypeNasalSwab->id]);
        \DB::table('test_type_mappings')->insert(
            ["test_type_id" => $testTypeHB->id, "specimen_type_id" => $specimenTypePleuralTap->id]);
        \DB::table('test_type_mappings')->insert(
            ["test_type_id" => $testTypeHB->id, "specimen_type_id" => $specimenTypeVomitus->id]);
        \DB::table('test_type_mappings')->insert(
            ["test_type_id" => $testTypeWBC->id, "specimen_type_id" => $specimenTypeBlood->id]);

        $this->command->info("test_type_mappings seeded");

        /* Instruments table */
        $instrumentsData = [
            "name" => "Celltac F Mek 8222",
            // "driver_name" => "KBLIS\\Plugins\\CelltacFMachine",
            // "ip" => "192.168.1.12",
            // "hostname" => "HEMASERVER"
        ];

        $instrument = Instrument::create($instrumentsData);
        $instrument->testTypes()->attach([$testTypeWBC->id]);

        $this->command->info("Instruments table seeded");

        /* Test Types for prevalence */
        $test_types_salmonella = TestType::create(["name" => "Salmonella Antigen Test", "test_type_category_id" => $test_categories->id]);
        $test_types_direct = TestType::create(["name" => "Direct COOMBS Test", "test_type_category_id" => $testTypeCategoryTransfusion->id]);
        $test_types_du = TestType::create(["name" => "DU Test", "test_type_category_id" => $testTypeCategoryTransfusion->id]);
        $test_types_sickling = TestType::create(["name" => "Sickling Test", "test_type_category_id" => $testTypeCategoryHematology->id]);
        $test_types_borrelia = TestType::create(["name" => "Borrelia", "test_type_category_id" => $test_categories->id]);
        $test_types_vdrl = TestType::create(["name" => "VDRL", "test_type_category_id" => $testTypeCategorySerology->id]);
        $test_types_pregnancy = TestType::create(["name" => "Pregnancy Test", "test_type_category_id" => $testTypeCategorySerology->id]);
        $test_types_brucella = TestType::create(["name" => "Brucella", "test_type_category_id" => $testTypeCategorySerology->id]);
        $test_types_pylori = TestType::create(["name" => "H. Pylori", "test_type_category_id" => $testTypeCategorySerology->id]);

        $this->command->info("Test Types seeded");

        /* Test Types and specimen types relationship for prevalence */
        \DB::insert('INSERT INTO test_type_mappings (test_type_id, specimen_type_id) VALUES (?, ?)',
            [$test_types_salmonella->id, $specimenTypeBlood->id]);
        \DB::insert('INSERT INTO test_type_mappings (test_type_id, specimen_type_id) VALUES (?, ?)',
            [$test_types_direct->id, $specimenTypeBlood->id]);
        \DB::insert('INSERT INTO test_type_mappings (test_type_id, specimen_type_id) VALUES (?, ?)',
            [$test_types_du->id, $specimenTypeBlood->id]);
         \DB::insert('INSERT INTO test_type_mappings (test_type_id, specimen_type_id) VALUES (?, ?)',
            [$test_types_sickling->id, $specimenTypeBlood->id]);
        \DB::insert('INSERT INTO test_type_mappings (test_type_id, specimen_type_id) VALUES (?, ?)',
            [$test_types_borrelia->id, $specimenTypeUrine->id]);
        \DB::insert('INSERT INTO test_type_mappings (test_type_id, specimen_type_id) VALUES (?, ?)',
            [$test_types_vdrl->id, $specimenTypeBlood->id]);
         \DB::insert('INSERT INTO test_type_mappings (test_type_id, specimen_type_id) VALUES (?, ?)',
            [$test_types_pregnancy->id, $specimenTypeUrine->id]);
        \DB::insert('INSERT INTO test_type_mappings (test_type_id, specimen_type_id) VALUES (?, ?)',
            [$test_types_brucella->id, $specimenTypeBlood->id]);
        \DB::insert('INSERT INTO test_type_mappings (test_type_id, specimen_type_id) VALUES (?, ?)',
            [$test_types_pylori->id, $specimenTypeStool->id]);
        $this->command->info("TestTypes/SpecimenTypes seeded");

        /*New measures for prevalence*/
        $measure_salmonella = Measure::create([
            "measure_type_id" => "2",
            "test_type_id" => $test_types_salmonella->id,
            "name" => "Salmonella Antigen Test",
            "unit" => ""]);
        $measure_direct = Measure::create([
            "measure_type_id" => "2",
            "test_type_id" => $test_types_direct->id,
            "name" => "Direct COOMBS Test",
            "unit" => ""]);
        $measure_du = Measure::create([
            "measure_type_id" => "2",
            "test_type_id" => $test_types_du->id,
            "name" => "Du Test",
            "unit" => ""]);
        $measure_sickling = Measure::create([
            "measure_type_id" => "2",
            "test_type_id" => $test_types_sickling->id,
            "name" => "Sickling Test",
            "unit" => ""]);
        $measure_borrelia = Measure::create([
            "measure_type_id" => "2",
            "test_type_id" => $test_types_borrelia->id,
            "name" => "Borrelia",
            "unit" => ""]);
        $measure_vdrl = Measure::create([
            "measure_type_id" => "2",
            "test_type_id" => $test_types_vdrl->id,
            "name" => "VDRL",
            "unit" => ""]);
        $measure_pregnancy = Measure::create([
            "measure_type_id" => "2",
            "test_type_id" => $test_types_pregnancy->id,
            "name" => "Pregnancy Test",
            "unit" => ""]);
        $measure_brucella = Measure::create([
            "measure_type_id" => "2",
            "test_type_id" => $test_types_brucella->id,
            "name" => "Brucella",
            "unit" => ""]);
        $measure_pylori = Measure::create([
            "measure_type_id" => "2",
            "test_type_id" => $test_types_pylori->id,
            "name" => "H. Pylori",
            "unit" => ""]);


        MeasureRange::create(["measure_id" => $measure_salmonella->id, "display" => "Positive"]);
        MeasureRange::create(["measure_id" => $measure_salmonella->id, "display" => "Negative"]);
        MeasureRange::create(["measure_id" => $measure_direct->id, "display" => "Positive"]);
        MeasureRange::create(["measure_id" => $measure_direct->id, "display" => "Negative"]);
        MeasureRange::create(["measure_id" => $measure_du->id, "display" => "Positive"]);
        MeasureRange::create(["measure_id" => $measure_du->id, "display" => "Negative"]);
        MeasureRange::create(["measure_id" => $measure_sickling->id, "display" => "Positive"]);
        MeasureRange::create(["measure_id" => $measure_sickling->id, "display" => "Negative"]);
        MeasureRange::create(["measure_id" => $measure_borrelia->id, "display" => "Positive"]);
        MeasureRange::create(["measure_id" => $measure_borrelia->id, "display" => "Negative"]);
        MeasureRange::create(["measure_id" => $measure_vdrl->id, "display" => "Positive"]);
        MeasureRange::create(["measure_id" => $measure_vdrl->id, "display" => "Negative"]);
        MeasureRange::create(["measure_id" => $measure_pregnancy->id, "display" => "Positive"]);
        MeasureRange::create(["measure_id" => $measure_pregnancy->id, "display" => "Negative"]);
        MeasureRange::create(["measure_id" => $measure_brucella->id, "display" => "Positive"]);
        MeasureRange::create(["measure_id" => $measure_brucella->id, "display" => "Negative"]);
        MeasureRange::create(["measure_id" => $measure_pylori->id, "display" => "Positive"]);
        MeasureRange::create(["measure_id" => $measure_pylori->id, "display" => "Negative"]);
        $this->command->info("Measures seeded again");

        $testTypeCBC = TestType::create([
            "name" => "CBC",
            "test_type_category_id" => $testTypeCategoryHematology->id,
        ]);

        $cBCMeasureID = [];
        $measureWBC = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "WBC",
            "unit" => "x10³/µL"]);
        $measureRBC = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "RBC",
            "unit" => "x10⁶/µL"]);
        $measureHGB = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "HGB",
            "unit" => "g/dL"]);
        $measureHCT = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "HCT",
            "unit" => "%"]);
        $measureMCV = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "MCV",
            "unit" => "fL"]);
        $measureMCH = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "MCH",
            "unit" => "pg"]);
        $measureMCHC = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "MCHC",
            "unit" => "g/dL"]);
        $measurePLT = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "PLT",
            "unit" => "x10³/µL"]);
        $measureRDWSD = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "RDW-SD",
            "unit" => "fL"]);
        $measureRDWCV = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "RDW-CV",
            "unit" => "%"]);
        $measurePDW = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "PDW",
            "unit" => "fL"]);
        $measureMPV = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "MPV",
            "unit" => "fL"]);
        $measurePLCR = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "P-LCR",
            "unit" => "%"]);
        $measurePCT = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "PCT",
            "unit" => "%"]);
        $measureNEUThash = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "NEUT#",
            "unit" => "x10³/µL"]);
        $measureLYMPHhash = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "LYMPH#",
            "unit" => "x10³/µL"]);
        $measureMONOhash = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "MONO#",
            "unit" => "x10³/µL"]);
        $measureEOhash = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "EO#",
            "unit" => "x10³/µL"]);
        $measureBASOhash = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "BASO#",
            "unit" => "x10³/µL"]);
        $measureNEUTpercent = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "NEUT%",
            "unit" => "%"]);
        $measureLYMPHpercent = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "LYMPH%",
            "unit" => "%"]);
        $measureMONOpercent = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "MONO%",
            "unit" => "%"]);
        $measureEOpercent = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "EO%",
            "unit" => "%"]);
        $measureBASOpercent = Measure::create([
            "measure_type_id" => MeasureType::numeric,
            "test_type_id" => $testTypeCBC->id,
            "name" => "BASO%",
            "unit" => "%"]);

        $cBCMeasureID[] = $measureWBC->id;
        $cBCMeasureID[] = $measureRBC->id;
        $cBCMeasureID[] = $measureHGB->id;
        $cBCMeasureID[] = $measureHCT->id;
        $cBCMeasureID[] = $measureMCV->id;
        $cBCMeasureID[] = $measureMCH->id;
        $cBCMeasureID[] = $measureMCHC->id;
        $cBCMeasureID[] = $measurePLT->id;
        $cBCMeasureID[] = $measureRDWSD->id;
        $cBCMeasureID[] = $measureRDWCV->id;
        $cBCMeasureID[] = $measurePDW->id;
        $cBCMeasureID[] = $measureMPV->id;
        $cBCMeasureID[] = $measurePLCR->id;
        $cBCMeasureID[] = $measurePCT->id;
        $cBCMeasureID[] = $measureNEUThash->id;
        $cBCMeasureID[] = $measureLYMPHhash->id;
        $cBCMeasureID[] = $measureMONOhash->id;
        $cBCMeasureID[] = $measureEOhash->id;
        $cBCMeasureID[] = $measureBASOhash->id;
        $cBCMeasureID[] = $measureNEUTpercent->id;
        $cBCMeasureID[] = $measureLYMPHpercent->id;
        $cBCMeasureID[] = $measureMONOpercent->id;
        $cBCMeasureID[] = $measureEOpercent->id;
        $cBCMeasureID[] = $measureBASOpercent->id;

        /* test_type_mappings table */
        \DB::table('test_type_mappings')->insert(
            ["test_type_id" => $testTypeCBC->id, "specimen_type_id" => $specimenTypeBlood->id]);

        $measureRangeCBCGroup1 = [
            "age_min" => "0",
            "age_max" => "0.01923",
            "gender_id" => Gender::both,
            "low" => [3,2.5,12,26,86,26,31,50,37,11,9,9,13,0.17,1.5,1,0,0,0,37,20,0,0,0],
            "high" => [15,5.5,16,50,110,38,37,400,54,16,17,13,43,0.35,7,3.7,0.7,0.4,0.1,72,50,14,6,1],
            ];
        $measureRangeCBCGroup2 = [
            "age_min" => "0.01923",
            "age_max" => "0.08333",
            "gender_id" => Gender::both,
            "low" => [3,2.5,8,26,86,26,31,50,37,11,9,9,13,0.17,1.5,1,0,0,0,37,20,0,0,0],
            "high" => [15,5.5,17,50,110,38,37,400,54,16,17,13,43,0.35,7,3.7,0.7,0.4,0.1,72,50,14,6,1],
            ];
        $measureRangeCBCGroup3 = [
            "age_min" => "0.08333",
            "age_max" => "1",
            "gender_id" => Gender::both,
            "low" => [3,2.5,8,26,86,26,31,50,37,11,9,9,13,0.17,1.5,1,0,0,0,37,20,0,0,0],
            "high" => [15,5.5,17,50,110,38,37,400,54,16,17,13,43,0.35,7,3.7,0.7,0.4,0.1,72,50,14,6,1],
            ];
        $measureRangeCBCGroup4 = [
            "age_min" => "1",
            "age_max" => "12",
            "gender_id" => Gender::both,
            "low" => [3,2.5,8,26,86,26,31,50,37,11,9,9,13,0.17,1.5,1,0,0,0,37,20,0,0,0],
            "high" => [15,5.5,17,50,110,38,37,400,54,16,17,13,43,0.35,7,3.7,0.7,0.4,0.1,72,50,14,6,1],
            ];
        $measureRangeCBCGroup5 = [
            "age_min" => "12",
            "age_max" => "60",
            "gender_id" => Gender::male,
            "low" => [3,2.5,13,26,86,26,31,50,37,11,9,9,13,0.17,1.5,1,0,0,0,37,20,0,0,0],
            "high" => [15,5.5,17,50,110,38,37,400,54,16,17,13,43,0.35,7,3.7,0.7,0.4,0.1,72,50,14,6,1],
            ];
        $measureRangeCBCGroup6 = [
            "age_min" => "12",
            "age_max" => "60",
            "gender_id" => Gender::female,
            "low" => [4,2.5,12,26,86,26,31,50,37,11,9,9,13,0.17,1.5,1,0,0,0,37,20,0,0,0],
            "high" => [11,5.5,14,50,110,38,37,400,54,16,17,13,43,0.35,7,3.7,0.7,0.4,0.1,72,50,14,6,1],
            ];
        $measureRangeCBCGroup7 = [
            "age_min" => "60",
            "age_max" => "999",
            "gender_id" => Gender::both,
            "low" => [3,2.5,8,26,86,26,31,50,37,11,9,9,13,0.17,1.5,1,0,0,0,37,20,0,0,0],
            "high" => [15,5.5,17,50,110,38,37,400,54,16,17,13,43,0.35,7,3.7,0.7,0.4,0.1,72,50,14,6,1],
            ];

        for ($i = 0; $i <= 23; $i++) {
            $measureRange = MeasureRange::create([
                "measure_id" => $cBCMeasureID[$i],
                "age_min" => $measureRangeCBCGroup1["age_min"],
                "age_max" => $measureRangeCBCGroup1["age_max"],
                "gender_id" => $measureRangeCBCGroup1["gender_id"],
                "low" => $measureRangeCBCGroup1["low"][$i],
                "high" => $measureRangeCBCGroup1["high"][$i]
            ]);

            $measureRange = MeasureRange::create([
                "measure_id" => $cBCMeasureID[$i],
                "age_min" => $measureRangeCBCGroup2["age_min"],
                "age_max" => $measureRangeCBCGroup2["age_max"],
                "gender_id" => $measureRangeCBCGroup2["gender_id"],
                "low" => $measureRangeCBCGroup2["low"][$i],
                "high" => $measureRangeCBCGroup2["high"][$i]
            ]);

            $measureRange = MeasureRange::create([
                "measure_id" => $cBCMeasureID[$i],
                "age_min" => $measureRangeCBCGroup3["age_min"],
                "age_max" => $measureRangeCBCGroup3["age_max"],
                "gender_id" => $measureRangeCBCGroup3["gender_id"],
                "low" => $measureRangeCBCGroup3["low"][$i],
                "high" => $measureRangeCBCGroup3["high"][$i]
            ]);

            $measureRange = MeasureRange::create([
                "measure_id" => $cBCMeasureID[$i],
                "age_min" => $measureRangeCBCGroup4["age_min"],
                "age_max" => $measureRangeCBCGroup4["age_max"],
                "gender_id" => $measureRangeCBCGroup4["gender_id"],
                "low" => $measureRangeCBCGroup4["low"][$i],
                "high" => $measureRangeCBCGroup4["high"][$i]
            ]);

            $measureRange = MeasureRange::create([
                "measure_id" => $cBCMeasureID[$i],
                "age_min" => $measureRangeCBCGroup5["age_min"],
                "age_max" => $measureRangeCBCGroup5["age_max"],
                "gender_id" => $measureRangeCBCGroup5["gender_id"],
                "low" => $measureRangeCBCGroup5["low"][$i],
                "high" => $measureRangeCBCGroup5["high"][$i]
            ]);

            $measureRange = MeasureRange::create([
                "measure_id" => $cBCMeasureID[$i],
                "age_min" => $measureRangeCBCGroup6["age_min"],
                "age_max" => $measureRangeCBCGroup6["age_max"],
                "gender_id" => $measureRangeCBCGroup6["gender_id"],
                "low" => $measureRangeCBCGroup6["low"][$i],
                "high" => $measureRangeCBCGroup6["high"][$i]
            ]);

            $measureRange = MeasureRange::create([
                "measure_id" => $cBCMeasureID[$i],
                "age_min" => $measureRangeCBCGroup7["age_min"],
                "age_max" => $measureRangeCBCGroup7["age_max"],
                "gender_id" => $measureRangeCBCGroup7["gender_id"],
                "low" => $measureRangeCBCGroup7["low"][$i],
                "high" => $measureRangeCBCGroup7["high"][$i]
            ]);
        }

        // test types
        $testTypeAppearance = TestType::create([
            'name' => 'Appearance',
            'test_type_category_id' => $testTypeCategoryMicrobiology->id,
        ]);
        $testTypeCultureAndSensitivity = TestType::create([
            "name" => "Culture and Sensitivity",
            "test_type_category_id" => $testTypeCategoryMicrobiology->id
        ]);
        $testTypeGramStaining = TestType::create([
            "name" => "Gram Staining",
            "test_type_category_id" => $testTypeCategoryMicrobiology->id
        ]);
        $testTypeIndiaInkStaining = TestType::create([
            "name" => "India Ink Staining",
            "test_type_category_id" => $testTypeCategoryMicrobiology->id
        ]);
        $testTypeProtein = TestType::create([
            "name" => "Protein",
            "test_type_category_id" => $testTypeCategoryMicrobiology->id
        ]);
        $testTypeWetPreparation = TestType::create([
            "name" => "Wet preparation (saline preparation)",
            "test_type_category_id" => $testTypeCategoryMicrobiology->id
        ]);
        $testTypeWetSalineIodinePrep = TestType::create([
            'name' => 'Wet Saline Iodine Prep',
            'test_type_category_id' => $testTypeCategoryMicrobiology->id,
        ]);
        $testTypeWhiteBloodCellCount = TestType::create([
            "name" => "White Blood Cell Count",
            "test_type_category_id" => $testTypeCategoryMicrobiology->id
        ]);
        $testTypeZNStaining = TestType::create([
            "name" => "ZN Staining",
            "test_type_category_id" => $testTypeCategoryMicrobiology->id
        ]);
        $testTypeModifiedZn = TestType::create([
            'name' => 'Modified ZN',
            'test_type_category_id' => $testTypeCategoryMicrobiology->id,
        ]);

        // these dont neccesarily belong to micro b, ... just testing
        $testTypeSerumAmylase = TestType::create([
            "name" => "Serum Amylase",
            'test_type_category_id' => $testTypeCategoryMicrobiology->id,
        ]);
        $testTypeCulcium = TestType::create([
            "name" => "Culcium",
            'test_type_category_id' => $testTypeCategoryMicrobiology->id,
        ]);
        $testTypeSGOT = TestType::create([
            "name" => "SGOT",
            'test_type_category_id' => $testTypeCategoryMicrobiology->id,
        ]);
        $testTypeIndirectCOOMBSTest = TestType::create([
            "name" => "Indirect COOMBS Test",
            'test_type_category_id' => $testTypeCategoryMicrobiology->id,
        ]);
        $testTypeDirectCOOMBSTest = TestType::create([
            "name" => "Direct COOMBS Test",
            'test_type_category_id' => $testTypeCategoryMicrobiology->id,
        ]);
        $testTypeDuTest = TestType::create([
            "name" => "DuT est",
            'test_type_category_id' => $testTypeCategoryMicrobiology->id,
        ]);



        $testTypeCrag = TestType::create(["name" => "Crag","test_type_category_id" => $testTypeCategoryMicrobiology->id,]);
        $testTypeDifferential = TestType::create(["name" => "Differential","test_type_category_id" => $testTypeCategoryMicrobiology->id,]);
        $testTypeTotalCellCount = TestType::create(["name" => "Total Cell Count","test_type_category_id" => $testTypeCategoryMicrobiology->id,]);
        $testTypeLymphocytes = TestType::create(["name" => "Lymphocytes","test_type_category_id" => $testTypeCategoryMicrobiology->id,]);
        $testTypeQuantitativeCulture = TestType::create(["name" => "Quantitative Culture","test_type_category_id" => $testTypeCategoryMicrobiology->id,]);
        $testTypeRBC = TestType::create(["name" => "RBC Count","test_type_category_id" => $testTypeCategoryMicrobiology->id,]);
        $testTypeTPHA = TestType::create(["name" => "TPHA","test_type_category_id" => $testTypeCategoryMicrobiology->id,]);

        $measureCrag = Measure::create([
            "measure_type_id" => "2",
            "test_type_id" => $testTypeCrag->id,
            "name" => "Crag",
            "unit" => "",
        ]);
        MeasureRange::create(["measure_id" => $measureCrag->id, "display" => "Reactive"]);
        MeasureRange::create(["measure_id" => $measureCrag->id, "display" => "Non Reactive"]);


        $measureDifferential = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeDifferential->id,
            "name" => "Differential",
            "unit" => "",
        ]);
        $measureTotalCellCount = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeTotalCellCount->id,
            "name" => "Total Cell Count",
            "unit" => "",
        ]);
        $measureLymphocytes = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeLymphocytes->id,
            "name" => "Lymphocytes",
            "unit" => "",
        ]);
        $measureQuantitativeCulture = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeQuantitativeCulture->id,
            "name" => "Quantitative Culture",
            "unit" => "",
        ]);
        $measureRBC = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeRBC->id,
            "name" => "RBC Count",
            "unit" => "",
        ]);
        $measureTPHA = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeTPHA->id,
            "name" => "TPHA",
            "unit" => "",
        ]);

        /* Urine Chemistry */
        $testTypeHCG = TestType::create(["name" => "HCG","test_type_category_id" => $testTypeCategoryMicrobiology->id,]);
        $testTypeBilirubin = TestType::create(["name" => "Bilirubin","test_type_category_id" => $testTypeCategoryMicrobiology->id,]);
        $testTypeBlood = TestType::create(["name" => "Blood","test_type_category_id" => $testTypeCategoryMicrobiology->id,]);
        $testTypeGlucose = TestType::create(["name" => "Glucose","test_type_category_id" => $testTypeCategoryMicrobiology->id,]);
        $testTypeKetones = TestType::create(["name" => "Ketones","test_type_category_id" => $testTypeCategoryMicrobiology->id,]);
        $testTypeLeukocytes = TestType::create(["name" => "Leukocytes","test_type_category_id" => $testTypeCategoryMicrobiology->id,]);
        $testTypeMicroscopy = TestType::create(["name" => "Microscopy","test_type_category_id" => $testTypeCategoryMicrobiology->id,]);
        $testTypeNitrite = TestType::create(["name" => "Nitrite","test_type_category_id" => $testTypeCategoryMicrobiology->id,]);
        $testTypePH = TestType::create(["name" => "pH","test_type_category_id" => $testTypeCategoryMicrobiology->id,]);
        // $testTypeProtein = TestType::create(["name" => "Protein","test_type_category_id" => $testTypeCategoryMicrobiology->id,]);
        $testTypeSpecificGravity = TestType::create(["name" => "Specific Gravity","test_type_category_id" => $testTypeCategoryMicrobiology->id,]);
        $testTypeUrobilinogen = TestType::create(["name" => "Urobilinogen","test_type_category_id" => $testTypeCategoryMicrobiology->id,]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeUrine->id,
            "test_type_id" => $testTypeHCG->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeUrine->id,
            "test_type_id" => $testTypeBilirubin->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeUrine->id,
            "test_type_id" => $testTypeBlood->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeUrine->id,
            "test_type_id" => $testTypeGlucose->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeUrine->id,
            "test_type_id" => $testTypeKetones->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeUrine->id,
            "test_type_id" => $testTypeLeukocytes->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeUrine->id,
            "test_type_id" => $testTypeMicroscopy->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeUrine->id,
            "test_type_id" => $testTypeNitrite->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeUrine->id,
            "test_type_id" => $testTypePH->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeUrine->id,
            "test_type_id" => $testTypeProtein->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeUrine->id,
            "test_type_id" => $testTypeSpecificGravity->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeUrine->id,
            "test_type_id" => $testTypeUrobilinogen->id
        ]);

        $measureHCG  = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeHCG->id,
            "name" => "HCG",
            "unit" => ""]);
        $measureBilirubin  = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeBilirubin->id,
            "name" => "Bilirubin",
            "unit" => ""]);
        $measureBlood  = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeBlood->id,
            "name" => "Blood",
            "unit" => ""]);
        $measureGlucose  = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeGlucose->id,
            "name" => "Glucose",
            "unit" => ""]);
        $measureKetones  = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeKetones->id,
            "name" => "Ketones",
            "unit" => ""]);
        $measureLeukocytes  = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeLeukocytes->id,
            "name" => "Leukocytes",
            "unit" => ""]);
        $measureMicroscopy  = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeMicroscopy->id,
            "name" => "Microscopy",
            "unit" => ""]);
        $measureNitrite  = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeNitrite->id,
            "name" => "Nitrite",
            "unit" => ""]);
        $measurePH  = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypePH->id,
            "name" => "pH",
            "unit" => ""]);
        $measureProtein  = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeProtein->id,
            "name" => "Protein",
            "unit" => ""]);
        $measureSpecificGravity  = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeSpecificGravity->id,
            "name" => "Specific Gravity",
            "unit" => ""]);
        $measureUrobilinogen  = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeUrobilinogen->id,
            "name" => "Urobilinogen",
            "unit" => ""]);

        /* Measures table */
        $measureAppearance = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeAppearance->id,
            "name" => "Appearance", "unit" => ""]);
        $measureCultureAndSensitivity = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeCultureAndSensitivity->id,
            "name" => "Culture and Sensitivity"]);
        $measureGramStaining = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeGramStaining->id,
            "name" => "Gram Staining", 'unit' => '']);
        $measureIndiaInkStaining = Measure::create([
            "measure_type_id" => "2",
            "test_type_id" => $testTypeIndiaInkStaining->id,
            "name" => "India Ink Staining"
        ]);
        MeasureRange::create(["measure_id" => $measureIndiaInkStaining->id, "display" => "Positive"]);
        MeasureRange::create(["measure_id" => $measureIndiaInkStaining->id, "display" => "Negative"]);

        $measureProtein = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeProtein->id,
            "name" => "Protein",
        ]);
        $measureWetPreparation = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeWetPreparation->id,
            "name" => "Wet preparation (saline preparation)",
        ]);
        $measureWhiteBloodCellCount = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeWhiteBloodCellCount->id,
            "name" => "White Blood Cell Count",
        ]);
        $measureZNStaining = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeZNStaining->id,
            "name" => "ZN Staining",
        ]);
        $measureModifiedZn = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeModifiedZn->id,
            "name" => "Modified ZN", "unit" => "",
        ]);

        $measureWetSalineIodinePrep = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeWetSalineIodinePrep->id,
            "name" => "Wet Saline Iodine Prep", "unit" => "",
        ]);
        $measureSerumAmylase = Measure::create([
            "measure_type_id" => "2",
            "test_type_id" => $testTypeSerumAmylase->id,
            "name" => "SERUM AMYLASE", "unit" => "",
        ]);
        $measureCalcium = Measure::create([
            "measure_type_id" => "2",
            "test_type_id" => $testTypeCulcium->id,
            "name" => "calcium", "unit" => "",
        ]);
        $measureSGOT = Measure::create([
            "measure_type_id" => "2",
            "test_type_id" => $testTypeSGOT->id,
            "name" => "SGOT", "unit" => "",
        ]);
        $measureIndirectCOOMBSTest = Measure::create([
            "measure_type_id" => "2",
            "test_type_id" => $testTypeIndirectCOOMBSTest->id,
            "name" => "Indirect COOMBS test", "unit" => "",
        ]);
        $measureDirectCOOMBSTest = Measure::create([
            "measure_type_id" => "2",
            "test_type_id" => $testTypeDirectCOOMBSTest->id,
            "name" => "Direct COOMBS test", "unit" => "",
        ]);
        $measureDuTest = Measure::create([
            "measure_type_id" => "2",
            "test_type_id" => $testTypeDuTest->id,
            "name" => "Du test", "unit" => "",
        ]);

        MeasureRange::create(["measure_id" => $measureSerumAmylase->id, "display" => "Low"]);
        MeasureRange::create(["measure_id" => $measureSerumAmylase->id, "display" => "High"]);
        MeasureRange::create(["measure_id" => $measureSerumAmylase->id, "display" => "Normal"]);

        MeasureRange::create(["measure_id" => $measureCalcium->id, "display" => "High"]);
        MeasureRange::create(["measure_id" => $measureCalcium->id, "display" => "Low"]);
        MeasureRange::create(["measure_id" => $measureCalcium->id, "display" => "Normal"]);

        MeasureRange::create(["measure_id" => $measureSGOT->id, "display" => "High"]);
        MeasureRange::create(["measure_id" => $measureSGOT->id, "display" => "Low"]);
        MeasureRange::create(["measure_id" => $measureSGOT->id, "display" => "Normal"]);

        MeasureRange::create(["measure_id" => $measureIndirectCOOMBSTest->id, "display" => "Positive"]);
        MeasureRange::create(["measure_id" => $measureIndirectCOOMBSTest->id, "display" => "Negative"]);

        MeasureRange::create(["measure_id" => $measureDirectCOOMBSTest->id, "display" => "Positive"]);
        MeasureRange::create(["measure_id" => $measureDirectCOOMBSTest->id, "display" => "Negative"]);

        MeasureRange::create(["measure_id" => $measureDuTest->id, "display" => "Positive"]);
        MeasureRange::create(["measure_id" => $measureDuTest->id, "display" => "Negative"]);

        $this->command->info("Measures seeded");

        // test type specimen types
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeStool->id,
            "test_type_id" => $testTypeCultureAndSensitivity->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeStool->id,
            "test_type_id" => $testTypeAppearance->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeStool->id,
            "test_type_id" => $testTypeModifiedZn->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeUrine->id,
            "test_type_id" => $testTypeCultureAndSensitivity->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeUrine->id,
            "test_type_id" => $testTypeAppearance->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeCSF->id,
            "test_type_id" => $testTypeAppearance->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeCSF->id,
            "test_type_id" => $testTypeProtein->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeCSF->id,
            "test_type_id" => $testTypeIndiaInkStaining->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeCSF->id,
            "test_type_id" => $testTypeWhiteBloodCellCount->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeCSF->id,
            "test_type_id" => $testTypeGramStaining->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeCSF->id,
            "test_type_id" => $testTypeZNStaining->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeCSF->id,
            "test_type_id" => $testTypeCultureAndSensitivity->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeCSF->id,
            "test_type_id" => $testTypeCrag->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeCSF->id,
            "test_type_id" => $testTypeDifferential->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeCSF->id,
            "test_type_id" => $testTypeTotalCellCount->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeCSF->id,
            "test_type_id" => $testTypeLymphocytes->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeCSF->id,
            "test_type_id" => $testTypeTPHA->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeCSF->id,
            "test_type_id" => $testTypeQuantitativeCulture->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeCSF->id,
            "test_type_id" => $testTypeRBC->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypePusSwab->id,
            "test_type_id" => $testTypeGramStaining->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypePusSwab->id,
            "test_type_id" => $testTypeAppearance->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypePusSwab->id,
            "test_type_id" => $testTypeZNStaining->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypePusSwab->id,
            "test_type_id" => $testTypeCultureAndSensitivity->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeWoundSwab->id,
            "test_type_id" => $testTypeGramStaining->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeWoundSwab->id,
            "test_type_id" => $testTypeAppearance->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeWoundSwab->id,
            "test_type_id" => $testTypeZNStaining->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeWoundSwab->id,
            "test_type_id" => $testTypeCultureAndSensitivity->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeUretheralSwab->id,
            "test_type_id" => $testTypeWetPreparation->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeUretheralSwab->id,
            "test_type_id" => $testTypeAppearance->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeUretheralSwab->id,
            "test_type_id" => $testTypeGramStaining->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeUretheralSwab->id,
            "test_type_id" => $testTypeCultureAndSensitivity->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeHVS->id,
            "test_type_id" => $testTypeWetPreparation->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeHVS->id,
            "test_type_id" => $testTypeAppearance->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeHVS->id,
            "test_type_id" => $testTypeGramStaining->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeHVS->id,
            "test_type_id" => $testTypeCultureAndSensitivity->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeEyeSwab->id,
            "test_type_id" => $testTypeGramStaining->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeEyeSwab->id,
            "test_type_id" => $testTypeCultureAndSensitivity->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeEyeSwab->id,
            "test_type_id" => $testTypeAppearance->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeEarSwab->id,
            "test_type_id" => $testTypeAppearance->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeEarSwab->id,
            "test_type_id" => $testTypeGramStaining->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeEarSwab->id,
            "test_type_id" => $testTypeCultureAndSensitivity->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeThroatSwab->id,
            "test_type_id" => $testTypeAppearance->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeThroatSwab->id,
            "test_type_id" => $testTypeGramStaining->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeThroatSwab->id,
            "test_type_id" => $testTypeCultureAndSensitivity->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeAspirates->id,
            "test_type_id" => $testTypeProtein->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeAspirates->id,
            "test_type_id" => $testTypeGramStaining->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeAspirates->id,
            "test_type_id" => $testTypeAppearance->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeAspirates->id,
            "test_type_id" => $testTypeZNStaining->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeAspirates->id,
            "test_type_id" => $testTypeCultureAndSensitivity->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeBAL->id,
            "test_type_id" => $testTypeAppearance->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeBAL->id,
            "test_type_id" => $testTypeGramStaining->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeBAL->id,
            "test_type_id" => $testTypeZNStaining->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeBAL->id,
            "test_type_id" => $testTypeCultureAndSensitivity->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeSputum->id,
            "test_type_id" => $testTypeZNStaining->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeSputum->id,
            "test_type_id" => $testTypeAppearance->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeSputum->id,
            "test_type_id" => $testTypeGramStaining->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeSputum->id,
            "test_type_id" => $testTypeCultureAndSensitivity->id
        ]);
        $this->command->info("test_type_mappings seeded");

        $testTypeRPR = TestType::create(['name' => 'RPR','test_type_category_id' => $testTypeCategoryMicrobiology->id,]);
        $testTypeSerumCrag = TestType::create(['name' => 'Serum Crag','test_type_category_id' => $testTypeCategoryMicrobiology->id,]);

        $measureRPR = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeRPR->id,
            "name" => "RPR", "unit" => ""]);
        $measureSerumCrag = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeSerumCrag->id,
            "name" => "Serum Crag", "unit" => ""]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeBlood->id,
            "test_type_id" => $testTypeRPR->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeBlood->id,
            "test_type_id" => $testTypeSerumCrag->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeBlood->id,
            "test_type_id" => $testTypeTPHA->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeBlood->id,
            "test_type_id" => $testTypeCultureAndSensitivity->id
        ]);
        $this->command->info("more blood associated type types and measures seeded");
    }
}
