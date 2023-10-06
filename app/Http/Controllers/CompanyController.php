<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use DB;
use App\Models\Country;
use App\Models\User;
use App\Models\CompanyManager;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // $companies=Company::orderBy('id','Desc')->paginate(3);
       $companies = DB::table('companies as c')
        ->select('c.id','c.name','c.email','c.country','c.address','t.name as country')
        ->leftJoin('countries as t','t.id','=','c.country')
        //->where('c.id','1')
        ->orderby('c.id','desc')
        ->paginate(5);
        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $countries = Country::all();
       $managers = DB::table('users')->get();
       return view('companies.create',compact('countries','managers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'address'=>'required'
        ]);

        $company = new Company();
        $company->name = $request->name;
        $company->email = $request->email;
        $company->country = $request->country;
        $company->address = $request->address;
        $company->save();

        $company_id=$company->id;

        $managers = $request->manager;
        foreach($managers as $manager){
            $com = new CompanyManager();
            $com->company = $company->id;
            $com->manager = $manager;
            $com->save();
        }

        DB::commit();
        return redirect()->route("companies-index")->with('success','Company has been created successfully.');
    }catch(\Throwable $e) {
        DB::rollback();
        return view('errors.500');
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

   /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $company = Company::find($id);
        $countries = Country::all();
        $managers = User::all();

        $com_managers = CompanyManager::where('company',$id)->get();

        $company_managers = [];
        foreach($com_managers as $com_manager){
            array_push($company_managers,$com_manager->manager);
        }

        return view('companies.edit',compact('company','countries','managers','company_managers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);

        $company = Company::find($id);
        $company->name = $request->name;
        $company->email = $request->email;
        $company->country = $request->country;
        $company->country = $request->country;
        $company->address = $request->address;
        $company->save();

        CompanyManager::where('company',$id)->delete();

        $managers = $request->manager;
        if(!is_null($managers)){
        foreach($managers as $manager){
            $com = new CompanyManager();
            $com->company = $company->id;
            $com->manager = $manager;
            $com->save();
            }
        }    

        return redirect()->route('companies-index')->with('success','company has bees updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $company = Company::find($id);
        $company->delete();
        
        return redirect()->route('companies-index')->with('success','company has been deleted successfully');
    }

    /**************************API functions**********************************/
    public function getAllCompanies(Request $request)
    {
     
        try{
            $companies = DB::table('companies as c')
            ->select('c.id','c.name','c.email','c.address','t.name as country')
            ->leftjoin('countries as t','t.id','=','c.country');
            
            $search = $request->search;

            if (!is_null($search)){
                $companies = $companies->where('c.name','LIKE','%'.$search.'%')
                ->orWhere('c.email','LIKE','%'.$search.'%')
                ->orWhere('c.address','LIKE','%'.$search.'%');
            }
            $companies = $companies->orderBy('c.id','desc')->get();

            return response()->json([
                "message" => "Companies Data",
                "data" => $companies,
            ],200);
        }catch(\Throwable $e){
            return response()->json([
                "message"=>"oops something went wrong",
                "error"=> $e->getMessage(),
            ],500);
        }
    }

    public function getCompanyInfo($id)
    {
        try{

            $company = DB::table('companies as c')
            ->select('c.id','c.name','c.email','c.address','t.name as country')
            ->leftjoin('countries as t','t.id','=','c.country')
            ->where('c.id',$id)
            ->first();

            return response()->json([
                "message" => "Company Data",
                "data" => $company,
            ],200);
        }catch(\Throwable $e){
            return response()->json([
                "message"=>"oops something went wrong",
                "error"=> $e->getMessage(),
            ],500);
        }
    }

    public function saveCompany(Request $request)
    {
        DB::beginTransaction();
        try{
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'address'=>'required'
        ]);

        $company = new Company();
        $company->name = $request->name;
        $company->email = $request->email;
        $company->country = $request->country;
        $company->address = $request->address;
        $company->save();

        $company_id=$company->id;

        $managers = $request->manager;
        foreach($managers as $manager){
            $com = new CompanyManager();
            $com->company = $company->id;
            $com->manager = $manager;
            $com->save();
        }

        DB::commit();

        return response()->json([
            "msg" => "Company Data",
            "data"=> $company,
        ],201);
    }catch(\Throwable $e) {
        DB::rollback();
        return response()->json([
            "msg"=>"oops something went wrong",
            "error"=> $e->getMessage(),
        ],500);
    }
    }

    public function updateCompany(Request $request, $id)
    {
        DB::beginTransaction();
        try{
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);

        $company = Company::find($id);
        $company->name = $request->name;
        $company->email = $request->email;
        $company->country = $request->country;
        $company->country = $request->country;
        $company->address = $request->address;
        $company->save();

        CompanyManager::where('company',$id)->delete();

        $managers = $request->manager;
        if(!is_null($managers)){
        foreach($managers as $manager){
            $com = new CompanyManager();
            $com->company = $company->id;
            $com->manager = $manager;
            $com->save();
            }
        }  
     
      DB::commit();

      return response()->json([
        "msg" => "Company Data",
        "data"=> $company,
    ],201);
}catch(\Throwable $e) {
    DB::rollback();
    return response()->json([
        "msg"=>"oops something went wrong",
        "error"=> $e->getMessage(),
    ],500);
}
    }
    
}
