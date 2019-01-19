<template>
    <div class="card">
        <div class="card-body" style="overflow: auto; height: 300px;">
            <div class="panel panel-default" v-for="message in messages">
                <div v-if="message.conversation_id == conversation_id">
                    <div v-if="message.user.role_id == 1">
                        <div class="card mb-3 text-right" style="background: rgba(43, 100, 181, 0.2);">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <b>{{ message.user.name }}</b>
                                </h6>
                                <p class="card-text">{{ message.message }}</p>
                                <span class="text-diff pull-right"><em>{{ message.created_at | timeago }}</em></span>
                            </div>
                        </div>
                    </div>
                    <div v-if="message.user.role_id == 2">
                        <div class="card mb-3 text-right" style="background: rgba(112, 41, 155, 0.2);">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <b>{{ message.user.name }}</b>
                                </h6>
                                <p class="card-text">{{ message.message }}</p>
                                <span class="text-diff pull-right"><em>{{ message.created_at | timeago }}</em></span>
                            </div>
                        </div>
                    </div>
                    <div v-if="message.user.role_id == 3">
                        <div class="card bg-light mb-3 text-left">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <b>{{ message.user.name }}</b>
                                </h6>
                                <p class="card-text">{{ message.message }}</p>
                                <span class="text-diff pull-right"><em>{{ message.created_at | timeago }}</em></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    moment.locale('es');
    export default {
        props: ['messages', 'conversation_id'],
        mounted() {
            console.log(this.messages)
        },
        filters: {
            timeago(value) {
                return moment.utc(value).local().fromNow()
            }
        }
    }
</script>
<style scoped>
    .panel{
        margin-bottom: 0;
    }
    .text-diff {
        font-size: 0.8em;
        color: #383535;
    }
</style>