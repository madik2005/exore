@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('admin.partials.sidebar')
        <div class="col-sm-10">
          <div class="card">
            <div class="col">
              <h3>{{ $post->title }}</h3>
              <p><img src="{{ $post->getImage() }}" class="img-thumbnail" width="200px"></p>
              @can('createUser', App\User::class)
                <p>User: <a href="{{ route('admin.user.posts.show', ['id' => $post->user->id]) }}">{{ $post->user->email }}<a></p>
              @endcan
              <p>Category: <a href="{{ route('admin.category.posts.show', ['id' => $post->category->id]) }}">{{ $post->category->title }}<a></p>
            </div>  
          </div>
    </div>       
</div>
@endsection