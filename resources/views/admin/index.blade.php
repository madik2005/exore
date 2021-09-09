@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('admin.partials.sidebar')
            <div class="col-sm-10">
                <h1>Admin page</h1>
            </div>
    </div>       
</div>
@endsection
