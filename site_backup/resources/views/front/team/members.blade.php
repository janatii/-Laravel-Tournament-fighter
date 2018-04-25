@extends('front.team.layout')

@section('sub_content')
    <div class="bloc">
        <div class="section-title">
            @lang('app.front.team.members.title')
            
            @can('invite-players', $team)
                <button class="btn btn-primary pull-right" data-remodal-target="invite-player">
                    <i class="fa fa-envelope"></i>
                    @lang('app.front.team.members.invite')
                </button>
            @endcan
        </div>
        <div class="section-content">
            <div class="team-members">
                @forelse($team->members as $member)
                    @can('manage', $team)
                        <div class="team-member">
                            @component('components.gamer')
                                @slot('gamer', $member)
                                @slot('role', $member->pivot->role)
                            @endcomponent
                            <div class="actions">
                                @if($member->id != $team->owner->id)
                                    <form class="js-confirmable-form" action="{{ route_with_subdomain('team_members_removeplayer', ['team' => $team, 'user' => $member]) }}" method="post" data-confirm="@lang('app.front.team.members.confirm-remove', ['username' => $member->username])">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                        <button class="btn btn-danger" type="submit">
                                            <i class="fa fa-user-times"></i>
                                            @lang('app.front.team.members.remove-player')
                                        </button>
                                    </form>
                                    @can('manage-managers', $team)
                                        @if($member->pivot->role == 'PLAYER')
                                            <form action="{{ route_with_subdomain('team_members_promotemanager', ['team' => $team, 'user' => $member]) }}" method="post">
                                                {{ csrf_field() }}
                                                <button class="btn btn-success" type="submit">
                                                    <i class="fa fa-level-up"></i>
                                                    @lang('app.front.team.members.promote-manager')
                                                </button>
                                            </form>
                                        @elseif($member->pivot->role == 'MANAGER')
                                            <form action="{{ route_with_subdomain('team_members_promoteplayer', ['team' => $team, 'user' => $member]) }}" method="post">
                                                {{ csrf_field() }}
                                                <button class="btn btn-danger" type="submit">
                                                    <i class="fa fa-level-down"></i>
                                                    @lang('app.front.team.members.promote-player')
                                                </button>
                                            </form>
                                        @endif
                                    @endcan
                                @endif
                            </div>
                        </div>
                    @else
                        @component('components.gamer')
                            @slot('gamer', $member)
                            @slot('role', $member->pivot->role)
                        @endcomponent
                    @endcan
                @empty
                    <div class="text-center">
                        @lang('app.front.team.members.text-no-members')
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @can('see-candidates-players', $team)
        <div class="bloc">
            <div class="section-title">
                @lang('app.front.team.members.title_candidatures')
            </div>
            <div class="section-content">
                <div class="team-candidates">
                    @forelse($team->candidates as $candidate)
                        @can('manage', $team)
                            <div class="team-candidate">
                                @component('components.gamer')
                                    @slot('gamer', $candidate)
                                    @slot('role', $candidate->pivot->role)
                                @endcomponent
                                <div class="actions">
                                    
                                    <form class="js-confirmable-form" action="{{ route_with_subdomain('team_members_denycandidate', ['team' => $team, 'user' => $candidate]) }}" method="post" data-confirm="@lang('app.front.team.members.confirm-deny', ['username' => $candidate->username])">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                        <button class="btn btn-danger" type="submit">
                                            <i class="fa fa-times"></i>
                                            @lang('app.front.team.members.deny-candidate')
                                        </button>
                                    </form>
                                    @if($candidate->can('be-accepted', $team))
                                        <form class="js-confirmable-form" action="{{ route_with_subdomain('team_members_acceptcandidate', ['team' => $team, 'user' => $candidate]) }}" method="post" data-confirm="@lang('app.front.team.members.confirm-accept', ['username' => $candidate->username])">
                                            {{ csrf_field() }}
                                            <button class="btn btn-success" type="submit">
                                                <i class="fa fa-user-plus"></i>
                                                @lang('app.front.team.members.accept-candidate')
                                            </button>
                                        </form>
                                    @endif
                                    @can('ban-players', $team)
                                        <form class="js-confirmable-form" action="{{ route_with_subdomain('team_members_banplayer', ['team' => $team, 'user' => $candidate]) }}" method="post" data-confirm="@lang('app.front.team.members.confirm-ban', ['username' => $candidate->username])">
                                            {{ csrf_field() }}
                                            {{ method_field('post') }}
                                            <button class="btn btn-danger" type="submit">
                                                <i class="fa fa-lock"></i>
                                                @lang('app.front.team.members.ban')
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        @else
                            @component('components.gamer')
                                @slot('gamer', $candidate)
                                @slot('role', $candidate->pivot->role)
                            @endcomponent
                        @endcan
                    @empty
                        <div class="text-center">
                            @lang('app.front.team.members.text-no-candidates')
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @endcan

    @can('see-invited-players', $team)
        <div class="bloc">
            <div class="section-title">
                @lang('app.front.team.members.title_invites')
            </div>
            <div class="section-content">
                <div class="team-invites">
                    @forelse($team->invites as $invite)
                        @can('manage', $team)
                            <div class="team-invite">
                                @component('components.gamer')
                                    @slot('gamer', $invite)
                                    @slot('role', $invite->pivot->role)
                                @endcomponent
                                <div class="actions">
                                    <form class="js-confirmable-form" action="{{ route_with_subdomain('team_members_removeinvite', ['team' => $team, 'user' => $invite]) }}" method="post" data-confirm="@lang('app.front.team.members.confirm-remove-invite', ['username' => $invite->username])">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                        <button class="btn btn-danger" type="submit">
                                            <i class="fa fa-times"></i>
                                            @lang('app.front.team.members.remove-invite')
                                        </button>
                                    </form>
                                    @can('ban-players', $team)
                                        <form class="js-confirmable-form" action="{{ route_with_subdomain('team_members_banplayer', ['team' => $team, 'user' => $invite]) }}" method="post" data-confirm="@lang('app.front.team.members.confirm-ban', ['username' => $invite->username])">
                                            {{ csrf_field() }}
                                            {{ method_field('post') }}
                                            <button class="btn btn-danger" type="submit">
                                                <i class="fa fa-lock"></i>
                                                @lang('app.front.team.members.ban')
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        @else
                            @component('components.gamer')
                                @slot('gamer', $invite)
                                @slot('role', $invite->pivot->role)
                            @endcomponent
                        @endcan
                    @empty
                        <div class="text-center">
                            @lang('app.front.team.members.text-no-invites')
                        </div>
                    @endforelse
                </div>
            </div>
            @can('invite-players', $team)
                <div class="section-actions">
                    <button class="btn btn-primary" data-remodal-target="invite-player">
                        <i class="fa fa-envelope"></i>
                        @lang('app.front.team.members.invite')
                    </button>
                </div>
            @endcan
        </div>
    @endcan

    @can('see-banned-players', $team)
        <div class="bloc">
            <div class="section-title">
                @lang('app.front.team.members.title_bans')
            </div>
            <div class="section-content">
                <div class="team-bans">
                    @forelse($team->bans as $ban)
                        @can('unban-players', $team)
                            <div class="team-ban">
                                @component('components.gamer')
                                    @slot('gamer', $ban)
                                    @slot('role', $ban->pivot->role)
                                @endcomponent
                                <div class="actions">
                                    <form class="js-confirmable-form" action="{{ route_with_subdomain('team_members_unbanplayer', ['team' => $team, 'user' => $ban]) }}" method="post" data-confirm="@lang('app.front.team.members.confirm-unban', ['username' => $ban->username])">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                        <button class="btn btn-danger" type="submit">
                                            <i class="fa fa-unlock"></i>
                                            @lang('app.front.team.members.unban')
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            @component('components.gamer')
                                @slot('gamer', $ban)
                                @slot('role', $ban->pivot->role)
                            @endcomponent
                        @endcan
                    @empty
                        <div class="text-center">
                            @lang('app.front.team.members.text-no-bans')
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @endcan
@endsection

@push('modals')
    @can('invite-players', $team)
        <div class="remodal" data-remodal-id="invite-player" role="dialog">
            <button data-remodal-action="close" class="remodal-close"></button>
            <div class="row" style="background:white">
                <h1 class="text-center">
                    @lang('app.front.team.members.modals.invite-player.title')
                </h1>
            </div>
            <div class="row text-center" style="padding:10px 0 ;">
                <img src="/img/logo-notext.png" class="img" width="100" >
            </div>
            <div class="alert alert-danger fade-in" role="alert" style="display: none"></div>
            <form class="form-horizontal" method="post" action="{{ route_with_subdomain('team_members_addinvite', ['team' => $team]) }}">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-1">
                        <div class="form-group">
                            <label for="username" class="col-sm-4 control-label">@lang('app.global.forms-fields.username')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="username" name="username" placeholder="" maxlength="15" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-4">
                                <button type="submit" class="btn btn-primary btn-block">@lang('app.front.team.members.modals.invite-player.button')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endcan
@endpush

@push('scripts')
    @can('invite-players', $team)
        <script>
            (function() {
                remodalize('invite-player', function(data, status, jqXhr) {
                    window.location.hash = '';
                    window.location.reload();
                });
            })();
        </script>
    @endcan
@endpush