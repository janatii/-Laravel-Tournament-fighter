<div class="btn-toolbar" role="toolbar">
    @foreach($filters as $filterName => $filterValues)
        <div class="btn-group" role="group">
            @foreach($filterValues as $filterValue)
                <a href="{{ QueryStringFilterViewHelper::currentUrlWith($filterName, $filterValue['value']) }}" class="btn btn-default {{ QueryStringFilterViewHelper::check($filterName, $filterValue['value']) ? 'active' : '' }}">{{ $filterValue['label'] }}</a>
            @endforeach
        </div>
    @endforeach
</div>
