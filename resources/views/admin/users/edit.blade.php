@extends('admin.layouts.app')

@section('title', 'Sửa thông tin người dùng')
@section('content')

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Sửa thông tin người dùng "{{$user->name}}"</h4>

        <form class="forms-sample" action="{{route('users.update',$user->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label >Full Name</label>
                <input name="name" value="{{old('name') ?? $user->name}}" type="text" class="form-control" placeholder="Name">
                @error('name')
                <span class="text-danger"> {{ $message }}</span>
                @enderror

            </div>
            <div class="form-group">
                <label >Email address</label>
                <input type="email" name="email" value="{{old('email') ?? $user->email}}" class="form-control" placeholder="Email">
                @error('email')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Number Phone</label>
                <input type="number" name="phone" value="{{old('phone') ?? $user->phone}}" class="form-control" placeholder="Phone">
            </div>

            <div class="form-group">
                <label >Password</label>
                <input  value="{{old('password') ?? $user->password}}" type="password" name="password" class="form-control" placeholder="Password">
                @error('password')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Date Of Birth</label>
                <input type="date" name="birthOfDay" value="{{old('birthOfDay') ?? $user->birthofday }}" class="form-control" placeholder="dd/MM/yyyy">
            </div>

            <div class="form-group">
                <label for="exampleSelectGender">Gender</label>
                <select name="gender" class="form-control" >
                    <option selected value="0">Male</option>
                    <option value="1">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label>File upload</label>
                <input value="{{$user->avatar}}" type="file" accept="image/*" name="image" class="file-upload-default">
                <div class="input-group col-xs-12">
                    <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                    <span class="input-group-append">
                        <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                    </span>
                </div>
            </div>


            <div class="form-group">
            <label>Vai trò người dùng</label>
                <div class="row">
                @foreach($roles as $groupName => $role)
                    <div class="col-5">
                        <h5>{{$groupName}}</h5>
                        <div>
                        @foreach($role as $item)
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input  {{ $user->roles->contains('id', $item->id) ? 'checked' : '' }} name="role_ids[]" type="checkbox" class="form-check-input" value="{{$item->name}}">
                                    {{$item->display_name}}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-primary mr-2">Submit</button>
            <button class="btn btn-light"><a href="">Cancel</a></button>
        </form>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        hiddenLoadingPage();
    });
</script>

@endsection