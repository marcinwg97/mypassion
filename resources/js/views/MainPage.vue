<template>
    <main-layout :title="'Strona główna | MyPassion'" :seo_description="'Strona główna MyPassion'" :seo_keywords="'strona główna, MyPassion'">
        <div class="container">
            <h1 class="lead text-center">Witamy na MyPassion!</h1>
            <div class="row">
                <div v-for="category in categories" :key="category.id" class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <i :class="`fas ${category.icon}  fa-5x`" style="color: #5D6D7E;"></i>
                            </div>    
                            <h5 class="card-title text-center"><router-link :to="{ name: 'category-details', params: { id: category.id, name: category.name }}">{{category.name}}</router-link></h5>
                        </div>
                    </div>
                </div>
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
                categories: [],
            }
        },
        mounted(){
            this.loadCategories();
        },
        components: {
            MainLayout,
        },
        computed: {
        
        },
        methods:{
        
        loadCategories:function(){
        
        axios.get('/api/categories').then(res=>{
       if(res.status==200){
         this.categories=res.data;
       }
     }).catch(err=>{
         console.log(err)
     });
        }
        }
    }
</script>
