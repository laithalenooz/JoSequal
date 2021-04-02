@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="mt-5">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">image</th>
                            <th scope="col">title</th>
                            <th scope="col">author</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td><img src="{{Storage::disk('s3')->url($post->avatar)}}" height="45" width="45"
                                         alt=""></td>
                                <td><a href="{{route('view.post', $post->id)}}">{{$post->title}}</a></td>
                                <td>{{$post->user->name}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$posts->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
