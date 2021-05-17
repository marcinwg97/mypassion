<template>
  <main-layout>
    
    <div class="container">
        <div class="row bg-white">
            <div class="col-4">
                <div class="p-2">
                    <!-- <a href="">{{user.name}}</a> -->
                   
                    <ul class="list-group">
                           <li class="list-group-item"
                           @click.prevent="openChat(user), getMessages(user)"
                           :key=user.id
                           v-for="user in users">
                            <a href="">{{user.name}}</a>
                            
                            
                           </li>
                        </ul>
                </div>
            </div>
            <div class="">
                 <div v-for="message_from in messages" :key="message_from">
                    {{message_from.message}} ({{message_from.created_at}})
                 </div>

                 <div v-for="sent_message in sent_messages" :key="sent_message">
                    {{sent_message.message}} ({{sent_message.created_at}})
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
  </main-layout>
</template>
<script>
import MainLayout from "@views/layout/Main";



export default {
    data() {
        return {
            users: [],
           message: null,
            toUser:null,
            messages:[],
            sent_messages:[],
           
        };
    },
    mounted() {
        this.loadUsers();
        this.getMessages();
        this.getMessagesSent();

    },

    components: {
        MainLayout,
       
    },
    filters: {
    },
    methods: {

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
        } 

        
        
        
    }
};
</script>
