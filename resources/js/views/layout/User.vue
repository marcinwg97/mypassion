<template>
    <div class="grid grid-cols-1 lg:grid-cols-6">
        <aside class="sidebar-container px-0 lg:w-1/6 w-full">
            <div class="sidebar-logo">
                MyPassion
            </div>
            <ul class="sidebar-navigation">
                <li>
                    <sidebar-link :href="'user-data'" :active="$route.name == 'user-data'">Dane użytkownika</sidebar-link>
                </li>
                <li>
                    <sidebar-link :href="'user-posts'" :active="$route.name == 'user-posts'">Twoje posty</sidebar-link>
                </li>
                <li>
                    <sidebar-link :href="'user-events'" :active="$route.name == 'user-events'">Twoje wydarzenia</sidebar-link>
                </li>
                <li>
                <sidebar-link :href="'favorite-post'" :active="$route.name == 'favorite-post'">Ulubione posty</sidebar-link>
                </li>
                <li>
                <sidebar-link :href="'favorite-user'" :active="$route.name == 'favorite-user'">Obserwani</sidebar-link>
                </li>
                <li>
                <sidebar-link :href="'user-event-member'" :active="$route.name == 'user-event-member'">Wydarzenia, w których chcesz wziąć udział</sidebar-link>
                </li>
                <li>
                <sidebar-link :href="'chat'" :active="$route.name == 'chat'">Czat ogólny</sidebar-link>
                </li>
                <li>
                <sidebar-link :href="'chat-one-to-one'" :active="$route.name == 'chat-one-to-one'">Wiadomości</sidebar-link>
                </li>
                <li>
                    <router-link :to="{ name: 'home' }">Powrót na stronę</router-link>
                </li>
                <li>
                    <a v-on:click="logout" v-if="isLoggedIn" style="cursor: pointer">Wyloguj</a>
                </li>
            </ul>
        </aside>
        <div class="lg:col-start-2 lg:col-span-5 px-3">
            <main id="content" class="pt-4">
                <slot></slot>
            </main>
        </div>
        <footer class="site-footer mt-auto bg-red-500 w-full bottom-0">
            <div class="container mx-auto pb-3">
                <div class="grid grid-cols-1 md:grid-cols-4">
                    <div class="col-span-2">
                        <h5 class="text-xl pb-3">My Passion</h5>
                    </div>
                    <div>
                        <h5 class="text-xl pb-3">Informacje</h5>
                        <ul class="footer-links">
                            <li><p>ul. Najlepsza</p></li>
                            <li><p>22-333 Wymyślone Miasto</p></li>
                        </ul>
                    </div>
                    <div>
                        <h5 class="text-xl pb-3">Kontakt</h5>
                        <ul class="footer-links">
                            <li><p>Telefon: +48 666 777 888</p></li>
                            <li><p>Email: <a href="mailto:mypassion@mypassion.pl">mypassion@mypassion.pl</a></p></li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr>
            <div class="container mx-auto">
                <div class="grid grid-cols-1">
                    <p class="copyright-text my-2">Copyright &copy; 2021</p>
                </div>
            </div>
        </footer>
    </div>
</template>
<style lang="scss" scoped>
    #content {
        min-height: 100vh;
    }
    footer {
        position: absolute;
    }
    @media(max-width: 991px) {
        footer {
            position: relative;
        }
        .sidebar-container {
            position: relative;
        }
        #content {
            min-height: unset;
        }
    }
</style>
<script>
import SidebarLink from '@components/SidebarLink'

export default {
    data(){
        return {
            categories: [],
            static_sites: [],
            isLoggedIn: null,
            name: null,
            url: process.env.MIX_APP_URL,
        }
    },
    components: {
        SidebarLink,
    },
    methods: {
        logout: function () {
            localStorage.removeItem('jwt')
            localStorage.removeItem('user')
            this.$router.push('/login')
        },
        loadCategories:function(){
            axios.get('/api/categories').then(res=>{
                if(res.status==200){
                    this.categories=res.data;
                }
            }).catch(err=>{
                console.log(err)
            });
        },
        loadStaticSites:function(){
            axios.get('/api/static-sites').then(res=>{
                if(res.status==200){
                    this.static_sites=res.data;
                }
            }).catch(err=>{
                console.log(err)
            });
        }
    },
    mounted(){
        this.loadCategories();
        this.loadStaticSites();
        this.isLoggedIn = localStorage.getItem('jwt')
        this.name = localStorage.getItem('user')
    }
}
</script>
