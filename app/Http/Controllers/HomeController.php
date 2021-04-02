<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware( 'auth' );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
            return view( 'welcome' )->with( 'posts', Post::with('comments')->paginate(5) );
    }

    public function store( PostCreateRequest $request )
    {
        $path = Storage::disk( 's3' )->put( 'posts', $request->avatar );

        Post::create( [
            'title' => $request->input( 'title' ),
            'description' => $request->input( 'description' ),
            'avatar' => $path,
            'user_id' => auth()->id()
        ] );

        Alert::success( 'Success', 'Post Created!' );
        return back();
    }

    public function showSinglePost( $id )
    {
        return view('post')->with('post', Post::where('id', $id)->first());
    }
}
