<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware( 'auth:web' );
    }

    public function index()
    {
        return view( 'user.profile' );
    }

    public function update( UserUpdateRequest $request ): \Illuminate\Http\RedirectResponse
    {

        if ( auth()->user()->avatar == 'users/avatar.png' ) {
            $path = Storage::disk( 's3' )->put( 'users', $request->avatar );
        } elseif ( !$request->hasFile( 'avatar' ) ) {
            $path = auth()->user()->avatar;
        } else {
            Storage::disk( 's3' )->delete( auth()->user()->avatar );
            $path = Storage::disk( 's3' )->put( 'users', $request->avatar );
        }
        auth()->user()->update( [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'avatar' => $path,
        ] );

        Alert::success('Success', 'Profile updated!');
        return back();
    }

    public function destroy( $id )
    {
        User::destroy( $id );

        Alert::success('Success', 'Profile Deleted!');
        return redirect( '/' );
    }

    public function showPost( $id )
    {
        return view('edit_post')->with('post', Post::where('id', $id)->first());
    }

    public function updatePost( UpdatePostRequest $request, $id )
    {
        if(!$request->hasFile('avatar')){
            $path = Post::find($id)->avatar;
        } else {
            $path = Storage::disk( 's3' )->put( 'posts', $request->avatar );
        }

        DB::table('posts')->where('id',$id)->update( [
            'title' => $request->input( 'title' ),
            'description' => $request->input( 'description' ),
            'avatar' => $path
        ] );

        Alert::success('Success', 'Post Updated!');
        return redirect()->route('user.posts');
    }

    public function destroyPost( $id )
    {
        Post::destroy( $id );

        Alert::success('Success', 'Post Deleted!');
        return back();
    }

    public function ViewTable()
    {
        return view('listpage')->with('posts', Post::with('user')->paginate(10));
    }
}
