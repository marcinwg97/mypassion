<template>
    <main-layout>
        <div class="container mx-auto">
            <div class="grid grid-cols-4">
                <div class="lg:col-span-3">
                    <h1 class="text-2xl">Posty</h1>
                    <div class="post-detail rounded-md p-3 my-4" v-for="post in posts" :key="post.id">
                        <div class="grid lg:grid-cols-4">
                            <div>
                                <h2 class="publish-day text-3xl">{{(post.date).substring(8,10)}}</h2>
                                <div class="publish-month">
                                    <p>{{monthName((post.date).substring(5,7))}} {{(post.date).substring(0,4)}}</p>
                                </div>
                                <div class="author mb-3">
                                    <span>
                                        <i class="fas fa-pen-nib fa-lg"></i>
                                        <span class="author-name" v-if="post.name">{{ post.name }}</span>
                                        <span class="author-name" v-else><router-link :to="{name: 'user-profile', params: { id: post.user.id}}">{{ post.user.name }}</router-link></span>
                                    </span>
                                </div>
                            </div>
                            <div class="lg:col-span-3">
                                <h2 class="post-title">
                                    <router-link :to="{name: 'post-details', params: { id: post.id, title:  post.title}}" class="post-title text-2xl text-gray-800">{{ post.title }}</router-link>
                                </h2>
                                <div class="post-description">
                                    <p v-html="post.description_short" class="card-text"></p>
                                </div>
                            </div>
                            <div class="col-span-4 text-right">
                                <router-link :to="{name: 'post-details', params: { id: post.id, title: post.title}}" class="read-more">Czytaj więcej</router-link>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pl-3">
                    <h1 class="text-center text-2xl">{{ user.name }}</h1>
                    <div class="col-12" v-if="isAddToFavorite == false">
                        <form class="col-12 col-lg-12" @submit.prevent="addUserToFavorite"><button type="submit" class="bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-1 px-2 rounded-full">Dodaj do ulubionych</button></form>
                    </div>
                    <div class="col-12" v-else>
                        <form class="col-12 col-lg-12" @submit.prevent="removeUserFromFavorite"><button type="submit" class="bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-1 px-2 rounded-full">Usuń z ulubionych</button></form>
                    </div>
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
                isAddToFavorite: false,
            }
        },
         mounted(){
            this.loadUser();
            this.loadPosts();
            this.CheckIfUserIsAddToFavorite();
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
            addUserToFavorite(){
                axios.post('/api/favorite-add-user',{favorite_user_id: this.$route.params.id, user_id: this.user_id})
                .then((response)=>{
                    $('#success').css("display", "block");
                    $('#success').html(response.data.message);
                    window.location.reload();
                })
            },
            CheckIfUserIsAddToFavorite() {
                axios.get('/api/favorite/user/' + this.$route.params.id).then(res=>{
                if(res.status==200){
                    if(res.data == 1) {
                        this.isAddToFavorite = true;
                    }
                }
                }).catch(err=>{
                    console.log(err)
                });
            },
            removeUserFromFavorite() {
                axios.post('/api/favorite-remove-user',{favorite_user_id: this.$route.params.id, user_id: this.user_id})
                .then((response)=>{
                    $('#success').css("display", "block");
                    $('#success').html(response.data.message);
                    window.location.reload();
                })
            },
            monthName:function(mon) {
                return ['stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia'][mon - 1];
            },
        }
    }
</script>
