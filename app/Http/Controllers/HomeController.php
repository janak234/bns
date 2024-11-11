<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $users = DB::table('customer')->count();
        $transactions = DB::table('transaction')->count();
        $totalAmount = DB::table('transaction')->sum('amount');

        $today = Carbon::today();
        $now = Carbon::now();
        $oneWeekLater = $now->copy()->addWeek();    
        $expiringLicenses = DB::table('customer')->where('license_expire', '>=', $today)->where('license_expire', '<=', $oneWeekLater)->get();
        
       
        $license = DB::table('customer')->where('license_expire', '<', $today)->get();
        
        
        // transaction
        
                $query = "
        SELECT
            t.*,
            COALESCE(CONCAT(c.first_name, ' ', c.last_name), 'Unknown User') AS customer_fullname
        FROM
            transaction t
        LEFT JOIN
            customer c ON t.customer_id = c.id where t.is_cheked = '1'";

    // Get the current page from the request query string
    $perPage = 10;
    $currentPage = $request->query('page', 1);
    
    $offset = ($currentPage - 1) * $perPage;

    
    $paginatedQuery = $query . " LIMIT $perPage OFFSET $offset";
    $transactiondata = DB::select(DB::raw($paginatedQuery));
    
    foreach($transactiondata as $tran){
        $companys = DB::table('company')->where('id',$tran->company)->first();
        $tran->compnyname = $companys->name;
    }

    // Create a paginator manually
    $totalQuery = "SELECT COUNT(*) as total FROM ($query) as count_table";
    $totalResults = DB::select(DB::raw($totalQuery));
    $total = $totalResults[0]->total;

    $paginator = new Paginator($transactiondata, $perPage, $currentPage, [
        'path' => Paginator::resolveCurrentPath(),
        'pageName' => 'page',
        'total' => $total,
    ]);

    

       return view('home', ['users' => $users, 'transactions' => $transactions, 'totalAmount' =>$totalAmount,'license'=>$license, 'expiringLicenses' =>$expiringLicenses, 'fradtransactions' =>$paginator]);
    }

    public function getAdjustedTotals(Request $request, $timePeriod)
    {
        $startDate = null;
        $endDate = now(); // Current date

        // Calculate start and end date based on the selected time period
        switch ($timePeriod) {
            case 'day':
                $startDate = now()->startOfDay();
                break;
            case 'week':
                $startDate = now()->startOfWeek();
                break;
            case 'month':
                $startDate = now()->startOfMonth();
                break;
            case 'year':
                $startDate = now()->startOfYear();
                break;
            case 'yesterday':
                $startDate = now()->subDay()->startOfDay();
                $endDate = now()->subDay()->endOfDay();
                break;
            default:
                break;
        }

        // Adjust totals based on the selected time period
        $users = DB::table('customer')->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate)->count();
        $transactions = DB::table('transaction')->where('date', '>=', $startDate)->where('date', '<=', $endDate)->count();
        $totalAmount = DB::table('transaction')->where('date', '>=', $startDate)->where('date', '<=', $endDate)->sum('amount');

        return response()->json([
            'users' => $users,
            'transactions' => $transactions,
            'totalAmount' => $totalAmount,
        ]);
    }
    /**
     * User Profile
     * @param Nill
     * @return View Profile
     * @author Shani Singh
     */
    public function getProfile()
    {
        return view('profile');
    }

    /**
     * Update Profile
     * @param $profileData
     * @return Boolean With Success Message
     * @author Shani Singh
     */
    public function updateProfile(Request $request)
    {
        #Validations
        $request->validate([
            'first_name'    => 'required',
            'last_name'     => 'required',
            'mobile_number' => 'required|numeric|digits:10',
        ]);

        try {
            DB::beginTransaction();
            
            #Update Profile Data
            User::whereId(auth()->user()->id)->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'mobile_number' => $request->mobile_number,
            ]);

            #Commit Transaction
            DB::commit();

            #Return To Profile page with success
            return back()->with('success', 'Profile Updated Successfully.');
            
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Change Password
     * @param Old Password, New Password, Confirm New Password
     * @return Boolean With Success Message
     * @author Shani Singh
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        try {
            DB::beginTransaction();

            #Update Password
            User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
            
            #Commit Transaction
            DB::commit();

            #Return To Profile page with success
            return back()->with('success', 'Password Changed Successfully.');
            
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }
}
