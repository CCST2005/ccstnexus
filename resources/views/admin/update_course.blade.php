@extends('admin.index_admin')



@section('titlePage')

    CCSTNexus | Edit academic program

@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit academic program</h1>
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
                <h3 class="card-title">Update academic program ({{$existingEmployee->course}})</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <div class="card-body">
              <form id="myForm" method="POST" action="{{ route('admin.updating_track', ['id' => $existingEmployee->id]) }}"  enctype="multipart/form-data">
              @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="employee_no">Department<sup class="sup">*</sup></label>
                            <input type="text" class="form-control" id="Department" readonly name="Department" placeholder="Department" value="{{ $departs }}">
                            <input type="hidden" name="id_Dept" id="id_Dept" value="{{ $existingEmployee->id_Dept }}">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="employee_no">Academic program<sup class="sup">*</sup></label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Academic program" value="{{ $existingEmployee->course }}">
                        </div>
                    </div>
                    

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="first_name">Duration (year)<sup class="sup">*</sup></label>
                            <div style="position:relative">
                                <input type="text" onkeyup="validateInput(this)" class="form-control" id="lect" value="{{ $existingEmployee->YrLength }}" name="lect" placeholder="Lecture">
                                <div class="addMinus"><button class="btn bg-gradient-secondary" onclick="addings2('add')" type="button">+</button><button  onclick="addings2('minus')"  class="btn bg-gradient-secondary" type="button">-</button></div>
                            </div>
                        </div>
                    </div>





                    <div class="col-sm-4">
                    <div class="form-group">
                        <label for="first_name">Coordinator<sup class="sup">*</sup></label>
                        <div  class="dropdown">
                        <input class=" form-control" style="text-align:left;background-color:transparent" type="button" id="dropdownMenuButtons"  value="Choose head" readonly data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        
                        <input type="hidden" id="adviser" name="adviser">
                        
                        <div class="dropdown-menu "  aria-labelledby="dropdownMenuButtons">
                            <input onkeyup="getvalss(this)" class="form-control searchingSubs" style="" id="searchFills" placeholder="Search" type="text">
                            <div class="habaan" id="preqs">
                                
                            </div>
                        </div>
                        </div>
            
                    </div>
                    </div>

                    <div style="display: none" id="PositionDiv" class="col-sm-2">
                        <div class="form-group">
                            <label for="employee_no">Position<sup class="sup">*</sup></label>
                            <input type="text" class="form-control" id="position" name="position" value="{{ $existingEmployee->adviserPosition }}" placeholder="Position">
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                                <label for="employee_no">Change signature</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image" accept=".png" id="image">
                                <label class="custom-file-label" for="image" >@if($existingEmployee->imageName != '') {{$existingEmployee->imageName}} @else {{'Choose signature'}} @endif</label>
                            </div>
                        </div>
                    </div>

                    <script>
                    // Add the following code if you want the name of the file appear on select
                    $(".custom-file-input").on("change", function() {
                    var fileName = $(this).val().split("\\").pop();
                    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                    });
                    </script>

                    <input type="hidden" name="imaging" value="{{ $existingEmployee->imageName }}">
                    <script>
                        function validateInput(input) {
                            input.value = input.value.replace(/[^0-9]/g, '').replace(/^-/,'');
                            
                        }
                    </script>
                    <script>
                        var varValues = 0;
                        var varValues2 = {{ $existingEmployee->YrLength }};
                    

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
                        
                     
                    </script>
                  <script>


                    const Descriptionss = [
                        @foreach($teacher as $subjects)
                            '{{$subjects->employee_no}} - {{$subjects->firstname}} {{$subjects->lastname}}',
                        @endforeach
                    ];
                    const DescriptionsIDs = [
                        @foreach($teacher as $subjects)
                            '{{$subjects->id}}',
                        @endforeach
                    ];

                    function validateInput(input) {
                        input.value = input.value.replace(/[^0-9]/g, '').replace(/^-/,'');
                        
                    }
                    function resetss(){
                    
                    var preq = document.getElementById('preqs');

                    // Get all child elements of the parent
                    var childElements = preq.children;

                    
                    for (var i = childElements.length - 1; i >= 0; i--) {
                    
                        if (childElements[i].tagName.toLowerCase() !== 'input') {
                            
                            preq.removeChild(childElements[i]);
                            
                        }
                    }
                    }
                    function changingings(){
                        var dropdownMenuButton =  document.getElementById('dropdownMenuButtons').value = 'Choose adviser';
                        var searchedvalue =  document.getElementById('adviser').value = '';
                    }

                    function changeValueSearcheds(valueGets, vals){
                        var PositionDiv = document.getElementById('PositionDiv');
                        PositionDiv.style = "display: block";
                    var searchedvalue = document.getElementById('adviser');

                    searchedvalue.value = valueGets;

                        // alert(searchedvalue.value);

                    var dropdownMenuButton = document.getElementById('dropdownMenuButtons');
                    dropdownMenuButton.value = vals;


                    }
                    function refreshs(){
                            
                            


                            resetss();
                            const searchTerm = '';

                            const find = Descriptionss.filter(fruit => fruit.includes(searchTerm));
                            
                            
                            for(var x = 0; x != find.length; x++){
                            
                                var preq = document.getElementById('preqs');

                                const buttonElement = document.createElement('button');
                                const i = Descriptionss.indexOf(find[x]);
                                buttonElement.setAttribute('onclick', 'changeValueSearcheds("'+DescriptionsIDs[i]+'", "'+find[x]+'")'); 
                                buttonElement.setAttribute('value', DescriptionsIDs[i]);
                                buttonElement.setAttribute('type', 'button');
                                buttonElement.setAttribute('class', 'dropdown-item');
                                buttonElement.innerText = find[x];


                                preq.appendChild(buttonElement);
                            }
                        

                        }
                        refreshs();

                        function getvalss(searching){
                        
                            
                        resetss();
                        

                        const searchTerm = searching.value.toLowerCase(); 
                        const find = Descriptionss.filter(fruit => fruit.toLowerCase().includes(searchTerm)); 
                        
                        for (var x = 0; x < find.length; x++) {
                            var preq = document.getElementById('preqs');

                            const buttonElement = document.createElement('button');
                            const i = Descriptionss.indexOf(find[x]);
                            buttonElement.setAttribute('onclick', 'changeValueSearcheds("'+DescriptionsIDs[i]+'", "'+find[x]+'")'); 
                            buttonElement.setAttribute('value', DescriptionsIDs[i]);
                            buttonElement.setAttribute('type', 'button');
                            buttonElement.setAttribute('class', 'dropdown-item');
                            buttonElement.innerText = find[x];


                            

                            preq.appendChild(buttonElement);
                        }
                        

                    }

                    @if($existingEmployee->adviser != '')
                        changeValueSearcheds('{{ $existingEmployee->adviser }}', '{{ $existingEmployee->adviser }} - {{$teacherNames->firstname}} {{$teacherNames->lastname}}');
                    @endif
                    

                    </script>
                
              
                </div>

      

                <div class="d-flex gap-flex">
                    <a href="{{ route('admin.track') }}"><button type="button" class="btn bg-gradient-secondary" id="submit_button" onclick="">Back</button></a>
                    <button type="button" class="btn bg-gradient-success" id="submit_buttons" onclick="validateForm();">Edit program</button>
                    
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
                        
                    var emailExists = false;
                    var isValid = true;
                    // Function to validate the form

                    function validateForm(){
                        
                        var title = document.getElementById('title').value;
                        var id_Dept = document.getElementById('id_Dept').value;
              

    

                            jQuery.ajax({
                                    
                                                    
                                    url: "{{ url('admin/checkIftitlesexistCourse') }}",
                                    data: {
                         
                                        datacheckTitle: title,
                                        id_Dept: id_Dept,
                                    },
                                    type: 'post',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },

                                    success:function(result)
                                    {
                                        

                                       
                                        emailExists = result.title;
                          
                                        validateForm_second();
                                    
                                    }

                                
                                });


                        
                    }

                    
                    
                    function validateForm_second() {
                        var currentEma = "{{ $existingEmployee->course }}";
                        isValid = true;

                        // Reset borders and error messages
                        resetValidation();

                        // Validation for First Name, Middle Name, and Last Name


                        // Validation for Email
                        const title = document.getElementById("title");
          

                        

                     

                        if( title.value != "" ){
                           
                            
                            
                          
                            

                    
                            
                            if(emailExists  && currentEma != title.value){
                                markAsInvalid(title);
                                modals("Academic program already exists.");
                                isValid = false;
                            }
                            
                            
                            
                            
                            if (isValid) {
                            var id_admin = '{{ $existingEmployee->id }}';
                            var messageHtml = 'Admin password.';
                            deleting_admin(id_admin, messageHtml);
                            
                            $(function () {
                                $('[data-toggle="tooltip"]').tooltip()
                                })
                                    function deleting_admin(id_admin, messageHtml)
                                    {
                                        var trues = "";
                                        
                                    (async () => {
                                    


                                            const { value: password } = await Swal.fire({
                                            title: 'Enter your password',
                                            input: 'password',
                                            html: '<b>' + messageHtml + '</b>',
                                            confirmButtonText: "Continue",
                                            inputPlaceholder: 'Enter your password',
                                            inputAttributes: {
                                                maxlength: 30,
                                                autocapitalize: 'off',
                                                autocorrect: 'off',
                                                
                                            }
                                            })

                                            if (password) {
                                            
                                            // Swal.fire(`Entered password: ${password}`);
                                            jQuery.ajax({
                                            
                                            
                                                url: "{{ url('admin/checkpassword') }}",
                                                data: {
                                                    password: password,
                                                },
                                                type: 'post',
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },

                                                success:function(result)
                                                {
                                                    
                                                trues = result.password;
                                                id = id_admin;
                                                checkingTrues(trues, id);
                                                }

                                        
                                            });
                                            
                                            
                                            }
                                            
                                        
                                    })()
                                    
                                    }
                                    function checkingTrues(password, id){
                                    
                                    if(password != 'false'){
                                        document.getElementById('myForm').submit();
                                    }
                                    else{
                                        deleting_admin(id, '<span style="color:rgb(165, 73, 73)">Wrong password.</span>');
                                    }
                                }



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