<template>
    <user-layout>
        <div class="container">
    <div id="success" style="display: none" class="alert alert-success" role="alert">
        </div>
        <form class="col-12 col-lg-12" v-on:submit.prevent="editPost(post.id)">
            <div class="form-group row">
                <div class="form-group col-12">
                    <label for="title" class="col-form-label">Tytuł:</label>
                    <div>
                        <input class="form-control" type="text" name="title" v-model="post.title" required>
                    </div>
                </div>
                <div class="form-group col-12">
                    <label for="description" class="col-form-label">Opis:</label>
                    <div>
                        <quill-editor v-model="post.description"
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
                post: {
                    title: '',
                    description: '',
                    is_active: '',
                    description_short: '',
                    seo_keywords: '',
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
            this.loadPost();
        },
        methods:{
            loadPost:function(){
                axios.get('/api/admin/post/' + this.$route.params.id).then(res=>{
                    if(res.status==200){
                        this.post=res.data;
                    }
                }).catch(err=>{
                    console.log(err)
                });
            },
            editPost(id){
                axios.post('/api/admin/post/' + id, {title: this.post.title, description: this.post.description, description_short: this.post.description_short, seo_keywords: this.post.seo_keywords, is_active: this.post.is_active})
                .then((response)=>{
                    $('#success').css("display", "block");
                    $('#success').html(response.data.message);
                    this.loadPost();
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
