<template>

    <div class="container">
<div class="pb-2"><button class="btn btn-success"><router-link style="color: white !important;" :to="{ name: 'admin-users-create'}">Dodaj</router-link></button></div>
              <div class="card-body table-responsive p-0">
                <table class="table">
                  <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Nazwa</th>
                        <th>Email</th>
                        <th>Edytuj</th>
                        <th>Usuń</th>
                  </tr>
                  </thead>
                <tbody>
                  <tr v-for="user in users.data" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td><button class="btn btn-warning"><router-link style="color: white !important;" :to="{ name: 'admin-users-edit', params: { id: user.id }}">Edytuj</router-link></button></td>
                    <td><form @submit.prevent="deleteUser(user.id)"><button type="submit" class="btn btn-danger">Usuń</button></form></td>
                  </tr>
                  <pagination :data="users" @pagination-change-page="loadUsers"></pagination>
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
                users: {},
                name: '',
                email: '',
            }
        },
         mounted(){
            this.loadUsers();
        },
        methods:{
     loadUsers:function(page){
         if (typeof page === 'undefined') {
                    page = 1;
                }
  axios.get('/api/admin/users?page=' + page).then(res=>{
       if(res.status==200){
         this.users=res.data;
       }
     }).catch(err=>{
         console.log(err)
     });
     },

            deleteUser(id){

                axios.post('/api/admin/user/delete/' + id)
                .then((response)=>{

                $('#success').html(response.data.message)
                this.loadUsers();
                })
            },

  }



    }
    </script>
