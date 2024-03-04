@extends('admin.index_admin')



@section('titlePage')

    CCSTNexus | add department

@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Create subject</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          
          <div class="col-12">
            
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Add subject to the list</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
              <div class="card-body">
              <form id="myForm" method="POST" action="{{ route('admin.adding_subjects') }}">
              @csrf
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="employee_no">Subject code<sup class="sup">*</sup></label>
                            <input type="text" class="form-control" id="code" name="code" placeholder="Subject code">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="employee_no">Title<sup class="sup">*</sup></label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="first_name">Description<sup class="sup"></sup></label>
                            <input type="text" class="form-control" id="desc"  name="desc" placeholder="Description">
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="first_name">Lecture<sup class="sup">*</sup></label>
                            <div style="position:relative">
                                <input type="text" onkeyup="validateInput(this)" class="form-control" id="lect"  name="lect" placeholder="Lecture">
                                <div class="addMinus"><button class="btn bg-gradient-secondary" onclick="addings2('add')" type="button">+</button><button  onclick="addings2('minus')"  class="btn bg-gradient-secondary" type="button">-</button></div>
                            </div>
                        </div>
                    </div>
                    <script>
                        function validateInput(input) {
                            input.value = input.value.replace(/[^0-9]/g, '').replace(/^-/,'');
                            
                        }
                    </script>

                    <div class="col-sm-2">
                        <div class="form-group" >
                            <label for="first_name">Lab<sup class="sup"></sup></label>
                            
                            <div style="position:relative">
                    
                                <input type="text" style="background-color:transparent" readonly class="form-control" id="lab" name="lab" placeholder="Lab">
                                 <div class="addMinus"><button class="btn bg-gradient-secondary" onclick="addings('add')" type="button">+</button><button  onclick="addings('minus')"  class="btn bg-gradient-secondary" type="button">-</button></div>
                            </div>
                        </div>
                    </div>
                    <script>
                        var varValues = 0;
                        var varValues2 = 0;
                        function addings(mode){
                            var lab = document.getElementById('lab');
                            
                                if(mode == "add"){
                                    
                                    
                                        varValues++;
                                        if(varValues == 20 ){
                                            varValues = 19;
                                        }
                                        lab.value = varValues;
                                
                                }
                                else if(mode == "minus"){
                                
                                        varValues--;
                                        
                                        if(varValues == -1 ){
                                            varValues = 0;
                                        }
                                        lab.value = varValues;
                                
                                }
                            
                        }

                        function addings2(mode){
                            var sa = document.getElementById('lect');
                            
                                if(mode == "add"){
                                    
                                    
                                    varValues2++;
                                        if(varValues2 == 20 ){
                                            varValues2 = 19;
                                        }
                                        sa.value = varValues2;
                                
                                }
                                else if(mode == "minus"){
                             
                                    varValues2--;
                                        
                                        if(varValues2 == 0 ){
                                            varValues2 = 1;
                                        }
                                        sa.value = varValues2;
                                
                                }
                            
                        }
                        addings2('add');
                        addings('minus');
                    </script>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="first_name">Pre-requisite<sup class="sup"></sup></label>
                            <div  class="dropdown">
                            <input class=" form-control" style="text-align:left;background-color:transparent" type="button" id="dropdownMenuButton"  value="Choose pre-requisite" readonly data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span style="display:none" class="resetingspre" id="resetID" ><span onclick="resetings(this)">reset pre-requisite</span></span>
                            <input type="hidden" id="searchedvalue" name="pre">
                            
                            <div class="dropdown-menu" id="preq" aria-labelledby="dropdownMenuButton">
                                <input onkeyup="getvals(this)" class="form-control searchingSubs" style="" id="searchFill" placeholder="Search" type="text">
                               
                            </div>
                            </div>
               
                        </div>
                        <script>
                            function resetings(mine){
                                var resetID = document.getElementById('resetID');
                                var dropdownMenuButton = document.getElementById('dropdownMenuButton');
                                var searchedvalue = document.getElementById('searchedvalue');
                                dropdownMenuButton.value = 'Choose pre-requisite';
                                searchedvalue.value = '';

                                  
                                  resetID.style.display = "none";
                            }
                            function resetings2(mine){
                                  
                                  
                                  var resetID = document.getElementById('resetID');
                           
                                  

                                  
                                  resetID.style.display = "flex";
                                 
                 
                              
                              


                            }
                            function focusing(){
                          
                                var searchFill = document.getElementById('searchFill');
                                
                                
                                searchFill.focus();
                            }
                            focusing();


                           

                            const Descriptions = [
                                
                                @foreach($departments as $items)

                                 '{{$items->sub_code}}',
                                @endforeach
                            ];

                            const allItems = [
                                
                                @foreach($departments as $items)

                                 '{{$items->sub_code}} - {{Str::limit($items->title, 30, "...")}}',
                                @endforeach
                            ];

                            const Ids = [
                                
                                @foreach($departments as $items)

                                 '{{$items->id}}',
                                @endforeach
                            ];



                            function getvals(searching){
                                refresh();
                                
                                resets();
                                

                                const searchTerm = searching.value.toLowerCase(); 
                                const find = allItems.filter(fruit => fruit.toLowerCase().includes(searchTerm)); 
                                
                                for (var x = 0; x < find.length; x++) {
                                    var preq = document.getElementById('preq');

                                    const buttonElement = document.createElement('button');
                                    const i = allItems.indexOf(find[x]);
                                    buttonElement.setAttribute('onclick', 'changeValue('+"'"+Descriptions[i]+"'"+');changeValueSearched('+"'"+Ids[i]+"'"+');resetings2(this)'); 
                                    buttonElement.setAttribute('value', Descriptions[i]);
                                    buttonElement.setAttribute('type', 'button');
                                    buttonElement.setAttribute('class', 'dropdown-item');
                                    buttonElement.innerText = find[x];


                                    

                                    preq.appendChild(buttonElement);
                                }
                                

                            }


                            function refresh(){
                                
                                


                                resets();
                                const searchTerm = '';

                                const find = allItems.filter(fruit => fruit.includes(searchTerm));
                                
                                
                                for(var x = 0; x != find.length; x++){
                                
                                    var preq = document.getElementById('preq');

                                    const buttonElement = document.createElement('button');
                                    buttonElement.setAttribute('onclick', 'changeValue('+"'"+Descriptions[x]+"'"+');changeValueSearched('+"'"+Ids[x]+"'"+');resetings2(this)'); 
                                    buttonElement.setAttribute('value', Descriptions[x]);
                                    buttonElement.setAttribute('type', 'button');
                                    buttonElement.setAttribute('class', 'dropdown-item');
                                    buttonElement.innerText = find[x];

                                    preq.appendChild(buttonElement);
                                }
                                

                            }
                            refresh();
                            
                            function changeValue(valueGets){
                               
                                var preq = document.getElementById('dropdownMenuButton');
                                preq.value = valueGets;
                         

                            }
                            function changeValueSearched(valueGets){
                                var searchedvalue = document.getElementById('searchedvalue');
                               
                                searchedvalue.value = valueGets;
                             

                            }
                            function resets(){
                                var preq = document.getElementById('preq');

                                // Get all child elements of the parent
                                var childElements = preq.children;

                                
                                for (var i = childElements.length - 1; i >= 0; i--) {
                                
                                if (childElements[i].tagName.toLowerCase() !== 'input') {
                                    
                                    preq.removeChild(childElements[i]);
                                }
                                }
                            }
                        </script>
                        
                    </div>

                   
                  
                
              
                </div>

      

                <div class="d-flex gap-flex">
                    <a href="{{ route('admin.subjects') }}"><button type="button" class="btn bg-gradient-secondary" id="submit_button" onclick="">Back</button></a>
                    <button type="button" class="btn bg-gradient-success" id="submit_buttons" onclick="validateForm();">Add subject</button>
                    
                </div>
            </form>
                @if (session('success'))
                    <script>
                        $(document).ready(function () {
                            
                            
                                Swal.fire({
                                    
                                    text: "{{ session('success')['title'] }}",
                                    icon: "{{ session('success')['icon'] }}",
                                });
                            
                        });
                    </script>
                @endif
           
                <script>
                    
              
                


                  
                    
            
                    var employeeExist = false;
                    var emailExistscode = false;
                    
                    var emailExists = false;
                    var isValid = true;
                    // Function to validate the form

                    function validateForm(){
                        var code = document.getElementById('code').value.trim();
                        var title = document.getElementById('title').value.trim();
                        const desc = document.getElementById("desc").value;
              

    

                            jQuery.ajax({
                                    
                                                    
                                    url: "{{ url('admin/checkIftitlesexistSubject') }}",
                                    data: {
                         
                                        datacheckTitle: title,
                                        datacheckCode: code,
                                    },
                                    type: 'post',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },

                                    success:function(result)
                                    {
                                        

                                        emailExistscode = result.code;
                                        emailExists = result.title;
                          
                                        validateForm_second();
                                    
                                    }

                                
                                });


                        
                    }

                    
                    
                    function validateForm_second() {
                        
                        isValid = true;

                        // Reset borders and error messages
                        resetValidation();

                        // Validation for First Name, Middle Name, and Last Name


                        // Validation for Email
                        var code = document.getElementById('code').value.trim();
                        var title = document.getElementById('title').value.trim();
                        var desc = document.getElementById('desc').value.trim();
                        var lect = document.getElementById('lect').value.trim();
                        var lab = document.getElementById('lab').value.trim();
                        var pre = document.getElementById('searchedvalue').value.trim();
                        if(  
                            
                            code !== "" &&
                            title !== "" &&
                     
                            
                            lect !== "" 
                  
                           
                         
                            ){


                            if (!code || code.length < 2 || code.length > 100) {
                                modals("Subject code should have a minimum of 2 characters and a maximum of 100 characters.");
                                markAsInvalid(document.getElementById('code'));
                                isValid = false;
                            }
                            else if(!title || title.length < 2 || title.length > 100){
                                modals("Subject title should have a minimum of 2 characters and a maximum of 100 characters.");
                                markAsInvalid(document.getElementById('title'));
                                isValid = false;
                            }

                         
                            else if( !lect || lect.length > 80){
                                modals("Lecture should have a minimum of 2 digits and a maximum of 80 digits.");
                                markAsInvalid(document.getElementById('lect'));
                                isValid = false;
                            }
                            else if(emailExists){
                                modals("Subject code  and title already exists.");
                                markAsInvalid(document.getElementById('title'));
                                isValid = false;

                                markAsInvalid(document.getElementById('code'));
                             
                            }
                           

                            else if(!lab || lab > 3){
                                modals("Lab should have a minimum of 1 digits and a maximum of 3 digits.");
                                markAsInvalid(document.getElementById('lab'));
                                isValid = false;
                            }
                        
                            
                                

                            
                            
                            
                            if (isValid) {
                                Swal.fire({
                                    title: '',
                                    text: "Are you sure you want to add this department?",
                                    icon: 'question',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes, add it!'
                                    }).then((result) => {
                                    if (result.isConfirmed) {
                                        document.getElementById('myForm').submit();
                                    }
                                })
                                
                            }
    



                        
                        
                    }
                    else{
                        modals("Please fill all the information needed.");
                        isValid = false;
                    }
                      
                        
                        
   
                      
                   
                    
                    }



                    function modals(message){

                        Swal.fire({
                        icon: 'error',
                        title: 'Invalid input',
                        text: message,
                        confirmButtonText: "Back",
                        }
                        
                        
                        )

                        

                    }

                    // Function to mark an input as invalid (add red border)
                    function markAsInvalid(inputElement) {
                        inputElement.style.borderColor = "rgb(165, 73, 73)";
                    }



                    // Function to reset input styles and error messages
                    function resetValidation() {
                        const inputs = document.querySelectorAll("input");
                        for (const input of inputs) {
                            input.style.borderColor = "";
                        }
                    }

                    
                    function validateInput(input) {
                        input.value = input.value.replace(/[^0-9-]/g, '');
                        document.getElementById("email").value = input.value;
                    }

                    
                   
                </script>
                
              </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  
@endsection