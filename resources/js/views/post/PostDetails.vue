<template>
  <main-layout :title="post.title" :seo_description="post.description_short" :seo_keywords="post.seo_keywords">
    <div v-if="isLoading" class="row mx-0">
      <page-loader></page-loader>
    </div>
    <div v-else class="container mx-auto">
        <div class="row mx-0 p-3 post-detail mb-4">
            <div class="col-12 text-center">
                <h1 style="color: #2574A9">{{ post.title }}</h1>
            </div>
            <div class="col-9 col-lg-9">
                <div class="author mb-3">
                    <span v-if="post.name" class="author-name" style="font-style: italic;"><i class="fas fa-pen-nib"></i> {{ post.name }}</span><br v-if="post.name">
                    <span class="post-date"  style="font-style: italic;"><i class="far fa-calendar-alt"></i> {{ post.date.substring(8, 10) }} {{ monthName(post.date.substring(5, 7)) }}, {{ post.date.substring(0, 4) }}</span>
                </div>
            </div>
            <div class="col-3 col-lg-3 social-buttons pl-0 pr-2 px-lg-3 text-right">
                <span class="badge badge-pill px-0">
                    <a title="Udostępnianie strony na Facebook" class="facebook-share" style="color: white;" href="https://www.facebook.com/sharer/sharer.php?u=https://erpit.pl/post/200-ostatnia-prosta-do-wdrozenia-%E2%80%93-ppk-w-instytucjach-publicznych---webinarium" target="_blank" aria-label="Przycisk udostępniania na Facebook"><i class="fab fa-facebook-f fa-sm"></i></a>
                </span>
                <span class="badge badge-pill px-0">
                    <a title="Udostępnianie strony na Twitterze" class="twitter-share" style="color: white;" href="https://twitter.com/intent/tweet?text=Polecam&amp;url=https://erpit.pl/post/200-ostatnia-prosta-do-wdrozenia-%E2%80%93-ppk-w-instytucjach-publicznych---webinarium" target="_blank" aria-label="Przycisk udostępniania na Twitter"><i class="fab fa-twitter fa-sm"></i></a>
                </span>
            </div>
            <div class="col-12 col-lg-12 post-description order-2">
                <p
                v-html="post.description"
                class="card-text"></p>
            </div>
        </div>
        
        <div class="col-12" v-if="isAddToFavorite == false">
            <form class="col-12 col-lg-12" @submit.prevent="addPostToFavorite"><button type="submit" class="bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-1 px-2 rounded-full">Zapisz post do ulubionych</button></form>
        </div>
        <div class="col-12" v-else>
            <form class="col-12 col-lg-12" @submit.prevent="removePostFromFavorite"><button type="submit" class="bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-1 px-2 rounded-full">Usuń z ulubionych</button></form>
        </div>
        <h2 class="my-4 text-2xl">Komentarze</h2>
        <div class="row">
            <div v-for="comment in comments" :key="comment.id" class="my-4 row-span-full bg-yellow-100 rounded-md p-3">
                <p>{{comment.date}}, {{comment.user.name}}</p>
                <p>{{comment.contents}}</p>         
            </div>
        </div>
        <form class="row-span-full bg-gray-400" @submit.prevent="addComment">
            <div class="row-span-full">
                <input class="form-control" type="text" name="contents" v-model="contents" required>
            </div>
            <button type="submit" class="btn btn-primary">Dodaj komentarz</button>
        </form>
    </div>    
  </main-layout>
</template>
<script>
import MainLayout from "@views/layout/Main";
import PageLoader from "@components/PageLoader";

export default {
    data() {
        return {
            isLoading: true,
            post: {},
            comments: [],
            contents: '',
            isAddToFavorite: false,
        };
    },
    mounted() {
        this.loadPost();
        this.CheckIfPostIsAddToFavorite();
        this.loadComments();
    },
    components: {
        MainLayout,
        PageLoader
    },
    filters: {
    },
    methods: {
        loadPost: function() {
        axios
            .get(
            "/api/post", {
                params: {
                id: this.$route.params.id,
                title: this.$route.params.title
                }
                }
            )
            .then(res => {
            if (res.status == 200) {
                this.post = res.data;
                this.isLoading = false;
            }
            })
            .catch(err => {
            console.log(err);
            });
            
        },
        loadComments: function() {
        axios
            .get("/api/comments/" + this.$route.params.id)
            .then(res => {
            if (res.status == 200) {
                this.comments = res.data;
            }
            })
            .catch(err => {
            console.log(err);
            });
            
        },
        addPostToFavorite(){
            axios.post('/api/favorite-add-post',{post_id: this.$route.params.id, user_id: this.user_id})
            .then((response)=>{
                $('#success').css("display", "block");
                $('#success').html(response.data.message);
                window.location.reload();
            })
        },
        CheckIfPostIsAddToFavorite() {
            axios.get('/api/favorite/post/' + this.$route.params.id).then(res=>{
            if(res.status==200){
                if(res.data == 1) {
                    this.isAddToFavorite = true; 
                }
            }
            }).catch(err=>{
                console.log(err)
            });
        },
        addComment(){
            axios.post('/api/comment/store',{post_id: this.$route.params.id, user_id: this.user_id, contents: this.contents})
            .then((response)=>{
                $('#success').css("display", "block");
                $('#success').html(response.data.message);
                window.location.reload();
            })
        },
        removePostFromFavorite() {
            axios.post('/api/favorite-remove-post',{post_id: this.$route.params.id, user_id: this.user_id})
            .then((response)=>{
                $('#success').css("display", "block");
                $('#success').html(response.data.message);
                window.location.reload();
            })
        },
        monthName: function(mon) {
            return [
                "stycznia",
                "lutego",
                "marca",
                "kwietnia",
                "maja",
                "czerwca",
                "lipca",
                "sierpnia",
                "września",
                "października",
                "listopada",
                "grudnia"
            ][mon - 1];
        }
    }
};
</script>
