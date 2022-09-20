@extends('admin.layouts.main')
@section('content')
<div class="mx-5 my-5">
    <a href="{{ route('dataAdmin.index') }}" class="text-secondary">
        <h6 class="m-0 font-weight-bold"><i class="fas fa-chevron-left"></i> Back</h6>
    </a>
</div>

<div class="card shadow mx-5">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Add Admin</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('dataAdmin.addAdminUpdate') }}" method="post">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="user_id">Select User</label>
                <select class="custom-select  @error('user_id') is-invalid @enderror" name="user_id" id="user_id" required>
                    <option selected disabled>Select User</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select> 
                @error('user_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror   
            </div>
            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection