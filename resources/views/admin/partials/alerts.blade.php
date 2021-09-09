@if(session()->has('success'))
  <div class="alert alert-success">
      <strong>{{ session()->get('success') }}</strong>
  </div>
@endif