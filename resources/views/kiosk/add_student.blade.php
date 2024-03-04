@extends('kiosk.index_admin')



@section('titlePage')

    CCSTNexus | add student

@endsection

@section('content')
<style>
    .button{
        height: 200px;
        width: 400px;
        border-radius: 20px;
        transition: .5s;
        font-size: 30px;
        font-weight: bold;
        border: 5px solid gray;
    }
    .button:hover{
        background-color: gray;
        color: white;
    }
</style>
@if (session('success'))
    <script>
        $(document).ready(function () {
            
            
                Swal.fire({
                    
                    title: "{{ session('success')['text'] }}",
                    icon: "{{ session('success')['icon'] }}",
                    width: '60%',
                    allowOutsideClick: false,
                });
            
        });
    </script>
@endif
<div style="height: 100dvh; width: 100%;">


    <div style="height: 100%; width: 100%; justify-content: center; align-items: center; display: flex; gap: 40px; ">
 
        <a href="{{ route('kiosk.new_add_student_kiosk') }}"><button class="button">NEW STUDENT</button></a>
        <a href="{{ route('kiosk.update_student_kiosk') }}"><button class="button">OLD STUDENT</button></a>
    </div>
    
</div>
@endsection