<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS      - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead     - Emmanuel Kweyu.
 * Devs      - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma.
 * More Devs     - Derrick Rono|Anthony Ereng|Emmanuel Kitsao.
 */

use App\Models\Referral;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index()
    {
        $referral = Referral::orderBy('id', 'ASC')->paginate(10);

        return response()->json($referral);
    }


// move all these externally

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'storage_condition' => 'required',
            'transport' => 'required',
            'organization_id' => 'required',
            'person' => 'required',
            'contact' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator,422);
        } else {
            $referral = new Referral;
            $referral->time_dispatch = $request->input('time_dispatch');
            $referral->time_received = $request->input('time_received');
            $referral->storage_condition = $request->input('storage_condition');
            $referral->transport = $request->input('transport');
            $referral->referral_reason_id = $request->input('referral_reason_id');
            $referral->organization_id = $request->input('organization_id');
            $referral->person = $request->input('person');
            $referral->contact = $request->input('contact');
            $referral->user_id =  Auth::user()->id;

            try {
                $referral->save();

                return response()->json($referral);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }





        $rules = [
            'rejection_reason_ids' => 'required',
            'reject_explained_to' => 'required',
            'specimen_id' => 'required',
        ];

        $validator = \Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator,422);

        } else {

            $rejection = new SpecimenRejection;
            $rejection->specimen_id = $request->input('specimen_id');

            // if it is analytic rejection test_id is submitted
            if ($request->input('test_id')) {
                // to reject specimen only for a particular test
                $rejection->test_phase_id = TestPhase::analytical;
                $rejection->test_id = $request->input('test_id');

            } else {

                $rejection->test_phase_id = TestPhase::pre_analytical;
            }
            $rejection->rejection_reason_id = $request->input('rejection_reason_id');
            $rejection->reject_explained_to = $request->input('reject_explained_to');
            $rejection->rejected_by = Auth::user()->id;
            $rejection->time_rejected = date('Y-m-d H:i:s');
            $rejection->save();

            foreach ($request->input('rejection_reason_ids') as $rejectionReasonId) {
                // $specimenRejection = SpecimenRejection::find($rejection->id);
                $rejectionReason = RejectionReason::find($rejectionReasonId);
                // $specimenRejection->attach($rejectionReason);
                $rejection->attach($rejectionReason);
            }
            return response()->json($rejection);
        }




    }

    /**
     * Display the specified resource.
     *
     * @param  int  id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $referral = Referral::findOrFail($id);

        return response()->json($referral);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  request
     * @param  int  id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'storage_condition' => 'required',
            'transport_type' => 'required',
            'organization_id' => 'required',
            'person' => 'required',
            'contacts' => 'required',
            'user_id' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $referral = Referral::findOrFail($id);
            $referral->time_dispatch = $request->input('time_dispatch');
            $referral->storage_condition = $request->input('storage_condition');
            $referral->transport_type = $request->input('transport_type');
            $referral->referral_reason_id = $request->input('referral_reason_id');
            $referral->organization_id = $request->input('organization_id');
            $referral->person = $request->input('person');
            $referral->contacts = $request->input('contacts');
            $referral->user_id = $request->input('user_id');

            try {
                $referral->save();

                return response()->json($referral);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $referral = Referral::findOrFail($id);
            $referral->delete();

            return response()->json($referral, 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function attachReason(Request $request)
    {
        $rules = [
            'referral_reason_id' => 'required',
            'specimen_referral_id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator,422);
        } else {

                $referral = Referral::find($request->input('specimen_referral_id'));
                $referralReason = ReferralReason::find($request->input('referral_reason_id'));
            try {
                $referral->attach($referralReason);

                return response()->json(['message' => 'Item Successfully Created']);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }

    public function detachReason(Request $request)
    {
        $rules = [
            'referral_reason_id' => 'required',
            'specimen_referral_id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator,422);
        } else {
            $referral = Referral::find($request->input('specimen_referral_id'));
            $referralReason = ReferralReason::find($request->input('referral_reason_id'));

            try {
                $referral->detach($referralReason);

                return response()->json(['message' => 'Item Successfully deleted']);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }

}
