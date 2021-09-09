@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('admin.partials.sidebar')
            <div class="col-sm-10">
            <div class="card card-primary">
                @include('admin.partials.alerts')
                <form class="mb-0" action="{{ route('admin.posts.edit', $post->id) }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="title">Title*</label>
                            <input type="text" class="form-control  {{ $errors->has('title') ? 'is-invalid' : '' }}" id="title" name="title" placeholder="Title" value="{{ !old('title') ?  $post->title : old('title')  }}">
                            @if($errors->has('title'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="category_id">Category*</label>
                            <select class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}" id="category_id" name="category_id">
                                    <option>Select category</option>
                                @foreach ($categories as $k => $v)
                                    <option value="{{ $k }}" {{ ($k == $post->category->id && !old('category'))||($k ==old('category') ) ? 'selected' : '' }}>{{ $v }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('category_id'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('category_id') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="img">Image</label>
                            <input type="file" class="form-control-file {{ $errors->has('img') ? 'is-invalid' : '' }}"" id="img"  name="img">
                            @if($errors->has('img'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('img') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                          <img src="{{ $post->getImage() }}" class="img-thumbnail" width="200px">
                        </div>
                        <div class="form-group mb-3 text-center">
                            <button type="submit" class="btn btn-primary ">Edit</button>
                        </div>    
                    </div>
                </form>     
            </div>
    </div>       
</div>
@endsection