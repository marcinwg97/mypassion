<template>
<div class="row mx-0">
    <aside class="sidebar-container col-12 col-lg-2 px-0">
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
            <sidebar-link :href="'favorite-user'" :active="$route.name == 'favorite-user'">Ulubioni użytkownicy</sidebar-link>
            </li>
            <li>
            <sidebar-link :href="'user-event-member'" :active="$route.name == 'user-event-member'">Wydarzenia, w których chcesz wziąć udział</sidebar-link>
            </li>
            <li>
                <router-link :to="{ name: 'home' }">Powrót na stronę</router-link>
            </li>
            <li>
                <a v-on:click="logout" v-if="isLoggedIn" style="cursor: pointer">Wyloguj</a>
            </li>
        </ul>
    </aside>
    <div class="col-12 col-lg-10 offset-0 offset-lg-2 px-0">
        <main id="content" class="pt-4">
            <slot></slot>
        </main>
        <footer class="site-footer">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h6>My Passion</h6>
                    </div>
                    <div class="col-12 col-md-3">
                        <h6>Informacje</h6>
                        <ul class="footer-links">
                            <li><p>ul. Najlepsza</p></li>
                            <li><p>22-333 Wymyślone Miasto</p></li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-3">
                        <h6>Kontakt</h6>
                        <ul class="footer-links">
                            <li><p>Telefon: +48 666 777 888</p></li>
                            <li><p>Email: <a href="mailto:mypassion@mypassion.pl">mypassion@mypassion.pl</a></p></li>
                        </ul>
                    </div>
                </div>
                <hr>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-sm-6 col-12">
                        <p class="copyright-text">Copyright &copy; 2021</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
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
            this.$router.go('/')
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
