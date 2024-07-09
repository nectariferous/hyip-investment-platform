@if ($type === 'Role')
    @foreach ($tables as $role)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $role->name }}</td>
            <td>

                <button class="btn btn-primary btn-sm edit" data-name="{{ $role->name }}"
                    data-href="{{ route('admin.roles.update', $role) }}"
                    data-permissons="{{ $role->permissions->pluck('name') }}">
                    <i class="fa fa-pen"></i></button>
            </td>
        </tr>
    @endforeach
@elseif ($type === 'User')
    @forelse($tables as $key => $user)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $user->fullname }}</td>

            <td>{{ $user->phone }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ @$user->address->country ?? 'N/A' }}</td>
            <td>

                @if ($user->status)
                    <span class='badge badge-success'>{{ __('Active') }}</span>
                @else
                    <span class='badge badge-danger'>{{ __('Inactive') }}</span>
                @endif

            </td>

            <td>

                <a href="{{ route('admin.user.details', $user) }}" class="btn btn-md btn-primary"><i
                        class="fa fa-pen"></i></a>


                <a href="{{ route('admin.login.user', $user) }}" target="_blank"
                    class="btn btn-info btn-md ">{{ __('Login as User') }}</a>


            </td>


        </tr>
    @empty
        <tr>
            <td class="text-center" colspan="100%">{{ __('No Data Found') }}</td>
        </tr>
    @endforelse
@elseif($type === 'Admin')
    @foreach ($tables as $admin)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                @foreach ($admin->roles as $role)
                    <span class="badge badge-primary">{{ $role->name }}</span>
                @endforeach
            </td>

            <td>{{ $admin->username }}</td>
            <td>{{ $admin->email }}</td>

            <td>
                <a href="{{ route('admin.admins.edit', $admin) }}" class="btn btn-primary btn-sm"><i
                        class="fa fa-pen"></i></a>
            </td>

        </tr>
    @endforeach
@elseif($type === 'Payment')
    @forelse($tables as $transaction)
        <tr>
            <td>{{ @$transaction->user->fullname }}</td>
            <td>{{ @$transaction->gateway->gateway_name ?? 'Using Balance' }}</td>
            <td>{{ @$transaction->transaction_id }}</td>
            <td>{{ @number_format($transaction->amount, 2) }}</td>
            <td>{{ @number_format($transaction->rate, 2) }}</td>
            <td>{{ @number_format($transaction->charge, 2) }}</td>
            <td>{{ @number_format($transaction->final_amount, 2) }}</td>
            <td>
                @if ($transaction->payment_type == 1)
                    <span class="badge badge-success">{{ __('Autometic') }}</span>
                @else
                    <span class="badge badge-info">{{ __('Manual') }}</span>
                @endif
            </td>

        </tr>
    @empty
        <tr>
            <td colspan="8" class="text-center">{{ __('No Data Found') }}
            </td>
        </tr>
    @endforelse
@elseif($type === 'Withdraw')
    @forelse(@$tables as $transaction)
        <tr>
            <td>{{ @$transaction->user->fullname }}</td>
            <td>{{ @$transaction->withdrawMethod->name }}</td>
            <td>{{ @$transaction->transaction_id }}</td>

            <td>{{ @number_format($transaction->withdraw_charge, 2) }}</td>
            <td>{{ @number_format($transaction->withdraw_amount, 2) }}</td>


        </tr>
    @empty
        <tr>
            <td colspan="8" class="text-center">{{ __('No Data Found') }}
            </td>
        </tr>
    @endforelse

@endif
