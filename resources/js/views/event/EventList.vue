<template>
    <main-layout :title="'Wydarzenia | MyPassion'" :seo_description="'Wydarzenia w najbliższym czasie MyPassion'" :seo_keywords="'wydarzenia, hobby, MyPassion'">
        <div class="container mx-auto">
            <div class="row mx-0">
                <h1 class="text-center text-3xl">Najnowsze wydarzenia</h1>
                <div class="post-detail p-4 my-3" v-for="event in events.data" :key="event.id">
                    <div class="grid lg:grid-cols-4">
                        <div>
                            <h2 class="publish-day text-3xl">{{(event.date).substring(8,10)}}</h2>
                            <div class="publish-month">
                                {{monthName((event.date).substring(5,7))}} {{(event.date).substring(0,4)}}
                            </div>
                            <div class="author mb-3">
                                <span>
                                    <i class="fas fa-pen-nib fa-lg"></i>
                                    <span class="author-name">
                                        <router-link :to="{name: 'user-profile', params: { id: event.user.id}}">{{ event.user.name }}</router-link>
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="lg:col-span-3">
                            <h2 class="post-title">
                                <router-link :to="{name: 'event-details', params: { id: event.id, title:  event.title}}" class="post-title text-2xl text-gray-800">{{ event.title }}</router-link>
                            </h2>
                            <div class="post-description">
                                <p v-html="event.description_short" class="card-text"></p>
                            </div>
                        </div>
                        <div class="col-span-4 p-2 pr-0 text-right">
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
