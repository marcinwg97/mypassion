<template>
    <user-layout>
        <div class="card-body table-responsive p-0">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>Tytuł</th>
                        <th>Data</th>
                        <th>Kategoria</th>
                        <th>Edytuj</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="post in posts.data" :key="post.id">
                        <td>{{ post.title }}</td>
                        <td>{{ post.date }}</td>
                        <td>{{ post.category.name }}</td>
                        <td><button class="btn btn-warning"><router-link style="color: white !important;" :to="{ name: 'user-posts-edit', params: { id: post.id }}">Edytuj</router-link></button></td>
                        <td><form @submit.prevent="deletePost(post.id)"><button type="submit" class="btn btn-danger">Usuń</button></form></td>
                    </tr>
                    <pagination :data="posts" @pagination-change-page="loadPosts"></pagination>
                </tbody>
            </table>
        </div>
    </user-layout>
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
     import UserLayout from '@views/layout/User'

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
            UserLayout,
        },
        methods:{
            loadPosts:function(page){
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios.get('/api/user/posts?page=' + page).then(res=>{
                    if(res.status==200){
                        this.posts=res.data;
                    }
                }).catch(err=>{
                    console.log(err)
                });
            },
            deletePost(id){
                axios.post('/api/user/post/delete/' + id).then((response)=>{
                    $('#success').html(response.data.message)
                    this.loadPosts();
                })
            },
        }
    }
</script>
