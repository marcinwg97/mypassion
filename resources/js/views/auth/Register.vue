<template>
    <div class="justify-center flex" style="min-height: 100vh; background-color: #f4f5f7;">
        <div class="h-1/2 w-1/4 p-3 bg-white shadow-sm self-center">
            <img src="/img/logo.png" alt="" style="height: 80%; width: 80%;">
            <form method="POST" action="/register">
                <div class="my-5 text-sm">
                    <label for="name" class="text-sm">Nazwa</label>
                    <input id="name" placeholder="Podaj nazwę użytkownika" type="text" class="rounded-sm px-4 py-3 mt-3 focus:outline-none bg-gray-100 w-full" v-model="name" required autofocus>
                </div>
                <div class="my-5 text-sm">
                    <label for="email" class="text-sm">Adres e-mail</label>
                    <input id="email" placeholder="Podaj adres email" type="email" class="rounded-sm px-4 py-3 mt-3 focus:outline-none bg-gray-100 w-full" v-model="email" required autofocus>
                </div>
                <div class="my-5 text-sm">
                    <label for="password" class="text-sm">Hasło</label>
                    <input id="password" placeholder="Podaj hasło" type="password" class="rounded-sm px-4 py-3 mt-3 focus:outline-none bg-gray-100 w-full" v-model="password" required>
                </div>
                <div class="my-5 text-sm">
                    <label for="password" class="text-sm">Potwierdź hasło</label>
                    <input id="password" placeholder="Powtórz hasło" type="password" class="rounded-sm px-4 py-3 mt-3 focus:outline-none bg-gray-100 w-full" v-model="password_confirmation" required>
                </div>
                <div class="mt-5 text-sm">
                    <button type="submit" class="block text-center text-white bg-gray-800 p-3 duration-300 rounded-sm hover:bg-black w-full" @click="handleSubmit">
                        Zarejestruj
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
<style lang="scss" scoped>
    @media(min-width: 992px) {
        .auth-form {
            width: 22rem;
        }
    }
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
                name : "",
                email : "",
                password : "",
                password_confirmation : ""
            }
        },
        methods : {
            handleSubmit(e) {
                e.preventDefault()

                    axios.post('api/register', {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        })
                        .then(response => {
                        localStorage.setItem('user',response.data.success.name)
                        localStorage.setItem('jwt',response.data.success.token)

                        if (localStorage.getItem('jwt') != null){
                            this.$router.go('user/data')
                        }
                        })
                        .catch(error => {
                        console.error(error);
                        });
            }
        },
        beforeRouteEnter (to, from, next) {
            if (localStorage.getItem('jwt')) {
                return next('user/data');
            }
            next();
        }
    }
</script>
