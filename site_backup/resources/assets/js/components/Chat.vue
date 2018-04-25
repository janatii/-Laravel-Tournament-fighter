<!-- Chat.vue -->
<template>
    <div class="chatroom" :class="{'chatroom-closed': closed, 'chatroom-hidden': isChatHidden}">
        <div class="chatroom-title">
            Chat Training #{{ match_id }} {{ closed ? "(" + $trans['generic-texts']['closed'] + ")" : '' }}
            <i class="fa fa-fw fa-caret-down" v-if="!isChatHidden" @click="slideDownChat"></i>
            <i class="fa fa-fw fa-caret-up" v-if="isChatHidden" @click="slideUpChat"></i>
        </div>
        <div class="chatroom-content">
            <div class="messages-container" ref="messagesContainer" @scroll="onMessagesScroll">
                <div v-for="message in messages" class="message-container">
                    <div class="message-header user-infos" :class="{ 'squad1' : message.squad_id == squad1_id, 'squad2' : message.squad_id == squad2_id, 'staff' : message.is_staff == 1 }" v-if="message.user">
                        {{ message.user.username }}
                    </div>
                    <div class="message-header event-infos" v-if="!message.user && message.is_event == 1">
                        {{ message.is_event == 1 ? 'event' : message.is_event }}
                    </div>
                    <div class="message-content" v-html="message.message">
                    
                    </div>
                </div>
            </div>
            <div class="form-container" v-if="!closed">
                <form @submit.prevent="sendMessage">
                    <textarea v-model="messageToSend" name="message" rows="2" maxlength="255" placeholder="Message..." @keyup.enter="sendMessage"></textarea>
                    <button type="submit">
                        <i class="fa fa-fw fa-send-o"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import {errorModal} from "../lib";

export default {
    
    props: {
        reduced: {
            type: Boolean,
            default: false
        },
        closed: {
            type: Boolean
        },
        match_id: {
            type: Number
        },
        squad1_id: {
            type: Number
        },
        squad2_id: {
            type: Number
        }
    },
    
    data() {
        return {
            messages: [],
            messageToSend: '',
            userScrolled: false,
            isChatHidden: this.reduced
        };
    },
    
    updated() {
        if (!this.userScrolled) {
            this.textareaGoToBottom();
        }
    },
    
    mounted() {
        let vm = this;
        $.getJSON('/trainings/' + this.match_id + '/messages')
            .done(function(json) {
                vm.messages = json;
            })
            .fail(function(jqxhr, textStatus, error) {
                console.log(textStatus, error);
            });
        this.listen();
    },
    
    methods: {
        listen() {
            let vm = this;
            Echo.private('match.' + this.match_id)
                .listen('NewChatMessageEvent', function(e) {
                    vm.messages.push(e);
                });
        },
        
        sendMessage() {
            $.post('/trainings/' + this.match_id + '/send-message', { message: this.messageToSend })
                .done(function(json) {
                
                })
                .fail(function(jqxhr, textStatus, error) {
                    if (jqxhr.responseJSON && jqxhr.responseJSON.message) {
                        errorModal(jqxhr.responseJSON.message);
                    }
                });
            this.userScrolled = false;
            this.messageToSend = "";
        },
        
        textareaGoToBottom() {
            this.$refs.messagesContainer.scrollTop = this.$refs.messagesContainer.scrollHeight;
        },
        
        onMessagesScroll(e) {
            if (this.$refs.messagesContainer.scrollHeight == this.$refs.messagesContainer.scrollTop + this.$refs.messagesContainer.clientHeight) {
                this.userScrolled = false;
            } else {
                this.userScrolled = true;
            }
        },
        
        slideDownChat() {
            this.isChatHidden = true;
        },
        
        slideUpChat() {
            this.isChatHidden = false;
        }
    }
}
</script>


<style lang="scss">
    
    .chatroom {
        position: fixed;
        bottom: 0;
        right: 100px;
        width: 320px;
        height: 400px;
        
        background: #ffffff;
        border: 2px solid #17222e;
        z-index: 9999;
        
        .chatroom-title {
            background: #17222e;
            color: white;
            font-weight: bold;
            font-style: italic;
            font-size: 16px;
            padding: 3px;
            
            i {
                cursor: pointer;
            }
        }
        
        .chatroom-content {
            padding: 5px;
            
            .messages-container {
                height: 290px;
                overflow-x: hidden;
                overflow-y: scroll;
                
                .message-container {
                    margin: 5px 0 5px 0;
                    
                    .message-header {
                        padding: 3px;
                        border: 1px solid green;
                        color: white;
                        font-weight: bold;
                        background: #17222e;
                        text-align: center;
                        
                        &.squad1 {
                            text-align: left;
                            background: #266bb6;
                        }
                        
                        &.squad2 {
                            text-align: right;
                            background: #ce0000;
                        }
                    }
                    
                    .message-content {
                        margin-top: 2px;
                        padding: 3px;
                        border: 1px solid black;
                    }
                }
            }
            
            .form-container {
                padding-top: 5px;
                padding-bottom: 5px;
                
                form {
                    display: flex;
                    
                    textarea {
                        width: 100%;
                        resize: none;
                    }
                    
                    button {
                        margin-left: 3px;
                    }
                }
            }
        }
        
        &.chatroom-closed {
            .messages-container {
                height: 350px;
            }
        }
        
        &.chatroom-hidden {
            height: 30px;
        }
    }
    
</style>