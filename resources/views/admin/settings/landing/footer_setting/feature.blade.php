<div class="form-group">
    <label>{{__('Select Features')}}</label>
    <select multiple name="features[]" class="selectpicker form-control bg-transparent" id="select-features" data-container="body" data-live-search="true" title="" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false">
        @foreach($features as $feature)
            <option value="{{$feature->id}}" @if($feature->footer_status) selected @endif>{{$feature->sub_title}}</option>
        @endforeach
    </select>
</div>
