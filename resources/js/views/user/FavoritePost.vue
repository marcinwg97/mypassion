<template>
    <user-layout>
        <div class="card-body table-responsive p-0">
            <table class="table w-full">
                <thead class="thead-light">
                    <tr>
                        <th class="text-left">Tytuł</th>
                        <th>Data dodania</th>
                        <th>Użytkownik</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="post in posts.data" :key="post.id">
                        <td>{{ post.title }}</td>
                        <td class="text-center">{{ post.date }}</td>
                        <td class="text-center">{{ post.user.email }}</td>
                        <td><form @submit.prevent="deletePost(post.id)" class="justify-center flex"><button type="submit" class="bg-red-500 hover:bg-red-600 px-2 py-1 rounded-full text-gray-100 w-full"><i class="far fa-trash-alt"></i> Usuń</button></form></td>
                    </tr>
                    <pagination :data="posts" @pagination-change-page="loadPosts"></pagination>
                </tbody>
            </table>
        </div>
    </user-layout>
</template>
<style scoped>

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
                axios.get('/api/user/post-favorite?page=' + page).then(res=>{
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
        },
        beforeRouteEnter (to, from, next) {
        if ( ! localStorage.getItem('jwt')) {
            return next('login')
        }
        next()
        },
    }
</script>
