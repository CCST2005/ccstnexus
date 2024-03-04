@extends('admin.index_admin')



@section('titlePage')

    CCSTNexus | Edit strand

@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit strand</h1>
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
                <h3 class="card-title">Update strand ({{$existingEmployee->strand}})</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <div class="card-body">
              <form id="myForm" method="POST" action="{{ route('admin.updating_strand', ['id' => $existingEmployee->id]) }}">
              @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="employee_no">Strand<sup class="sup">*</sup></label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Strand" value="{{ $existingEmployee->strand }}">
                        </div>
                    </div>
                    

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="first_name">Duration (year)<sup class="sup">*</sup></label>
                            <div style="position:relative">
                                <input type="text" onkeyup="validateInput(this)" class="form-control" id="lect" value="@if($existingEmployee->YrLength != ''){{ $existingEmployee->YrLength }}@else {{1}} @endif" name="lect" placeholder="">
                                <div class="addMinus"><button class="btn bg-gradient-secondary" onclick="addings2('add')" type="button">+</button><button  onclick="addings2('minus')"  class="btn bg-gradient-secondary" type="button">-</button></div>
                            </div>
                        </div>
                    </div>

                    <script>
                        function validateInput(input) {
                            input.value = input.value.replace(/[^0-9]/g, '').replace(/^-/,'');
                            
                        }
                    </script>
                    <script>
                        var varValues = 0;
                        var varValues2 = @if($existingEmployee->YrLength != ""){{ $existingEmployee->YrLength }}@else {{ 1 }} @endif;
                    

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
                  
                
              
                </div>

      

                <div class="d-flex gap-flex">
                    <a href="{{ route('admin.strand') }}"><button type="button" class="btn bg-gradient-secondary" id="submit_button" onclick="">Back</button></a>
                    <button type="button" class="btn bg-gradient-success" id="submit_buttons" onclick="validateForm();">Edit strand</button>
                    
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
                
              

    

                            jQuery.ajax({
                                    
                                                    
                                    url: "{{ url('admin/checkIftitlesexiststrand') }}",
                                    data: {
                         
                                        datacheckTitle: title,
                                       
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
                        var currentEma = "{{ $existingEmployee->strand }}";
                        isValid = true;

                        // Reset borders and error messages
                        resetValidation();

                        // Validation for First Name, Middle Name, and Last Name


                        // Validation for Email
                        const title = document.getElementById("title");
          

                        

                     

                        if( title.value != "" ){
                           
                            
                            
                          
                            

                    
                            
                            if(emailExists  && currentEma != title.value){
                                markAsInvalid(title);
                                modals("Strand already exists.");
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