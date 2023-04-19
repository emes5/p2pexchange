@if(isset($buys[0]))
    @foreach($buys as $buy)
        @include('user.marketplace.market.include.buy_data')
    @endforeach
@else
    <tr>
        <td colspan="7" class="text-center">{{__('No data available')}}</td>
    </tr>
@endif
