<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    
</head>
<body>
    <a href="{{route('companies-create')}}"><button>Create new</button></a>

    @if($message = Session::get('success'))
        <div><p>{{$message}}</p></div>
    @endif
    @if($message = Session::get('error'))
        <div><p>{{$message}}</p></div>
    @endif
    <table border="1px">
        <thead>
        <tr>
        <th>Comp.Id</th>
        <th>Company name</th>
        <th>Email</th>
        <th>Country</th>
        <th>Address</th>
        <th>Actions</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($companies as $company)
            <tr>
                <td>{{$company->id}}</td>
                <td>{{$company->name}}</td>
                <td>{{$company->email}}</td>
                <td>{{$company->country}}</td>
                <td>{{$company->address}}</td>
                <td><a href="{{route('companies-edit',$company->id)}}"><button>Update</button>
                    <form action="{{route('companies-destroy',$company->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
                
            @endforeach
        </tbody>
       

    </table>
    {!! $companies->links()!!}
</body>
</html>