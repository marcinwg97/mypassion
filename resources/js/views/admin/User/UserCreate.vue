<template>

    <div class="container">
        <div id="success" class="alert alert-success" role="alert">
        </div>
        <form class="col-12 col-lg-12" @submit.prevent="addNewUser">
            <div class="form-group row">
                <div class="form-group col-12">
                    <label for="name" class="col-form-label">Nazwa:</label>
                    <div>
                        <input class="form-control" type="text" name="name" v-model="name" required>
                    </div>
                </div>
                <div class="form-group col-12">
                    <label for="email" class="col-form-label">Email:</label>
                    <div>
                        <input class="form-control" type="text" name="email" v-model="email" required>
                    </div>
                </div>
                <div class="form-group col-12">
                    <label for="password" class="col-form-label">Hasło:</label>
                    <div>
                        <input class="form-control" type="password" name="password" v-model="password" required>
                    </div>
                </div>
                <button type="submit" class="bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-1 px-2 rounded-full">Zapisz</button>
            </div>
        </form>
    </div>

</template>


    <style scoped>
    .full-height {
        height: 100vh;
    }
    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }
    .position-ref {
        position: relative;
    }
    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }
    .content {
        text-align: center;
    }
    .title {
        font-size: 60px;
    }
    .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }
    .m-b-md {
        margin-bottom: 30px;
        color: #000000;
    }
    </style>

    <script>

    export default {

        data() {
            return {
                name: '',
                email: '',
                password: '',
            }
        },
        methods:{


     addNewUser(){
                axios.post('/api/admin/users', {name: this.name, email: this.email, password: this.password })
                .then((response)=>{

                $('#success').html(response.data.message)
                })
            },

  },

    }
    </script>
