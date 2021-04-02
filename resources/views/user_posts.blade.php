@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card">
                        @if(\App\Models\Post::all() !== null)
                            <div class="card-header">{{ __('Add a Post') }}</div>

                            <div class="card-body">
                                <form method="post" action="{{ route('post.create') }}"
                                      enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="title"
                                               class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                                        <div class="col-md-6">
                                            <input id="title" type="text"
                                                   class="form-control @error('title') is-invalid @enderror"
                                                   name="title"
                                                   value="{{ old('title') }}" required autocomplete="title"
                                                   autofocus>

                                            @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email"
                                               class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                                        <div class="col-md-6">
                                    <textarea id="email" type=""
                                              class="form-control @error('description') is-invalid @enderror"
                                              name="description"
                                              value="{{ old('description') }}" required
                                              autocomplete="description"> </textarea>

                                            @error('description')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="avatar"
                                               class="col-md-4 col-form-label text-md-right">{{ __('Image') }}</label>

                                        <div class="col-md-6">
                                            <input id="avatar" type="file"
                                                   class="form-control @error('avatar') is-invalid @enderror"
                                                   name="avatar"
                                                   required>

                                            @error('avatar')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Create') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                        @foreach(\App\Models\Post::where('user_id', auth()->id())->get() as $post)
                            <div class="card-header font-weight-bolder text-decoration-none"><a
                                    href="{{route('view.post', $post->id)}}">{{$post->title}}</a></div>
                            <div class="card-body">
                                <p class="font-weight-bold">{{$post->description}}</p>
                            </div>
                            <div class="container">
                                <img class="pr-4" src="{{Storage::disk('s3')->url($post->avatar)}}" width="720"
                                     height="309" alt="{{$post->avatar}}">
                            </div>
                            <a class="btn btn-primary" href="{{route('update.post', $post->id)}}">Edit</a>
                            <a class="btn btn-danger" href="{{route('delete.post', $post->id)}}">Delete</a>
                            @comments([
                            'model' => $post,
                            'perPage' => 2
                            ])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
