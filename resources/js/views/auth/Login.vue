<template>
    <div class="justify-center flex" style="min-height: 100vh; background-color: #f4f5f7;">
        <div class="h-1/2 w-1/4 p-3 bg-white shadow-sm self-center">
            <img src="/img/logo.png" alt="" style="height: 80%; width: 80%;">
            <form method="POST" action="/login">
                <div class="my-5 text-sm">
                    <label for="email" class="text-sm">Adres e-mail</label>
                    <input id="email" placeholder="Adres email" type="email" class="rounded-sm px-4 py-3 mt-3 focus:outline-none bg-gray-100 w-full" v-model="email" required autofocus>
                </div>
                <div class="my-5 text-sm">
                    <label for="password" class="text-sm">Hasło</label>
                    <input id="password" placeholder="Podaj hasło" type="password" class="rounded-sm px-4 py-3 mt-3 focus:outline-none bg-gray-100 w-full" v-model="password" required>
                </div>
                <div class="my-5 text-sm">
                    <button type="submit" class="block text-center text-white bg-gray-800 p-3 duration-300 rounded-sm hover:bg-black w-full" @click="handleSubmit">
                        Zaloguj
                    </button>
                </div>
                <a style="color: black !important;" href="/register">Jeśli nie masz konta, zarejestruj się!</a>
            </form>
        </div>
        <!-- Alert jeśli wystąpi błąd -->
        <div v-if="error_message" class="alert alert-danger" role="alert" style="position: fixed; top: 1rem;">
            {{ error_message }}
        </div>
    </div>
</template>
<style lang="scss" scoped>
    .btn-dark-gray {
        background-color: #252f3f;
        color: white;
        font-weight: 500;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
        transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
    }
    .text-sm {
        color: #343a40;
        font-family: Nunito, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    }
</style>
<script>
    export default {
        data(){
            return {
                email : "",
                password : "",
                error_message: null
            }
        },
        props: {
            title: {
                type: String,
                default: 'Logowanie'
            },
        },
        methods : {
            handleSubmit(e){
                e.preventDefault()

                if (this.password.length > 0) {
                    axios.post('api/login', {
                        email: this.email,
                        password: this.password
                    }).then(response => {
                        localStorage.setItem('user',response.data.success.email)
                        localStorage.setItem('jwt',response.data.success.token)

                        if (localStorage.getItem('jwt') != null){
                            this.$router.go('home')
                        }
                    }).catch(error => {
                        switch (error.response.status) {
                        case 422:                                       //Złe dane logowania
                            this.showError('Błędne dane logowania');
                            break;
                        default:                                        //Pozostałe błędy
                            console.error(error);
                            break;
                        }
                    });
                }
            },
            showError: function(message_value) {
                this.error_message = message_value;                     //Przekazanie wartości errora do property
                setTimeout(() => {                                      //Po 3000ms wywołuje funkcje chowającą alert
                    this.hideError();
                }, 3000);
            },
            hideError: function() {
                this.error_message = null;
            }
        },
        beforeRouteEnter (to, from, next) {
            if (localStorage.getItem('jwt')) {
                return next('/');
            }
            next();
        },
        watch: {
            title: {
                immediate: true,
                handler(title) {
                    document.title = title
                },
            },
        },
    }
</script>
