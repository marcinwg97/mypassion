<template>
  <main-layout>
    <div v-if="isLoading" class="row mx-0">
      <page-loader></page-loader>
    </div>
    <div v-else class="container mx-auto">
        <div class="p-3 post-detail mb-4 row-span-full grid grid-cols-4">
            <div class="text-center col-span-4">
                <h1 style="color: #2574A9" class="text-2xl">{{ event.title }}</h1>
            </div>
            <div class="col-span-3">
                <div class="author mb-3">
                    <span v-if="event.name" class="author-name" style="font-style: italic;"><i class="fas fa-pen-nib"></i> {{ event.name }}</span><br v-if="event.name">
                    <span class="post-date text-3xl"  style="font-style: italic;"><i class="far fa-calendar-alt"></i> {{ event.date.substring(8, 10) }} {{ monthName(event.date.substring(5, 7)) }}, {{ event.date.substring(0, 4) }}</span>
                </div>
            </div>
            <div class="social-buttons pl-0 pr-2 px-lg-3 text-right">
                <span class="badge badge-pill px-0">
                    <a title="Udostępnianie strony na Facebook" class="facebook-share" style="color: white;" href="https://www.facebook.com/sharer/sharer.php?u=https://erpit.pl/post/200-ostatnia-prosta-do-wdrozenia-%E2%80%93-ppk-w-instytucjach-publicznych---webinarium" target="_blank" aria-label="Przycisk udostępniania na Facebook"><i class="fab fa-facebook-f fa-sm"></i></a>
                </span>
                <span class="badge badge-pill px-0">
                    <a title="Udostępnianie strony na Twitterze" class="twitter-share" style="color: white;" href="https://twitter.com/intent/tweet?text=Polecam&amp;url=https://erpit.pl/post/200-ostatnia-prosta-do-wdrozenia-%E2%80%93-ppk-w-instytucjach-publicznych---webinarium" target="_blank" aria-label="Przycisk udostępniania na Twitter"><i class="fab fa-twitter fa-sm"></i></a>
                </span>
            </div>
            <div class="col-span-4 post-description order-2">
                <p
                v-html="event.description"
                class="card-text"></p>
            </div>
        </div>
        <div class="col-12" v-if="isAddToEvent == false">
            <form class="col-12 col-lg-12" @submit.prevent="addNewUserToEvent"><button type="submit" class="bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-1 px-2 rounded-full">Dołącz do wydarzenia</button></form>
        </div>
        <div class="col-12" v-else>
        <form class="col-12 col-lg-12" @submit.prevent="removeUserFromEvent"><button type="submit" class="bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-1 px-2 rounded-full">Opuść wydarzenie</button></form>
        </div>
    </div>
  </main-layout>
</template>
<script>
import MainLayout from "@views/layout/Main";
import PageLoader from "@components/PageLoader";

export default {
    data() {
        return {
            isAddToEvent: false,
            isLoading: true,
            event: {},
        };
    },
    mounted() {
        this.loadEvent();
        this.CheckIfUserIsAddToEvent();
    },
    components: {
        MainLayout,
        PageLoader
    },
    filters: {
    },
    methods: {
        loadEvent: function() {
        axios
            .get(
            "/api/event", {
                params: {
                id: this.$route.params.id,
                title: this.$route.params.title
                }
                }
            )
            .then(res => {
            if (res.status == 200) {
                this.event = res.data;
                this.isLoading = false;
            }
            })
            .catch(err => {
            console.log(err);
            });
        },
        addNewUserToEvent(){
            axios.post('/api/event-add-user',{event_id: this.$route.params.id, user_id: this.user_id})
            .then((response)=>{
                $('#success').css("display", "block");
                $('#success').html(response.data.message);
                window.location.reload();
            })
        },
        CheckIfUserIsAddToEvent() {
            axios.get('/api/event/user/' + this.$route.params.id).then(res=>{
            if(res.status==200){
                if(res.data == 1) {
                    this.isAddToEvent = true;
                }
            }
            }).catch(err=>{
                console.log(err)
            });
        },
        removeUserFromEvent() {
            axios.post('/api/event-remove-user',{event_id: this.$route.params.id, user_id: this.user_id})
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
