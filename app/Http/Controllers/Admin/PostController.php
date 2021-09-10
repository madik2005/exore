<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Category, Post};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        
    }

    /**
    * Helper function for validate form post data.
    *
    * @return mixed
    */
    public function validateData($request, $required = 'required')
    {
        return $this->validate($request,[
            'title' => ['required', 'string', 'max:255'],
            'img' => [$required, 'image', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048'],
            'category_id' => ['required', 'integer'],
        ]);
    }

    /**
     * Helper function check if isset current page with post.
     *
     * @return Illuminate\Http\RedirectResponse
     */
    protected function redirectNoPage($posts, Request $request, $route, $id = null)
    {
        $lastpage = $posts->lastPage();
        $page = $request->input('page');
        $url_variable = ($id) ? ['id' => $id, 'page' => $lastpage] : ['page'=>$lastpage];
        if ($page>$lastpage) {
            return redirect()->route($route, $url_variable);
        }
        return null;
    }

    /**
    * Show the post create form.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function create(User $user)
    {
        $this->authorize('createPost', $user);
        $categories = Category::pluck('title', 'id')->all();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Create a new post after a validate data.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    protected function store(Request $request, User $user)
    {
        $this->authorize('createPost', $user);
        $this->validateData($request);
        $data = $request->all();
        $data['img'] = Post::uploadImage($request);
        $data['user_id'] = Auth::id();

        Post::create($data);

        return redirect()->route('admin.posts.create')->with('success', 'Post created'); 
    }

    /**
     * Show all posts from this user.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    protected function show(Request $request)
    {
        if (Auth::user()->role == 'manager'){
            $posts = Post::orderBy('id', 'desc')->paginate(10);
        } else {
            $posts = Post::where('user_id', Auth::id())->orderBy('id', 'desc')->paginate(10);
        }

        $target_url = $this->redirectNoPage($posts, $request, 'admin.posts.show');
        return isset($target_url) ? redirect($target_url->getTargetUrl()) : view('admin.posts.show', compact('posts'));
    }

    /**
     * View post.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    protected function view(Request $request, $id)
    {
        $post = Post::find($id);
        $this->authorize('viewPost', $post);
        $request->user()->can('viewPost', $post);
        return view('admin.posts.view', compact('post'));
    }

    /**
     * View all post in categiry .
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    protected function viewCategoryPosts(Request $request, $id)
    {
        if (Auth::user()->role == 'manager'){
            $posts = Post::where('category_id', $id)->paginate(10);
        } else {
            $posts = Post::where('category_id', $id)->where('user_id', Auth::id())->paginate(10);
        }

        $target_url = $this->redirectNoPage($posts, $request, 'admin.category.posts.show', $id);
        return isset($target_url) ? redirect($target_url->getTargetUrl()) : view('admin.posts.show', compact('posts'));
    }

    /**
     * View all post from user .
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    protected function viewUserPosts(Request $request, User $user, $id)
    {
        $this->authorize('createUser', $user);
        $posts = Post::where('user_id', $id)->paginate(10);

        $target_url = $this->redirectNoPage($posts, $request,'admin.user.posts.show', $id);
        return isset($target_url) ? redirect($target_url->getTargetUrl()) :  view('admin.posts.show', compact('posts'));
    }

    /**
     * Edit post.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    protected function edit(Request $request, $id)
    {
        $post = Post::find($id);
        $this->authorize('viewPost', $post);
        $categories = Category::pluck('title', 'id')->all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update post.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    protected function update(Request $request, $id)
    {
        $post = Post::find($id);
        $this->authorize('viewPost', $post);
        $this->validateData($request, 'nullable');
        
        $data = $request->all();
        if(isset($data['img'])) $data['img'] = Post::uploadImage($request, $post->img);

        $post->update($data);

        return redirect()->route('admin.posts.edit', $id)->with('success', 'Post updated'); 
    }

    /**
     * Delete post.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    protected function delete(Request $request, $id)
    {
        $post = Post::find($id);
        $this->authorize('viewPost', $post);
        Storage::delete($post->img);
        $post->delete();
        $url = url()->previous();
        return redirect($url)->with('success', 'Post deleted');
    }
}
