<template>
    <user-layout>
        <div class="container">
    <div id="success" style="display: none" class="alert alert-success" role="alert">
        </div>
        <form class="col-12 col-lg-12" v-on:submit.prevent="editUser(user.id)">
            <div class="form-group row">
                <div class="form-group col-12">
                    <label for="title" class="col-form-label">Nazwa:</label>
                    <div>
                        <input class="form-control" type="text" name="name" v-model="user.name" required>
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
                <div class="form-group col-12">
                    <label for="facebook" class="col-form-label">Facebook:</label>
                    <div>
                        <input class="form-control" type="text" name="facebook_link" v-model="user.facebook_link">
                    </div>
                </div>
                <div class="form-group col-12">
                    <label for="instagram" class="col-form-label">Instagram:</label>
                    <div>
                        <input class="form-control" type="text" name="instagram_link" v-model="user.instagram_link">
                    </div>
                </div>
                <div class="form-group col-12">
                    <label for="twitter" class="col-form-label">Twitter:</label>
                    <div>
                        <input class="form-control" type="text" name="twitter_link" v-model="user.twitter_link" >
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Zapisz</button>
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
        },
        computed: {
            editor(){
                return this.$refs.myQuillEditor.quill
            }
        }
    }
</script>
