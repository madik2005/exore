@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('admin.partials.sidebar')
            <div class="col-sm-10">
            <div class="card card-primary">
                @include('admin.partials.alerts')
                <!-- form start -->
                <form class="mb-0" action="{{ route('admin.users.create') }}" method="post">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="email">Email*</label>
                            <input type="email" class="form-control  {{ $errors->has('email') ? 'is-invalid' : '' }}"  name="email" id="email" placeholder="Еmail" value="{{ old('email') }}" required>
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Password*</label>
                            <input type="password" name="password"
                                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="Password">
                            @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="password_confirmation">Confirm password*</label>
                            <input type="password" name="password_confirmation"
                                class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" placeholder="Confirm password">
                            @if($errors->has('password_confirmation'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="form-group mb-3 text-center">
                            <button type="submit" class="btn btn-primary ">Create</button>
                        </div>    
                    </div>
                </form>     
            </div>
    </div>       
</div>
@endsection