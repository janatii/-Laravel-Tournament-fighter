<!-- TrainingNav.vue -->
<template>
    <div class="training-list-container">
        <div class="training-nav">
            <div class="trn-title">
                {{ $trans['trainings-list']['title'] }}
            </div>

            <div class="btn-filters">
                <div class="btn-options">
                    <label class="btn btn-default btn-sm" v-for="item in filtersAvailable.typesList" :class="{ 'active': filtersSelected.typesList.indexOf(item) >= 0 }">
                        <input type="checkbox" :value="item" v-model="filtersSelected.typesList"> {{ $trans['trainings-list'][item] }}
                    </label>
                </div>

                <div class="btn-options">
                    <label class="btn btn-default btn-sm" v-for="(item, index) in filtersAvailable.boList" :class="{ 'active': filtersSelected.boList.indexOf(index) >= 0 }">
                        <input type="checkbox" :value="index" v-model="filtersSelected.boList"> {{ item }}
                    </label>
                </div>

                <div class="btn-options">
                    <label class="btn btn-default btn-sm" v-for="(item, index) in filtersAvailable.vsList" :class="{ 'active': filtersSelected.vsList.indexOf(index) >= 0 }">
                        <input type="checkbox" :value="index" v-model="filtersSelected.vsList"> {{ item }}
                    </label>
                </div>
            </div>
        </div>
        <div class="training-content">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ $trans['trainings-list']['cols']['game'] }}</th>
                            <th>{{ $trans['trainings-list']['cols']['team'] }}</th>
                            <th>{{ $trans['trainings-list']['cols']['rank'] }}</th>
                            <th>{{ $trans['trainings-list']['cols']['rule'] }}</th>
                            <th>{{ $trans['trainings-list']['cols']['mode'] }}</th>
                            <th>{{ $trans['trainings-list']['cols']['bo'] }}</th>
                            <th>{{ $trans['trainings-list']['cols']['vs'] }}</th>
                            <th>{{ $trans['trainings-list']['cols']['style'] }}</th>
                            <th>{{ $trans['trainings-list']['cols']['join'] }}</th>
                            <th class="text-left">{{ $trans['trainings-list']['cols']['details'] }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="matches.length == 0">
                            <td colspan="10">
                                {{ $trans['trainings-list']['no-trainings'] }}
                            </td>
                        </tr>
                        <tr v-if="matches.length > 0 && orderedFilteredMatches.length == 0">
                            <td colspan="10">
                                {{ $trans['trainings-list']['no-trainings-filters'] }}
                            </td>
                        </tr>

                        <template v-if="orderedFilteredMatches.length > 0">
                            <template v-for="match in orderedFilteredMatches">
                                <tr :id="'training-' + match.id" :class="['training', 'training-type-' + match.type, match.premium ? 'training-premium' : '', match.new ? 'training-new' : '']" v-bind:key="match.id">
                                    <td>
                                        <img class="middle-game-icon" :src="'/storage/games/logo_list_trainings/' + match.game.id" alt="">
                                    </td>
                                    <td class="team-name">
                                        <a :href="'/team/' + match.squads[0].team.name">
                                            <img class="middle-team-icon" :src="'/storage/teams/avatar/' + match.squads[0].team.id" alt="">
                                            {{ match.squads[0].team.name }}
                                        </a>
                                        <img v-if="match.premium" class="premium-icon middle-premium-icon" src="/img/premium-icon.png" alt="premium" :title="$trans['trainings-list']['match-premium']">
                                    </td>
                                    <td>
                                        <div class="rank">
                                            {{ match.squads[0].team.score }} <i class="fa fa-line-chart"></i>
                                        </div>
                                        <div class="win-lost">
                                            <div class="green">W <span>{{ match.squads[0].team.win }}</span></div>
                                            <div class="red">L <span>{{ match.squads[0].team.lost }}</span></div>
                                        </div>
                                    </td>
                                    <td>{{ match.typeText }}</td>
                                    <td>{{ match.mode.name }}</td>
                                    <td>{{ match.boText }}</td>
                                    <td>{{ match.vsText }}</td>
                                    <td>{{ match.betText }}</td>
                                    <td>
                                        <a v-if="$store.authUser && $store.authUser.activeTeam && $store.authUser.activeTeam.id == match.squads[0].team.id && $store.authUser.id != match.creator_id" class="btn btn-default btn-success button">{{ $trans['trainings-list']['my-team-match'] }}</a>
                                        <a v-else-if="$store.authUser && $store.authUser.activeTeam && $store.authUser.activeTeam.id == match.squads[0].team.id && $store.authUser.id == match.creator_id" class="btn btn-default btn-danger button button-red" data-remodal-target="abort-match" @click="abortMatch(match)">{{ $trans['trainings-list']['abort-match'] }}</a>
                                        <join-training-form v-else :match-id="match.id" :match-vs="match.vs" :training-type="match.type === 'WAGER' ? 'wager' : 'training'"></join-training-form>
                                    </td>
                                    <td>
                                        <div class="more">
                                            <i class="fa" :class="openedMatch == match.id ? 'fa-minus-circle' : 'fa-plus-circle'" aria-hidden="true" @click="openMatchTeam(match)"></i>
                                        </div>
                                    </td>
                                </tr>
                                <transition name="fade">
                                    <tr class="team-details" v-if="openedMatch == match.id">
                                        <td colspan="10">
                                            <div class="detail-container">
                                                <div class="col-detail col-detail-1">

                                                </div>
                                                <div class="col-detail col-detail-2">
                                                    <div class="two-gamer-col" v-for="members in duos(match.squads[0].members)">
                                                        <div class="gamer">
                                                            <a :href="'/profile/' + members[0].username">
                                                                <img class="gamer-avatar" :src="'/storage/users/avatar/' + members[0].id" alt="">
                                                                <span :class="[members[0].premium ? 'premium-member-training-list' : '']">{{ members[0].username }}</span>
                                                                <span class="clsmt-elo">{{ members[0].score }} <i class="fa fa-line-chart"></i></span>
                                                            </a>
                                                        </div>
                                                        <div class="gamer" v-if="members[1]">
                                                            <a :href="'/profile/' + members[1].username">
                                                                <img class="gamer-avatar" :src="'/storage/users/avatar/' + members[1].id" alt="">
                                                                <span :class="[members[1].premium ? 'premium-member-training-list' : '']">{{ members[1].username }}</span>
                                                                <span class="clsmt-elo">{{ members[1].score }} <i class="fa fa-line-chart"></i></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </transition>
                            </template>
                        </template>
                        <tr><td colspan="10"></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            filtersAvailable: {
                typesList: ['FRIENDLY', 'RANKED', 'WAGER'],
                boList: this.$store.gameSelected.bo_list,
                vsList: this.$store.gameSelected.vs_list
            },
            filtersSelected: {
                typesList: ['FRIENDLY', 'RANKED', 'WAGER'],
                boList: Object.keys(this.$store.gameSelected.bo_list),
                vsList: Object.keys(this.$store.gameSelected.vs_list)
            },
            matches: this.$store.trainingsAvailable,
            openedMatch: null,
        }
    },

    mounted() {
        this.listen();
    },

    methods: {

        listen() {
            Echo.channel('matchs')
                .listen('MatchCreated', (e) => {
                    this.receiveNewMatch(e);
                })
                .listen('MatchAborted', (e) => {
                    this.receiveMatchAborted(e);
                })
                .listen('MatchJoined', (e) => {
                    this.receiveMatchJoined(e);
                });
        },

        receiveNewMatch(match) {
            match.new = true;
            this.matches.push(match);
        },

        receiveMatchAborted(matchReceived) {
            let newMatches = this.matches.filter((match) => {
                return match.id != matchReceived.id;
            });

            $('#training-' + matchReceived.id).addClass('aborted');

            setTimeout(() => {
                this.matches = newMatches;
            }, 1000);
        },

        receiveMatchJoined(matchReceived) {
            let newMatches = this.matches.filter((match) => {
                return match.id != matchReceived.id;
            });

            $('#training-' + matchReceived.id).addClass('joined');

            setTimeout(() => {
                this.matches = newMatches;
            }, 1000);
        },

        joinMatch(match) {
            let $modal = $('#join-match');
            $modal.find('input[name="match"]').val(match.id);
            $modal.find('.players-selection-container .player-select').hide();
            $modal.find('.players-selection-container .player-select').slice(0, match.vs).show();
        },

        abortMatch(match) {
            $('#abort-match-modal').find('input[name="match"]').val(match.id);
        },

        openMatchTeam(match) {
            if (this.openedMatch === match.id) {
                this.openedMatch = null;
            } else {
                this.openedMatch = match.id;
            }
        },

        duos(values) {
            // https://stackoverflow.com/a/8495740/4726998
            let i, j, chunk = 2;
            let chunkedValues = [];
            for (i = 0, j = values.length; i < j; i += chunk) {
                chunkedValues.push(values.slice(i, i + chunk));
            }
            return chunkedValues;
        },

        isUserMatch(match) {
            if (this.$store.authUser) {
                return match.creator_id == this.$store.authUser.id;
            }
            return false;
        }
    },

    computed: {
        orderedMatches() {
            let results = this.userMatches;

            if (this.filtersSelected.typesList.indexOf('WAGER') >= 0) {
                results = results.concat(this.premiumWagerMatches);
            }
            if (this.filtersSelected.typesList.indexOf('RANKED') >= 0) {
                results = results.concat(this.premiumRankedMatches);
            }
            if (this.filtersSelected.typesList.indexOf('FRIENDLY') >= 0) {
                results = results.concat(this.premiumFriendlyMatches);
            }
            if (this.filtersSelected.typesList.indexOf('WAGER') >= 0) {
                results = results.concat(this.nonPremiumWagerMatches);
            }
            if (this.filtersSelected.typesList.indexOf('RANKED') >= 0) {
                results = results.concat(this.nonPremiumRankedMatches);
            }
            if (this.filtersSelected.typesList.indexOf('FRIENDLY') >= 0) {
                results = results.concat(this.nonPremiumFriendlyMatches);
            }

            return results;
        },

        orderedFilteredMatches() {
            return this.orderedMatches.filter((match) => {
                return this.filtersSelected.boList.indexOf(match.bo + '') >= 0
                    && this.filtersSelected.vsList.indexOf(match.vs + '') >= 0;
            });
        },

        userMatches() {
            if (!this.$store.authUser) {
                return [];
            }

            return this.matches.filter((item) => {
                return this.isUserMatch(item);
            });
        },

        premiumWagerMatches() {
            return this.matches.filter((item) => {
                return !this.isUserMatch(item) && item.premium && item.type === 'WAGER';
            });
        },

        premiumRankedMatches() {
            return this.matches.filter((item) => {
                return !this.isUserMatch(item) && item.premium && item.type === 'RANKED';
            });
        },

        premiumFriendlyMatches() {
            return this.matches.filter((item) => {
                return !this.isUserMatch(item) && item.premium && item.type === 'FRIENDLY';
            });
        },

        nonPremiumWagerMatches() {
            return this.matches.filter((item) => {
                return !this.isUserMatch(item) && !item.premium && item.type === 'WAGER';
            });
        },

        nonPremiumRankedMatches() {
            return this.matches.filter((item) => {
                return !this.isUserMatch(item) && !item.premium && item.type === 'RANKED';
            });
        },

        nonPremiumFriendlyMatches() {
            return this.matches.filter((item) => {
                return !this.isUserMatch(item) && !item.premium && item.type === 'FRIENDLY';
            });
        },
    }
}
</script>
