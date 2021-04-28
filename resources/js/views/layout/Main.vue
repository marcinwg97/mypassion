<template>
<div style="position: relative; min-height: 100vh">
    <div class="container cont-mobile">
        <nav class="navbar navbar-expand-md" style="background-color: white;">
            <router-link :to="{name: 'home'}" class="navbar-brand">
                <img class="img-fluid" src="/img/logo.png" alt="">
            </router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
              <!--  <ul class="navbar-nav mr-auto">
                    <li class="nav-link"><router-link :to="{ name: 'about-us' }">O nas</router-link></li>
                    <li class="nav-link"><router-link :to="{ name: 'form-contact' }">Kontakt</router-link></li>
                </ul> -->
                <!-- Right Side Of Navbar -->
                <div class="navbar-nav ml-auto">
                  <!--  <div class="search-box" style="position: relative">
                        <form @submit.prevent="redirectSearch">
                            <div class="row no-gutters align-items-center input-group">
                                <div class="col-12">
                                      v-on:input wywołuje pobieranie hintów przy każdej zmianie wartości search
                                    <input class="form-control border-secondary rounded-pill pr-5" type="text" v-on:focusout="hide" v-on:input="loadHints" placeholder="Szukaj..." v-model="search">
                                </div>
                                <div class="col-auto" style="left: 6px">
                                    <button class="btn rounded-pill ml-n5" v-on:click="redirectSearch" style="color: white; background-color: #2574A9" type="button">
                                    <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <search-help v-if="isHintVisible" :hints="searchResults"></search-help>
                    </div> -->
                    <!-- Niezalogowany -->
                    <router-link :to="{ name: 'login' }" class="nav-link" v-if="!isLoggedIn">Logowanie</router-link>
                    <router-link :to="{ name: 'register' }" class="nav-link" v-if="!isLoggedIn">Rejestracja</router-link>
                    <!-- Zalogowany -->
                    <router-link :to="{ name: 'events' }" class="nav-link" v-if="isLoggedIn">Wydarzenia</router-link>
                    <router-link :to="{ name: 'user-data' }" class="nav-link" v-if="isLoggedIn">Panel</router-link>
                    <a v-on:click="logout" class="nav-link" v-if="isLoggedIn" style="cursor: pointer">Wyloguj</a>
                </div>
            </div>
        </nav>
    </div>
    <main id="content" class="pt-3 py-lg-5">
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
            this.$router.go('/')
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
