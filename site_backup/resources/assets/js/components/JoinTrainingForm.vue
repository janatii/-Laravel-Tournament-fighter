<!-- JoinTrainingForm.vue -->
<template>
    <div>
        <div>
            <button :class="['btn', 'btn-default', 'btn-primary', 'button', trainingType]" @click="openModal()">{{ $trans['join-training']['open-buttons']['join'] }}</button>
        </div>
        
        <div v-if="$store.gameSelected && $store.authUser && $store.authUser.activeTeam" :id="'join-' + trainingType + '-form-modal'" :class="['modal', 'fade-scale', 'in', trainingType]" tabindex="-1" aria-labelledby="join-training-label" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form :action="$urls.joinTraining" method="post">
                        <input type="hidden" name="match" :value="matchId">
                        <input type="hidden" name="team" :value="$store.authUser.activeTeam.id">
                        
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            
                            <h4 class="modal-title" id="join-training-label">{{ $trans['join-training'][trainingType]['title'] }}</h4>
                            <h5 class="modal-subtitle">{{ $trans['generic-texts']['with-team'] }} {{ $store.authUser.activeTeam.name }}</h5>
                        </div>
                        
                        <div class="modal-body">
                            
                            <div class="form-group manager">
                                <label>{{ $trans['join-training'][trainingType]['manager'] }} : </label>
                                <div class="player-select" :style="{ backgroundImage: 'url(' + getPlayerAvatar(selectedManager, 0) + ')' }">
                                    <select v-model="selectedManager" name="manager">
                                        <option :value="null">{{ $trans['join-training'][trainingType]['manager'] }}</option>
                                        <option v-for="item in managersList" :value="item.id">{{ item.username }}</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group players">
                                <label>{{ $trans['join-training'][trainingType]['players'] }} : </label>
                                <div class="players-selection-container">
                                    <div class="player-select" v-for="(keyVS, indexVS) in matchVs" :style="{ backgroundImage: 'url(' + getPlayerAvatar(selectedPlayers[indexVS], indexVS + 1) + ')' }">
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
                            
                        </div>
                        <div class="modal-errors alert alert-danger"></div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">{{ $trans['join-training'][trainingType]['btn-join'] }}</button>
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
        },
        matchId: {
            type: Number,
            required: true
        },
        matchVs: {
            type: Number,
            required: true
        }
    },
    
    data() {
        let authUser = this.$store.authUser;
        
        let data = {};
        
        data.selectedManager = null;
        data.selectedPlayers = new Array(this.matchVs).fill(null);
        
        if (authUser && authUser.activeTeam) {
            data.playersList = authUser.activeTeam.members;
            data.managersList = authUser.activeTeam.members.filter((member) => member.role === 'MANAGER');
        }
        
        return data;
    },
    
    beforeCreate() {
    
    },
    
    created() {
    
    },
    
    beforeUpdate() {
    
    },
    
    mounted() {
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
                let $modal = $('#join-' + this.trainingType + '-form-modal');
                
                $modal.find('form').on('submit', function(e) {
                    e.preventDefault();
                    
                    let $this = $(this);
                    let form = $this[0];
                    let $errorsZone = $modal.find('.modal-errors');
                    let $button = $this.find('button[type="submit"]');
                    
                    $errorsZone.hide();
                    $button.attr('disabled', 'disabled');
                    addSpinnerTo($button);
                    
                    
                    $.post(form.action, $this.serialize())
                        .done(function(data, textStatus, jqXHR) {
                            $modal.modal('hide');
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
                
                $modal.modal('show');
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
        }
    }
}
</script>
