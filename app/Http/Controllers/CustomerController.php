<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Auth;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:staff', ['only' => ['create','store','index']]);
        $this->middleware('permission:supervisor', ['only' => ['updateStatus']]);
        $this->middleware('permission:supervisor', ['only' => ['edit','update']]);
        $this->middleware('permission:supervisor', ['only' => ['delete']]);
      
    }


    /**
     * List User 
     * @param Nill
     * @return Array $user
     * @author Shani Singh
     */
    public function index()
    {
        //$users = User::with('roles')->paginate(10);
         $users = DB::table('customer')->paginate(10);
        return view('customer.index', ['users' => $users]);
    }

    public function search(Request $request)
    {
        $item = $request->input('item');
        $keyword = $request->input('keyword');

        if($item=='name'){
        $users = DB::table('customer')->where(function($query) use ($item, $keyword) {
            $query->where('first_name', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('last_name', 'LIKE', '%' . $keyword . '%');
        })
        ->paginate(10);
        }
        else {
         $users = DB::table('customer')->where($item, 'LIKE', '%' . $keyword . '%')->paginate(10);
        }
        return view('customer.index', ['users' => $users,'item'=>$item,'keyword'=>$keyword]);
    }
    
    /**
     * Create User 
     * @param Nill
     * @return Array $user
     * @author Shani Singh
     */
    public function create()
    {
        $roles = Role::all();
       
        return view('customer.add', ['roles' => $roles]);
    }

    /**
     * Store User
     * @param Request $request
     * @return View Users
     * @author Shani Singh
     */
    public function store(Request $request)
    {
        // Validations
        $request->validate([                   
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'dob' => 'required',
            // 'company' => 'required',
            'street_address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zipcode' => 'required',
            'license_number' => 'required',
            'license_expire' => 'required',
            'license_issue' => 'required',
            'sex' => 'required',
            'height' => 'required',
            'documents' => 'required',
            'itin_number' => 'required',
            // 'memo' => 'required',
            // 'image' => 'required',
            'name_list' => 'required',
            'rate_list' => 'required|min:0|max:100',
            'phone_list' => 'required',
            // 'licences' => 'required',
            // 'birth_certificate' => 'required',
            // 'passport' => 'required',
            'driver_name' => 'required',
            'driver_bdate' => 'required',
            'driver_address' => 'required',
            'driver_issuing_authority' => 'required',
            'birth_full_name' => 'required',
            'birth_bdate' => 'required',
            'birth_place_of_birth' => 'required',
            'birth_parents_name' => 'required',
            'birth_registration_number' => 'required',
            'birth_issuing_authority' => 'required',
            'passport_full_name' => 'required',
            'passport_bdate' => 'required',
            'passport_number' => 'required',
            'passport_nationality' => 'required',
            'passport_place_of_birth' => 'required',
            'passport_issuing_authority' => 'required',
            'passport_Issue_date' => 'required',
            'passport_expiry_date' => 'required',
        ]);
        
        
        
        // dd($request);

        $files = $request->file('documents');

        DB::beginTransaction();
        try {

            
            if ($request->hasFile('documents')) {
                $files = $request->file('documents');
                
                $uploadedFiles = [];
                foreach ($files as $file) {
                       $uniqueFilename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

                    //   $filePath = $file->storeAs('uploads', $uniqueFilename, 'public');
                    
                      $filePath = 'uploads/'.$uniqueFilename;
                       
                       $file->move('public/storage/uploads', $uniqueFilename);

                        $uploadedFiles[] = $filePath;
                    }
                
             }
             
             
             $documentsJson = json_encode($uploadedFiles);
             
             
             
            if ($request->hasFile('image')) {
                
                $files = $request->file('image');
                $img = time() . '_' . Str::random(8) . '.' . $files->getClientOriginalExtension();
                $files->move('public/storage/uploads', $img);
                $image = 'uploads/'.$img;
             }
             else{
                 $image = '';
             }
             
            if ($request->hasFile('birth_certificate')) {
                
                $files = $request->file('birth_certificate');
                $bc = time() . '_' . Str::random(8) . '.' . $files->getClientOriginalExtension();
                $files->move('public/storage/uploads', $bc);
                $birth_certificate = 'uploads/'.$bc;
             }
             else{
                 $birth_certificate = '';
             }
             
            if ($request->hasFile('passport')) {
                
                $files = $request->file('passport');
                $pass = time() . '_' . Str::random(8) . '.' . $files->getClientOriginalExtension();
                $files->move('public/storage/uploads', $pass);
                $passport = 'uploads/'.$pass;
             }
             else{
                 $passport = '';
             }
             
            if ($request->hasFile('licences')) {
                
                $files = $request->file('licences');
                $lice = time() . '_' . Str::random(8) . '.' . $files->getClientOriginalExtension();
                $files->move('public/storage/uploads', $lice);
                $licences = 'uploads/'.$lice;
             }
             else{
                 $licences = '';
             }
             
             

        DB::table('customer')->insert([              
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'dob' => $request->dob,
                'company' => $request->company,
                'street_address' => $request->street_address,
                'city' => $request->city,
                'state' => $request->state,
                'zipcode' => $request->zipcode,
                'license_number' => $request->license_number,
                'license_expire' => $request->license_expire,
                'license_issue' => $request->license_issue,
                'sex' => $request->sex,
                'height' => $request->height,
                'documents' => $documentsJson,
                'itin_number' => $request->itin_number,
                'memo' => $request->memo,
                'image' => $image,
                'licences' => $licences,
                'birth_certificate' => $birth_certificate,
                'passport' => $passport,
                'driver_name' => $request->driver_name,
                'driver_bdate' => $request->driver_bdate,
                'driver_address' => $request->driver_address,
                'driver_issuing_authority' => $request->driver_issuing_authority,
                'birth_full_name' => $request->birth_full_name,
                'birth_bdate' => $request->birth_bdate,
                'birth_place_of_birth' => $request->birth_place_of_birth,
                'birth_parents_name' => $request->birth_parents_name,
                'birth_registration_number' => $request->birth_registration_number,
                'birth_issuing_authority' => $request->birth_issuing_authority,
                'passport_full_name' => $request->passport_full_name,
                'passport_bdate' => $request->passport_bdate,
                'passport_number' => $request->passport_number,
                'passport_nationality' => $request->passport_nationality,
                'passport_place_of_birth' => $request->passport_place_of_birth,
                'passport_issuing_authority' => $request->passport_issuing_authority,
                'passport_Issue_date' => $request->passport_Issue_date,
                'passport_expiry_date' => $request->passport_expiry_date,
                
            ]);
           
           
           
            // Commit And Redirected To Listing
            DB::commit();
            
            $customer = DB::table('customer')->orderBy('id', 'DESC')->first();
            
            
            // add company 
            
            
            
            foreach($request->name_list as $key =>$com){
                
               DB::table('company')->insert([              
                'customer_id' => $customer->id,
                'name' => $request->name_list[$key],
                'rate' => $request->rate_list[$key],
                'phone' => $request->phone_list[$key],
            ]);
           
           
            // Commit And Redirected To Listing
            DB::commit();
                
            }
            
            // add activity log
            
            $id = Auth::id();
            $auth = Auth::user();
            
            DB::table('activity_log')->insert([              
                'manage_id' => $id,
                'customer_id' => $customer->id,
                'role_id' => $auth->role_id,
                'action' => 'add',
            ]);
           
           
            // Commit And Redirected To Listing
            DB::commit();

            return redirect()->route('customer.index')->with('success','Customer Added Successfully.');

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Update Status Of User
     * @param Integer $status
     * @return List Page With Success
     * @author Shani Singh
     */



    public function edit($user)
    {
     
     $id = $user;
        $user = DB::table('customer')->where('id', $user)->first();
        $companys = DB::table('company')->where('customer_id', $id)->get();
        
        $uploadedDocuments = json_decode($user->documents, true);
        return view('customer.edit')->with([ 'user'  => $user,'uploadedDocuments' =>$uploadedDocuments,'companys' =>$companys]);
    }

    /**
     * Update User
     * @param Request $request, User $user
     * @return View Users
     * @author Shani Singh
     */
    public function update(Request $request, $user)
    {
        // Validations
        $data = $request->input('removed_documents');
        if($data){
            $array_str = implode(', ', $data);
        }
        if($request->check_validation){
            $rules = [                   
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'dob' => 'required',
                // 'company' => 'required',
                'street_address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'zipcode' => 'required',
                'license_number' => 'required',
                'license_expire' => 'required',
                'license_issue' => 'required',
                'sex' => 'required',
                'height' => 'required',
                'itin_number' => 'required',
                // 'memo' => 'required',
                'driver_name' => 'required',
                'driver_bdate' => 'required',
                'driver_address' => 'required',
                'driver_issuing_authority' => 'required',
                'birth_full_name' => 'required',
                'birth_bdate' => 'required',
                'birth_place_of_birth' => 'required',
                'birth_parents_name' => 'required',
                'birth_registration_number' => 'required',
                'birth_issuing_authority' => 'required',
                'passport_full_name' => 'required',
                'passport_bdate' => 'required',
                'passport_number' => 'required',
                'passport_nationality' => 'required',
                'passport_place_of_birth' => 'required',
                'passport_issuing_authority' => 'required',
                'passport_Issue_date' => 'required',
                'passport_expiry_date' => 'required',
            ];

            // Create a Validator instance and check if validation fails
            $validator = Validator::make($request->all(), $rules);
        
            if ($validator->fails()) {
                return redirect('customer/edit/'.$user)->withErrors($validator)->withInput();
            }
        }

      
        

        DB::beginTransaction();
        try {

            $user_data = DB::table('customer')->where('id', $user)->first();

            $uploadedFiles = json_decode($user_data->documents, true);
            

            if ($request->hasFile('documents')) {
                $files = $request->file('documents');
                
                foreach ($files as $file) {
                       $uniqueFilename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

                       $filePath = $file->storeAs('uploads', $uniqueFilename, 'public');

                        $uploadedFiles[] = $filePath;
                    }
                
             }
             //return redirect()->back()->withInput()->with('error', json_encode($uploadedFiles));

             if ($request->has('removed_documents')) {
                $removedFiles = $request->input('removed_documents');
                foreach ($removedFiles as $filename) {
             
    
                    // Remove the file from the uploadedFiles array
                    $uploadedFiles = array_filter($uploadedFiles, function ($file) use ($filename) {
                        return $file !== $filename;
                    });
                }
            }
            $documentsJson = json_encode($uploadedFiles);
            
            if ($request->hasFile('image')) {
                
                $files = $request->file('image');
                $img = time() . '_' . Str::random(8) . '.' . $files->getClientOriginalExtension();
                $files->move('public/storage/uploads', $img);
                $image = 'uploads/'.$img;
             }
             else{
                 $image = $user_data->image;
             }
             
            if ($request->hasFile('birth_certificate')) {
                
                $files = $request->file('birth_certificate');
                $bc = time() . '_' . Str::random(8) . '.' . $files->getClientOriginalExtension();
                $files->move('public/storage/uploads', $bc);
                $birth_certificate = 'uploads/'.$bc;
             }
            else{
                 $birth_certificate = $user_data->birth_certificate;
             }
             
            if ($request->hasFile('passport')) {
                
                $files = $request->file('passport');
                $pass = time() . '_' . Str::random(8) . '.' . $files->getClientOriginalExtension();
                $files->move('public/storage/uploads', $pass);
                $passport = 'uploads/'.$pass;
             }
            else{
                 $passport = $user_data->passport;
             }
             
            if ($request->hasFile('licences')) {
                
                $files = $request->file('licences');
                $lice = time() . '_' . Str::random(8) . '.' . $files->getClientOriginalExtension();
                $files->move('public/storage/uploads', $lice);
                $licences = 'uploads/'.$lice;
             }
            else{
                 $licences = $user_data->licences;
             }
             

            // Store Data
            $user_updated = DB::table('customer')->whereId($user)->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'dob' => $request->dob,
                'company' => $request->company,
                'street_address' => $request->street_address,
                'city' => $request->city,
                'state' => $request->state,
                'zipcode' => $request->zipcode,
                'license_number' => $request->license_number,
                'license_expire' => $request->license_expire,
                'license_issue' => $request->license_issue,
                'sex' => $request->sex,
                'height' => $request->height,
                'documents' => $documentsJson,
                'itin_number' => $request->itin_number,
                'memo' => $request->memo,
                'image' => $image,
                'licences' => $licences,
                'birth_certificate' => $birth_certificate,
                'passport' => $passport,
                'driver_name' => $request->driver_name,
                'driver_bdate' => $request->driver_bdate,
                'driver_address' => $request->driver_address,
                'driver_issuing_authority' => $request->driver_issuing_authority,
                'birth_full_name' => $request->birth_full_name,
                'birth_bdate' => $request->birth_bdate,
                'birth_place_of_birth' => $request->birth_place_of_birth,
                'birth_parents_name' => $request->birth_parents_name,
                'birth_registration_number' => $request->birth_registration_number,
                'birth_issuing_authority' => $request->birth_issuing_authority,
                'passport_full_name' => $request->passport_full_name,
                'passport_bdate' => $request->passport_bdate,
                'passport_number' => $request->passport_number,
                'passport_nationality' => $request->passport_nationality,
                'passport_place_of_birth' => $request->passport_place_of_birth,
                'passport_issuing_authority' => $request->passport_issuing_authority,
                'passport_Issue_date' => $request->passport_Issue_date,
                'passport_expiry_date' => $request->passport_expiry_date,
            ]);

          

            // Commit And Redirected To Listing
            DB::commit();
            
            if($request->name_list){
             
            
            foreach($request->name_list as $key =>$com){
                
               DB::table('company')->insert([              
                'customer_id' => $user_data->id,
                'name' => $request->name_list[$key],
                'rate' => $request->rate_list[$key],
                'phone' => $request->phone_list[$key],
            ]);
           
           
            // Commit And Redirected To Listing
            DB::commit();
                
            }
            
         }  
         
          // add activity log
            
            $id = Auth::id();
            $auth = Auth::user();
            
            DB::table('activity_log')->insert([              
                'manage_id' => $id,
                'customer_id' => $user_data->id,
                'role_id' => $auth->role_id,
                'action' => 'edit',
            ]);
           
           
            // Commit And Redirected To Listing
            DB::commit();
         
            return redirect()->route('customer.index')->with('success','Customer Details Updated Successfully.');

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Delete User
     * @param User $user
     * @return Index Users
     * @author Shani Singh
     */
    public function delete($user)
    {
        DB::beginTransaction();
        try {
            // Delete User
            DB::table('customer')->whereId($user)->delete();

            DB::commit();
            
          // add activity log
            
            $id = Auth::id();
            $auth = Auth::user();
            
            DB::table('activity_log')->insert([              
                'manage_id' => $id,
                'customer_id' => $user,
                'role_id' => $auth->role_id,
                'action' => 'delete',
            ]);
           
           
            // Commit And Redirected To Listing
            DB::commit();
            
            return redirect()->back()->with('success', 'Customer Deleted Successfully!.');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function customertransaction(Request $request, $user)
    {
           $query = "
        SELECT
            t.*,
            COALESCE(CONCAT(c.first_name, ' ', c.last_name), 'Unknown User') AS customer_fullname
        FROM
            transaction t
        LEFT JOIN
            customer c ON t.customer_id = c.id where t.customer_id = ".$user;

        // Get the current page from the request query string
        $perPage = 10;
        $currentPage = $request->query('page', 1);
        
        $offset = ($currentPage - 1) * $perPage;
    
        
        $paginatedQuery = $query . " LIMIT $perPage OFFSET $offset";
        $transactions = DB::select(DB::raw($paginatedQuery));
        
        foreach($transactions as $tran){
            $companys = DB::table('company')->where('id',$tran->company)->first();
            $tran->compnyname = $companys->name;
        }
    
        // Create a paginator manually
        $totalQuery = "SELECT COUNT(*) as total FROM ($query) as count_table";
        $totalResults = DB::select(DB::raw($totalQuery));
        $total = $totalResults[0]->total;
    
        $paginator = new Paginator($transactions, $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
            'total' => $total,
        ]);
    
        return view('customer.customertransaction', ['users' => $paginator]);
        
        
    }
    
    public function deletecompany($companyid)
    {
        DB::beginTransaction();
        try {
            // Delete User
            DB::table('company')->whereId($companyid)->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Company Deleted Successfully!.');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    
    public function activitylog(Request $request, $user)
    {

         $activitys = DB::table('activity_log')->where('customer_id', $user)->orderBy('id', 'DESC')->get();
         
         foreach($activitys as $activity){
             
             $manage = DB::table('users')->where('id', $activity->manage_id)->first();
             
             $customer = DB::table('customer')->where('id', $activity->customer_id)->first();
             $role = DB::table('roles')->where('id', $activity->role_id)->first();
             $activity->managename = $manage->first_name.' '.$manage->last_name;
             $activity->email = $manage->email;
             $activity->customername = $customer->first_name.' '.$customer->last_name;
             $activity->rolename = $role->name;
         }
         
         $customeremail = DB::table('customer')->where('id', $user)->first();
         $cust_email = $customeremail->email;
         
        return view('customer.activitylog', ['activitys' => $activitys,'cust_email' => $cust_email]);
        
        
    }

}



