@extends('kiosk.index_admin')



@section('titlePage')

    CCSTNexus | add student

@endsection

@section('content')
<style>
    input{
        border:none;
        border-bottom: 5px solid white;
        background:none;
        color: white;
        font-size: 30px;
        outline: none
    }
    button{
        background-color: white;
   border:none;
   font-size: 30px;
   color:#454d55 !important;
   border-bottom: 5px solid white !important;
        height: 100%;
        padding-right: 15px;
        padding-left: 15px;
    }
</style>
@if (session('success'))
    <script>
        $(document).ready(function () {
            
            
                Swal.fire({
                    title: "{{ session('success')['title'] }}",
                    text: "{{ session('success')['text'] }}",
                    icon: "{{ session('success')['icon'] }}",
                    showConfirmButton: false,
                });
            
        });
    </script>
@endif
<div style="height: 100dvh; width: 100%;">

    <a href="{{ route('kiosk.index') }}" style="position: fixed;top:40px;left:40px;color:white;font-size:40px"><i class="fas fa-reply"></i></a>
    <div style="height: 100%; width: 100%; justify-content: center; align-items: center; display: flex; gap: 40px; ">
    
    <form id="myForm" method="GET" action="{{ route('kiosk.searched_student_kiosk') }}">
              @csrf
            <input required name="student_no" placeholder="Student No." value="05-" type="text"><button><i class="fas fa-arrow-right"></i></button>
        </form>
        
    </div>
    
</div>

@endsection