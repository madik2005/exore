@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('admin.partials.sidebar')
        <div class="col-sm-10">
          <div class="card card-primary">
           @include('admin.partials.alerts')
            <table class="table table-hover text-center">
              <thead>
                <tr class="pl-3">
                    <th scope="col">Title</th>
                    <th scope="col">actions</th>
                  </tr>
                </thead>
                <tbody>
                @foreach ($posts as $post)
                  <tr class="pl-3">
                    <td><a href="{{ route('admin.posts.view', ['id' => $post->id]) }}">{{ $post->title}}</a></td>
                    <td>
                      @cannot('createUser', App\User::class)
                        <a href="{{ route('admin.posts.edit', ['id' => $post->id]) }}" class="pr-3">Edit</a>  
                      @endcannot
                      <a href="{{ route('admin.posts.delete', ['id' => $post->id]) }}">Delete</a>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            <div class="row justify-content-center">
              {{ $posts->links() }}
            </div>  
          </div>
    </div>       
</div>
@endsection