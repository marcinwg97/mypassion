<template>
    <admin-layout>
        <div class="pb-2">
            <button class="btn btn-success"><router-link style="color: white !important;" :to="{ name: 'admin-static-sites-create'}">Dodaj</router-link></button>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Opis</th>
                        <th>Edytuj</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="static_site in static_sites.data" :key="static_site.id">
                        <td>{{ static_site.id }}</td>
                        <td>{{ static_site.name }}</td>
                        <td>{{ static_site.contents }}</td>
                        <td><button class="btn btn-warning"><router-link style="color: white !important;" :to="{ name: 'admin-static-sites-edit', params: { id: static_site.id }}">Edytuj</router-link></button></td>
                        <td><form @submit.prevent="deleteStaticSite(static_site.id)"><button type="submit" class="btn btn-danger">Usuń</button></form></td>
                    </tr>
                    <pagination :data="static_sites" @pagination-change-page="loadStaticSites"></pagination>
                </tbody>
            </table>
        </div>
    </admin-layout>
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
    import AdminLayout from '@views/layout/Admin'

    export default {
        data() {
            return {
                static_sites: {},
                title: '',
                description: '',
                titleEdit: '',
                descriptionEdit: ''
            }
        },
         mounted(){
            this.loadStaticSites();
        },
        components: {
            AdminLayout,
        },
        methods:{
            loadStaticSites:function(page){
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios.get('/api/admin/static-sites?page=' + page).then(res=>{
                    if(res.status==200){
                        this.static_sites=res.data;
                    }
                }).catch(err=>{
                    console.log(err)
                });
            },
            deleteStaticSite(id){
                axios.post('/api/admin/static-site/delete/' + id).then((response)=>{
                    $('#success').html(response.data.message)
                    this.loadStaticSites();
                })
            },
        }
    }
</script>
