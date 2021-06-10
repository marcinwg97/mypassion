<template>
    <user-layout>
        <div class="card-body table-responsive p-0">
            <table class="table w-full">
                <thead class="thead-light">
                    <tr>
                        <th class="text-left">Tytuł</th>
                        <th>Data</th>
                        <th>Kategoria</th>
                        <th>Edytuj</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="post in posts.data" :key="post.id">
                        <td>{{ post.title }}</td>
                        <td class="text-center">{{ post.date }}</td>
                        <td class="text-center">{{ post.category.name }}</td>
                        <td class="justify-center flex">
                            <button class="bg-blue-500 hover:bg-blue-600 px-2 py-1 rounded-full text-gray-100">
                                <router-link :to="{ name: 'user-posts-edit', params: { id: post.id }}">Edytuj</router-link>
                            </button>
                        </td>
                        <td>
                            <form @submit.prevent="deletePost(post.id)" class="justify-center flex">
                                <button type="submit" class="bg-red-500 hover:bg-red-600 px-2 py-1 rounded-full text-gray-100 w-full">
                                    <i class="far fa-trash-alt"></i> Usuń
                                </button>
                            </form>
                        </td>
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
        },
        beforeRouteEnter (to, from, next) {
        if ( ! localStorage.getItem('jwt')) {
            return next('login')
        }
        next()
        },
    }
</script>
