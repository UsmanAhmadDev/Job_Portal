@extends('frontend.layouts.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.sidebar')
                </div>
                <div class="col-lg-9">
                    @include('frontend.message')
                    <div class="card border-0 shadow mb-4">
                        <div class="card-body">
                            <div class="card-body card-form">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3 class="fs-4 mb-1">Users</h3>
                                    </div>


                                </div>
                                <div class="table-responsive">
                                    <table class="table ">
                                        <thead class="bg-light">
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Mobile</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="border-0">
                                            @if ($users->isNotEmpty())
                                                @foreach ($users as $user)
                                                    <tr class="active">
                                                        <td>{{ $user->id }}</td>
                                                        <td>
                                                            <div class="job-name fw-500">{{ $user->name }}</div>
                                                        </td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->mobile }}</td>
                                                        <td>
                                                            <div class="action-dots">
                                                                <button class="btn" data-bs-toggle="dropdown"
                                                                    aria-expanded="false">
                                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li>
                                                                        <a class="dropdown-item"href="{{ route("admin.users.edit", $user->id) }}"> <i class="fa fa-edit" aria-hidden="true">
                                                                            </i>Edit
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="deleteUser({{ $user->id }})"> <i class="fa fa-trash" aria-hidden="true">
                                                                            </i>Delete
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div>
                                    {{ $users->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('customjs')
    <script type="text/javascript">
        // function deleteUser(id){
        //     if (confirm("Are you sure you want to delete?")) {
        //         $.ajax({
        //             url: '{{ route("admin.users.destroy") }}',
        //             type: 'delete',
        //             data: {id: id},
        //             dataType: 'json',
        //             success: function (response) {
        //                 window.location.href = "{{ route('admin.users') }}";
        //             }
        //         });
        //     }
        // }

        function deleteUser(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("admin.users.destroy") }}',
                        type: 'delete',
                        data: {id: id},
                        dataType: 'json',
                        success: function (response) {
                            window.location.href = "{{ route('admin.users') }}";
                        }
                    });
                }
            });
        }

    </script>
@endsection
