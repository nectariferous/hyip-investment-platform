@forelse(@$transactions as $transaction)
<tr>
    <td>{{ @$transaction->user->fullname }}</td>
    <td>{{ @$transaction->gateway->gateway_name }}</td>
    <td>{{ @$transaction->transaction_id }}</td>
    <td>{{ @number_format($transaction->amount,2) }}</td>
    <td>{{ @number_format($transaction->rate,2) }}</td>
    <td>{{ @number_format($transaction->charge,2) }}</td>
    <td>{{ @number_format($transaction->final_amount,2) }}</td>
    <td>
        @if($transaction->payment_type == 1)
            <span class="badge badge-success">{{__('Autometic')}}</span>
        @else
            <span class="badge badge-info">{{__('Manual')}}</span>
        @endif
    </td>

</tr>
@empty
<tr>
    <td colspan="8" class="text-center">{{ __('No Data Found') }}
    </td>
</tr>
@endforelse