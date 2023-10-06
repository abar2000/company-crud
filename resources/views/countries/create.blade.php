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
    <h1>Add new country</h1>
    <a href="{{route('companies-index')}}"><button class="button">back</button></a>
<form action="{{route('countries-store')}}" method="POST" enctype="multipart/form-data">
@csrf
<p>Country name:</p>
<input type="text" name="name" width="20px" placeholder="company name">
@error('name')
<div>{{ $message }}</div>
@enderror

<p>Tp code:</p>
<input type="number" name="tp-code" width="20px" placeholder="tp-code">
@error('tp-code')
<div>{{ $message }}</div>
@enderror

<p>Code:</p>
<input type="text" name="code" width="20px" placeholder="code">
@error('code')
<div>{{ $message }}</div>
@enderror

<p>Description:</p>
<input type="text" name="description" width="20px" placeholder="description">
@error('code')
<div>{{ $message }}</div>
@enderror

 <br>

<button type="submit" class="button">Submit</button>
</form>
</body>
</html>