<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = DB::select('select * from posts');
        
        // $posts = Post::all();

        
        $posts = Post::OrderBy('id','Desc')->paginate(3);   

        return view('posts.index')->with('posts',$posts);
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
            $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);        

         
           
           

            $post = new Post;

            $post->title=$request->input('title');
            $post->body= $request->input('content');
            $post->user_id=auth()->user()->id;

            $post->save();

            
            // $data = array("title"=>$title, "body"=>$body );
            // DB::table('posts')->insert($data);

            return redirect('/blogs')->with('success','Post Added');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);   
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);


        return view('posts.edit')->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


            $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);        
            $post = Post::find($id);
            $title = $request->input('title');
            $body = $request->input('content');  
            
            $post->title=$title;
            $post->body=$body;

            $post->save();  
            return redirect('/blogs')->with('success','Post Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        $post->delete();
        return redirect('/blogs')->with('error','Post Deleted');

    }
}
