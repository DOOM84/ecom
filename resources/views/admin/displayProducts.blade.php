@extends('layouts.admin')

@section('body')
    <div class="table-responsive">
        <table class="table table-stripped">
            <tr>
                <th>#id</th>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Type</th>
                <th>Edit Image</th>
                <th>Edit</th>
                <th>Remove</th>
            </tr>
            <tbody>
            @foreach($products as $product)
            <tr>
            <td>{{$product['id']}}</td>
            <td>
                <img src="{{Storage::url('product_images/'.$product['image'])}}" alt="{{Storage::url($product['image'])}}" width="100" height="100">
            </td>
            <td>{{$product['name']}}</td>
            <td>{{$product['description']}}</td>
            <td>{{$product['price']}}</td>
            <td>{{$product['type']}}</td>
            <td><a class="btn btn-primary" href="{{route('adminEditProductImageForm', ['id' => $product['id']])}}">Edit Image</a></td>
            <td><a class="btn btn-primary" href="{{route('adminEditProductForm', ['id' => $product['id']])}}">Edit</a></td>
            <td><a class="btn btn-warning" href="{{route('adminDeleteProduct', ['id' => $product['id']])}}">Remove</a></td>
            </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endsection