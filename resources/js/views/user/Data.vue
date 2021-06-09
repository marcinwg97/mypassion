<template>
    <user-layout>
        <div class="container">
            <div id="success" style="display: none" class="alert alert-success" role="alert">
            </div>
            <form @submit="formSubmit" enctype="multipart/form-data">
                <div class="profile-header-container">
                    <div class="profile-header-img text-center">
                        <img class="rounded-circle" v-bind:src="user.profile_img" style="height: 25%; width: 25%;" />
                        <!-- badge -->
                        <div class="custom-file">
                            <!-- MOST IMPORTANT - SEE "ref" AND "@change" PROPERTIES -->
                            <input type="file" class="form-control" v-on:change="onFileChange">
                        </div>
                    </div>
                </div>
                <button class="btn btn-success">Zmień avatar</button>
            </form>
            <form class="col-12 col-lg-12" v-on:submit.prevent="editUser(user.id)">
                <div class="form-group row">

                    <div class="form-group col-12">
                        <label for="title" class="col-form-label">Nazwa:</label>
                        <div>
                            <input class="rounded-sm px-3 py-2 mt-3 focus:outline-none bg-gray-100 w-full lg:w-1/2" type="text" name="name" v-model="user.name" required>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label for="description" class="col-form-label">Biografia:</label>
                        <div>
                            <quill-editor v-model="user.description"
                                class="mb-3"
                                id="rich-text"
                                rows="20"
                                :options="editorOption"
                                ref="myQuillEditor"
                                @blur="onEditorBlur($event)"
                                @focus="onEditorFocus($event)"
                                @ready="onEditorReady($event)">
                            </quill-editor>
                        </div>
                    </div>
                    <h3 class="text-2xl">
                        Social media
                    </h3>
                    <div class="form-group">
                        <label for="facebook" class="col-form-label">Facebook:</label>
                        <div>
                            <input class="rounded-sm px-3 py-2 mt-3 focus:outline-none bg-gray-100 w-full lg:w-1/2" type="text" name="facebook_link" v-model="user.facebook_link">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="instagram" class="col-form-label">Instagram:</label>
                        <div>
                            <input class="rounded-sm px-3 py-2 mt-3 focus:outline-none bg-gray-100 w-full lg:w-1/2" type="text" name="instagram_link" v-model="user.instagram_link">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="twitter" class="col-form-label">Twitter:</label>
                        <div>
                            <input class="rounded-sm px-3 py-2 mt-3 focus:outline-none bg-gray-100 w-full lg:w-1/2" type="text" name="twitter_link" v-model="user.twitter_link" >
                        </div>
                    </div>
                    <button type="submit" class="mb-3 bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-1 px-2 rounded-full">Zapisz</button>
                </div>
            </form>
        </div>
    </user-layout>
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
    import 'quill/dist/quill.core.css'
    import 'quill/dist/quill.snow.css'
    import 'quill/dist/quill.bubble.css'
    import { quillEditor, Quill } from 'vue-quill-editor'
    import ImageResize from 'quill-image-resize';
     import UserLayout from '@views/layout/User'

    // Register ImageResize module
    Quill.register('modules/imageResize', ImageResize);

    // Set toolbar options
    const toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],
        ['blockquote', 'code-block'],

        [{'header': 1}, {'header': 2}],
        [{'list': 'ordered'}, {'list': 'bullet'}],
        [{'script': 'sub'}, {'script': 'super'}],
        [{'indent': '-1'}, {'indent': '+1'}],
        [{'direction': 'rtl'}],

        [{'size': ['small', false, 'large', 'huge']}],
        [{'header': [1, 2, 3, 4, 5, 6, false]}],

        [{'color': []}, {'background': []}],
        [{'font': []}],
        [{'align': []}],
        ['link', 'image', 'video'],
        ['clean'],
    ];

    export default {
        components: {
            quillEditor,
            UserLayout,
        },
        data() {
            return {
                user: {
                    name: '',
                    biography: '',
                    facebook_link: '',
                    twitter_link: '',
                    instagram_link: '',
                },
                avatar: '',
                avatarName: '',
                editorOption: {
                    modules: {
                        toolbar: {
                            container: toolbarOptions,
                        },
                        history: {
                            delay: 1000,
                            maxStack: 50,
                            userOnly: false
                        },
                        imageResize: {
                            displayStyles: {
                                backgroundColor: 'black',
                                border: 'none',
                                color: 'white'
                            },
                            modules: [ 'Resize', 'DisplaySize', 'Toolbar' ]
                        }
                    }
                },
            }
        },
        mounted(){
            this.loadUser();
        },
        methods:{
            loadUser:function(){
                axios.get('/api/user').then(res=>{
                    if(res.status==200){
                        this.user=res.data;
                    }
                }).catch(err=>{
                    console.log(err)
                });
            },
            editUser(id){
                axios.post('/api/user', {name: this.user.name, biography: this.user.biography, facebook_link: this.user.facebook_link, instagram_link: this.user.instagram_link, twitter_link: this.user.twitter_link })
                .then((response)=>{
                    $('#success').css("display", "block");
                    $('#success').html(response.data.message);
                    this.loadUser();
                })
            },
            onEditorBlur(editor) {
                // console.log('editor blur!', editor)
            },
            onEditorFocus(editor) {
                // console.log('editor focus!', editor)
            },
            onEditorReady(editor) {
                // console.log('editor ready!', editor)
            },
            onFileChange(e){
                console.log(e.target.files[0]);
                this.avatar = e.target.files[0];
                this.avatarName = this.avatar.name;
            },
            formSubmit(e) {
                e.preventDefault();
                let currentObj = this;

                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }

                let formData = new FormData();
                formData.append('file', this.avatar);
                axios.post('/api/user/avatar', formData, config)
                .then(function (response) {
                    window.location.reload();
                })
                .catch(function (error) {
                    currentObj.output = error;
                });
            }
        },
        computed: {
            editor(){
                return this.$refs.myQuillEditor.quill
            }
        },
        beforeRouteEnter (to, from, next) {
        if ( ! localStorage.getItem('jwt')) {
            return next('login')
        }
        next()
        },
    }
</script>
