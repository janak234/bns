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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\Paginator;
use Auth;

class TransactionController extends Controller
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
    public function index(Request $request)
    {
        $query = "
        SELECT
            t.*,
            COALESCE(CONCAT(c.first_name, ' ', c.last_name), 'Unknown User') AS customer_fullname
        FROM
            transaction t
        LEFT JOIN
            customer c ON t.customer_id = c.id";

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

    return view('transaction.index', ['users' => $paginator]);
    }
    
    public function search(Request $request)
    {
        $item = $request->input('item');
        $keyword = $request->input('keyword');

        if($item=='name'){
            $query = "
            SELECT t.*, COALESCE(CONCAT(c.first_name, ' ', c.last_name), 'Unknown User') AS customer_fullname
            FROM transaction t
            LEFT JOIN customer c ON t.customer_id = c.id
            WHERE CONCAT(c.first_name, ' ', c.last_name) LIKE '%$keyword%'
             ";
    
            $perPage = 10;
            $currentPage = $request->query('page', 1);        
            $offset = ($currentPage - 1) * $perPage;    
            $paginatedQuery = $query . " LIMIT $perPage OFFSET $offset";
            $transactions = DB::select(DB::raw($paginatedQuery));
            
            $totalQuery = "SELECT COUNT(*) as total FROM ($query) as count_table";
            $totalResults = DB::select(DB::raw($totalQuery));
            $total = $totalResults[0]->total;
        
            $paginator = new Paginator($transactions, $perPage, $currentPage, [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => 'page',
                'total' => $total,
            ]);
    
        return view('transaction.index', ['users' => $paginator,'item'=>$item,'keyword'=>$keyword]);

        }
        else {
            $query = "
            SELECT t.*, COALESCE(CONCAT(c.first_name, ' ', c.last_name), 'Unknown User') AS customer_fullname
            FROM transaction t
            LEFT JOIN customer c ON t.customer_id = c.id
            WHERE t.$item LIKE '%$keyword%'
             ";
    
            $perPage = 10;
            $currentPage = $request->query('page', 1);        
            $offset = ($currentPage - 1) * $perPage;    
            $paginatedQuery = $query . " LIMIT $perPage OFFSET $offset";
            $transactions = DB::select(DB::raw($paginatedQuery));
            
            $totalQuery = "SELECT COUNT(*) as total FROM ($query) as count_table";
            $totalResults = DB::select(DB::raw($totalQuery));
            $total = $totalResults[0]->total;
        
            $paginator = new Paginator($transactions, $perPage, $currentPage, [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => 'page',
                'total' => $total,
            ]);
    
            return view('transaction.index', ['users' => $paginator,'item'=>$item,'keyword'=>$keyword]);

        }
        //return view('transaction.index', ['users' => $users,'item'=>$item,'keyword'=>$keyword]);
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
        $users = DB::table('customer')->get();
        $companys = DB::table('company')->get();
        return view('transaction.add', ['roles' => $roles,'customers' =>$users,'companys'=>$companys]);
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
            'customer_id' => 'required',
            'date' => 'required',
            'company' =>  'required',
            'amount' =>  'required',
            'description' =>  'required',
            'status'=>  'required',
            'bank_name'=>  'required',
            'routing'=>  'required',
            'account_number'=>  'required',
        ]);


        DB::beginTransaction();
        try {
            
            if($request->has('fraud_checked')) {
                $checked = '1';
            }
            else{
                $checked = '0';
            }
            
            DB::table('transaction')->insert([
 
                'date' => $request->date,
                'customer_id' => $request->customer_id,
                'company' =>  $request->company,
                'amount' =>  $request->amount,
                'description' =>  $request->description,
                'is_cheked'=>  $checked,
                'status'=>  $request->status,
                'bank_name'=>  $request->bank_name,
                'routing'=>  $request->routing,
                'account_number'=>  $request->account_number,
      
            ]);
           

            // Commit And Redirected To Listing
            DB::commit();
            
            
            // add activity log
            
            $id = Auth::id();
            $auth = Auth::user();
            $transaction = DB::table('transaction')->orderBy('id', 'DESC')->first();
            
            DB::table('activity_log')->insert([              
                'manage_id' => $id,
                'transaction_id' => $transaction->id,
                'role_id' => $auth->role_id,
                'action' => 'add',
            ]);
           
           
            // Commit And Redirected To Listing
            DB::commit();
            
            
            return redirect()->route('transaction.index')->with('success','Transaction Added Successfully.');

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
     
        $transaction = DB::table('transaction')->where('id', $user)->first();
        $users = DB::table('customer')->get();
        $companys = DB::table('company')->where('customer_id',$transaction->customer_id)->get();
        $new_user = DB::table('customer')->where('id',$transaction->customer_id)->first();
        $new_company = DB::table('company')->where('id',$transaction->company)->first();
        
        return view('transaction.edit')->with([
            'transaction'  => $transaction,'customers' =>$users,'companys'=>$companys,'new_user'=>$new_user,'new_company'=>$new_company
        ]);
    }

    /**
     * Update User
     * @param Request $request, User $user
     * @return View Users
     * @author Shani Singh
     */
    public function update(Request $request, $userid)
    {
        // Validations
           $request->validate([
            'customer_id' => 'required',
            'date' => 'required',
            'company' =>  'required',
            'amount' =>  'required',
            'description' =>  'required',
            'status'=>  'required',
            'bank_name'=>  'required',
            'routing'=>  'required',
            'account_number'=>  'required',
        ]);
        
    
        
        DB::beginTransaction();
        try {

            if($request->has('fraud_checked')) {
                $checked = '1';
            }
            else{
                $checked = '0';
            }

            // Store Data
            $user_updated = DB::table('transaction')->whereId($userid)->update([
                'date' => $request->date,
                'customer_id' => $request->customer_id,
                'company' =>  $request->company,
                'amount' =>  $request->amount,
                'description' =>  $request->description,
                'is_cheked'=>  $checked,
                'status'=>  $request->status,
                'bank_name'=>  $request->bank_name,
                'routing'=>  $request->routing,
                'account_number'=>  $request->account_number,
            ]);

          

            // Commit And Redirected To Listing
            DB::commit();
            
            // add activity log
            
            $id = Auth::id();
            $auth = Auth::user();
            
            DB::table('activity_log')->insert([              
                'manage_id' => $id,
                'transaction_id' => $userid,
                'role_id' => $auth->role_id,
                'action' => 'edit',
            ]);
           
           
            // Commit And Redirected To Listing
            DB::commit();
            
            return redirect()->route('transaction.index')->with('success','Transaction Details Updated Successfully.');

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
            DB::table('transaction')->whereId($user)->delete();

            DB::commit();
            
            // add activity log
            
            $id = Auth::id();
            $auth = Auth::user();
            
            DB::table('activity_log')->insert([              
                'manage_id' => $id,
                'transaction_id' => $user,
                'role_id' => $auth->role_id,
                'action' => 'delete',
            ]);
           
           
            // Commit And Redirected To Listing
            DB::commit();
            
            return redirect()->back()->with('success', 'Transaction Deleted Successfully!.');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function updateStatus($user_id, $status)
    {
        // Validation
        $validate = Validator::make([
            'user_id'   => $user_id,
            'status'    => $status
        ], [
            'user_id'   =>  'required',
            'status'    =>  'required|in:0,1',
        ]);

        // If Validations Fails
        if($validate->fails()){
            return redirect()->route('transaction.index')->with('error', $validate->errors()->first());
        }

        try {
            DB::beginTransaction();

            // Update Status
            $user_updated = DB::table('transaction')->whereId($user_id)->update([
                'status'=>  $status
            ]);

            // Commit And Redirect on index with Success Message
            DB::commit();
            
            
            // add activity log
            
            $id = Auth::id();
            $auth = Auth::user();
            
            DB::table('activity_log')->insert([              
                'manage_id' => $id,
                'transaction_id' => $user_id,
                'role_id' => $auth->role_id,
                'action' => 'edit',
            ]);
           
           
            // Commit And Redirected To Listing
            DB::commit();
            
            
            return redirect()->route('transaction.index')->with('success','Transaction Status Updated Successfully!');
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

     public function activitylog(Request $request, $user)
    {

         $activitys = DB::table('activity_log')->where('transaction_id', $user)->orderBy('id', 'DESC')->get();
         
         foreach($activitys as $activity){
             
             $manage = DB::table('users')->where('id', $activity->manage_id)->first();
             $transaction = DB::table('transaction')->where('id', $activity->transaction_id)->first();
             
             $customer = DB::table('customer')->where('id', $transaction->customer_id)->first();
             $role = DB::table('roles')->where('id', $activity->role_id)->first();
             $activity->managename = $manage->first_name.' '.$manage->last_name;
             $activity->email = $manage->email;
             $activity->customername = $customer->first_name.' '.$customer->last_name;
             $activity->rolename = $role->name;
         }
         
         $transactiondata = DB::table('transaction')->where('id', $user)->first();
         $transaction_id = $transactiondata->id;
         
        return view('transaction.activitylog', ['activitys' => $activitys,'transaction_id' => $transaction_id]);
        
        
    }

    public function customercompany(Request $request)
    {
        
        $names = DB::table('company')->where('customer_id',$request->customer_id)->get();
        
        $html = '';
        // $html = '<option value="">Select Company</option>';
       
        foreach($names as $name){
            // $html .= '<option value="'.$name->id.'">'.$name->name.'</option>';
            $html .= '<a class="dropdown-item" data-company_id="'.$name->id.'">'.$name->name.'</a>';
        }
        
         return response()->json($html);
    }
    
    public function searchcustomer(Request $request)
    {
         
        if($request->name == ''){
            $names = DB::table('customer')->get();
        }
        else{
            $names = DB::table('customer')->where('first_name', 'like', '%'.$request->name.'%')->orwhere('last_name', 'like', '%'.$request->name.'%')->get();
        }
        
        $html = '';
        // $html = '<option value="">Select Customer</option>';
       
        foreach($names as $name){
            // $html .= '<option value="'.$name->id.'">'.$name->first_name.' '.$name->last_name.'</option>';
            $html .= '<a class="dropdown-item" data-customer_id="'.$name->id.'">'.$name->first_name.' '.$name->last_name.'</a>';
        }
        
         return response()->json($html);
    }
    
    public function searchcompany(Request $request)
    {
        
        if($request->name == ''){
            $names = DB::table('company')->where('customer_id',$request->customer_id)->get();
        }
        else{
            $names = DB::table('company')->where('name', 'like', '%'.$request->name.'%')->where('customer_id',$request->customer_id)->get();
        }
        
        $html = '';
        // $html = '<option value="">Select Company</option>';
       
        foreach($names as $name){
            // $html .= '<option value="'.$name->id.'">'.$name->name.'</option>';
            $html .= '<a class="dropdown-item" data-company_id="'.$name->id.'">'.$name->name.'</a>';
        }
        
         return response()->json($html);
    }

}
