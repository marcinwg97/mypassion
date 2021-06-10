<template>
    <user-layout>
        <div class="card-body table-responsive p-0">
            <table class="table w-full">
                <thead class="thead-light">
                    <tr>
                        <th class="text-left">Tytuł</th>
                        <th>Data</th>
                        <th>Kategoria</th>
                        <th>Miejsce wydarzenia</th>
                        <th>Edytuj</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="event in events.data" :key="event.id">
                        <td>{{ event.title }}</td>
                        <td class="text-center">{{ event.date }}</td>
                        <td class="text-center">{{ event.category.name }}</td>
                        <td class="text-center">{{ event.place }}</td>
                        <td class="justify-center flex">
                            <button class="bg-blue-500 hover:bg-blue-600 px-2 py-1 rounded-full text-gray-100">
                                <router-link :to="{ name: 'user-events-edit', params: { id: event.id }}">Edytuj</router-link>
                            </button>
                        </td>
                        <td>
                            <form @submit.prevent="deleteEvent(event.id)" class="justify-center flex">
                                <button type="submit" class="bg-red-500 hover:bg-red-600 px-2 py-1 rounded-full text-gray-100 w-full">
                                    <i class="far fa-trash-alt"></i> Usuń
                                </button>
                            </form>
                        </td>
                    </tr>
                    <pagination :data="events" @pagination-change-page="loadEvents"></pagination>
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
                events: {},
                title: '',
                description: '',
            }
        },
        mounted(){
            this.loadEvents();
        },
        components: {
            UserLayout,
        },
        methods:{
            loadEvents:function(page){
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios.get('/api/user/events?page=' + page).then(res=>{
                    if(res.status==200){
                        this.events=res.data;
                    }
                }).catch(err=>{
                    console.log(err)
                });
            },
            deleteEvent(id){
                axios.post('/api/user/event/delete/' + id).then((response)=>{
                    $('#success').html(response.data.message)
                    this.loadEvents();
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
