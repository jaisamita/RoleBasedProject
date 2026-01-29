@extends('layouts.admin')

			
      
@section('content')
      <h4>Account Details</h4>
        <hr>
		  <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
        <p><strong>User ID:</strong> {{ auth()->user()->id }}</p>
        
@endsection
