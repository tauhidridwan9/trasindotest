@extends('layouts.customer')

@section('content')
<div class="container mt-5">
    <h1>Selesaikan Pembayaran Anda</h1>

    <div id="midtrans-button"></div>

    <form id="submit_form" method="POST" action="{{ route('customer.order.complete', $order->id) }}">
        @csrf
        <input type="hidden" name="payment_token" id="payment_token">
    </form>
</div>

<script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script type="text/javascript">
    snap.pay('{{ $snapToken }}', {
        onSuccess: function(result) {
            document.getElementById('payment_token').value = result.token;
            document.getElementById('submit_form').submit();
        }
    });
</script>
@endsection