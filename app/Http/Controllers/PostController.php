<?php

namespace App\Http\Controllers;

use App\Author;
use App\Category;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data['title']='Posts List';
       $data['posts']=Post::with('category','author')->orderBy('id','asc')->get();
       $data['serial']=1;
       //dd($data);
       return view('admin.post.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title']='Post Create ';
        $data['categories']=Category::orderBy('name')->get();
        $data['authors']=Author::orderBy('name')->get();
        return view('admin.post.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'title'=>'required',
            'details'=>'required',
            'category_id'=>'required',
            'author_id'=>'required',
            'status'=>'required',
            'file'=>'required',
            'published_at'=>'required',
            'is_featured'=>'required',

        ]);
        $data_r=$request->except('_token');
        //FILE UPLOAD
        if($request->hasFile('file'))
        {
            $file=$request->file('file');
            $file->move('image/post/',$file->getClientOriginalName());
            $data_r['file']='image/post/'.$file->getClientOriginalName();
        }
         Post::create($data_r);
         Session()->flash('message','Post created successfully');
         return redirect()->route('post.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $data['title']='Edit Post';
        $data['post']=$post;
        $data['categories']=Category::orderBy('name')->get();
        $data['authors']=Author::orderBy('name')->get();
        return view('admin.post.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'=>'required',
            'details'=>'required',
            'category_id'=>'required',
            'author_id'=>'required',
            'status'=>'required',
            'file'=>'required',
            'published_at'=>'required',
            'is_featured'=>'required',
        ]);
        $data = $request->except('_token');
        //file upload update
        if($request->hasFile('file')){
            $file=$request->file('file');
            $file->move('image/post/',$file->getClientOriginalName());
            File::delete($post->file);
            $data['file']='image/post/'.$file->getClientOriginalName();
        }

        $post->update($data);
        Session()->flash('message','Post Updated Successfully');
        return redirect()->route('post.index');


    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {   File::delete($post->file);
        $post->delete();
        Session()->flash('message','Post Deleted Successfully');
        return redirect()->route('post.index');
    }
}
