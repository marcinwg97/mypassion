<template>
<div style="position: relative; min-height: 100vh; flex-direction: column; display: flex">
    <nav class="bg-yellow-100 shadow" role="navigation">
        <div class="container mx-auto py-3 flex flex-wrap items-center md:flex-no-wrap">
            <div class="mr-4 md:mr-8">
                <router-link :to="{name: 'home'}" class="navbar-brand">
                    <img class="h-20" src="/img/logo.svg" alt="">
                </router-link>
            </div>
            <div class="ml-auto md:hidden">
                <button class="flex items-center px-3 py-2 border rounded" type="button">
                    <svg class="h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <title>Menu</title>
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
                    </svg>
                </button>
            </div>
            <div v-if="isLoggedIn" class="w-full md:w-auto md:flex-grow md:flex md:items-center">
                <ul class="flex flex-col mt-4 -mx-4 pt-4 border-t md:flex-row md:items-center md:mx-0 md:ml-auto md:mt-0 md:pt-0 md:border-0">
                    <li>
                        <router-link :to="{ name: 'events' }" class="block px-4 py-1 md:p-2 lg:px-4">Wydarzenia</router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'user-data' }" class="block px-4 py-1 md:p-2 lg:px-4">Konto</router-link>
                    </li>
                    <li>
                        <a v-on:click="logout" class="block px-4 py-1 md:p-2 lg:px-4 lg:pr-0" style="cursor: pointer">Wyloguj</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main id="content" class="pt-4">
        <slot></slot>
    </main>
    <footer class="site-footer mt-auto bg-red-500">
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
<script>
import SearchHelp from '@components/SearchHelp';

export default {
    data(){
        return {
            isLoggedIn: null,
            name: null,
            search: '',
            searchResults: {}, //będzie przechowywać wyniki szukania i przerzucać je do propa hints w kompenencie search-help
            isHintVisible: false,
        }
    },
    props: {
        title: {
            type: String,
            default: 'MyPassion'
        },
        seo_description: {
            type: String,
            default: 'Strona MyPassion'
        },
        seo_keywords: {
            type: String,
            default: 'brak'
        },
    },
    methods: {
        logout: function () {
            localStorage.removeItem('jwt')
            localStorage.removeItem('user')
            this.$router.push('/login')
        },
        redirectSearch: function() {
            this.$router.push({name: 'search', params: {search: this.search}})
        },
        loadHints: function() {
            this.isHintVisible = true;
            axios.get('/api/search-hints?search=' + this.search).then(res=>{
                if(res.status==200){
                    this.searchResults=res.data;
                }
            }).catch(err=>{
                console.log(err)
            });
        },
        hide: function () {
            setTimeout(() => {
                this.isHintVisible = false;
            },600);

        }
    },
    components: {
        SearchHelp,
    },
    watch: {
        title: {
            immediate: true,
            handler(title) {
                document.title = title
            },
        },
        seo_description: {
            immediate: true,
            handler(seo_description) {
                if(this.seo_keywords != null) {
                    document.getElementsByTagName('meta').namedItem('description').setAttribute('content', seo_description)
                }
            }
        },
        seo_keywords: {
            immediate: true,
            handler(seo_keywords) {
                if(seo_keywords != null) {
                    document.getElementsByTagName('meta').namedItem('keywords').setAttribute('content', seo_keywords)
                }
            }
        },
    },
    mounted(){
        // this.loadCategories();
        // this.loadStaticSites();
        this.isLoggedIn = localStorage.getItem('jwt')
        this.name = localStorage.getItem('user')
    }
}
</script>
