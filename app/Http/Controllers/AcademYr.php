<?php

namespace App\Http\Controllers;
use App\Models\acadYear;
use Illuminate\Http\Request;

class AcademYr extends Controller
{
    public function index()
    {        
        if (!session()->has('user_logged')) {
            return view('admin.login_page_admin');
        }
        
        
        $all_admin = acadYear::where('current', '1')->first();
        return view('admin.acad_year',compact('all_admin'));
    }

    public function update_acad(Request $request, $id, $password){
        $hashedPassword = base64_decode($password);

        $password = 'this_is_password123';
        $key = 'CCST_2005';

        
        $ComparingHash = hash_hmac('sha256', $password, $key);

     

  
        if($hashedPassword === $ComparingHash){

            $all_admin = acadYear::where('current', '1')->first();
            $all_admin->current = '0';
            $all_admin->save();

            $admin_add = new acadYear([
                'current' => '1',
                'year' => $id,
                
            ]);
    
            $admin_add->save();

        }

        $success = [

            'icon' => 'success',
            'title' => 'Updated successfully!',
        ];

        

         return back()->with('success', $success);
    }

}
