<div class="form-group">
    <label>{{__('Select Custom Pages')}}</label>
    <select multiple name="pages[]" class="selectpicker form-control bg-transparent" id="select-pages" data-container="body" data-live-search="true" title="" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false">
        @foreach($custom_pages as $c_page)
            <option value="{{$c_page->id}}" @if(in_array($c_page->id,$selected_custom_pages)) selected @endif>{{$c_page->title}}</option>
        @endforeach
    </select>
</div>
