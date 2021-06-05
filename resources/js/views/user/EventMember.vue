<template>
    <user-layout>
        <div class="card-body table-responsive p-0">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>Tytuł</th>
                        <th>Data</th>
                        <th>Opis</th>
                        <th>Twórca</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="event in events.data" :key="event.id">
                        <td>{{ event.title }}</td>
                        <td>{{ event.date }}</td>
                        <td>{{ event.description }}</td>
                        <td>{{ event.user.email }}</td>
                        <td><form @submit.prevent="deleteEvent(event.id)"><button type="submit" class="btn btn-danger">Usuń</button></form></td>
                    </tr>
                    <pagination :data="events" @pagination-change-page="loadEvents"></pagination>
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
                axios.get('/api/user/event-member?page=' + page).then(res=>{
                    if(res.status==200){
                        this.events=res.data;
                    }
                }).catch(err=>{
                    console.log(err)
                });
            },
            deleteEvent(id){
                axios.post('/api/user/event-member/delete/' + id).then((response)=>{
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
