<template>
    <div>
        <div class="message-wrapper">
            <ul class="messages">
                <li v-for="message in messages" :key="message.id" class="message clearfix">
                    <div :class="getClass(message.from)">
                        <p>{{message.message}}</p>
                    </div>
                </li>
            </ul>
        </div>

        <div class="input-text">
            <input @input="sendNotification" v-model="form.message" type="text" v-on:keyup.enter="postMessage" name="message" class="submit">
        </div>
    </div>
</template>
<script>
import {mapGetters} from 'vuex'
import Form from "vform";
export default {
    metaInfo() {
        return { title: this.$route.params.username };
    },

    data: () => ({
        messages : [],
        form: new Form({
            message: "",
            username_received: ''
        }),
    }),

    computed: mapGetters({
        user: "auth/user",
    }),

    methods : {
        getMessages(){
            axios.get('/api/messages/from/' + this.$route.params.username)
            .then((response) => {
                this.messages = response.data
            })
            .catch((error) => {
                console.log(error)
            })
        },
        getClass(id){
            return this.user.id == id ? 'sent' : 'received'
        },
        postMessage(){
            axios.post("/api/messages", this.form)
            .then((response) => {
                this.form.message = "";
            })
            .catch((error) => {
                console.log(error);
            });
        },
        sendNotification(){
            console.log('haha');
        }
    },

    created(){
        this.form.username_received = this.$route.params.username
        this.getMessages()
    },

    mounted(){
        let pusher = new Pusher('2a039f54d3cd24112198', {
            cluster: 'ap1'
        });

        let channel = pusher.subscribe('channel-chat');
        channel.bind('event-chat', (data) => {
            if(this.$route.params.username == data.user_to.username || this.$route.params.username == data.user_from.username)
            {
                this.messages.push(data.message)
            }
        });

    },
}
</script>
<style scoped>
.message-wrapper {
    padding: 10px;
    height: 450px;
    background: #eeeeee;
    overflow-y: auto;
}

.messages .message {
    margin-bottom: 15px;
}

.messages .message:last-child {
    margin-bottom: 0;
}

ul{ 
  list-style-type: none;
}

.received, .sent {
    width: 45%;
    padding: 3px 10px;
    border-radius: 10px;
}

.received {
    background: #ffffff;
}

.sent {
    background: #3bebff;
    float: right;
    text-align: right;
}

.message p {
    margin: 5px 0;
}

.active {
    background: #eeeeee;
}

input[type=text] {
    width: 100%;
    padding: 12px 20px;
    margin: 15px 0 0 0;
    display: inline-block;
    border-radius: 4px;
    box-sizing: border-box;
    outline: none;
    border: 1px solid #cccccc;
}

input[type=text]:focus {
    border: 1px solid #aaaaaa;
}
</style>