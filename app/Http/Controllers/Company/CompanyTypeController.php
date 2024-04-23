<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\{CompanyType, Service};
use Illuminate\Http\Request;

class CompanyTypeController extends Controller
{
    /**
     * Display a listing of the company list.
     */



    // services for company types are below
    

    public function company_list(Request $request)
    {
        $comapnyList = CompanyType::get();
        if ($comapnyList->isNotEmpty()) {
            $response = [
                'status' => true,
                'message' => 'Company List',
                'data' => $comapnyList,
            ];
            return response()->json($response, 200);
        }
        $response = [
            'status' => false,
            'message' => 'No Company Found in Database',
            'data' => [],
        ];
        return response()->json($response, 200);
    }
    public function services(Request $request)
    {

        $services = Service::where('company_type_id', $request->company_type_id)->get();
        if (!$services->isNotEmpty()) {
            $response = [
                'status' => false,
                'message' => 'Failed to fetch services',
                'data' => [],
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'status' => true,
                'message' => 'Services fetched successfully',
                'data' => $services,
            ];
            return response()->json($response, 200);
        }
    }
}
