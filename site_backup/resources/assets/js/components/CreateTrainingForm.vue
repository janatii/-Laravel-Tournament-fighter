<!-- CreateTrainingForm.vue -->
<template>
    <div>
        <div>
            <button :class="['btn', 'btn-default', 'btn-primary', 'button', trainingType]" @click="openModal()">{{ $trans['create-training']['open-buttons']['create-' + trainingType] }}</button>
        </div>
        
        <div v-if="$store.gameSelected && $store.authUser && $store.authUser.activeTeam" :id="'create-' + trainingType + '-form-modal'" :class="['modal', 'fade-scale', 'in', trainingType]" tabindex="-1" aria-labelledby="create-training-label" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form :action="$urls.createTraining" method="post">
                        
                        <input type="hidden" name="team" :value="$store.authUser.activeTeam.id">
                        
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            
                            <h4 class="modal-title" id="create-training-label">{{ $trans['create-training'][trainingType]['title'] }}</h4>
                            <h5 class="modal-subtitle">{{ $trans['generic-texts']['with-team'] }} {{ $store.authUser.activeTeam.name }}</h5>
                        </div>
                        
                        <div class="modal-body">
                            
                            <template v-if="trainingType !== 'wager'">
                                <div class="form-group rule btn-options">
                                    <label>{{ $trans['create-training'][trainingType]['rule'] }} : </label>
                                    <label class="btn btn-default" :class="{ 'active': selectedRule == 'RANKED' }">
                                        <input v-model="selectedRule" type="radio" name="rule" value="RANKED"> {{ $trans['generic-texts']['ranked'] }}
                                    </label>
                                    <label class="btn btn-default" :class="{ 'active': selectedRule == 'FRIENDLY' }">
                                        <input v-model="selectedRule" type="radio" name="rule" value="FRIENDLY" checked> {{ $trans['generic-texts']['friendly'] }}
                                    </label>
                                </div>
                            </template>
                            <template v-else>
                                <input type="hidden" name="rule" value="WAGER">
                            </template>
                            
                            <div class="form-group bestof btn-options">
                                <label>{{ $trans['create-training'][trainingType]['bestof'] }} : </label>
                                <label class="btn btn-default" v-for="(item, key) in boList" :class="{ 'active': selectedBO === key }">
                                    <input v-model="selectedBO" type="radio" name="bestof" :value="key"> {{ item }}
                                </label>
                            </div>
                            
                            <transition name="slideVertical">
                                <template v-if="trainingType == 'training' && selectedRule == 'FRIENDLY' && gamemodesList.length > 1">
                                    <div class="form-group btn-options">
                                        <label>{{ $trans['create-training'][trainingType]['mode'] }} : </label>
        
                                        <label class="btn btn-default" :class="{ 'active': !selectedGamemode }">
                                            <input v-model="selectedGamemode" type="radio" name="mode" value=""> {{ $trans['generic-texts']['classic'] }}
                                        </label>
                                        <label class="btn btn-default" v-for="(item, key) in gamemodesList" :class="{ 'active': selectedGamemode === item.id }">
                                            <input v-model="selectedGamemode" type="radio" name="mode" :value="item.id"> {{ item.abbrev }}
                                        </label>
                                    </div>
                                </template>
                                <template v-else>
                                    <input type="hidden" name="mode" value="">
                                </template>
                            </transition>
                            
                            <transition name="slideVertical">
                                <template v-if="selectedRule !== 'RANKED'">
                                    <template v-if="trainingType !== 'wager'">
                                        <div class="form-group maps">
                                            <label>{{ $trans['create-training'][trainingType]['maps'] }} : </label><br>
                                            <div class="map-select" v-for="(keyBO, indexBO) in parseInt(selectedBO)" :style="{ backgroundImage: 'url(' + getMapLogo(selectedMaps[indexBO]) + ')' }">
                                                <select v-model="selectedMaps[indexBO]" name="maps[]">
                                                    <option disabled :value="null">{{ $trans['generic-texts']['map'] }}</option>
                                                    <option v-for="item in filteredMaps(indexBO)" :value="item.id">{{ item.name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </template>
                                </template>
                            </transition>
                            
                            <div class="form-group versus btn-options">
                                <label>{{ $trans['create-training'][trainingType]['vs'] }} : </label>
                                <label class="btn btn-default" v-for="(item, key) in vsList" :class="{ 'active': selectedVS === key }">
                                    <input v-model="selectedVS" type="radio" name="nbplayers" :value="key"> {{ item }}
                                </label>
                            </div>
                            
                            <div class="form-group manager">
                                <label>{{ $trans['create-training'][trainingType]['manager'] }} : </label>
                                <div class="player-select" :style="{ backgroundImage: 'url(' + getPlayerAvatar(selectedManager, 0) + ')' }">
                                    <select v-model="selectedManager" name="manager">
                                        <option :value="null">{{ $trans['create-training'][trainingType]['manager'] }}</option>
                                        <option v-for="item in managersList" :value="item.id">{{ item.username }}</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group players">
                                <label>{{ $trans['create-training'][trainingType]['players'] }} : </label>
                                <div class="players-selection-container">
                                    <div class="player-select" v-for="(keyVS, indexVS) in parseInt(selectedVS)" :style="{ backgroundImage: 'url(' + getPlayerAvatar(selectedPlayers[indexVS], indexVS + 1) + ')' }">
                                        <select v-model="selectedPlayers[indexVS]" name="players[]">
                                            <option disabled :value="null">{{ $trans['generic-texts']['player'] }}</option>
                                            <template v-if="selectedPlayers[indexVS]">
                                                <option :value="selectedPlayers[indexVS]">{{ getPlayerUsername(selectedPlayers[indexVS]) }}</option>
                                            </template>
                                            <option v-for="item in availablePlayers" :value="item.id">{{ item.username }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div v-if="trainingType === 'wager'" class="form-group bet">
                                <label>{{ $trans['create-training']['wager']['bet'] }} :</label><br>
                                <select v-model="bet" name="bet">
                                    <option v-for="avbet in $store.availableBets" :value="avbet">{{ avbet }}C</option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="modal-errors alert alert-danger"></div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">{{ $trans['create-training'][trainingType]['btn-create'] }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    
    props: {
        trainingType: {
            type: String,
            default() {
                return 'training';
            }
        }
    },
    
    data() {
        let authUser = this.$store.authUser;
        let gameSelected = this.$store.gameSelected;
        
        let data = {};
        
        data.selectedRule = 'FRIENDLY';
        data.selectedGamemode = "";
        data.selectedManager = null;
        data.bet = null;
        
        data.modal = null;
        
        if (authUser && authUser.activeTeam) {
            data.playersList = authUser.activeTeam.members;
            data.managersList = authUser.activeTeam.members.filter((member) => member.role === 'MANAGER');
        }
        
        if (gameSelected) {
            data.gamemodesList = gameSelected.gamemodes;
            
            data.classicGamemodesSequenceIds = gameSelected.classic_modes_list;
            
            data.mapsList = gameSelected.maps;
            data.selectedMaps = new Array(parseInt(Object.keys(gameSelected.bo_list).slice(-1)[0])).fill(null);
            
            data.vsList = gameSelected.vs_list;
            data.selectedVS = Object.keys(gameSelected.vs_list).slice(-1)[0];
            
            data.boList = gameSelected.bo_list;
            data.selectedBO = Object.keys(gameSelected.bo_list).slice(-1)[0];
            
            data.selectedPlayers = new Array(parseInt(Object.keys(gameSelected.vs_list).slice(-1)[0])).fill(null);
        }
        
        return data;
    },
    
    beforeCreate() {
    
    },
    
    created() {
    
    },
    
    beforeUpdate() {
        this.selectedMaps.forEach((selectedMapID, index) => {
            if (selectedMapID) {
                if (!this.mapCompatibleWithGamemodeAt(selectedMapID, index)) {
                    Vue.set(this.selectedMaps, index, null);
                }
            }
        });
    },
    
    mounted() {
        if (this.trainingType === 'wager') {
            this.selectedRule = 'WAGER';
            this.selectedGamemode = "";
            this.bet = this.$store.availableBets[0];
        } else {
            this.selectedRule = 'FRIENDLY';
            this.bet = null;
        }
        
        this.modal = $('#create-' + this.trainingType + '-form-modal').first();
        
        var vm = this;
        this.modal.find('form').on('submit', function(e) {
            e.preventDefault();
            
            let $this = $(this);
            let form = $this[0];
            let $errorsZone = vm.modal.find('.modal-errors');
            let $button = $this.find('button[type="submit"]');
            
            $errorsZone.hide();
            $button.attr('disabled', 'disabled');
            addSpinnerTo($button);
            
            
            $.post(form.action, $this.serialize())
                .done(function(data, textStatus, jqXHR) {
                    vm.modal.modal('hide');
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 422 && jqXHR.responseJSON) {
                        let json = jqXHR.responseJSON;
                        let fieldsNames = Object.keys(json);
                        let html = '';
                        fieldsNames.forEach(function (key) {
                            if (typeof json[key] === 'string') {
                                html += json[key] + '<br>';
                            } else {
                                html += json[key][0] + '<br>';
                            }
                        });
                        $errorsZone.show().html(html);
                    } else {
                        $errorsZone.show().html(errorThrown);
                    }
                })
                .always(function () {
                    $button.attr('disabled', null);
                    removeSpinnerFrom($button);
                });
        });
        
        this.listen();
    },
    
    computed: {
        availablePlayers() {
            return this.playersList.filter((player) => {
                return this.selectedPlayers.indexOf(player.id) === -1;
            });
        }
    },
    
    methods: {
        listen() {
        
        },
        
        openModal() {
            if (!this.$store.authUser) {
                $("[data-remodal-id='login']").remodal().open();
            } else if (!this.$store.gameSelected) {
                $('#js-select-game-dropdown:not(.open) .dropdown-toggle').click();
            } else if (!this.$store.authUser.activeTeam) {
                errorModal(this.$trans['errors-modals']['no-active-team']['message']);
            } else if (this.$store.authUser.activeTeam.game.id != this.$store.gameSelected.id) {
                errorModal(this.$trans['errors-modals']['wrong-game-active-team']['message']);
            } else if (this.$store.authUser.hasMatch) {
                errorModal(this.$trans['errors-modals']['match-in-progress']['message']);
            } else {
                this.modal.modal('show');
            }
        },
        
        getPlayerAvatar(selectedPlayerID, index) {
            if (selectedPlayerID) {
                return this.playersList.find((player) => player.id === selectedPlayerID).avatar;
            }
            return '/img/' + this.trainingType + '-players-icons/' + (index % 6) + '.jpg';
        },
        
        getPlayerUsername(selectedPlayerID) {
            if (selectedPlayerID) {
                return this.playersList.find((player) => player.id === selectedPlayerID).username;
            }
            return '????';
        },
        
        getMapLogo(selectedMapID) {
            if (selectedMapID) {
                return this.mapsList.find((map) => map.id === selectedMapID).logo;
            }
            return '/img/map-undefined.jpg';
        },
        
        filteredMaps(index) {
            if (this.selectedGamemode !== "") {
                return this.mapsList.filter((map) => map.gamemodes.indexOf(this.selectedGamemode) > -1);
            }
            return this.mapsList.filter((map) => map.gamemodes.indexOf(this.classicGamemodesSequenceIds[index]) > -1);
        },
        
        mapCompatibleWithGamemodeAt(selectedMapID, index) {
            let map = this.mapsList.find((map) => map.id === selectedMapID);
            if (this.selectedGamemode !== "") {
                return map.gamemodes.indexOf(this.selectedGamemode) > -1;
            } else {
                return map.gamemodes.indexOf(this.classicGamemodesSequenceIds[index]) > -1;
            }
        }
    }
}
</script>
