@if(count($errors))
    <div class="form-group">
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@if(Session::has('success'))
   <div class="alert alert-success">
       <button type="button" class="close" data-dismiss="alert">×</button>
       {{ Session::get('success') }}
   </div>
@endif

@if(Session::has('danger'))
   <div class="alert alert-danger">
       <button type="button" class="close" data-dismiss="alert">×</button>
       {{ Session::get('danger') }}
   </div>
@endif 