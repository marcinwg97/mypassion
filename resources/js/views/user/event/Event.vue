<template>
    <user-layout>
        <div class="card-body table-responsive p-0">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>Tytuł</th>
                        <th>Data</th>
                        <th>Kategoria</th>
                        <th>Opis</th>
                        <th>Miejsce wydarzenia</th>
                        <th>Edytuj</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="event in events.data" :key="event.id">
                        <td>{{ event.title }}</td>
                        <td>{{ event.date }}</td>
                        <td>{{ event.category.name }}</td>
                        <td>{{ event.description }}</td>
                        <td>{{ event.place }}</td>
                        <td><button class="btn btn-warning"><router-link style="color: white !important;" :to="{ name: 'user-events-edit', params: { id: event.id }}">Edytuj</router-link></button></td>
                        <td><form @submit.prevent="deleteEvent(event.id)"><button type="submit" class="btn btn-danger">Usuń</button></form></td>
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
