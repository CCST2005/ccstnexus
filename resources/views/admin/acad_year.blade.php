@extends('admin.index_admin')


@section('titlePage')

    CCSTNexus | academic year

@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Academic year</h1>
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
                <h3 class="card-title">Set academic year</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <div class="card-body">
              <form id="myForm" method="POST" action="{{ route('admin.adding_admin') }}">
              @csrf
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            
                        <select id="yearPicker2" onchange="yeargrads(this)" name="collegeyr"  class="form-control  ">
                        
                            </select>
                            
                        </div>
                    </div>
                   
                    <script>
                                // Get the current year
                                var currentYear = new Date().getFullYear();

                                // Set the range of years (adjust as needed)
                                var startYear = currentYear-1;
                                var endYear = currentYear + 10;
                                var currentEnds = '{{ $all_admin->year }}';
                                var yearsPass ="";
                                // Get the select element
                                var yearPicker = document.getElementById("yearPicker2");
                                var previous = document.getElementById("previous");
                                // Populate the dropdown with years
                                for (var year = endYear; year >= startYear; year--) {
                                    
                                        var option = document.createElement("option");
                                        option.value = year + "-" + (year+1);

                                        option.text = year + "-" + (year+1);

                                        yearsPass = year + "-" + (year+1);
                                        if(currentEnds == yearsPass){
                                            option.selected = true;
                                        }
                                        yearPicker.add(option);
                                    
                                   
                                }

                                
                                function yeargrads(yearsSelected){
                                    const submit_buttons = document.getElementById("submit_buttons");
                                    if(yearsSelected.value != currentEnds){
                                        submit_buttons.style.display = "block";
                                        
                                    }
                                    else{
                                        submit_buttons.style.display = "none";
                                       
                                    }
                 
                                    
                                }
                                
                            </script>
                              
                   
                   
                    
                </div>

                <div class="d-flex gap-flex">
              
                    <button type="button" style="display:none" class="btn bg-gradient-success" id="submit_buttons" onclick="beforeDelete()" >Update</button>
                    
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

                        function beforeDelete(){
                            const yearPicker2 = document.getElementById("yearPicker2").value;
                            
                            deleting_admin(yearPicker2, 'Admin password');
                        }

                       $(function () {
                        $('[data-toggle="tooltip"]').tooltip()
                        })
                            function deleting_admin(id_admin, wrongPassword)
                            {
                                var trues = "";
                                
                            (async () => {
                            


                                    const { value: password } = await Swal.fire({
                                    title: 'Enter your password',
                                    input: 'password',
                                    html: '<b>' + wrongPassword + '</b>',
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
                            const values = [encodeURIComponent(password), id];
                            

                            if(password != 'false'){
                                
                                var newPageURL = "{{ route('admin.update_acad', ['id' => 'PLACEHOLDER_ID', 'password' => 'PLACEHOLDER_PASS']) }}"
                            .replace('PLACEHOLDER_ID', values[1])
                            .replace('PLACEHOLDER_PASS', values[0]);

                                window.location.href = newPageURL;
                            }
                            else{
                                deleting_admin(id, '<span style="color:rgb(165, 73, 73)">Wrong password.</span>');
                            }
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