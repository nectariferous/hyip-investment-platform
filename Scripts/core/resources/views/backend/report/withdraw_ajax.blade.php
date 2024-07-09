@forelse(@$transactions as $transaction)
    <tr>
        <td>{{ @$transaction->user->fullname }}</td>
        <td>{{ @$transaction->withdrawMethod->name }}</td>
        <td>{{ @$transaction->transaction_id }}</td>

        <td>{{ @number_format($transaction->withdraw_charge,2) }}</td>
        <td>{{ @number_format($transaction->withdraw_amount,2) }}</td>


    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center">{{ __('No Data Found') }}
        </td>
    </tr>
@endforelse
