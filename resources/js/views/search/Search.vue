<template>
    <main-layout>
        <div class="container">
            <div class="container foreground">
                <h1 class="lead">Wyszukiwana fraza: {{this.$route.params.search}}</h1>
                <div class="jumbotron" v-for="(post, index) in orderedPosts" :key="index">
                    <div class="row">
                        <div class="col-lg-2">
                            <h2 class="publish-day text-3xl">{{(post.date).substring(8,10)}}</h2>
                            <div class="publish-month">{{monthName((post.date).substring(5,7))}} {{(post.date).substring(0,4)}}</div>
                        </div>
                        <div class="col-lg-10">
                            <h2 class="post-title">
                                <router-link :to="{name: 'post-details', params: { id: post.id, title: post.title}}" class="post-title">{{ post.title }}</router-link>
                            </h2>
                            <div class="author mb-3">
                                <span>
                                    <i class="fas fa-pen-nib fa-lg"></i>
                                    <span class="author-name" v-if="post.name">{{ post.name }}</span>
                                    <span class="author-name" v-else>{{ post.user.name }}</span>
                                </span>
                            </div>
                            <div class="post-description">
                                <p v-html="$options.filters.addSource(post.description)" class="card-text"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <pagination :align="'center'" :limit="1" :data="posts" @pagination-change-page="loadPosts"></pagination>
            </div>
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
                posts: {},
            }
        },
        mounted(){
            this.loadPosts();
        },
        components: {
            MainLayout,
        },
        filters: {
            addSource(value) {
                value = value.toString();
                return value.replaceAll('src="/images/posts','src="https://www.erpit.pl/public/images/posts');
            }
        },
        computed: {
            orderedPosts: function () {
                return _.orderBy(this.posts.data, 'date', 'desc')
            }
        },
        methods: {
            loadPosts:function(page){
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios.get('/api/search?search=' + this.$route.params.search).then(res=>{
                    if(res.status==200){
                        this.posts=res.data;
                    }
                }).catch(err=>{
                    console.log(err)
                });
            },
            monthName:function(mon) {
                return ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'][mon - 1];
            },
        },
        watch: {
            $route(to, from) { // react to route changes...
                if(to !== from){ location.reload(); }
            }
        }
    }
</script>
