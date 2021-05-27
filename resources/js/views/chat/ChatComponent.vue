<template>
  <main-layout>
    
    <div class="container">
        <div class="bg-white p-3">
            <div v-for="message in messages" :key="message.id">
                <label>{{message.title}}</label>
                <b>{{message.email}}</b> <br />
                {{message.contents}}
               <hr style="border-top: 1px solid green">
            </div>

            <br />
            <div>
                <form @submit.prevent="send">
                    <input type="text" class="form-control write-message" placeholder="Wpisz wiadomość" v-model="message">
                </form>
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
            messages: [],
            message: null,
           
        };
    },
    mounted() {
        this.loadMessages();

    },

    components: {
        MainLayout,
       
    },
    filters: {
    },
    methods: {

         loadMessages: function() {
             let token = localStorage.getItem('jwt');
        axios.post("/api/messages/")
            .then(res => {
                
                
            if (res.status == 200) {
                
               this.messages = res.data;
            }
            })
            .catch(err => {
            console.log(err);
            });
            
        },

        send: function()
        {let token = localStorage.getItem('jwt');
            axios.post('/api/send-message', {
              
                    contents: this.message,
                    
                });
            this.message = null;
            window.location.reload();
        }
        
        
    }
};
</script>
