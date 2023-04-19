@if(isset($payment_methods[0]))
    @foreach($payment_methods as $payment_method)
        <option value="{{$payment_method->payment_method_id}}">{{$payment_method->name}}</option>
    @endforeach
@endif
