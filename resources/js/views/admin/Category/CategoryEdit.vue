<template>
    <admin-layout>
        <div class="container">
            <div id="success" style="display: none" class="alert alert-success" role="alert">
            </div>
            <form class="col-12 col-lg-12" v-on:submit.prevent="editCategory(category.id)">
                <div class="form-group row">
                    <div class="form-group col-12">
                        <label for="name" class="col-form-label">Nazwa kategorii:</label>
                        <div>
                            <input class="form-control" type="text" name="name" v-model="category.name" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Zapisz</button>
                </div>
            </form>
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
                category: {
                    name: '',
                },
            }
        },
        mounted(){
            this.loadCategory();
        },
        components: {
            AdminLayout,
        },
        methods:{
            loadCategory:function(){
                axios.get('/api/admin/category/' + this.$route.params.id).then(res=>{
                    if(res.status==200){
                        this.category=res.data;
                    }
                }).catch(err=>{
                    console.log(err)
                });
            },
            editCategory(id){
                axios.post('/api/admin/category/' + id, {name: this.category.name}).then((response)=>{
                    $('#success').css("display", "block");
                    $('#success').html(response.data.message);
                    this.loadCategory();
                })
            },
        },
    }
</script>
