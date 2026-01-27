@extends('layouts.admin')

			
      
@section('content')
      <h4>Account Details</h4>
        <hr>
		  <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
        <p><strong>Role:</strong> {{ ucfirst(auth()->user()->role) }}</p>
        <p><strong>User ID:</strong> {{ auth()->user()->id }}</p>
        <p><strong>Registered On:</strong>
            {{ auth()->user()->created_at->format('d M Y') }}
        </p>
        <p><strong>Last Updated:</strong>
            {{ auth()->user()->updated_at->format('d M Y') }}
        </p>
@endsection
