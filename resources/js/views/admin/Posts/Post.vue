<template>
    <admin-layout>
        <div class="pb-2">
            <button class="btn btn-success"><router-link style="color: white !important;" :to="{ name: 'admin-posts-create'}">Dodaj</router-link></button>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Tytuł</th>
                        <th>Data</th>
                        <th>Użytkownik</th>
                        <th>Aktywny</th>
                        <th>Opis</th>
                        <th>Edytuj</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="post in posts.data" :key="post.id">
                        <td>{{ post.id }}</td>
                        <td>{{ post.title }}</td>
                        <td>{{ post.date }}</td>
                        <td>{{ post.user.email }}</td>
                        <td>{{ post.is_active == 1 ? 'TAK' : 'NIE'}}</td>
                        <td>{{ post.description }}</td>
                        <td><button class="btn btn-warning"><router-link style="color: white !important;" :to="{ name: 'admin-posts-edit', params: { id: post.id }}">Edytuj</router-link></button></td>
                        <td><form @submit.prevent="deletePost(post.id)"><button type="submit" class="btn btn-danger">Usuń</button></form></td>
                    </tr>
                    <pagination :data="posts" @pagination-change-page="loadPosts"></pagination>
                </tbody>
            </table>
        </div>
    </admin-layout>
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
    import AdminLayout from '@views/layout/Admin'

    export default {
        data() {
            return {
                posts: {},
                title: '',
                description: '',
            }
        },
        mounted(){
            this.loadPosts();
        },
        components: {
            AdminLayout,
        },
        methods:{
            loadPosts:function(page){
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios.get('/api/admin/posts?page=' + page).then(res=>{
                    if(res.status==200){
                        this.posts=res.data;
                    }
                }).catch(err=>{
                    console.log(err)
                });
            },
            deletePost(id){
                axios.post('/api/admin/post/delete/' + id).then((response)=>{
                    $('#success').html(response.data.message)
                    this.loadPosts();
                })
            },
        }
    }
</script>
