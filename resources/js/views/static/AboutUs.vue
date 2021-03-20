<template>
    <main-layout>
        <div class="container">
            <div class="post-box">
                <h1 class="text-center" style="font-weight: 300">{{ about_us.name}}</h1>
                <p v-html="about_us.contents"></p>
            </div>
        </div>
    </main-layout>
</template>
<script>
import MainLayout from '@views/layout/Main'

export default {
    data() {
        return {
            about_us: {},
        }
    },
    mounted(){
        this.loadAboutUs();
    },
    components: {
        MainLayout,
    },
    methods:{
        loadAboutUs:function(){
            axios.get('/api/about-us').then(res=>{
                if(res.status==200){
                    this.about_us=res.data;
                }
            }).catch(err=>{
                console.log(err)
            });
        },
    }
}
</script>
