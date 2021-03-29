<template>
  <main-layout :title="post.title" :seo_description="post.description_short" :seo_keywords="post.seo_keywords">
    <div v-if="isLoading" class="row mx-0">
      <page-loader></page-loader>
    </div>
    <div v-else class="container">
        <div class="row mx-0 py-3 post-detail">
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
        <h2 class="lead mt-2">Komentarze</h2>
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
        };
    },
    mounted() {
        this.loadPost();
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
