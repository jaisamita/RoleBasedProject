@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5>Edit User</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ url('/users/'.$user->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $user->name) }}">
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', $user->email) }}">
                </div>


                <button type="submit" class="btn btn-success">
                    Update
                </button>

                <!--a href="{{ route('admin.users') }}" class="btn btn-secondary">
                    Back
                </a-->
            </form>
        </div>
    </div>
</div>

@endsection
