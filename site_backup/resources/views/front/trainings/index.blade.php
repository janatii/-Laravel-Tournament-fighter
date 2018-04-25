@extends('front.layout')

@section('content')
    <div class="bancanopy">
        <div class="bancanopy-inner">
            <div class="bancanopy-header">
                <div class="bancanopy-header-bg" style="background-image: url('{{ isset($game_selected) ? $game_selected->banner : '' }}')"></div>
            </div>
        </div>
    </div>
    
    <div class="main-content-wrapper">
        <div class="container">
            <div class="row mid-wrapper">
                <div class="col-lg-10 mid-main">
                    <div class="col-lg-12">
                        <training-list></training-list>
                    </div>
                </div>
                <div class="sidebar-right sidebar-right-trainings col-lg-2">
                    <create-training-form training-type="wager"></create-training-form>
                    <create-training-form></create-training-form>
                    <div class="premium-advantages">
                        <a href="{{ route_with_subdomain('shop_premium') }}">
                            <img src="/img/premium-{{ App::getLocale() }}.jpg" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if(Auth::check() && isset($game_selected, $active_team))
        <div class="remodal" id="abort-match-modal" data-remodal-id="abort-match" role="dialog" data-remodal-options="hashTracking: false">
            <div class="row">
                <button data-remodal-action="close" class="remodal-close"></button>
                
                <form action="{{ route_with_subdomain('training_abort') }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                    
                    <input type="hidden" name="match" value="">
                    
                    <h4 class="modal-title" id="abort-match-label">@lang('app.front.trainings.list.modals.abort-match.title')</h4>
                    <br>
                    <button type="button" data-remodal-action="close" class="btn btn-primary">@lang('app.front.trainings.list.modals.abort-match.btn-not-abort')</button>
                    <button type="submit" class="btn btn-danger">@lang('app.front.trainings.list.modals.abort-match.btn-abort')</button>
                </form>
            </div>
        </div>
    @endif
@endsection

@push('vue-data')
<script type="text/javascript">
    Vue.prototype.$trans['trainings-list'] = {!! json_encode(trans('app.front.trainings.list.component')) !!};
    Vue.prototype.$trans['create-training'] = {!! json_encode(trans('app.front.trainings.list.modals.create-training')) !!};
    Vue.prototype.$trans['join-training'] = {!! json_encode(trans('app.front.trainings.list.modals.join-training')) !!};
    Vue.prototype.$trans['errors-modals'] = {!! json_encode(trans('app.front.trainings.list.modals.errors-modals')) !!};
    Vue.prototype.$urls.createTraining = {!! json_encode(route_with_subdomain('training_create')) !!};
    Vue.prototype.$urls.joinTraining = {!! json_encode(route_with_subdomain('training_join')) !!};
    Vue.prototype.$store.trainingsAvailable = {!! json_encode($trainings) !!};
</script>
@endpush

@push('scripts')
    <script type="text/javascript">
        $(function() {
            remodalize('abort-match', false);
        });
    </script>
@endpush
