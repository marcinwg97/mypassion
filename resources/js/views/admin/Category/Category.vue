<template>
    <admin-layout>
        <div class="pb-2">
            <button class="btn btn-success"><router-link style="color: white !important;" :to="{ name: 'admin-categories-create'}">Dodaj</router-link></button>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Nazwa</th>
                        <th>Edytuj</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="category in categories.data" :key="category.id">
                        <td>{{ category.id }}</td>
                        <td>{{ category.name }}</td>
                        <td><button class="btn btn-warning"><router-link style="color: white !important;" :to="{ name: 'admin-categories-edit', params: { id: category.id }}">Edytuj</router-link></button></td>
                        <td><form @submit.prevent="deleteCategory(category.id)"><button type="submit" class="btn btn-danger" onclick="return confirm('Czy napewno usunąć? Usunięcie kategorii spowoduje także usunięcie wszystkich przypisanych postów.')">Usuń</button></form></td>
                    </tr>
                    <pagination :data="categories" v-on:pagination-change-page="loadCategories"></pagination>
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
                categories: {},
                name: '',
            }
        },
        mounted(){
            this.loadCategories();
        },
        components: {
            AdminLayout,
        },
        methods:{
            loadCategories:function(page){
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios.get('/api/admin/categories?page=' + page).then(res=>{
                    if(res.status==200){
                        this.categories=res.data;
                    }
                }).catch(err=>{
                    console.log(err)
                });
            },
            deleteCategory(id){
                axios.post('/api/admin/category/delete/' + id).then((response)=>{
                    $('#success').html(response.data.message)
                    this.loadCategories();
                })
            },
        }
    }
</script>
