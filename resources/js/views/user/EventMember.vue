<template>
    <user-layout>
        <div class="card-body table-responsive p-0">
            <table class="table w-full">
                <thead class="thead-light">
                    <tr>
                        <th class="text-left">Tytuł</th>
                        <th>Data</th>
                        <th>Opis</th>
                        <th>Organizator</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="event in events.data" :key="event.id">
                        <td>{{ event.title }}</td>
                        <td class="text-center">{{ event.date }}</td>
                        <td class="text-center">{{ event.description }}</td>
                        <td class="text-center">{{ event.user.email }}</td>
                        <td><form @submit.prevent="deleteEvent(event.id)" class="justify-center flex"><button type="submit" class="bg-red-500 hover:bg-red-600 px-2 py-1 rounded-full text-gray-100 w-full"><i class="far fa-trash-alt"></i> Usuń</button></form></td>
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
