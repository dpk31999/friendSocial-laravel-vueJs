<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 bg-white">
                <div class="user-wrapper">
                    <!-- <h4 style="position: absolute;top: 20%;left:10%;">You don't have reccent message!</h4> -->
                    <div v-if="isLoading" class="loader">
                        <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <ul class="users">
                        <router-link v-for="friend in friends" :key="friend.id" :to="{ name: 'message.user' , params : {username : friend.username} }" class="btn user-specific text-decoration-none text-dark" active-class="active-user">
                            <div class="user">
                                <!-- will show unread count notification -->
                                <!-- <span class="pending" v-if="friend.unread">{{ friend.unread }}</span> -->
                                <div class="media d-flex align-items-center">
                                    <div class="media-left">
                                        <img :src="friend.url_avatar" alt="" class="media-object">
                                    </div> 
                                    <div>
                                        <div class="text-username">{{ friend.username }}</div>
                                        <div class="text-name">{{ friend.name }}</div>
                                    </div>
                                    <span class="ml-3" v-if="friend.unread > 0">(<span ref="countUnread">{{friend.unread}}</span>)</span>
                                </div>
                            </div>
                        </router-link>
                    </ul>
                </div>
            </div>
            <div class="col-md-7 bg-white">
                <router-view :key="$route.fullPath" />
            </div>
        </div>
    </div>
</template>
<script>
import {mapGetters} from 'vuex'
export default {
    middleware: 'auth',
    metaInfo() {
        return { title: "Message" };
    },

    data: () => ({
        friends : [],
        isLoading : false
    }),

    computed: mapGetters({
        user: "auth/user",
    }),

    methods : {
        getFriend(){
            this.isLoading = true;
            axios.get('/api/friends/' + this.user.id)
            .then((response) => {
                this.friends = response.data;
                this.isLoading = false;
            })
            .catch((error) => {
                console.log(error)
            })
        }
    },

    created() {
        this.getFriend();
    },

    mounted(){
        let pusher = new Pusher('2a039f54d3cd24112198', {
            cluster: 'ap1'
        });

        let channel = pusher.subscribe('channel-chat');
        channel.bind('event-chat', (data) => {
            this.friends.map((friend) => {
                if(friend.id === data.user_from.id)
                {
                    friend.unread++;
                }
            })
        });

    },
    
    updated() {
        this.friends.map((friend) => {
            if(friend.username === this.$route.params.username)
            {
                friend.unread = 0
            }
        })
    }

}
</script>
<style scoped>
.text-username {
  font-weight: 600;
  text-decoration: none;
}
.text-name {
  color: #8e8e8e;
  font-size: 12px;
  line-height: 14px;
}
ul {
    margin: 0;
    padding: 0;
}
.user-specific{
    width: 100%;
}
li {
    list-style: none;
}

.user-wrapper, .message-wrapper {
    border: 1px solid #dddddd;
    overflow-y: auto;
}

.user-wrapper {
    height: 515px;
    overflow-y: auto;
    position: relative;
}

.user {
    cursor: pointer;
    padding: 5px 0;
    position: relative;
}

.user:hover {
    background: #eeeeee;
}

.user:last-child {
    margin-bottom: 0;
}

.pending {
    position: absolute;
    left: 13px;
    top: 9px;
    background: #b600ff;
    margin: 0;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    line-height: 18px;
    padding-left: 5px;
    color: #ffffff;
    font-size: 12px;
}

.media-left {
    margin: 0 10px;
}

.media-left img {
    width: 64px;
    height: 64px;
    border-radius: 64px;
    border: 0.5px solid blueviolet;
}

.loader {
    position: absolute;
    left: 50%;
    top: 50%;
}

.active-user{
    background: #eeeeee;
}
</style>