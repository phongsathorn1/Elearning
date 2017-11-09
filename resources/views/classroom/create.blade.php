@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create Classroom</div>
                <div class="panel-body">
                    <form action="{{ route('classroom.create') }}" method="POST">
                        {{ csrf_field() }}
                        Classroom name: <input type="text" name="classroom_name"><br/>
                        Description: <textarea name="classroom_description"></textarea>
                        <input type="submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
