@extends('layouts.app')
@section('content')
    <div class="container">

        <h2 class="text-right">تعديل</h2>
        @if($errors->any())
            @foreach($errors->all() as $error)
               
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <strong>Alert!</strong> {{$error}}.
                </div>
            @endforeach

        @endif
    <form action="{{route('parties.update', ['party' => $partie->id])}}" method="POST">
            @csrf
            @method('PUT')
            <div dir="rtl" class="row">
                
                <div dir="rtl" class="form-group col">
                    <label for="nomination">طرف في ملف</label>
                </div>
                <div dir="rtl" class="form-group col">
                <input type="text" name="nomination" id="nomination" class="form-control" placeholder="طرف في ملف" value="{{$partie->nomination}}">
                </div>
                <div class="col">
                    <input type="submit" class="btn btn-success btn-block" value="تعديل"/>
                </div>
                
    
            </div>
            
            
        </form>
        
    </div>
@endsection