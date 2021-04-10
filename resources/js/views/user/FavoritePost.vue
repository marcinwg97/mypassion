<template>
    <user-layout>
        <div class="card-body table-responsive p-0">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>Tytuł</th>
                        <th>Data dodania</th>
                        <th>Użytkownik</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="post in posts.data" :key="post.id">
                        <td>{{ post.title }}</td>
                        <td>{{ post.date }}</td>
                        <td>{{ post.user.email }}</td>
                        <td><form @submit.prevent="deletePost(post.id)"><button type="submit" class="btn btn-danger">Usuń</button></form></td>
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
        }
    }
</script>
