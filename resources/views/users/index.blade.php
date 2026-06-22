@extends('layouts.app-admin')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">
            <h4>User Management</h4>
        </div>

        <div class="card-body">

            <table class="table">

                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>History</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($users as $user)

                    <tr>

                        <td>{{ $user->name }}</td>

                        <td>{{ $user->email }}</td>

                        <!-- ROLE -->
                        <td>

                            <form action="{{ route('users.role', $user->id) }}"
                                  method="POST">

                                @csrf
                                @method('PUT')

                                <select name="	user_type"
                                        onchange="this.form.submit()"
                                        class="form-control">

                                    <option value="buyer"
                                        {{ $user->user_type == 'buyer' ? 'selected' : '' }}>
                                        Buyer
                                    </option>

                                    <option value="seller"
                                        {{ $user->user_type == 'seller' ? 'selected' : '' }}>
                                        Seller
                                    </option>

                                </select>

                            </form>

                        </td>

                        <!-- STATUS -->
                        <td>

                            <form action="{{ route('users.status', $user->id) }}"
                                  method="POST">

                                @csrf
                                @method('PUT')

                                <select name="status"
                                        onchange="this.form.submit()"
                                        class="form-control">

                                    <option value="active"
                                        {{ $user->status == 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>

                                    <option value="blocked"
                                        {{ $user->status == 'blocked' ? 'selected' : '' }}>
                                        Blocked
                                    </option>

                                </select>

                            </form>

                        </td>

                        <!-- HISTORY -->
                        <td>

                            @if($user->user_type == 'buyer')

                                Purchase History

                            @else

                                Selling History

                            @endif

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
