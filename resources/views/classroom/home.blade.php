@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        @foreach ($classrooms as $classroom)
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ route('classroom.view', ['classroom_id' => $classroom->id]) }}">{{ $classroom->name }}</a></div>
                <div class="panel-body">
                    {{ $classroom->description }}
                </div>
            </div>
        @endforeach
        </div>
    </div>
</div>
@endsection
