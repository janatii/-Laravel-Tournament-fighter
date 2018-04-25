@if(session()->has('errors'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger" role="alert">
                @lang('app.global.generic-texts.errors-occured')
            </div>
        </div>
    </div>
@elseif(session()->has('success'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        </div>
    </div>
@endif
