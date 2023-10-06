<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}
        </style>
</head>
<body>
    <h1>Add new company</h1>
    <a href="{{route('companies-index')}}"><button class="button">back</button></a>
<form action="{{route('companies-store')}}" method="POST" enctype="multipart/form-data">
@csrf
<p>Company name:</p>
<input type="text" name="name" width="20px" placeholder="company name">
@error('name')
<div>{{ $message }}</div>
@enderror

<p>E-mail:</p>
<input type="email" name="email" width="20px" placeholder="contact">
@error('email')
<div>{{ $message }}</div>
@enderror

<p>Country:</p>
<select id="sel-country2" name="country">
    <option value="">Unspecified</option>
    @foreach ($countries as $obj)
        <option value="{{$obj->id}}">{{$obj->name}}</option>        
    @endforeach
</select>
@error('country')
<div>{{ $message }}</div>
@enderror

<p>Managers:</p>
<select data-type='multiple' multiple='multiple' name="manager[]">
    @foreach ($managers as $obj)
        <option value="{{$obj->id}}">{{$obj->name}}</option>        
    @endforeach
</select>
@error('manager')
<div>{{ $message }}</div>
@enderror

<p>Address:</p>
<input type="text" name="address" width="20px" placeholder="address">
@error('address')
<div>{{ $message }}</div>
@enderror

 <br>

<button type="submit" class="button">Submit</button>
</form>
</body>
</html>