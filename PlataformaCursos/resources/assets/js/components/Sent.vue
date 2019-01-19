<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-footer">
                        <br>
                        <form @submit.prevent.keyup="sent(conversation_id)">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" v-model="message.message">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn" style="background-color: #70299b; color: white;"><i class="fa fa-send"></i> Enviar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props:['user', 'conversation_id'],
        data() {
            return {
                message: {
                    message: '',
                    user: this.user,
                    conversation_id: this.conversation_id
                }
            }
        },
        methods: {
            sent () {
                console.log(this.message.conversation_id)
                this.$emit('messagesent', this.message)
                this.message = {}
                this.message.conversation_id = this.conversation_id
                this.message.user = this.user
            }
        }
    }
</script>