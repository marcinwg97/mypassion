<template>
    <main-layout>
    <div class="container">
        <h1 class="text-center">{{ user.name }}</h1>
        <h1 class="lead">Posty:</h1>
        <div class="post-detail col-12 py-4 my-4" v-for="post in posts" :key="post.id">
            <div class="col-lg-2">
                <h2 class="publish-day">{{(post.date).substring(8,10)}}</h2>
                <div class="publish-month">{{monthName((post.date).substring(5,7))}} {{(post.date).substring(0,4)}}</div>
            </div>
            <div class="col-lg-10">
                <h2 class="post-title">
                    <router-link :to="{name: 'post-details', params: { id: post.id, title:  post.title}}" class="post-title">{{ post.title }}</router-link>
                </h2>
                <div class="author mb-3">
                    <span>
                        <i class="fas fa-pen-nib fa-lg"></i>
                        <span class="author-name" v-if="post.name">{{ post.name }}</span>
                        <span class="author-name" v-else><router-link :to="{name: 'user-profile', params: { id: post.user.id}}">{{ post.user.name }}</router-link></span>
                    </span>
                </div>
                <div class="post-description">
                    <p v-html="post.description_short" class="card-text"></p>
                </div>
            </div>
            <div class="col-lg-12 p-2 text-right">
                <router-link :to="{name: 'post-details', params: { id: post.id, title: post.title}}" class="read-more">Czytaj więcej</router-link>
            </div>
        </div> 
    </div>
    </main-layout>
</template>




<script>
import MainLayout from "@views/layout/Main";
import PageLoader from "@components/PageLoader";
    export default {
        data() {
            return {
                user: {},
                posts: [],
            }
        },
         mounted(){
            this.loadUser();
            this.loadPosts();
        },
        components: {
            MainLayout,
            PageLoader
        },
        methods:{
        loadUser:function(){
            axios.get('/api/user/' + this.$route.params.id).then(res=>{
                if(res.status==200){
                    this.user=res.data;
                }
            }).catch(err=>{
                console.log(err)
            });
            
        },
        loadPosts:function(){
            axios.get('/api/user/posts/' + this.$route.params.id).then(res=>{
                if(res.status==200){
                    this.posts=res.data;
                }
            }).catch(err=>{
                console.log(err)
            });
            
        },
        monthName:function(mon) {
            return ['stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia'][mon - 1];
        },
    }
}
</script>
