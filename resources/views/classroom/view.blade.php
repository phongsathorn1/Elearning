@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ route('classroom.view', ['classroom_id' => $classroom->id]) }}">{{ $classroom->name }}</a></div>
                <div class="panel-body">
                    {{ $classroom->description }}
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Post</div>
                <div class="panel-body">
                    <form action="{{ route('post') }}" method="POST">
                        {{ csrf_field() }}
                        <textarea name="post" style="width: 100%; height: 100px"></textarea>
                        <input type="submit" value="post">
                    </form>
                </div>
            </div>
            @if(Auth::user()->role->actions == "is_teacher")
            <div class="panel panel-default">
                <div class="panel-heading">Assignment</div>
                <div class="panel-body">
                    <form action="{{ route('assignment') }}" method="POST">
                        {{ csrf_field() }}
                        Title: <input type="text" name="title"><br>
                        Detail: <textarea name="detail"></textarea><br>
                        <input type="submit">
                    </form>
                </div>
            </div>
            @endif
            <h2>Post</h2>
            <hr>
            
            @foreach($posts->reverse() as $post)
            @if($post->type == 'assignment')
            <div class="panel panel-default">
                <div class="panel-heading">{{$post->user->name}}</div>
                <div class="panel-body">
                    <h3><a href="{{ route('assignment.view', ['classroom_id' => $classroom->id, 'assignment_id' => $post->id]) }}">{{ $post->title }}</a></h3>
                    {{ $post->detail }}
                </div>
            </div>
            @else
            <div class="panel panel-default">
                <div class="panel-heading">{{$post->user->name}}</div>
                <div class="panel-body">
                    {{ $post->detail }}
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>
@endsection
