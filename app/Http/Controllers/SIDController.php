<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SIDConfiguration;
use DB;

class SIDController extends Controller
{
    public function __construct()
    {

    $this->middleware('prevent-back-history');
    $this->middleware('Employee');
    $this->middleware('SessionTimeOut');
    
    }

    public function index() 
    {
        $storedIds = DB::table('merchant_services')->pluck('merchant_id')->toArray();
        $sids = SIDConfiguration::all();
        // dd($sids);
        $merchants = [];
        $storedPermissions = [];
        return view('employee.technical.sidconfiguration', compact('merchants', 'storedPermissions','sids'));
    }

    public function add(Request $request) 
    {
        
        $validator = Validator::make($request->all(), [
            'sid' => 'required|max:10',
            'company_name' => 'required|max:50',
            'vpa' => 'required|max:60',
            'mcc_code' => 'required|max:10',
        ],
            [
                'sid.required' => 'The SID field is required.',
                'sid.max' => 'The SID field cannot exceed 10 characters.',
                'company_name.required' => 'The company name field is required.',
                'company_name.max' => 'The company name field cannot exceed 50 characters.',
                'vpa.required' => 'The VPA field is required.',
                'vpa.max' => 'The VPA field cannot exceed 60 characters.',
                'mcc_code.required' => 'The MCC code field is required.',
                'mcc_code.max' => 'The MCC code field cannot exceed 10 characters.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }
        
          $sid_details['sid'] = $request->sid;
          $sid_details['company_name'] = $request->company_name;
          $sid_details['vpa'] = $request->vpa;
          $sid_details['is_active'] = '1';
          $sid_details['mcc_code'] = $request->mcc_code;
          
          SIDConfiguration::insert($sid_details);
          
          $success = 'Submerchant Id added successfully';
          return redirect()->route('sidconfiguration')->with('success',$success);
        //   return response()->json(['success'=>'Submerchant Id added successfully']);
      }

      public function fetchSid(Request $request, $sid)
      {
          // Fetch data based on $sid
          $data = SIDConfiguration::where('id', $sid)->first();
        //  dd($data);
          // Check if data is found
          if (!$data) {
              return response()->json(['error' => 'Data not found'], 404);
          }
  
          return response()->json($data);

         
      }

      public function edit(Request $request, $sid)
      {
       // Validate the request data if necessary
    // Fetch the SID configuration record based on the SID
    $sidConfig = SIDConfiguration::where('id', $sid)->first();

    // Check if the SID configuration record exists
    if ($sidConfig) {
        // Update the SID configuration record with the new values
        $sidConfig->sid = $request->editsid; // Update the SID itself
        $sidConfig->company_name = $request->edit_company_name;
        $sidConfig->vpa = $request->edit_vpa;
        $sidConfig->mcc_code = $request->edit_mcc_code;

        // Save the updated record
        $sidConfig->save();

        // Optionally, you can return a response indicating success
        return response()->json(['message' => 'SID configuration updated successfully'], 200);
    } else {
        // Handle the case where the SID configuration record does not exist
        return response()->json(['error' => 'SID configuration not found'], 404);
    }
      }

public function destroy($id)
{
    try {
        // Find the SID configuration by its ID
        $sidConfiguration = SIDConfiguration::findOrFail($id);

        // Delete the SID configuration
        $sidConfiguration->delete();

        // Optionally, you can return a response indicating success
        return response()->json(['message' => 'SID configuration deleted successfully'], 200);
    } catch (\Exception $e) {
        // Handle any errors that occur during deletion
        return response()->json(['error' => 'Failed to delete SID configuration'], 500);
    }
}

public function statusUpdate($id)
{
    try {
        // Find the SID configuration by its ID
        $sidConfiguration = SIDConfiguration::findOrFail($id);

        // Toggle the status
        $sidConfiguration->is_active = !$sidConfiguration->is_active;

        // Save the changes
        $sidConfiguration->save();

        // Optionally, you can return a response indicating success
        return response()->json(['message' => 'SID configuration status updated successfully'], 200);
    } catch (\Exception $e) {
        // Handle any errors that occur during status update
        return response()->json(['error' => 'Failed to update SID configuration status'], 500);
    }
}


}
