<template>
  <user-layout>
    <div class="container">
        <div class="row bg-purple-200" style="padding-bottom: 20px;padding-top:20px;margin-left:0px;margin-right:0px">
            <div class="col-4">
                <div class="p-2">
                    <!-- <a href="">{{user.name}}</a> -->
                    <ul class="list-group">
                        <li class="list-group-item" @click.prevent="openChat(user), getMessages(user), getMessagesSent(user), unreadMessages(user)" :key=user.id v-for="user in users">
                            <a href="">{{user.name}}</a>
                            <span v-for="count_message in count_messages" :key="count_message" v-if="user.id===count_message.from_user && count_message.status==1">
                               <img src="https://pics.freeicons.io/uploads/icons/png/15378291991558965373-512.png" alt="message icon" style="width:30px; display:inline">
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            <div>
                <div class="row">
                    <div>
                        <div v-for="message_from in messages" :key="message_from">
                            {{message_from.message}}
                        </div>
                    </div>
                    <div v-for="sent_message in sent_messages" :key="sent_message">
                        {{sent_message.message}}
                    </div>
                </div>
                <div>
                    Wyślij wiadomość do: <b class="user_name"></b>
                    <form @submit.prevent="send">
                        <p class="to_user" style="display:none"></p>
                        <input type="text" class="form-control write-message" placeholder="Wpisz wiadomość" v-model="message">
                    </form>
                </div>
            </div>
        </div>
    </div>
  </user-layout>
</template>
<script>
import UserLayout from "@views/layout/User";

export default {
    data() {
        return {
            users: [],
            message: null,
            toUser:null,
            messages:[],
            sent_messages:[],
            count_messages:[],

        };
    },
    mounted() {
        this.loadUsers();
        this.getMessages();
        this.getMessagesSent();
        this.countMessages();
        this.unreadMessages();
    },
    components: {
        UserLayout,
    },
    filters: {
    },
    methods: {
        lol: function(a)
        {
            let b = parseInt(a);
            return b;
        },
        loadUsers: function() {
        axios
            .post("/api/chat-one-to-one/")
            .then(res => {
                if (res.status == 200) {
                   this.users = res.data;
                }
            })
            .catch(err => {
                console.log(err);
            });
        },
        openChat(user)
        {
            let user_id = document.querySelector('.to_user');
            user_id.textContent = user.id;

            let user_name = document.querySelector('.user_name');
            user_name.textContent = user.name;
        },

        send: function()
        {
            let to_user = document.querySelector('.to_user').textContent;
            axios.post('/api/chat-one-to-one-send', {
                    to_user: to_user,
                    message: this.message,
                });
            this.message = null;
            window.location.reload();
        },
        getMessages: function()
        {
            let from_user = document.querySelector('.to_user').textContent;

            axios
            .post("/api/chat-one-to-one-messages/"+from_user)
            .then(res => {
                if (res.status == 200) {
                    this.messages=res.data;
                }
            })
            .catch(err => {
                console.log(err);
            });
        },
        getMessagesSent: function()
        {
            let to_user = document.querySelector('.to_user').textContent;

            axios
            .post("/api/chat-one-to-one-messages-sent/"+to_user)
            .then(res => {
                if (res.status == 200) {
                    this.sent_messages=res.data;
                }
            })
            .catch(err => {
                console.log(err);
            });
        },
        countMessages: function()
        {
            axios
            .post("/api/chat-one-to-one-count-messages")
            .then(res => {
                if (res.status == 200) {
                    this.count_messages=res.data;
                }
            })
            .catch(err => {
                console.log(err);
            });
        },
        unreadMessages: function()
        {
            let to_user = document.querySelector('.to_user').textContent;

            axios.post('/api/chat-one-to-one-unread-messages/'+to_user, {
                to_user: to_user,
            });
        },
    }
};
</script>
