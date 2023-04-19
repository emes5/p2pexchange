@if(isset($sells[0]))
    @foreach($sells as $sell)
        @include('user.marketplace.market.include.sell_data')
    @endforeach

@else
    <tr>
        <th colspan="7" class="text-center">{{__('No data available')}}</th>
    </tr>
@endif


