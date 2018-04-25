<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.front.search.players-title')</div>
            
            <div class="panel-body search">
                @forelse($resultsPlayers as $result)
                    @component('components.gamer')
                        @slot('gamer', $result)
                    @endcomponent
                @empty
                    <div class="text-center">
                        @lang('app.front.search.no-players')
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.front.search.teams-title')</div>
    
            <div class="panel-body search">
                @forelse($resultsTeams as $result)
                    @component('components.team')
                        @slot('team', $result)
                    @endcomponent
                @empty
                    <div class="text-center">
                        @lang('app.front.search.no-teams')
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
