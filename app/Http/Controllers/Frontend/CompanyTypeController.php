<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CompanyType;
use App\Models\Service;
use Illuminate\Http\Request;


class CompanyTypeController extends Controller
{
    public  function category()
    {       
        
        $data = CompanyType::orderBy('created_at', 'desc')->paginate(10);
        foreach ($data as $row) {
            $services = Service::where('company_type_id', $row->id)->count();
            $row->services = $services;
        }
        $totall  =  CompanyType::all();
        return view('frontend.CompanyTypes',compact('data', 'totall'));
    }

    public function add_company_type(Request $request)
    {
        $name = $request->input('name');

        $entry = [
            'name' => $name,
        ];
        $data = CompanyType::create($entry);
        return redirect('CompanyTypes');
    }

    public  function company_type_update(Request $request, $id)
    {

        $type = CompanyType::find($id);
        $type->name = $request->input('name');
        $type->save();
        return redirect('CompanyTypes');
    }

    public function category_destroy($id)
    {
        // DB::delete('DELETE FROM business_categories WHERE id = ?', [$id]);
        // return redirect('Admin/Category');
    }

    public  function service(Request $request, $id)
    {  
        $data = Service::where('company_type_id', $id)->orderBy('created_at', 'desc')->paginate(10);
        $category = CompanyType::find($id);
        $totall = Service::where('company_type_id', $id)->get();
        return view('frontend.Services', compact('data', 'category', 'id', 'totall'));
    }

    public function add_service(Request $request , $id)
    {
        $name = $request->input('name');
        $company_type_id = $id;
        $create = [
            'name' => $name,
            'company_type_id' => $company_type_id,
        ];
        $data = Service::create($create);
        return back();
    }
    public  function service_update(Request $request, $id)
    {

        $interest = Service::find($id);
        $interest->name = $request->input('name');
        $interest->save();
        return back();
    }

    public function service_destroy($id)
    {
        // DB::delete('DELETE FROM business_services WHERE id = ?', [$id]);
        // return back();
    }
}
