<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rules;
use App\Exports\ExportUsers;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.index');
    }

    public function export(Request $request)
    {
        return Excel::download(new ExportUsers($request), 'users.xlsx');
    }

     /**
	 * Display users in datable using ajax
	 * @author kevin patel
	 * @create_at 22-12-2020
	 * @return \Illuminate\Http\Response
	 */
	public function getStaffList(Request $request) {

		if ($request->ajax()) {
            $search = trim($request->search);
			$user = User::select(\DB::raw('CASE WHEN user_type = 2 THEN "Admin" ELSE "Staff" END AS user_type'),\DB::raw('CASE WHEN status = 0 THEN "Inactive" ELSE "Active" END AS user_status'),'name' ,'email','status', 'id','created_at as created_at');
			if ($search) {
				$user->havingRaw('name LIKE "%' . $search . '%" OR email LIKE "%' . $search . '%" OR user_type LIKE "%' . $search . '%" OR user_status LIKE "' . $search . '" OR created_at LIKE "%' . $search . '%"');
			}
            if ($request->order['0']['column'] == 0) {
				$user = $user->orderBy('id', 'desc');
			}

			{
				return Datatables::eloquent($user)
					//->addIndexColumn()
                    ->editColumn('user_status', function ($row) {
                        $btn = '';

                        \Log::info($row->user_status);
                        if($row->user_status == 'Active'){
                            $btn .= '<span class="badge bg-success">Active</span>';
                        }
                        else{
                            $btn .= '<span class="badge bg-danger">Inactive</span>';
                        }

						return $btn;
                    })
					->addColumn('action', function ($row) {
						$btn = '';

                        if($row->id != \Auth::user()->id){
                            $checked = '';
                            if($row->status == 1){
                                $checked = 'checked';
                            }

                            $btn .= '<div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input updateStatus" data-id="'.$row->id.'" type="checkbox" '.$checked.' id="flexSwitchCheckDefault_'.$row->id.'">
                            <label class="custom-control-label" for="flexSwitchCheckDefault_'.$row->id.'"></label>
                          </div>';

                           // $btn .= '<a href="/user/'.$row->id.'/show" data-toggle="tooltip" data-original-title="View" class="view viewUser text-info">View</a>&nbsp;&nbsp;&nbsp;';
                            $btn .= '<a href="/staffs/'.$row->id.'/edit" title="Edit" data-toggle="tooltip" data-original-title="Edit" class="edit editUser text-primary"><i class="fa fa-pencil-alt"></i></a>&nbsp;&nbsp;&nbsp;';
                            $btn .= '<a href="javascript:void(0)" title="Delete" data-toggle="tooltip"  data-toggle="modal" data-target="#model-delete" data-id="' . $row->id . '" data-original-title="Delete" class="text-danger deleteUser"><i class="fa fa-trash"></i></a>';
                        }


						return $btn;
					})->filter(function ($instance) use ($request) {

                    if ($request->user_filter != '') {
                    //\Log::info($request->user_filter);
                        $instance->where('user_type', $request->user_filter);
                    }

					// if (!empty($request->search)) {
					// 	$instance->where(function ($w) use ($request) {
					// 		$search = trim($request->search);
					// 		$w->orWhere('name', 'LIKE', "%$search%")
					// 			->orWhere('email', 'LIKE', "%$search%");
					// 	});
					// }
				})->rawColumns(['action','user_status'])->make(true);
			}

		}
	}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = 'NULL';
        Validator::extend('unique_email', function ($attribute, $value, $parameters) {
            //dd($value, $attribute, $parameters);
            $user = User::where('email', $value)->where('id', '!=', $parameters[0])->whereNull('deleted_at')->count();
            if ($user != 0) {
                return false;
            } else {
                return true;
            }
        }, 'Email id is already exists.');
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique_email:'.$id],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'user_type' => ['required'],
        ]);

        //dd("her");
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => $request->user_type,
            'password' => \Hash::make($request->password),
            'email_verified_at' => date('Y-m-d H:i:s')
        ]);

        if($user){
            return \Redirect::route('staffs')->with('success','Staff created successfully.');
        }
        else{
            return \Redirect::back()->with('error','Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        if($user){

            if(\Auth::user()->id == $user->user_id || \Auth::user()->user_type == 2){


                return view('users.edit',compact('user'));
            }
            else{
                return \Redirect::route('dashboard')->with('error','Not able to edit other users record.');
            }

        }
        else{
            return \Redirect::back()->with('error','Record not exist.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        Validator::extend('unique_email', function ($attribute, $value, $parameters) {
            //dd($value, $attribute, $parameters);
            $user = User::where('email', $value)->where('id', '!=', $parameters[0])->whereNull('deleted_at')->count();
            if ($user != 0) {
                return false;
            } else {
                return true;
            }
        }, 'Email id is already exists.');
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique_email:'.$request->id],
            'user_type' => ['required'],
            'password' => ['confirmed'],
        ]);
        //dd("hete");

        //dd("her");
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->user_type = $request->user_type;
        $user->email = $request->email;
        if($request->password != ''){
            $user->password = $request->password;
        }
       // dd(date('Y-m-d H:i:s'));
        if($user->email_verified_at == null){
            $user->email_verified_at = date('Y-m-d H:i:s');
        }

        $user->save();

      //  dd($user);

        if($user){
            return \Redirect::route('staffs')->with('success','Staff updated successfully.');
        }
        else{
            return \Redirect::back()->with('error','Something went wrong.');
        }
    }

    /**
	 * it is used delete specific record from workspace table based on id
	 * @author kevin patel
	 * @create_at 7-6-2023
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$ajax['flag'] = 0;
		$ajax['message'] = '';
		$ajax['data'] = '';
		try {
			$user = User::findOrFail($id);
            if($user){
                $user->delete();
            }
			$ajax['flag'] = 1;
			$ajax['message'] = 'User deleted successfully.';
			return response()->json($ajax);
		} catch (\Exception $e) {
			\Log::error($e);
			\Log::error($e->getMessage());
			$ajax['message'] = 'Something went wrong.';
			return response()->json($ajax);
		}
	}

     /**
	 * it is used delete specific record from workspace table based on id
	 * @author kevin patel
	 * @create_at 7-6-2023
	 * @return \Illuminate\Http\Response
	 */
	public function updateStatus(Request $request) {
		$ajax['flag'] = 0;
		$ajax['message'] = '';
		$ajax['data'] = '';
		try {
			$user = User::findOrFail($request->id);
            if($user){
               $user->status = $request->status;
               $user->save();
               $ajax['flag'] = 1;
               if($request->status == 1){
                $ajax['message'] = 'User activated successfully.';
               }
               else{
                $ajax['message'] = 'User inactivated successfully.';
               }
               return response()->json($ajax);
            }
            else{
                $ajax['message'] = 'User not found.';
                return response()->json($ajax);
            }

		} catch (\Exception $e) {
			\Log::error($e);
			\Log::error($e->getMessage());
			$ajax['message'] = 'Something went wrong.';
			return response()->json($ajax);
		}
	}

    // update user
    public function updateUser(Request $request) {
		$ajax['flag'] = 0;
		$ajax['message'] = '';
		$ajax['data'] = '';
		try {
			// $user = User::findOrFail($request->id);
            $user = User::where('wallet', $request->wallet)->firstOrFail();
            if($user){
               $user->role = $request->role;
               $user->status = $request->status=='true'?1:0;
               $user->image = $request->imageUrl;
               $user->save();
               $ajax['flag'] = 1;
            //    if($request->status == 1){
            //     $ajax['message'] = 'User activated successfully.';
            //    }
            //    else{
                $ajax['message'] = 'User update successfully.';
            //    }
               return response()->json($ajax);
            }
            else{
                $ajax['message'] = 'User not found.';
                return response()->json($ajax);
            }

		} catch (\Exception $e) {
			\Log::error($e);
			\Log::error($e->getMessage());
			$ajax['message'] = 'Something went wrong.';
			return response()->json($ajax);
		}
	}
}
