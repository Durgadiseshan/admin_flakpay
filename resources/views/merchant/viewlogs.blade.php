
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


<div class="container">
    <div class="row">
    @foreach ($newarr as $errors)
<div class="card my-3">
<div class="card-body">

    <h6>{{$errors[0]}}</h6>
    
</div>
</div>

@endforeach
    </div>
</div>
