<template>
    <main-layout :title="'Strona główna | MyPassion'" :seo_description="'Strona główna MyPassion'" :seo_keywords="'strona główna, MyPassion'">
        <div class="container mx-auto">
            <div class="grid grid-cols-2 lg:grid-cols-4 lg:gap-4 mb-5">
                <div v-for="category in categories" :key="category.id">
                    <div class="category-box glassy gls-rnd-3 gls-invert gls-hov rounded-lg bg-gradient-to-b from-yellow-300 to-yellow-400">
                        <div class="p-4" :id="'menu' + category.id">
                            <div class="text-center">
                                <i :class="`fas ${category.icon} fa-5x category-icon text-red-400`"></i>
                            </div>
                            <div class="text-center mt-4">
                                <router-link :to="{ name: 'category-details', params: { id: category.id, name: category.name }}" class="text-lg text-gray-800">{{category.name}}</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mx-0">
                <div class="col-12 justify-content-center">
                    <h1 class="text-center mb-0 py-1 text-2xl">Najnowsze posty obserwowanych</h1>
                </div>
                <div class="post-detail rounded-md p-4 my-3 lg:col-span-3" v-for="post in posts.data" :key="post.id">
                    <div class="grid lg:grid-cols-4">
                        <div>
                            <h2 class="publish-day">{{(post.date).substring(8,10)}}</h2>
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
            <pagination :data="posts" @pagination-change-page="loadPosts"></pagination>
        </div>
    </main-layout>
</template>
<style scoped>

</style>
<script>
    import MainLayout from '@views/layout/Main'

    export default {
        data() {
            return {
                categories: [],
                posts: {},
            }
        },
        mounted(){
            this.loadCategories();
            this.loadPosts();
        },
        components: {
            MainLayout,
        },
        computed: {

        },
        methods:{

        loadCategories:function(){
            axios.
            get('/api/categories').then(res=>{
            if(res.status==200){
                this.categories=res.data;
            }
            }).catch(err=>{
                console.log(err)
            });
        },
        loadPosts: function(page) {
            if (typeof page === 'undefined') {
                    page = 1;
            }
            axios.get('/api/posts' + '?page=' + page).then(res=>{
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
        },
        beforeRouteEnter (to, from, next) {
        if ( ! localStorage.getItem('jwt')) {
            return next('login')
        }
        next()
        }
    }
</script>
