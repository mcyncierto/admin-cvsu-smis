@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Users List</h3>

                    <form action="{{ route('users.index') }}" method="post" id="formSearchUser" class="card-tools">
                        @method('get')
                        @csrf
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" value="{{ $search }}" name="search" class="form-control float-right" placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-head-fixed table-hover">
                        <thead>
                            <tr>
                                <th>Student Number</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Birthdate</th>
                                <th>Gender</th>
                                <th>Contact Number</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th style="text-align:center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->student_number }}</td>
                                    <td>{{ $user->first_name}}</td>
                                    <td>{{ $user->middle_name}}</td>
                                    <td>{{ $user->last_name}}</td>
                                    <td>{{ $user->birthdate}}</td>
                                    <td>{{ $user->gender}}</td>
                                    <td>{{ $user->contact_number}}</td>
                                    <td>{{ $user->address}}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->type }}</td>
                                    <td style="width:110px">
                                        <div>
                                            <button title="Edit User" type="button"
                                                class="btn btn-block btn-outline-info btn-sm float-left" style="max-width: 35px"
                                                data-toggle="modal" data-target="#user-modal-{{ $user->id }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="post"
                                                id="formDeleteUser{{ $user->id }}">
                                                <button title="Delete User" type="button" class="btn btn-block btn-outline-danger btn-sm 
                                                        @if ($user->type == 'Admin') disabled @endif float-right" style="width: 35px"
                                                    onclick="confirmSubmit('delete', 'formDeleteUser',
                                                    '{{ $user->id }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                @method('delete')
                                                @csrf
                                            </form>
                                        </div>
                                    </td>
                                    @include('user.edit_modal')
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <span class=" float-right">{{ $users->links() }}</span>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
