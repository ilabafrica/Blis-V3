<?php

use App\User;
use App\Models\Role;
use App\Models\Test;
use App\Models\Gender;
use App\Models\Patient;
use App\Models\Measure;
use App\Models\TestType;
use App\Models\TestPhase;
use App\Models\TestStatus;
use App\Models\Antibiotic;
use App\Models\Interpretation;
use App\Models\Instrument;
use App\Models\MeasureType;
use App\Models\MeasureRange;
use App\Models\SpecimenType;
use App\Models\Organization;
use App\Models\SpecimenStatus;
use App\Models\ReferralReason;
use App\Models\TestTypeCategory;
use App\Models\GramStainRange;
use App\Models\RejectionReason;
use App\Models\SusceptibilityBreakPoint;
use ILabAfrica\EquipmentInterface\InstrumentMapping;
use ILabAfrica\EquipmentInterface\InstrumentParameters;

use Illuminate\Support\Str;
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
        $organizations = [
          ["name" => "Coolest Clinic in Town", "created_by" => 1],
          ["name" => "iLabAfrica Fantasy Hospital", "created_by" => 1],
        ];
        foreach ($organizations as $organization)
        {
            Organization::create($organization);
        }
        $this->command->info("rejection_reasons seeded");

        $rejection_reasons_array = [
          ["display" => "Inadequate sample volume"],
          ["display" => "Haemolysed sample"],
          ["display" => "Specimen without lab request form"],
          ["display" => "No test ordered on  lab request form of sample"],
          ["display" => "No sample label or identifier"],
          ["display" => "Wrong sample label"],
          ["display" => "Unclear sample label"],
          ["display" => "Sample in wrong container"],
          ["display" => "Damaged/broken/leaking sample container"],
          ["display" => "Too old sample"],
          ["display" => "Date of sample collection not specified"],
          ["display" => "Time of sample collection not specified"],
          ["display" => "Improper transport media"],
          ["display" => "Sample type unacceptable for required test"],
          ["display" => "Other"],
        ];
        foreach ($rejection_reasons_array as $rejection_reason)
        {
            RejectionReason::create($rejection_reason);
        }
        $this->command->info("rejection_reasons seeded");

        $referralReasons = [
          ["display" => "QA"],
          ["display" => "Relayed"],
          ["display" => "Beyond Facility"],
        ];
        foreach ($referralReasons as $referralReason)
        {
            ReferralReason::create($referralReason);
        }
        $this->command->info("referral reasons seeded");

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

        \DB::table('test_type_mappings')->insert(
            ["test_type_id" => $testTypeUrinalysis->id, "specimen_type_id" => $specimenTypeUrine->id]);

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

        foreach($measureHIV as $measure){
            $id = Measure::create($measure)->id;
            MeasureRange::create(["measure_id" => $id, "display" => "Reactive"]);
            MeasureRange::create(["measure_id" => $id, "display" => "Non Reactive"]);
        }

        $measureBSforMPS = Measure::create([
            "measure_type_id" => "2",
            "test_type_id" => $testTypeBS->id,
            "name" => "BS for mps",
            "unit" => ""]);



        $positive = Interpretation::create([
            "code" => 'positive',
            "name" => "Positive",
        ]);
        $negative = Interpretation::create([
            "code" => 'negative',
            "name" => "Negative",
        ]);

        MeasureRange::create([
            "measure_id" => $measureBSforMPS->id,
            "display" => "No mps seen",
            "interpretation_id" => $negative->id,
        ]);
        MeasureRange::create([
            "measure_id" => $measureBSforMPS->id,
            "display" => "+",
            "interpretation_id" => $positive->id,
        ]);
        MeasureRange::create([
            "measure_id" => $measureBSforMPS->id,
            "display" => "++",
            "interpretation_id" => $positive->id,
        ]);
        MeasureRange::create([
            "measure_id" => $measureBSforMPS->id,

            "display" => "+++",
            "interpretation_id" => $positive->id,
        ]);

        /* test_type_mappings table */
        \DB::table('test_type_mappings')->insert(
            ["test_type_id" => $testTypeHIV->id, "specimen_type_id" => $specimenTypeBlood->id]);
        \DB::table('test_type_mappings')->insert(
            ["test_type_id" => $testTypeBS->id, "specimen_type_id" => $specimenTypeBlood->id]);
        \DB::table('test_type_mappings')->insert(
            ["test_type_id" => $testTypeGXM->id, "specimen_type_id" => $specimenTypeBlood->id]);
        \DB::table('test_type_mappings')->insert(
            ["test_type_id" => $testTypeWBC->id, "specimen_type_id" => $specimenTypeBlood->id]);

        $this->command->info("Test Type Mappings Seeded");

        /* Instruments table */
        $instrument_celltac = Instrument::create(["name" => "celltac_f_mek_8222", "ip" => "192.168.1.12", "hostname" => "HEMASERVER"]);
        $instrument_sysmex_xs_1000i = Instrument::create(["name" => "sysmex_xs_1000i", "ip" => "192.168.1.13", "hostname" => "HEMASERVER"]);
        $instrument_genexpert = Instrument::create(["name" => "genexpert", "ip" => "192.168.1.14", "hostname" => "HEMASERVER"]);
        $instrument_sysmex_poch_100i = Instrument::create(["name" => "sysmex_poch_100i", "ip" => "192.168.1.15", "hostname" => "HEMASERVER"]);
        $instrument_humacount_60ts = Instrument::create(["name" => "humacount_60ts", "ip" => "192.168.1.16", "hostname" => "HEMASERVER"]);

        $this->command->info("Instruments table seeded");

        /* Instrument Mapping table */
        $instrument_mapping_celltac = InstrumentMapping::create(["instrument_id" => $instrument_celltac->id, "test_type_id" => $testTypeHIV->id]);
        $instrument_mapping_sysmex_xs_1000i = InstrumentMapping::create(["instrument_id" => $instrument_sysmex_xs_1000i->id, "test_type_id" => $testTypeWBC->id]);
        $instrument_mapping_genexpert = InstrumentMapping::create(["instrument_id" => $instrument_genexpert->id, "test_type_id" => $testTypeWBC->id]);
        $instrument_mapping_sysmex_poch_100i = InstrumentMapping::create(["instrument_id" => $instrument_sysmex_poch_100i->id, "test_type_id" => $testTypeWBC->id]);
        $instrument_mapping_humacount_60ts = InstrumentMapping::create(["instrument_id" => $instrument_humacount_60ts->id, "test_type_id" => $testTypeWBC->id]);

        $this->command->info("Instrument Mappings table seeded");

        

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

        /* Instrument Parameters table */
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 1]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_direct->id, "sub_test_id" => 2]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_du->id, "sub_test_id" => 3]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_sickling->id, "sub_test_id" => 4]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_borrelia->id, "sub_test_id" => 5]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_vdrl->id, "sub_test_id" => 6]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_pregnancy->id, "sub_test_id" => 7]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_brucella->id, "sub_test_id" => 8]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_pylori->id, "sub_test_id" => 9]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_pylori->id, "sub_test_id" => 10]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_brucella->id, "sub_test_id" => 11]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_pregnancy->id, "sub_test_id" => 12]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_vdrl->id, "sub_test_id" => 13]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_borrelia->id, "sub_test_id" => 14]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_sickling->id, "sub_test_id" => 15]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_du->id, "sub_test_id" => 16]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_direct->id, "sub_test_id" => 17]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 18]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_direct->id, "sub_test_id" => 19]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_du->id, "sub_test_id" => 20]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_sickling->id, "sub_test_id" => 21]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_borrelia->id, "sub_test_id" => 22]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_vdrl->id, "sub_test_id" => 23]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_xs_1000i->id, "measure_id" => $measure_pregnancy->id, "sub_test_id" => 24]);

        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 1]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_direct->id, "sub_test_id" => 2]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_du->id, "sub_test_id" => 3]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_sickling->id, "sub_test_id" => 4]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_borrelia->id, "sub_test_id" => 5]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_vdrl->id, "sub_test_id" => 6]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_pregnancy->id, "sub_test_id" => 7]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_brucella->id, "sub_test_id" => 8]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_pylori->id, "sub_test_id" => 9]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_pylori->id, "sub_test_id" => 10]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_brucella->id, "sub_test_id" => 11]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_pregnancy->id, "sub_test_id" => 12]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_vdrl->id, "sub_test_id" => 13]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_borrelia->id, "sub_test_id" => 14]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_sickling->id, "sub_test_id" => 15]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_du->id, "sub_test_id" => 16]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_direct->id, "sub_test_id" => 17]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 18]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_direct->id, "sub_test_id" => 19]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_du->id, "sub_test_id" => 20]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_sickling->id, "sub_test_id" => 21]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_borrelia->id, "sub_test_id" => 22]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_vdrl->id, "sub_test_id" => 23]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_pregnancy->id, "sub_test_id" => 24]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 25]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_direct->id, "sub_test_id" => 26]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_du->id, "sub_test_id" => 27]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_sickling->id, "sub_test_id" => 28]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_borrelia->id, "sub_test_id" => 29]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_vdrl->id, "sub_test_id" => 30]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_pregnancy->id, "sub_test_id" => 31]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_brucella->id, "sub_test_id" => 32]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_pylori->id, "sub_test_id" => 33]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_pylori->id, "sub_test_id" => 34]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_brucella->id, "sub_test_id" => 35]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_pregnancy->id, "sub_test_id" => 36]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_vdrl->id, "sub_test_id" => 37]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_borrelia->id, "sub_test_id" => 38]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_sickling->id, "sub_test_id" => 39]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_du->id, "sub_test_id" => 40]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_direct->id, "sub_test_id" => 41]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 42]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_direct->id, "sub_test_id" => 43]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_direct->id, "sub_test_id" => 44]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_genexpert->id, "measure_id" => $measure_direct->id, "sub_test_id" => 45]);

        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_poch_100i->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 67]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_poch_100i->id, "measure_id" => $measure_direct->id, "sub_test_id" => 68]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_poch_100i->id, "measure_id" => $measure_du->id, "sub_test_id" => 69]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_poch_100i->id, "measure_id" => $measure_sickling->id, "sub_test_id" => 70]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_poch_100i->id, "measure_id" => $measure_borrelia->id, "sub_test_id" => 71]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_poch_100i->id, "measure_id" => $measure_vdrl->id, "sub_test_id" => 72]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_poch_100i->id, "measure_id" => $measure_pregnancy->id, "sub_test_id" => 73]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_poch_100i->id, "measure_id" => $measure_brucella->id, "sub_test_id" => 74]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_poch_100i->id, "measure_id" => $measure_pylori->id, "sub_test_id" => 86]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_poch_100i->id, "measure_id" => $measure_pylori->id, "sub_test_id" => 87]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_poch_100i->id, "measure_id" => $measure_brucella->id, "sub_test_id" => 88]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_poch_100i->id, "measure_id" => $measure_pregnancy->id, "sub_test_id" => 89]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_poch_100i->id, "measure_id" => $measure_vdrl->id, "sub_test_id" => 90]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_poch_100i->id, "measure_id" => $measure_borrelia->id, "sub_test_id" => 81]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_poch_100i->id, "measure_id" => $measure_sickling->id, "sub_test_id" => 82]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_poch_100i->id, "measure_id" => $measure_du->id, "sub_test_id" => 83]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_sysmex_poch_100i->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 84]);

        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_humacount_60ts->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 67]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_humacount_60ts->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 82]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_humacount_60ts->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 83]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_humacount_60ts->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 87]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_humacount_60ts->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 88]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_humacount_60ts->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 68]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_humacount_60ts->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 69]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_humacount_60ts->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 70]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_humacount_60ts->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 73]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_humacount_60ts->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 81]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_humacount_60ts->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 77]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_humacount_60ts->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 74]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_humacount_60ts->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 84]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_humacount_60ts->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 85]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_humacount_60ts->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 76]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_humacount_60ts->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 75]);
        InstrumentParameters::create(["instrument_mapping_id" => $instrument_mapping_humacount_60ts->id, "measure_id" => $measure_salmonella->id, "sub_test_id" => 79]);

        $this->command->info("Instrument Parameters table seeded");

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
            "culture" => 1,
            "test_type_category_id" => $testTypeCategoryMicrobiology->id
        ]);
        $testTypeGramStain = TestType::create([
            "name" => "Gram Stain",
            "test_type_category_id" => $testTypeCategoryMicrobiology->id
        ]);
        $testTypeIndiaInkStain = TestType::create([
            "name" => "India Ink Stain",
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
        $testTypeZNStain = TestType::create([
            "name" => "ZN Stain",
            "test_type_category_id" => $testTypeCategoryMicrobiology->id
        ]);
        $testTypeModifiedZn = TestType::create([
            'name' => 'Modified ZN',
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
            "name" => "Organisms Isolated"]);
        $measureGramStain = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeGramStain->id,
            "name" => "Gram Stain", 'unit' => '']);
        $measureIndiaInkStain = Measure::create([
            "measure_type_id" => "2",
            "test_type_id" => $testTypeIndiaInkStain->id,
            "name" => "India Ink Stain"
        ]);
        MeasureRange::create(["measure_id" => $measureIndiaInkStain->id, "display" => "Positive"]);
        MeasureRange::create(["measure_id" => $measureIndiaInkStain->id, "display" => "Negative"]);

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
        $measureZNStain = Measure::create([
            "measure_type_id" => "4",
            "test_type_id" => $testTypeZNStain->id,
            "name" => "ZN Stain",
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
            "test_type_id" => $testTypeIndiaInkStain->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeCSF->id,
            "test_type_id" => $testTypeWhiteBloodCellCount->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeCSF->id,
            "test_type_id" => $testTypeGramStain->id
        ]);
        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeCSF->id,
            "test_type_id" => $testTypeZNStain->id
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
            "test_type_id" => $testTypeGramStain->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypePusSwab->id,
            "test_type_id" => $testTypeAppearance->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypePusSwab->id,
            "test_type_id" => $testTypeZNStain->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypePusSwab->id,
            "test_type_id" => $testTypeCultureAndSensitivity->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeWoundSwab->id,
            "test_type_id" => $testTypeGramStain->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeWoundSwab->id,
            "test_type_id" => $testTypeAppearance->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeWoundSwab->id,
            "test_type_id" => $testTypeZNStain->id
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
            "test_type_id" => $testTypeWetSalineIodinePrep->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeUretheralSwab->id,
            "test_type_id" => $testTypeAppearance->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeUretheralSwab->id,
            "test_type_id" => $testTypeGramStain->id
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
            "test_type_id" => $testTypeGramStain->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeHVS->id,
            "test_type_id" => $testTypeCultureAndSensitivity->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeEyeSwab->id,
            "test_type_id" => $testTypeGramStain->id
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
            "test_type_id" => $testTypeGramStain->id
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
            "test_type_id" => $testTypeGramStain->id
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
            "test_type_id" => $testTypeGramStain->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeAspirates->id,
            "test_type_id" => $testTypeAppearance->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeAspirates->id,
            "test_type_id" => $testTypeZNStain->id
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
            "test_type_id" => $testTypeGramStain->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeBAL->id,
            "test_type_id" => $testTypeZNStain->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeBAL->id,
            "test_type_id" => $testTypeCultureAndSensitivity->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeSputum->id,
            "test_type_id" => $testTypeZNStain->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeSputum->id,
            "test_type_id" => $testTypeAppearance->id
        ]);

        \DB::table('test_type_mappings')->insert([
            "specimen_type_id" => $specimenTypeSputum->id,
            "test_type_id" => $testTypeGramStain->id
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

        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "No organism seen",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "Gram positive cocci in singles",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "Gram positive cocci in chains",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "Gram positive cocci in clusters",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "Gram positive diplococci",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "Gram positive micrococci",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "Gram positive rods",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "Gram positive rods with terminal spores",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "Gram positive rods with sub-terminal spores",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "Gram positive rods with endospores",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "Gram negative diplococci",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "Gram negative intracellular diplococci",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "Gram negative extracellular diplococci",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "Gram negative rods",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "Gram positive yeast cells",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "Gram negative pleomorphic rods",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+ Gram positive cocci in singles",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+ Gram positive cocci in chains",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+ Gram positive cocci in clusters",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+ Gram positive diplococci",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+ Gram positive micrococci",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+ Gram positive rods",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+ Gram positive rods with terminal spores",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+ Gram positive rods with sub-terminal spores",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+ Gram positive rods with endospores",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+ Gram negative diplococci",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+ Gram negative intracellular diplococci",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+ Gram negative extracellular diplococci",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+ Gram negative rods",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+ Gram positive yeast cells",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+ Gram negative pleomorphic rods",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "++ Gram positive cocci in singles",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "++ Gram positive cocci in chains",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "++ Gram positive cocci in clusters",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "++ Gram positive diplococci",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "++ Gram positive micrococci",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "++ Gram positive rods",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "++ Gram positive rods with terminal spores",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "++ Gram positive rods with sub-terminal spores",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "++ Gram positive rods with endospores",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "++ Gram negative diplococci",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "++ Gram negative intracellular diplococci",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "++ Gram negative extracellular diplococci",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "++ Gram negative rods",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "++ Gram positive yeast cells",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "++ Gram negative pleomorphic rods",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+++ Gram positive cocci in singles",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+++ Gram positive cocci in chains",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+++ Gram positive cocci in clusters",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+++ Gram positive diplococci",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+++ Gram positive micrococci",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+++ Gram positive rods",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+++ Gram positive rods with terminal spores",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+++ Gram positive rods with sub-terminal spores",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+++ Gram positive rods with endospores",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+++ Gram negative diplococci",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+++ Gram negative intracellular diplococci",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+++ Gram negative extracellular diplococci",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+++ Gram negative rods",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+++ Gram positive yeast cells",
        ]);
        MeasureRange::create([
            "measure_id" => $measureGramStain->id,
            "display" => "+++ Gram negative pleomorphic rods",
        ]);
        $this->command->info("Gram Stain Measure Ranges");

        $antibiotic1 = Antibiotic::create(['name' => 'Amikacin']);
        $antibiotic2 = Antibiotic::create(['name' => 'Ampicillin']);
        $antibiotic3 = Antibiotic::create(['name' => 'Augmentin']);
        $antibiotic4 = Antibiotic::create(['name' => 'Cefotaxime']);
        $antibiotic5 = Antibiotic::create(['name' => 'Ceftazidime']);
        $antibiotic6 = Antibiotic::create(['name' => 'Ceftriaxone']);
        $antibiotic7 = Antibiotic::create(['name' => 'Ceftizoxime']);
        $antibiotic8 = Antibiotic::create(['name' => 'Cefuroxime']);
        $antibiotic9 = Antibiotic::create(['name' => 'Cefuroxime oral']);
        $antibiotic10 = Antibiotic::create(['name' => 'Chloramphenicol']);
        $antibiotic11 = Antibiotic::create(['name' => 'Ciprofloxacin']);
        $antibiotic12 = Antibiotic::create(['name' => 'Co-trimoxazole']);
        $antibiotic13 = Antibiotic::create(['name' => 'Gentamicin']);
        $antibiotic14 = Antibiotic::create(['name' => 'Imipenem']);
        $antibiotic15 = Antibiotic::create(['name' => 'Meropenem']);
        $antibiotic16 = Antibiotic::create(['name' => 'Nalidixic acid']);
        $antibiotic17 = Antibiotic::create(['name' => 'Peperacillintazobactam']);
        $antibiotic18 = Antibiotic::create(['name' => 'Piperacillin']);
        $antibiotic19 = Antibiotic::create(['name' => 'Nitrofurantoin']);
        $antibiotic20 = Antibiotic::create(['name' => 'Trimethoprim']);
        $antibiotic21 = Antibiotic::create(['name' => 'Amoxycillin']);
        $antibiotic22 = Antibiotic::create(['name' => 'Cefepime']);
        $antibiotic23 = Antibiotic::create(['name' => 'Colistin']);
        $antibiotic24 = Antibiotic::create(['name' => 'Tetracycline']);
        $antibiotic25 = Antibiotic::create(['name' => 'Erythromycin']);
        $antibiotic26 = Antibiotic::create(['name' => 'Clindamycin']);
        $antibiotic27 = Antibiotic::create(['name' => 'Vancomycin']);
        $antibiotic28 = Antibiotic::create(['name' => 'Linezolid']);
        $antibiotic29 = Antibiotic::create(['name' => 'Penicillin G']);
        $antibiotic30 = Antibiotic::create(['name' => 'Cefoxitin']);
        $antibiotic31 = Antibiotic::create(['name' => 'Rifampicin']);
        $antibiotic32 = Antibiotic::create(['name' => 'Streptomycin']);
        $antibiotic33 = Antibiotic::create(['name' => 'Minocycline']);
        $antibiotic34 = Antibiotic::create(['name' => 'Cefexime']);
        $antibiotic35 = Antibiotic::create(['name' => 'spectinomycin']);
        $antibiotic36 = Antibiotic::create(['name' => 'Oxacillin']);
        $antibiotic37 = Antibiotic::create(['name' => 'Levofloxacin']);
        $antibiotic38 = Antibiotic::create(['name' => 'Cefuroxime Parentral']);
        $antibiotic39 = Antibiotic::create(['name' => 'High level Gentamicin']);

        $this->command->info("Antibiotics Seeded");

        $organismMeasureRange1= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Pseudomonas aeruginosa',
        ]);
        $organismMeasureRange2= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Escherichia coli',
        ]);
        $organismMeasureRange3= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Enterobacteriacae',
        ]);
        $organismMeasureRange5= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Pseudomonas flourescens',
        ]);
        $organismMeasureRange6= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Pseudomonas spp',
        ]);
        $organismMeasureRange12= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Acinetobacter spp',
        ]);
        $organismMeasureRange13= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Acinetobacter baumannii',
        ]);
        $organismMeasureRange16= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Salmonella spp',
        ]);
        $organismMeasureRange17= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Salmonella typhi',
        ]);
        $organismMeasureRange18= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Salmonella paratyphi B',
        ]);
        $organismMeasureRange19= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Salmonella choleraesuis',
        ]);
        $organismMeasureRange20= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Vibrio cholerae',
        ]);
        $organismMeasureRange21= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Viridans streptococcus',
        ]);
        $organismMeasureRange23= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Staphylococcus aureus',
        ]);
        $organismMeasureRange24= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Staphylococcus epidermidis',
        ]);
        $organismMeasureRange25= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Staphylococcus spp',
        ]);
        $organismMeasureRange29= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Staphylococcus horminis',
        ]);
        $organismMeasureRange30= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Staphylococcus pasteuri.',
        ]);
        $organismMeasureRange31= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Staphylococcus saprophyticus',
        ]);
        $organismMeasureRange32= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Enterobacter spp',
        ]);
        $organismMeasureRange33= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Enterobacter cloacae',
        ]);
        $organismMeasureRange34= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Enterococcus spp',
        ]);
        $organismMeasureRange35= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Enterococcus feacalis',
        ]);
        $organismMeasureRange36= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Streptococcus spp',
        ]);
        $organismMeasureRange37= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Burkholderia cepacia',
        ]);
        $organismMeasureRange38= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Burkholderia mallei',
        ]);
        $organismMeasureRange39= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Burkholderia pseudomallei',
        ]);
        $organismMeasureRange40= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Neisseria spp',
        ]);
        $organismMeasureRange41= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Neisseria gonorrhae',
        ]);
        $organismMeasureRange42= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Neisseria gonorrhoeae',
        ]);
        $organismMeasureRange43= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Neisseria meningitidis',
        ]);
        $organismMeasureRange44= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Haemophilus spp',
        ]);
        $organismMeasureRange45= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Haemophilus influenzae spp',
        ]);
        $organismMeasureRange46= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Haemophilus influenzae type B',
        ]);
        $organismMeasureRange48= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Haemophilus influenzae nontypaeble',
        ]);
        $organismMeasureRange52= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Haemophilus influenza',
        ]);
        $organismMeasureRange53= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Haemophilus ducreyi',
        ]);
        $organismMeasureRange54= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Haemophilus aphrophilus',
        ]);
        $organismMeasureRange55= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Haemophilus aegyptius',
        ]);
        $organismMeasureRange56= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Haemophilus parainfluenzae',
        ]);
        $organismMeasureRange61= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Streptococcus pneumoniae',
        ]);
        $organismMeasureRange67= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Enterobacter aerogenes',
        ]);
        $organismMeasureRange68= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Edwardsiella tarda',
        ]);
        $organismMeasureRange69= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Ehrlichia chaffeensis',
        ]);
        $organismMeasureRange71= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Eikenella corrodens',
        ]);
        $organismMeasureRange72= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Klebsiella pneumoniae',
        ]);
        $organismMeasureRange74= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Klebsiella oxytoca',
        ]);
        $organismMeasureRange75= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Kelbsiella spp',
        ]);
        $organismMeasureRange76= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Kingella kingae',
        ]);
        $organismMeasureRange77= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Proteus mirabilis',
        ]);
        $organismMeasureRange80= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Citrobacter freundii',
        ]);
        $organismMeasureRange81= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Citrobacter spp',
        ]);
        $organismMeasureRange83= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Providencia spp',
        ]);
        $organismMeasureRange84= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Proteus valgaris',
        ]);
        $organismMeasureRange87= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Providentia rettgeri',
        ]);
        $organismMeasureRange88= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Providentia stuartii',
        ]);
        $organismMeasureRange89= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Salmonella nontyphi group B',
        ]);
        $organismMeasureRange90= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Stenotrophomonas maltophilia',
        ]);
        $organismMeasureRange91= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Morganella morganii',
        ]);
        $organismMeasureRange95= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Morganella spp',
        ]);
        $organismMeasureRange96= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Salmonella paratyphi A',
        ]);
        $organismMeasureRange97= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Enterrococcus faecium',
        ]);
        $organismMeasureRange98= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Shigella boydii',
        ]);
        $organismMeasureRange99= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Shigella dysenteriae',
        ]);
        $organismMeasureRange100= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Shigella flexneri',
        ]);
        $organismMeasureRange101= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Shigella sonnei',
        ]);
        $organismMeasureRange102= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Streptococcus pyogenes',
        ]);
        $organismMeasureRange103= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Streptococcus pyogenes (Group A Strep)',
        ]);
        $organismMeasureRange107= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Streptococcus salivarius',
        ]);
        $organismMeasureRange108= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Streptococcus sanguis',
        ]);
        $organismMeasureRange109= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Salmonella group B',
        ]);
        $organismMeasureRange110= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Moraxella spp',
        ]);
        $organismMeasureRange111= MeasureRange::create([
            'measure_id' => $measureCultureAndSensitivity->id,
            'display' => 'Coagulase-negative Staphylococcus',
        ]);
        $this->command->info("Organisms Seeded");

        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic1->id,
            'measure_range_id' => $organismMeasureRange1->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange2->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic3->id,
            'measure_range_id' => $organismMeasureRange2->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic4->id,
            'measure_range_id' => $organismMeasureRange2->id,
            'resistant_max' => '22.0',
            'intermediate_min' => '23.0',
            'intermediate_max' => '25.0',
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange2->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange2->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic7->id,
            'measure_range_id' => $organismMeasureRange2->id,
            'resistant_max' => '22.0',
            'intermediate_min' => '23.0',
            'intermediate_max' => '25.0',
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange2->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic9->id,
            'measure_range_id' => $organismMeasureRange2->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange2->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange2->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange2->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange2->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange2->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange2->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange2->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange2->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange2->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange2->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange2->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange3->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange3->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic9->id,
            'measure_range_id' => $organismMeasureRange3->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic21->id,
            'measure_range_id' => $organismMeasureRange3->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange3->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange3->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange3->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange3->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange3->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic7->id,
            'measure_range_id' => $organismMeasureRange3->id,
            'resistant_max' => '22.0',
            'intermediate_min' => '23.0',
            'intermediate_max' => '25.0',
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange3->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange3->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '25.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange3->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange3->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange3->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange3->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange3->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange1->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange1->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange1->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange1->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange1->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange1->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange1->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange1->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic23->id,
            'measure_range_id' => $organismMeasureRange1->id,
            'resistant_max' => '10.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '12.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic1->id,
            'measure_range_id' => $organismMeasureRange5->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange5->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange5->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange5->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic23->id,
            'measure_range_id' => $organismMeasureRange5->id,
            'resistant_max' => '10.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '11.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange5->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange5->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange5->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange5->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange5->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic1->id,
            'measure_range_id' => $organismMeasureRange6->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange6->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange6->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange6->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic23->id,
            'measure_range_id' => $organismMeasureRange6->id,
            'resistant_max' => '10.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '11.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange6->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange6->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange6->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange6->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange6->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange12->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange12->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange12->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic1->id,
            'measure_range_id' => $organismMeasureRange12->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange12->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange12->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange12->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange12->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange12->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange12->id,
            'resistant_max' => '11.0',
            'intermediate_min' => '12.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange12->id,
            'resistant_max' => '18.0',
            'intermediate_min' => '19.0',
            'intermediate_max' => '21.0',
            'sensitive_min' => '22.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange12->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange13->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange13->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic1->id,
            'measure_range_id' => $organismMeasureRange13->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange13->id,
            'resistant_max' => '18.0',
            'intermediate_min' => '19.0',
            'intermediate_max' => '21.0',
            'sensitive_min' => '22.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange13->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange13->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange13->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange13->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange13->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange13->id,
            'resistant_max' => '11.0',
            'intermediate_min' => '12.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange13->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange13->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange16->id,
            'resistant_max' => '20.0',
            'intermediate_min' => '21.0',
            'intermediate_max' => '30.0',
            'sensitive_min' => '31.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange16->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange16->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange16->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange16->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange16->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange17->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange17->id,
            'resistant_max' => '20.0',
            'intermediate_min' => '21.0',
            'intermediate_max' => '30.0',
            'sensitive_min' => '31.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange17->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange17->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange17->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange17->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange18->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange18->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange18->id,
            'resistant_max' => '20.0',
            'intermediate_min' => '21.0',
            'intermediate_max' => '30.0',
            'sensitive_min' => '31.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange18->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange18->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange18->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange19->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange19->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange19->id,
            'resistant_max' => '20.0',
            'intermediate_min' => '21.0',
            'intermediate_max' => '30.0',
            'sensitive_min' => '31.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange19->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange19->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange19->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange20->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange20->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange20->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange20->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange21->id,
            'resistant_max' => '24.0',
            'intermediate_min' => '25.0',
            'intermediate_max' => '26.0',
            'sensitive_min' => '27.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic25->id,
            'measure_range_id' => $organismMeasureRange21->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic26->id,
            'measure_range_id' => $organismMeasureRange21->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange21->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic27->id,
            'measure_range_id' => $organismMeasureRange21->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic28->id,
            'measure_range_id' => $organismMeasureRange21->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange21->id,
            'resistant_max' => '18.0',
            'intermediate_min' => '19.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic1->id,
            'measure_range_id' => $organismMeasureRange23->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange23->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange23->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic25->id,
            'measure_range_id' => $organismMeasureRange23->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic26->id,
            'measure_range_id' => $organismMeasureRange23->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange23->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange23->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic28->id,
            'measure_range_id' => $organismMeasureRange23->id,
            'resistant_max' => '16.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic31->id,
            'measure_range_id' => $organismMeasureRange23->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange23->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange23->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic27->id,
            'measure_range_id' => $organismMeasureRange23->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic30->id,
            'measure_range_id' => $organismMeasureRange23->id,
            'resistant_max' => '21.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '22.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic29->id,
            'measure_range_id' => $organismMeasureRange23->id,
            'resistant_max' => '28.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '29.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic1->id,
            'measure_range_id' => $organismMeasureRange24->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic27->id,
            'measure_range_id' => $organismMeasureRange24->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange24->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic31->id,
            'measure_range_id' => $organismMeasureRange24->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange24->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic29->id,
            'measure_range_id' => $organismMeasureRange24->id,
            'resistant_max' => '28.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '29.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange24->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic28->id,
            'measure_range_id' => $organismMeasureRange24->id,
            'resistant_max' => '16.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange24->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic25->id,
            'measure_range_id' => $organismMeasureRange24->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic26->id,
            'measure_range_id' => $organismMeasureRange24->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange24->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange24->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic30->id,
            'measure_range_id' => $organismMeasureRange24->id,
            'resistant_max' => '21.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '22.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic28->id,
            'measure_range_id' => $organismMeasureRange25->id,
            'resistant_max' => '16.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic31->id,
            'measure_range_id' => $organismMeasureRange25->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange25->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic1->id,
            'measure_range_id' => $organismMeasureRange25->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange25->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange25->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange25->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange25->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange25->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic27->id,
            'measure_range_id' => $organismMeasureRange25->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic26->id,
            'measure_range_id' => $organismMeasureRange25->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic25->id,
            'measure_range_id' => $organismMeasureRange25->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic30->id,
            'measure_range_id' => $organismMeasureRange25->id,
            'resistant_max' => '21.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '22.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic29->id,
            'measure_range_id' => $organismMeasureRange25->id,
            'resistant_max' => '28.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '29.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic27->id,
            'measure_range_id' => $organismMeasureRange29->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange29->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange29->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic31->id,
            'measure_range_id' => $organismMeasureRange29->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic29->id,
            'measure_range_id' => $organismMeasureRange29->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange29->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic28->id,
            'measure_range_id' => $organismMeasureRange29->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange29->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic25->id,
            'measure_range_id' => $organismMeasureRange29->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic26->id,
            'measure_range_id' => $organismMeasureRange29->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange29->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange29->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic30->id,
            'measure_range_id' => $organismMeasureRange29->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic1->id,
            'measure_range_id' => $organismMeasureRange29->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic1->id,
            'measure_range_id' => $organismMeasureRange30->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic30->id,
            'measure_range_id' => $organismMeasureRange30->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic27->id,
            'measure_range_id' => $organismMeasureRange30->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange30->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange30->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic31->id,
            'measure_range_id' => $organismMeasureRange30->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic29->id,
            'measure_range_id' => $organismMeasureRange30->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange30->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic28->id,
            'measure_range_id' => $organismMeasureRange30->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange30->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic25->id,
            'measure_range_id' => $organismMeasureRange30->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic26->id,
            'measure_range_id' => $organismMeasureRange30->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange30->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange30->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic1->id,
            'measure_range_id' => $organismMeasureRange31->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic30->id,
            'measure_range_id' => $organismMeasureRange31->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic27->id,
            'measure_range_id' => $organismMeasureRange31->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange31->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange31->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic31->id,
            'measure_range_id' => $organismMeasureRange31->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic29->id,
            'measure_range_id' => $organismMeasureRange31->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange31->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic28->id,
            'measure_range_id' => $organismMeasureRange31->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange31->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic25->id,
            'measure_range_id' => $organismMeasureRange31->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic26->id,
            'measure_range_id' => $organismMeasureRange31->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange31->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange31->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange32->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange32->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange32->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange32->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange32->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange32->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange32->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange32->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange32->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange32->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange32->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange32->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange32->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic21->id,
            'measure_range_id' => $organismMeasureRange32->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange33->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange33->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange33->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange33->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange33->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange33->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange33->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange33->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange33->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange33->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange33->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange33->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange33->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '25.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange33->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic28->id,
            'measure_range_id' => $organismMeasureRange34->id,
            'resistant_max' => '20.0',
            'intermediate_min' => '21.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic31->id,
            'measure_range_id' => $organismMeasureRange34->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange34->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic32->id,
            'measure_range_id' => $organismMeasureRange34->id,
            'resistant_max' => '6.0',
            'intermediate_min' => '7.0',
            'intermediate_max' => '9.0',
            'sensitive_min' => '10.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange34->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange34->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic27->id,
            'measure_range_id' => $organismMeasureRange34->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange34->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic25->id,
            'measure_range_id' => $organismMeasureRange34->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic29->id,
            'measure_range_id' => $organismMeasureRange34->id,
            'resistant_max' => '14.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange34->id,
            'resistant_max' => '16.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic27->id,
            'measure_range_id' => $organismMeasureRange35->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange35->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic32->id,
            'measure_range_id' => $organismMeasureRange35->id,
            'resistant_max' => '6.0',
            'intermediate_min' => '7.0',
            'intermediate_max' => '9.0',
            'sensitive_min' => '10.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic31->id,
            'measure_range_id' => $organismMeasureRange35->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic29->id,
            'measure_range_id' => $organismMeasureRange35->id,
            'resistant_max' => '14.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange35->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic28->id,
            'measure_range_id' => $organismMeasureRange35->id,
            'resistant_max' => '20.0',
            'intermediate_min' => '21.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange35->id,
            'resistant_max' => '6.0',
            'intermediate_min' => '7.0',
            'intermediate_max' => '9.0',
            'sensitive_min' => '10.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic25->id,
            'measure_range_id' => $organismMeasureRange35->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange35->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange35->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange35->id,
            'resistant_max' => '16.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange36->id,
            'resistant_max' => '18.0',
            'intermediate_min' => '19.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic27->id,
            'measure_range_id' => $organismMeasureRange36->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange36->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic26->id,
            'measure_range_id' => $organismMeasureRange36->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic25->id,
            'measure_range_id' => $organismMeasureRange36->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange36->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '24.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange37->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange37->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic33->id,
            'measure_range_id' => $organismMeasureRange37->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange37->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange38->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange38->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic33->id,
            'measure_range_id' => $organismMeasureRange38->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange38->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange39->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange39->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic33->id,
            'measure_range_id' => $organismMeasureRange39->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange39->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange40->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '35.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic34->id,
            'measure_range_id' => $organismMeasureRange40->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '31.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange40->id,
            'resistant_max' => '27.0',
            'intermediate_min' => '28.0',
            'intermediate_max' => '40.0',
            'sensitive_min' => '41.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic29->id,
            'measure_range_id' => $organismMeasureRange40->id,
            'resistant_max' => '26.0',
            'intermediate_min' => '27.0',
            'intermediate_max' => '46.0',
            'sensitive_min' => '47.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange40->id,
            'resistant_max' => '30.0',
            'intermediate_min' => '31.0',
            'intermediate_max' => '37.0',
            'sensitive_min' => '38.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic35->id,
            'measure_range_id' => $organismMeasureRange40->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange41->id,
            'resistant_max' => '30.0',
            'intermediate_min' => '31.0',
            'intermediate_max' => '37.0',
            'sensitive_min' => '38.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic35->id,
            'measure_range_id' => $organismMeasureRange41->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic29->id,
            'measure_range_id' => $organismMeasureRange41->id,
            'resistant_max' => '26.0',
            'intermediate_min' => '27.0',
            'intermediate_max' => '46.0',
            'sensitive_min' => '47.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange41->id,
            'resistant_max' => '27.0',
            'intermediate_min' => '28.0',
            'intermediate_max' => '40.0',
            'sensitive_min' => '41.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange41->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '35.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange42->id,
            'resistant_max' => '30.0',
            'intermediate_min' => '31.0',
            'intermediate_max' => '37.0',
            'sensitive_min' => '38.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic35->id,
            'measure_range_id' => $organismMeasureRange42->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic29->id,
            'measure_range_id' => $organismMeasureRange42->id,
            'resistant_max' => '26.0',
            'intermediate_min' => '27.0',
            'intermediate_max' => '46.0',
            'sensitive_min' => '47.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange42->id,
            'resistant_max' => '27.0',
            'intermediate_min' => '28.0',
            'intermediate_max' => '40.0',
            'sensitive_min' => '41.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange42->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '35.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange43->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '35.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange43->id,
            'resistant_max' => '27.0',
            'intermediate_min' => '28.0',
            'intermediate_max' => '40.0',
            'sensitive_min' => '41.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic29->id,
            'measure_range_id' => $organismMeasureRange43->id,
            'resistant_max' => '26.0',
            'intermediate_min' => '27.0',
            'intermediate_max' => '46.0',
            'sensitive_min' => '47.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic35->id,
            'measure_range_id' => $organismMeasureRange43->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange43->id,
            'resistant_max' => '30.0',
            'intermediate_min' => '31.0',
            'intermediate_max' => '37.0',
            'sensitive_min' => '38.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange44->id,
            'resistant_max' => '25.0',
            'intermediate_min' => '26.0',
            'intermediate_max' => '28.0',
            'sensitive_min' => '29.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange44->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange44->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic31->id,
            'measure_range_id' => $organismMeasureRange44->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange44->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange44->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange44->id,
            'resistant_max' => '25.0',
            'intermediate_min' => '26.0',
            'intermediate_max' => '28.0',
            'sensitive_min' => '29.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic3->id,
            'measure_range_id' => $organismMeasureRange44->id,
            'resistant_max' => '19.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange44->id,
            'resistant_max' => '18.0',
            'intermediate_min' => '19.0',
            'intermediate_max' => '21.0',
            'sensitive_min' => '22.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange44->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange45->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange45->id,
            'resistant_max' => '25.0',
            'intermediate_min' => '26.0',
            'intermediate_max' => '28.0',
            'sensitive_min' => '29.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic31->id,
            'measure_range_id' => $organismMeasureRange45->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange45->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange45->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange45->id,
            'resistant_max' => '25.0',
            'intermediate_min' => '26.0',
            'intermediate_max' => '28.0',
            'sensitive_min' => '29.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange45->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange45->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic3->id,
            'measure_range_id' => $organismMeasureRange45->id,
            'resistant_max' => '19.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange45->id,
            'resistant_max' => '18.0',
            'intermediate_min' => '19.0',
            'intermediate_max' => '21.0',
            'sensitive_min' => '22.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange46->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange46->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange46->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange46->id,
            'resistant_max' => '25.0',
            'intermediate_min' => '26.0',
            'intermediate_max' => '28.0',
            'sensitive_min' => '29.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic31->id,
            'measure_range_id' => $organismMeasureRange46->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange46->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange46->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange46->id,
            'resistant_max' => '25.0',
            'intermediate_min' => '26.0',
            'intermediate_max' => '28.0',
            'sensitive_min' => '29.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic3->id,
            'measure_range_id' => $organismMeasureRange46->id,
            'resistant_max' => '19.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange46->id,
            'resistant_max' => '18.0',
            'intermediate_min' => '19.0',
            'intermediate_max' => '21.0',
            'sensitive_min' => '22.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange48->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange48->id,
            'resistant_max' => '25.0',
            'intermediate_min' => '26.0',
            'intermediate_max' => '28.0',
            'sensitive_min' => '29.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic31->id,
            'measure_range_id' => $organismMeasureRange48->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange48->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange48->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange48->id,
            'resistant_max' => '25.0',
            'intermediate_min' => '26.0',
            'intermediate_max' => '28.0',
            'sensitive_min' => '29.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange48->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange48->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic3->id,
            'measure_range_id' => $organismMeasureRange48->id,
            'resistant_max' => '19.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange48->id,
            'resistant_max' => '18.0',
            'intermediate_min' => '19.0',
            'intermediate_max' => '21.0',
            'sensitive_min' => '22.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic3->id,
            'measure_range_id' => $organismMeasureRange52->id,
            'resistant_max' => '19.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange52->id,
            'resistant_max' => '18.0',
            'intermediate_min' => '19.0',
            'intermediate_max' => '21.0',
            'sensitive_min' => '22.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange52->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange52->id,
            'resistant_max' => '25.0',
            'intermediate_min' => '26.0',
            'intermediate_max' => '28.0',
            'sensitive_min' => '29.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic31->id,
            'measure_range_id' => $organismMeasureRange52->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange52->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange52->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange52->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange52->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange52->id,
            'resistant_max' => '25.0',
            'intermediate_min' => '26.0',
            'intermediate_max' => '28.0',
            'sensitive_min' => '29.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange53->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange53->id,
            'resistant_max' => '25.0',
            'intermediate_min' => '26.0',
            'intermediate_max' => '28.0',
            'sensitive_min' => '29.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic31->id,
            'measure_range_id' => $organismMeasureRange53->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange53->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange53->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange53->id,
            'resistant_max' => '25.0',
            'intermediate_min' => '26.0',
            'intermediate_max' => '28.0',
            'sensitive_min' => '29.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange53->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange53->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic3->id,
            'measure_range_id' => $organismMeasureRange53->id,
            'resistant_max' => '19.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange53->id,
            'resistant_max' => '18.0',
            'intermediate_min' => '19.0',
            'intermediate_max' => '21.0',
            'sensitive_min' => '22.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic31->id,
            'measure_range_id' => $organismMeasureRange54->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange54->id,
            'resistant_max' => '25.0',
            'intermediate_min' => '26.0',
            'intermediate_max' => '28.0',
            'sensitive_min' => '29.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange54->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange54->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange54->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange54->id,
            'resistant_max' => '25.0',
            'intermediate_min' => '26.0',
            'intermediate_max' => '28.0',
            'sensitive_min' => '29.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange54->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange54->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic3->id,
            'measure_range_id' => $organismMeasureRange54->id,
            'resistant_max' => '19.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange54->id,
            'resistant_max' => '18.0',
            'intermediate_min' => '19.0',
            'intermediate_max' => '21.0',
            'sensitive_min' => '22.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange55->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange55->id,
            'resistant_max' => '25.0',
            'intermediate_min' => '26.0',
            'intermediate_max' => '28.0',
            'sensitive_min' => '29.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic31->id,
            'measure_range_id' => $organismMeasureRange55->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange55->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange55->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange55->id,
            'resistant_max' => '25.0',
            'intermediate_min' => '26.0',
            'intermediate_max' => '28.0',
            'sensitive_min' => '29.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange55->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange55->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic3->id,
            'measure_range_id' => $organismMeasureRange55->id,
            'resistant_max' => '19.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange55->id,
            'resistant_max' => '18.0',
            'intermediate_min' => '19.0',
            'intermediate_max' => '21.0',
            'sensitive_min' => '22.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange56->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange56->id,
            'resistant_max' => '25.0',
            'intermediate_min' => '26.0',
            'intermediate_max' => '28.0',
            'sensitive_min' => '29.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic31->id,
            'measure_range_id' => $organismMeasureRange56->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange56->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange56->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange56->id,
            'resistant_max' => '25.0',
            'intermediate_min' => '26.0',
            'intermediate_max' => '28.0',
            'sensitive_min' => '29.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange56->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange56->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic3->id,
            'measure_range_id' => $organismMeasureRange56->id,
            'resistant_max' => '19.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange56->id,
            'resistant_max' => '18.0',
            'intermediate_min' => '19.0',
            'intermediate_max' => '21.0',
            'sensitive_min' => '22.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange61->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange61->id,
            'resistant_max' => '24.0',
            'intermediate_min' => '25.0',
            'intermediate_max' => '27.0',
            'sensitive_min' => '28.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic31->id,
            'measure_range_id' => $organismMeasureRange61->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic28->id,
            'measure_range_id' => $organismMeasureRange61->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange61->id,
            'resistant_max' => '20.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic26->id,
            'measure_range_id' => $organismMeasureRange61->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic25->id,
            'measure_range_id' => $organismMeasureRange61->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic36->id,
            'measure_range_id' => $organismMeasureRange61->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange67->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange67->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange67->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange67->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange67->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange67->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange67->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange67->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange67->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange67->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic9->id,
            'measure_range_id' => $organismMeasureRange67->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange67->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange67->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange67->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic4->id,
            'measure_range_id' => $organismMeasureRange67->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange67->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange67->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic9->id,
            'measure_range_id' => $organismMeasureRange33->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange68->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange68->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange68->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange68->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange68->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange68->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange68->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange68->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange68->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange68->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic9->id,
            'measure_range_id' => $organismMeasureRange68->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange68->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange68->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange68->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic4->id,
            'measure_range_id' => $organismMeasureRange68->id,
            'resistant_max' => '22.0',
            'intermediate_min' => '23.0',
            'intermediate_max' => '25.0',
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange68->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '25.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange68->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic21->id,
            'measure_range_id' => $organismMeasureRange68->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange69->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange69->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange69->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange69->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic21->id,
            'measure_range_id' => $organismMeasureRange69->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange69->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange69->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '25.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic4->id,
            'measure_range_id' => $organismMeasureRange69->id,
            'resistant_max' => '22.0',
            'intermediate_min' => '23.0',
            'intermediate_max' => '25.0',
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange69->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange69->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic9->id,
            'measure_range_id' => $organismMeasureRange69->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange69->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange69->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange69->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange69->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange69->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange69->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange69->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange71->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange71->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange71->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange71->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange71->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange71->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange71->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange71->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic9->id,
            'measure_range_id' => $organismMeasureRange71->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange71->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange71->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange71->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic4->id,
            'measure_range_id' => $organismMeasureRange71->id,
            'resistant_max' => '22.0',
            'intermediate_min' => '23.0',
            'intermediate_max' => '25.0',
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange71->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '25.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic21->id,
            'measure_range_id' => $organismMeasureRange71->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange71->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange71->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange71->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange72->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange72->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange72->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange72->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange72->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange72->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange72->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange72->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange72->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange72->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic9->id,
            'measure_range_id' => $organismMeasureRange72->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange72->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange72->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange72->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic4->id,
            'measure_range_id' => $organismMeasureRange72->id,
            'resistant_max' => '22.0',
            'intermediate_min' => '23.0',
            'intermediate_max' => '25.0',
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange72->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '25.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange72->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic21->id,
            'measure_range_id' => $organismMeasureRange72->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange74->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange74->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange74->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange74->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange74->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange74->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange74->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange74->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange74->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange74->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic9->id,
            'measure_range_id' => $organismMeasureRange74->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange74->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange74->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange74->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic4->id,
            'measure_range_id' => $organismMeasureRange74->id,
            'resistant_max' => '22.0',
            'intermediate_min' => '23.0',
            'intermediate_max' => '25.0',
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange74->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '25.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange74->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic21->id,
            'measure_range_id' => $organismMeasureRange74->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange75->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange75->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange75->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange75->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange75->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange75->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange75->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange75->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange75->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange75->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic9->id,
            'measure_range_id' => $organismMeasureRange75->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange75->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange75->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange75->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic4->id,
            'measure_range_id' => $organismMeasureRange75->id,
            'resistant_max' => '22.0',
            'intermediate_min' => '23.0',
            'intermediate_max' => '25.0',
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange75->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '25.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange75->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic21->id,
            'measure_range_id' => $organismMeasureRange75->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange76->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange76->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange76->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange76->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange76->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange76->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange76->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange76->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange76->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange76->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic9->id,
            'measure_range_id' => $organismMeasureRange76->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange76->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange76->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange76->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic4->id,
            'measure_range_id' => $organismMeasureRange76->id,
            'resistant_max' => '22.0',
            'intermediate_min' => '23.0',
            'intermediate_max' => '25.0',
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange76->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '25.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange76->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic21->id,
            'measure_range_id' => $organismMeasureRange76->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange77->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange77->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange77->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange77->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange77->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange77->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange77->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange77->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange77->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange77->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic9->id,
            'measure_range_id' => $organismMeasureRange77->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange77->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange77->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange77->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic4->id,
            'measure_range_id' => $organismMeasureRange77->id,
            'resistant_max' => '22.0',
            'intermediate_min' => '23.0',
            'intermediate_max' => '25.0',
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange77->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '25.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange77->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic21->id,
            'measure_range_id' => $organismMeasureRange77->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange80->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange80->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange80->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange80->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange80->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange80->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange80->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange80->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange80->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange80->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic9->id,
            'measure_range_id' => $organismMeasureRange80->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange80->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange80->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange80->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic4->id,
            'measure_range_id' => $organismMeasureRange80->id,
            'resistant_max' => '22.0',
            'intermediate_min' => '23.0',
            'intermediate_max' => '25.0',
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange80->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '25.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange80->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic21->id,
            'measure_range_id' => $organismMeasureRange80->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange81->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange81->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange81->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange81->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange81->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange81->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange81->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange81->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange81->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange81->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic9->id,
            'measure_range_id' => $organismMeasureRange81->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange81->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange81->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange81->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic4->id,
            'measure_range_id' => $organismMeasureRange81->id,
            'resistant_max' => '22.0',
            'intermediate_min' => '23.0',
            'intermediate_max' => '25.0',
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange81->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '25.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic21->id,
            'measure_range_id' => $organismMeasureRange81->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange81->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange83->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange83->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange83->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange83->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange83->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange83->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange83->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange83->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange83->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange83->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic9->id,
            'measure_range_id' => $organismMeasureRange83->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange83->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange83->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange83->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic4->id,
            'measure_range_id' => $organismMeasureRange83->id,
            'resistant_max' => '22.0',
            'intermediate_min' => '23.0',
            'intermediate_max' => '25.0',
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange83->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '25.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange83->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic21->id,
            'measure_range_id' => $organismMeasureRange83->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange84->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange84->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange84->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange84->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange84->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange84->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange84->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic9->id,
            'measure_range_id' => $organismMeasureRange84->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange84->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange84->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange84->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic4->id,
            'measure_range_id' => $organismMeasureRange84->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange84->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange84->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic21->id,
            'measure_range_id' => $organismMeasureRange84->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange84->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange84->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange84->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange3->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange87->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange87->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange87->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange87->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange87->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange87->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange87->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange87->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange87->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange87->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic9->id,
            'measure_range_id' => $organismMeasureRange87->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange87->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange87->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange87->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic4->id,
            'measure_range_id' => $organismMeasureRange87->id,
            'resistant_max' => '22.0',
            'intermediate_min' => '23.0',
            'intermediate_max' => '25.0',
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange87->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '25.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange87->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic21->id,
            'measure_range_id' => $organismMeasureRange87->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange88->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange88->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange88->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange88->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange88->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange88->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange88->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange88->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange88->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange88->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange88->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic9->id,
            'measure_range_id' => $organismMeasureRange88->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange88->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange88->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange88->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '25.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic4->id,
            'measure_range_id' => $organismMeasureRange88->id,
            'resistant_max' => '22.0',
            'intermediate_min' => '23.0',
            'intermediate_max' => '25.0',
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange88->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic21->id,
            'measure_range_id' => $organismMeasureRange88->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange89->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange89->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange89->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange89->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange89->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange89->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic20->id,
            'measure_range_id' => $organismMeasureRange90->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic33->id,
            'measure_range_id' => $organismMeasureRange90->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic37->id,
            'measure_range_id' => $organismMeasureRange90->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic9->id,
            'measure_range_id' => $organismMeasureRange91->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange91->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange91->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange91->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange91->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange91->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange91->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange91->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange91->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange91->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange91->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange91->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange91->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange91->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic4->id,
            'measure_range_id' => $organismMeasureRange91->id,
            'resistant_max' => '22.0',
            'intermediate_min' => '23.0',
            'intermediate_max' => '25.0',
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange91->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '25.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange91->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic21->id,
            'measure_range_id' => $organismMeasureRange91->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic18->id,
            'measure_range_id' => $organismMeasureRange95->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic17->id,
            'measure_range_id' => $organismMeasureRange95->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange95->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange95->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange95->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic14->id,
            'measure_range_id' => $organismMeasureRange95->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange95->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange95->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange95->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange95->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic9->id,
            'measure_range_id' => $organismMeasureRange95->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic8->id,
            'measure_range_id' => $organismMeasureRange95->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange95->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic5->id,
            'measure_range_id' => $organismMeasureRange95->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic4->id,
            'measure_range_id' => $organismMeasureRange95->id,
            'resistant_max' => '22.0',
            'intermediate_min' => '23.0',
            'intermediate_max' => '25.0',
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange95->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '25.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange95->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic21->id,
            'measure_range_id' => $organismMeasureRange95->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic38->id,
            'measure_range_id' => $organismMeasureRange91->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange96->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange96->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange96->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange96->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange96->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange96->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => NULL,
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic27->id,
            'measure_range_id' => $organismMeasureRange97->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange97->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic32->id,
            'measure_range_id' => $organismMeasureRange97->id,
            'resistant_max' => '6.0',
            'intermediate_min' => '7.0',
            'intermediate_max' => '9.0',
            'sensitive_min' => '10.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic31->id,
            'measure_range_id' => $organismMeasureRange97->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic29->id,
            'measure_range_id' => $organismMeasureRange97->id,
            'resistant_max' => '14.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange97->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic28->id,
            'measure_range_id' => $organismMeasureRange97->id,
            'resistant_max' => '20.0',
            'intermediate_min' => '21.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange97->id,
            'resistant_max' => '6.0',
            'intermediate_min' => '7.0',
            'intermediate_max' => '9.0',
            'sensitive_min' => '10.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic25->id,
            'measure_range_id' => $organismMeasureRange97->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange97->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange97->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange97->id,
            'resistant_max' => '16.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange98->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange98->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange98->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange98->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange99->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange99->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange99->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange99->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange100->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange100->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange100->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange100->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange101->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange101->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange101->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange101->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic29->id,
            'measure_range_id' => $organismMeasureRange36->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '24.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic29->id,
            'measure_range_id' => $organismMeasureRange102->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '24.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange102->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '24.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic25->id,
            'measure_range_id' => $organismMeasureRange102->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic26->id,
            'measure_range_id' => $organismMeasureRange102->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange102->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic27->id,
            'measure_range_id' => $organismMeasureRange102->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange102->id,
            'resistant_max' => '18.0',
            'intermediate_min' => '19.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic27->id,
            'measure_range_id' => $organismMeasureRange103->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange103->id,
            'resistant_max' => '18.0',
            'intermediate_min' => '19.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic29->id,
            'measure_range_id' => $organismMeasureRange103->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '24.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic25->id,
            'measure_range_id' => $organismMeasureRange103->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic26->id,
            'measure_range_id' => $organismMeasureRange103->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange103->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange103->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '24.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic27->id,
            'measure_range_id' => $organismMeasureRange107->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange107->id,
            'resistant_max' => '18.0',
            'intermediate_min' => '19.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic29->id,
            'measure_range_id' => $organismMeasureRange107->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '24.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic25->id,
            'measure_range_id' => $organismMeasureRange107->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic26->id,
            'measure_range_id' => $organismMeasureRange107->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange107->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange107->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '24.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic27->id,
            'measure_range_id' => $organismMeasureRange108->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange108->id,
            'resistant_max' => '18.0',
            'intermediate_min' => '19.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic29->id,
            'measure_range_id' => $organismMeasureRange108->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '24.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic25->id,
            'measure_range_id' => $organismMeasureRange108->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic26->id,
            'measure_range_id' => $organismMeasureRange108->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange108->id,
            'resistant_max' => '17.0',
            'intermediate_min' => '18.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange108->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '24.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic22->id,
            'measure_range_id' => $organismMeasureRange32->id,
            'resistant_max' => '18.0',
            'intermediate_min' => '19.0',
            'intermediate_max' => '24.0',
            'sensitive_min' => '25.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic1->id,
            'measure_range_id' => $organismMeasureRange32->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic2->id,
            'measure_range_id' => $organismMeasureRange109->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange109->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange109->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange109->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic6->id,
            'measure_range_id' => $organismMeasureRange109->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic16->id,
            'measure_range_id' => $organismMeasureRange109->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic39->id,
            'measure_range_id' => $organismMeasureRange34->id,
            'resistant_max' => '6.0',
            'intermediate_min' => '7.0',
            'intermediate_max' => '9.0',
            'sensitive_min' => '10.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic3->id,
            'measure_range_id' => $organismMeasureRange33->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic15->id,
            'measure_range_id' => $organismMeasureRange33->id,
            'resistant_max' => '19.0',
            'intermediate_min' => '20.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic4->id,
            'measure_range_id' => $organismMeasureRange33->id,
            'resistant_max' => '22.0',
            'intermediate_min' => '23.0',
            'intermediate_max' => '25.0',
            'sensitive_min' => '26.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic25->id,
            'measure_range_id' => $organismMeasureRange110->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '22.0',
            'sensitive_min' => '23.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic26->id,
            'measure_range_id' => $organismMeasureRange110->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange110->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange110->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange110->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange110->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange110->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange110->id,
            'resistant_max' => '13.0',
            'intermediate_min' => '14.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic31->id,
            'measure_range_id' => $organismMeasureRange110->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic28->id,
            'measure_range_id' => $organismMeasureRange110->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic24->id,
            'measure_range_id' => $organismMeasureRange111->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '18.0',
            'sensitive_min' => '19.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic27->id,
            'measure_range_id' => $organismMeasureRange111->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '15.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic31->id,
            'measure_range_id' => $organismMeasureRange111->id,
            'resistant_max' => '16.0',
            'intermediate_min' => '17.0',
            'intermediate_max' => '19.0',
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic19->id,
            'measure_range_id' => $organismMeasureRange111->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '16.0',
            'sensitive_min' => '17.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic28->id,
            'measure_range_id' => $organismMeasureRange111->id,
            'resistant_max' => NULL,
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '20.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic11->id,
            'measure_range_id' => $organismMeasureRange111->id,
            'resistant_max' => '15.0',
            'intermediate_min' => '16.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic10->id,
            'measure_range_id' => $organismMeasureRange111->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '17.0',
            'sensitive_min' => '18.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic36->id,
            'measure_range_id' => $organismMeasureRange111->id,
            'resistant_max' => '19.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '25.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic29->id,
            'measure_range_id' => $organismMeasureRange111->id,
            'resistant_max' => '28.0',
            'intermediate_min' => NULL,
            'intermediate_max' => NULL,
            'sensitive_min' => '29.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic26->id,
            'measure_range_id' => $organismMeasureRange111->id,
            'resistant_max' => '14.0',
            'intermediate_min' => '15.0',
            'intermediate_max' => '20.0',
            'sensitive_min' => '21.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic12->id,
            'measure_range_id' => $organismMeasureRange111->id,
            'resistant_max' => '10.0',
            'intermediate_min' => '11.0',
            'intermediate_max' => '15.0',
            'sensitive_min' => '16.0',
        ]);
        SusceptibilityBreakPoint::create([
            'antibiotic_id' => $antibiotic13->id,
            'measure_range_id' => $organismMeasureRange111->id,
            'resistant_max' => '12.0',
            'intermediate_min' => '13.0',
            'intermediate_max' => '14.0',
            'sensitive_min' => '15.0',
        ]);


        $this->command->info("Susceptibility Break Points Seeded");

        // create users, tobe used randomly
        factory(\App\User::class, 10)->create();
        $this->command->info("Users Seeded");

        // create locations, tobe used randomly
        factory(\App\Models\Location::class, 10)->create();
        $this->command->info("Locations Seeded");

        // create patient

        $this->command->info("Patient Seeding...");

        factory(\App\Models\Patient::class, ((int)env('DEV_TEST_NO',100))/2)->create();
        $this->command->info("Patients Seeded");

        // create tests with all its dependencies from results to patient

        $this->command->info("Tests Seeding...");

<<<<<<< HEAD
        for ($i=0; $i < (int)env('DEV_TEST_NO',100); $i++) {
            $testTypeId = \App\Models\TestType::inRandomOrder()->first()->id;
            $user_id = \App\User::inRandomOrder()->first()->id;
            $specimenTypeId = \App\Models\TestTypeMapping::where('test_type_id',$testTypeId)->first()->specimen_type_id;
            $specimen = factory(App\Models\Specimen::class)->create([
                'specimen_type_id' => $specimenTypeId,
            ]);

            $test_status = rand(1,4);
            $created_at = date('Y-m-d H:i:s',strtotime("-".rand(0,10)." days"));
            switch ($test_status) {
                case 1: //pending
                    $tested_by = NULL;
                    $verified_by = NULL;
                    $time_started = NULL;
                    $specimen_id = NULL;
                    $time_completed = NULL;
                    $time_verified = NULL;
                    break;

                case 2: //started
                    $tested_by = NULL;
                    $verified_by = NULL;
                    $time_started = date('Y-m-d H:i:s',strtotime($created_at."+".rand(20,1800)." minutes"));
                    $specimen_id = $specimen->id;
                    $time_completed = NULL;
                    $time_verified = NULL;
                    break;

                case 3: //completed
                    $tested_by = \App\User::inRandomOrder()->first()->id;
                    $verified_by = NULL;
                    $time_started = date($created_at,strtotime("+".rand(20,1800)." minutes"));
                    $specimen_id = $specimen->id;
                    $time_completed = date('Y-m-d H:i:s',strtotime($time_started."+".rand(10,3600)." minutes"));
                    $time_verified = NULL;
                    break;

                case 4: //verified
                    $tested_by = \App\User::inRandomOrder()->first()->id;
                    $verified_by = \App\User::where("id","!=",$tested_by)->inRandomOrder()->first()->id;
                    $time_started = date('Y-m-d H:i:s',strtotime($created_at."+".rand(20,1800)." minutes"));
                    $specimen_id = $specimen->id;
                    $time_completed = date('Y-m-d H:i:s',strtotime($time_started."+".rand(20,3600)." minutes"));
                    $time_verified = date('Y-m-d H:i:s',strtotime($time_completed."+".rand(5,3600)." minutes"));;
                    break;

                default:
                    $tested_by = NULL;
                    $verified_by = NULL;
                    $time_started = NULL;
                    $specimen_id = NULL;
                    $time_completed = NULL;
                    $time_verified = NULL;
                    break;
            }

            factory(\App\Models\Test::class)->create([
                'test_type_id' => $testTypeId,
                'specimen_id' => $specimen_id,
                'test_status_id' => $test_status,
                'created_by' => $user_id,
                'tested_by' => $tested_by,
                'verified_by' => $verified_by,
                'time_started' => $time_started,
                'time_completed' => $time_completed,
                'time_verified' => $time_verified,
                'created_at' => $created_at
            ]);
        }
=======
        factory(\App\Models\Test::class, (int)env('DEV_TEST_NO',100))->create();

        Test::create(["encounter_id" => 1, "identifier" => "4667/12/17", "test_type_id" => 4, "specimen_id" => 4, "test_status_id" => 4, "created_by" => 7, "requested_by" => "molestias", "created_by" => "2018-09-17 07:40:08", "time_sent" => "2018-09-17 07:40:08", "updated_at" => "2018-09-17 07:40:08"]);
        Test::create(["encounter_id" => 1, "identifier" => 1, "test_type_id" => 4, "specimen_id" => 4, "test_status_id" => 4, "created_by" => 7, "requested_by" => "molestias", "created_by" => "2018-09-17 07:40:08", "time_sent" => "2018-09-17 07:40:08", "updated_at" => "2018-09-17 07:40:08"]);
        Test::create(["encounter_id" => 1, "identifier" => "IJA316000", "test_type_id" => 4, "specimen_id" => 4, "test_status_id" => 4, "created_by" => 7, "requested_by" => "molestias", "created_by" => "2018-09-17 07:40:08", "time_sent" => "2018-09-17 07:40:08", "updated_at" => "2018-09-17 07:40:08"]);
        Test::create(["encounter_id" => 1, "identifier" => 2017000010, "test_type_id" => 4, "specimen_id" => 4, "test_status_id" => 4, "created_by" => 7, "requested_by" => "molestias", "created_by" => "2018-09-17 07:40:08", "time_sent" => "2018-09-17 07:40:08", "updated_at" => "2018-09-17 07:40:08"]);

>>>>>>> instrumentsseed
        $this->command->info("Tests Seeded");

        // create results
        foreach (Test::where('test_status_id','>=',3)->get() as $test) { //make sure that only the tests completed/verified get result seeded
            \ILabAfrica\EMRInterface\DiagnosticOrder::create(['test_id' => $test->id]);
            foreach ($test->testType->measures as $measure) {


                $measureRange = MeasureRange::where('measure_id',$measure->id)
                    ->inRandomOrder()->first();

                if ($measure->measure_type_id == MeasureType::numeric) {

                    factory(\App\Models\Result::class)->create([
                        'test_id' => $test->id,
                        'measure_id' => $measure->id,
                        'result' => rand($measureRange->low,$measureRange->high),
                        // 'result' => $measure->id, // todo: eventually choos a high low normal critically_high critically_low randomly... work on the logic...

                        'measure_range_id' => $measureRange->id,
                    ]);

                }elseif ($measure->measure_type_id == MeasureType::alphanumeric) {


                    factory(\App\Models\Result::class)->create([
                        'test_id' => $test->id,
                        'measure_id' => $measure->id,
                        'result' => $measureRange->display,
                        'measure_range_id' => $measureRange->id,
                    ]);

                }elseif ($measure->measure_type_id == MeasureType::multi_alphanumeric) {
                    # code...: when the moment comes, microscopy, micro biology
                }else{
                    // no measure range for free text
                    factory(\App\Models\Result::class)->create([
                        'test_id' => $test->id,
                        'measure_id' => $measure->id,
                    ]);
                }
            echo ".";
            }
        }
        $this->command->info("Results Seeded");

        \App\ThirdPartyApp::create([
            'id' => (string) Str::uuid(),
            'name' => 'Default EMR',
            'email' => 'emr@blis.local',
            'password' =>  bcrypt('password'),
        ]);
    }
}