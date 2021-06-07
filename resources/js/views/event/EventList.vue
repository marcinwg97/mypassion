<template>
    <main-layout :title="'Wydarzenia | MyPassion'" :seo_description="'Wydarzenia w najbliższym czasie MyPassion'" :seo_keywords="'wydarzenia, hobby, MyPassion'">
        <div class="container mx-auto">
            <!-- <div class="row">
                <div v-for="category in categories" :key="category.id" class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                    <div class="card dropdown">
                        <div class="card-body" :id="'menu' + category.id" data-toggle="dropdown">
                            <div class="text-center">
                                <i :class="`fas ${category.icon}  fa-5x`" style="color: #5D6D7E;"></i>
                            </div>
                            <h5 class="card-title text-center">{{category.name}}</h5>
                        </div>

                        <ul class="dropdown-menu" role="menu" :aria-labelledby="'menu' + category.id" style="width: 100%; text-align: center;">
                            <li v-for="children in category.children" :key="children.id">
                                <router-link :to="{ name: 'category-details', params: { id: children.id, name: children.name }}" style="color: black !important">{{children.name}}</router-link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> -->
            <div class="row mx-0">
                <h1 class="text-center">Najnowsze wydarzenia</h1>
                <div class="post-detail col-12 py-4 my-4 glassy gls-rnd-3" v-for="event in events.data" :key="event.id">
                    <div class="row">
                        <div class="col-lg-2">
                            <h2 class="publish-day text-3xl">{{(event.date).substring(8,10)}}</h2>
                            <div class="publish-month">{{monthName((event.date).substring(5,7))}} {{(event.date).substring(0,4)}}</div>
                        </div>
                        <div class="col-lg-10">
                            <h2 class="post-title">
                                <router-link :to="{name: 'event-details', params: { id: event.id, title:  event.title}}" class="post-title">{{ event.title }}</router-link>
                            </h2>
                            <div class="author mb-3">
                                <span>
                                    <i class="fas fa-pen-nib fa-lg"></i>
                                    <span class="author-name">
                                        <router-link :to="{name: 'user-profile', params: { id: event.user.id}}">{{ event.user.name }}</router-link>
                                    </span>
                                </span>
                            </div>
                            <div class="post-description">
                                <p v-html="event.description_short" class="card-text"></p>
                            </div>
                        </div>
                        <div class="col-lg-12 p-2 text-right">
                            <router-link :to="{name: 'event-details', params: { id: event.id, title: event.title}}" class="read-more gls-btn-black">Więcej informacji</router-link>
                        </div>
                    </div>
                </div>
            </div>
            <pagination :data="events" @pagination-change-page="loadEvents"></pagination>
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
                events: {},
            }
        },
        mounted(){
            this.loadEvents();
        },
        components: {
            MainLayout,
        },
        computed: {

        },
        methods:{

        loadEvents: function(page) {
            if (typeof page === 'undefined') {
                    page = 1;
            }
            axios.get('/api/events' + '?page=' + page).then(res=>{
                if(res.status==200){
                    this.events=res.data;
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
