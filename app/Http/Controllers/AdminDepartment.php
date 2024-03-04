<?php

namespace App\Http\Controllers;
use App\Models\AdminDepartments;
use Illuminate\Http\Request;

class AdminDepartment extends Controller
{
    public function index(){
        $departments = AdminDepartments::all();

        return view('admin.departments', compact('departments'));
    }


    public function add_department ()
    {
        
      
        return view('admin.add_department');
    }

    public function checkIftitlesexist(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('admin.index');
        }
        
        $existingEmployee = AdminDepartments::where('title', $request->input('datacheckTitle'))->first();

    

        if ($existingEmployee) {
            return response()->json(['title' => true,]);
        } 
    
        else {
            
            return response()->json(['title' => false]);
        }
    }

    public function adding_departments  (Request $request)
    {

        $request->validate([
            'title' => 'required|string|between:1,100|unique:departments,title',
            'desc' => 'nullable|string|between:0,30',
           

           
           
        ]);
        
        $add_info_admin = new AdminDepartments([
          
            'title' => trim($request->input('title')),
            'description' => trim($request->input('desc')),
            'acadYr' => ''
        ]);

        $add_info_admin->save();



        $searchingDept = AdminDepartments::all();
                $departmentsList = [];
                foreach($searchingDept as $found){

                    if(strtolower($found->title) == 'college'){
                        $newDepartments = [
                            'College' => ['title' => 'College', 
                            'routes' => 'admin.College_curriculum',
                            'route' => route('admin.College_curriculum')
                          ],
                        ];

                        
                    }
                    else if(strtolower($found->title) == 'shs' || strtolower($found->title) == 'senior high school'){
                        $newDepartments = [
                            'college' => ['title' => 'SHS', 
                            'routes' => 'admin.SHS_curriculum',
                            'route' => route('admin.SHS_curriculum')
                            ],
                        ];
                    }
                    else{
                        $newDepartments = [
                            $found->title => ['title' => $found->title, 
                            'routes' => 'admin.index',
                            'route' => route('admin.index')
                            ],
                        ];
                    }
                    $departmentsList = array_merge($departmentsList, $newDepartments);
                    

                }


                $searchingDept = AdminDepartments::all();
                $sectionList = [];

                foreach($searchingDept as $found){
                    
                    $id = $found->id;
                    $route = route('admin.section', ['department' => $id]);
                    $newDepartments = [
                        $found->title => ['title' => $found->title, 
                        'route' => $route,
                        'routes' => 'fromController',
                        'idControll' => $id,
                        ],
                    ];

                        
                    
                    $sectionList = array_merge($sectionList, $newDepartments);
                    

                }

                
                session(['departmentsList' => $departmentsList, 'sectionList' => $sectionList]);
        
        $success = [

            'icon' => 'success',
            'title' => 'Added successfully!',
        ];

       
     
    
        
        return back()->with('success', $success);
    }

    public function update_department  (Request $request, $id)
    {

        
        $existingEmployee = AdminDepartments::where('id', $id)->first();


       
     
    
        
        return view('admin.update_department', compact('existingEmployee'));
    }
    public function updating_department  (Request $request, $id)
    {
        $add_info_admin = AdminDepartments::where('id', $id)->first();
        if(trim($request->input('title')) != $add_info_admin->title){
            $testing = 'required|string|between:1,100|unique:departments,title';
        }
        else{
            $testing = 'required|string|between:1,100';
        }

        $request->validate([
            'title' => $testing,
            'desc' => 'nullable|string|between:0,30',
           

           
           
        ]);
        
        $add_info_admin = AdminDepartments::where('id', $id)->first();

       
          
        $add_info_admin->title = trim($request->input('title'));
        $add_info_admin->description = trim($request->input('desc'));
        $add_info_admin->acadYr = '';
    

        $add_info_admin->save();

        $searchingDept = AdminDepartments::all();
                $departmentsList = [];
                foreach($searchingDept as $found){

                    if(strtolower($found->title) == 'college'){
                        $newDepartments = [
                            'College' => ['title' => 'College', 
                            'routes' => 'admin.College_curriculum',
                            'route' => route('admin.College_curriculum')
                          ],
                        ];

                        
                    }
                    else if(strtolower($found->title) == 'shs' || strtolower($found->title) == 'senior high school'){
                        $newDepartments = [
                            'college' => ['title' => 'SHS', 
                            'routes' => 'admin.SHS_curriculum',
                            'route' => route('admin.SHS_curriculum')
                            ],
                        ];
                    }
                    else{
                        $newDepartments = [
                            $found->title => ['title' => $found->title, 
                            'routes' => 'admin.index',
                            'route' => route('admin.index')
                            ],
                        ];
                    }
                    $departmentsList = array_merge($departmentsList, $newDepartments);
                    

                }


                $searchingDept = AdminDepartments::all();
                $sectionList = [];

                foreach($searchingDept as $found){
                    
                    $id = $found->id;
                    $route = route('admin.section', ['department' => $id]);
                    $newDepartments = [
                        $found->title => ['title' => $found->title, 
                        'route' => $route,
                        'routes' => 'fromController',
                        'idControll' => $id,
                        ],
                    ];

                        
                    
                    $sectionList = array_merge($sectionList, $newDepartments);
                    

                }

                
                session(['departmentsList' => $departmentsList, 'sectionList' => $sectionList]);
        
        $success = [

            'icon' => 'success',
            'title' => 'Updated successfully!',
        ];

       
     
    
        
        return back()->with('success', $success);
    }

    public function delete_department(Request $request, $id, $password)
    {

        $hashedPassword = base64_decode($password);

        $password = 'this_is_password123';
        $key = 'CCST_2005';

        
        $ComparingHash = hash_hmac('sha256', $password, $key);

     

  
        if($hashedPassword === $ComparingHash){
           
       
    
            $finding_user_acc = AdminDepartments::where('id', $id)->first();

            $name = $finding_user_acc->title;

            $finding_user_acc->delete();

        
            $searchingDept = AdminDepartments::all();
            $departmentsList = [];
            foreach($searchingDept as $found){

                if(strtolower($found->title) == 'college'){
                    $newDepartments = [
                        'College' => ['title' => 'College', 
                        'routes' => 'admin.College_curriculum',
                        'route' => route('admin.College_curriculum')
                      ],
                    ];

                    
                }
                else if(strtolower($found->title) == 'shs' || strtolower($found->title) == 'senior high school'){
                    $newDepartments = [
                        'college' => ['title' => 'SHS', 
                        'routes' => 'admin.SHS_curriculum',
                        'route' => route('admin.SHS_curriculum')
                        ],
                    ];
                }
                else{
                    $newDepartments = [
                        $found->title => ['title' => $found->title, 
                        'routes' => 'admin.index',
                        'route' => route('admin.index')
                        ],
                    ];
                }
                $departmentsList = array_merge($departmentsList, $newDepartments);
                

            }


            $searchingDept = AdminDepartments::all();
            $sectionList = [];

            foreach($searchingDept as $found){
                
                $id = $found->id;
                $route = route('admin.section', ['department' => $id]);
                $newDepartments = [
                    $found->title => ['title' => $found->title, 
                    'route' => $route,
                    'routes' => 'fromController',
                    'idControll' => $id,
                    ],
                ];

                    
                
                $sectionList = array_merge($sectionList, $newDepartments);
                

            }

            
            session(['departmentsList' => $departmentsList, 'sectionList' => $sectionList]);
    


            $success = [
                'title' => 'Deleted successfully!',
                'icon' => 'success',
                'text' => $name,
            ];
    
            
    
             return redirect()->route('admin.departments')->with('delete_success', $success);
           

        }
       

        
    }

    public function delete_multiple_department(Request $request){
        
        $storedHash = base64_decode($request->input('password'));

        $data = "this_is_password123"; 
        $key = "CCST_2005"; 


        $computedHash = hash_hmac("sha256", $data, $key);


        if($computedHash === $storedHash){
        
            $formData = $request->input('id');


            $dataArray = [];
            parse_str($formData, $dataArray);
    
            
            $token = $dataArray['_token'];
            $checkboxValues = $dataArray['checkboxes'];
            $counts = 0;
    
            foreach ($checkboxValues as $checkboxValue) {
    
            
    
                $finding_user_acc = AdminDepartments::where('id', $checkboxValue)->first();
                $finding_user_acc->delete();



    
                $counts++;
            }
    
            
            $searchingDept = AdminDepartments::all();
            $departmentsList = [];
            foreach($searchingDept as $found){

                if(strtolower($found->title) == 'college'){
                    $newDepartments = [
                        'College' => ['title' => 'College', 
                        'routes' => 'admin.College_curriculum',
                        'route' => route('admin.College_curriculum')
                      ],
                    ];

                    
                }
                else if(strtolower($found->title) == 'shs' || strtolower($found->title) == 'senior high school'){
                    $newDepartments = [
                        'college' => ['title' => 'SHS', 
                        'routes' => 'admin.SHS_curriculum',
                        'route' => route('admin.SHS_curriculum')
                        ],
                    ];
                }
                else{
                    $newDepartments = [
                        $found->title => ['title' => $found->title, 
                        'routes' => 'admin.index',
                        'route' => route('admin.index')
                        ],
                    ];
                }
                $departmentsList = array_merge($departmentsList, $newDepartments);
                

            }


            $searchingDept = AdminDepartments::all();
            $sectionList = [];

            foreach($searchingDept as $found){
                
                $id = $found->id;
                $route = route('admin.section', ['department' => $id]);
                $newDepartments = [
                    $found->title => ['title' => $found->title, 
                    'route' => $route,
                    'routes' => 'fromController',
                    'idControll' => $id,
                    ],
                ];

                    
                
                $sectionList = array_merge($sectionList, $newDepartments);
                

            }

            
            session(['departmentsList' => $departmentsList, 'sectionList' => $sectionList]);
            
    
            return response()->json(['success' => $counts]);
           

        }
       
       


 
 
    }

}
