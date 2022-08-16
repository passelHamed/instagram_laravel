<?php

namespace App\Http\Controllers;

use App\Models\post;
use App\Models\User;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'post_caption' => 'string',
            'image_path'   => ['required' , 'image']
        ]);

        $imagePath = request('image_path')->store('uploads' , 'public');

        auth()->user()->posts()->create([
            'post_caption' => $data['post_caption'],
            'image_path'   => $imagePath,
        ]);

        return redirect()->route('user_profile' , ['username' => auth()->user()->username]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(post $post)
    {
        if ($post == null)
        {
            abort(404);
        }

        return view('posts.show' , compact('post'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(post $post)
    {
        if ($post == null)
        {
            abort(404);
        }

        return view('posts.edit' , compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, post $post)
    {
        if ($post == null)
        {
            abort(404);
        }

        $data = request()->validate([
            'post_caption' => 'string',
            'image_path'   => ['nullable' , 'image']
        ]);

        if (request('image_path') != null)
            {
                $imagePath = request('image_path')->store('upload' , 'public');
            }
        elseif ($post->image_path != null)
            {
                $imagePath = $post->image_path;
            }
        else
            {
                abort(401);
            }

            $post->update([
                'post_caption' => $data['post_caption'],
                'image_path'   => $imagePath
            ]);

            return redirect('/posts/' . $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(post $post)
    {
        if ($post == null)
        {
            abort(404);
        }

        $post->delete();
        Storage::delete('public/' . $post->image_path);

        return redirect('/' . auth()->user()->username);
    }
}
