@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
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
            @foreach ($posts as $post)
            <div class="panel panel-default">
                <div class="panel-heading">{{ $post->user->name }}</div>
                <div class="panel-body">
                    {{ $post->detail }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
