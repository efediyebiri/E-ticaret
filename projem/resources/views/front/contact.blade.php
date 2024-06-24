@extends('layouts.front')

@section("css")

@endsection

@section("icerik")
<hr>
Contact Alani
<hr>
<div class="col-8 mx-auto">
<form action = "{{route("contact")}}" method = "POST">
    @csrf           

    <input type = "text" class="form-control" name="fullname">
    <br>
    <input type = "email" class="form-control" name= "email">
    <br>
    <button class="btn btn-success" type="submit">Gönder</button>
</form>
</div>



<hr>
<div class="col-8 mx-auto">
    İletişim alanı
<form action = "{{route("user",['id' => 5 , "name" => "asya"])}}" method = "POST">
    @csrf           

    <input type = "text" class="form-control" name="fullname">
    <br>
    <input type = "email" class="form-control" name= "email">
    <br>
    <button class="btn btn-success" type="submit">Gönder</button>
</form>
</div>


<hr>
<div class="col-8 mx-auto">
    Support Form
<form action = "{{route('support-form.support')}}">
    @csrf           

    <input type = "text" class="form-control" name="fullname">
    <br>
    <input type = "email" class="form-control" name= "email">
    <br>
    <button class="btn btn-success" type="submit">Gönder</button>
</form>
</div>


<hr>
<div class="col-8 mx-auto">
    Patch Form
<form action = "{{route('user.update', ['id' => 9])}}" method = "POST">
    @csrf           
    @method('PATCH')
    {{--<input type="hidden" name= "_method" value= {{"method_field("PATCH")"}}>--}}
    <input type = "text" class="form-control" name="fullname">
    <br>
    <input type = "email" class="form-control" name= "email">
    <br>
    <button class="btn btn-success" type="submit">Gönder</button>
</form>
</div>


<hr>
<div class="col-8 mx-auto">
    Put kullanımı
<form action = "{{route('user.updateAll', ['id' => 9])}}" method = "POST">
    @csrf           
    @method('PUT')
    {{--<input type="hidden" name= "_method" value= {{"method_field("PATCH")"}}>--}}
    <input type = "text" class="form-control" name="fullname">
    <br>
    <input type = "email" class="form-control" name= "email">
    <br>
    <button class="btn btn-success" type="submit">Gönder</button>
</form>
</div>

<hr>
<div class="col-8 mx-auto">
    Delete kullanımı
<form action = "{{route('user.delete', ['id' => 9])}}" method = "POST">
    @csrf           
    @method('DELETE')
    {{--<input type="hidden" name= "_method" value= {{"method_field("PATCH")"}}>--}}
    <input type = "text" class="form-control" name="fullname">
    <br>
    <input type = "email" class="form-control" name= "email">
    <br>
    <button class="btn btn-success" type="submit">Gönder</button>
</form>
</div>
@endsection

@section("js")

@endsection
