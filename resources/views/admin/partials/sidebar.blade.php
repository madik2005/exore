<div class="col-sm-2">
  @can('createUser', App\User::class)
    <p><a href="{{ route('admin.users.create') }}">Create User</a></p>
  @endcan
  @can('createPost', App\User::class)
    <p><a href="{{ route('admin.posts.create') }}">Create Post</a></p>
  @endcan
  <p><a href="{{ route('admin.posts.show') }}">Posts</a></p>
</div>
