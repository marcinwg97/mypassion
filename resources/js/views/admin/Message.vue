<template>

    <div class="container">
              <div class="card-body table-responsive p-0">
                <table class="table">
                  <thead class="thead-light">
                    <tr>
                        <th>Email</th>
                        <th>Tytuł</th>
                        <th>Treść</th>
                        <th>Usuń</th>
                  </tr>
                  </thead>
<tbody>
                  <tr v-for="message in messages.data" :key="message.id">
                    <td>{{ message.email }}</td>
                    <td>{{ message.title }}</td>
                    <td>{{ message.contents }}</td>
                    <td><form @submit.prevent="deleteMessage(message.id)"><button type="submit" class="btn btn-danger">Usuń</button></form></td>
                  </tr>
                  <pagination :data="messages" @pagination-change-page="loadMessages"></pagination>
                </tbody></table>
              </div>


            </div>

</template>

    <style scoped>
    .full-height {
        height: 100vh;
    }
    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }
    .position-ref {
        position: relative;
    }
    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }
    .content {
        text-align: center;
    }
    .title {
        font-size: 60px;
    }
    .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }
    .m-b-md {
        margin-bottom: 30px;
        color: #000000;
    }
    </style>

    <script>
    export default {
        data() {
            return {
                messages: {},
                email: '',
                title: '',
                contents: '',
            }
        },
         mounted(){
            this.loadMessages();
        },
        methods:{
     loadMessages:function(page){
         if (typeof page === 'undefined') {
                    page = 1;
                }
  axios.get('api/admin/messages?page=' + page).then(res=>{
       if(res.status==200){
         this.messages=res.data;
       }
     }).catch(err=>{
         console.log(err)
     });
     },

            deleteMessage(id){

                axios.post('/api/admin/message/delete/' + id)
                .then((response)=>{

                $('#success').html(response.data.message)
                this.loadMessages();
                })
            },

  }
    }
    </script>
