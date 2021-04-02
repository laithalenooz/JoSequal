@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="mt-5">
                    <div class="card">
                            <div class="card-header font-weight-bolder text-decoration-none">{{$post->title}}</div>
                            <div class="card-body">
                                <p class="font-weight-bold">{{$post->description}}</p>
                            </div>
                            <div class="container">
                                <img class="pr-4" src="{{Storage::disk('s3')->url($post->avatar)}}" width="720"
                                     height="309" alt="{{$post->avatar}}">
                            </div>
                            @comments([
                            'model' => $post,
                            'perPage' => 2
                            ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
