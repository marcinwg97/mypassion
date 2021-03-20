<template>
    <main-layout>
        <div class="container">

            <!-- The Modal -->
            <div class="modal" id="addPost">
                <div class="modal-dialog">
                    <div class="modal-content">
            
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Dodaj post</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div id="success" style="display: none" class="alert alert-success" role="alert">
                        </div>
                        <form class="col-12 col-lg-12" @submit.prevent="addNewPost">
                            <div class="form-group row">
                                <div class="form-group col-12">
                                    <label for="title" class="col-form-label">Tytuł:</label>
                                    <div>
                                        <input class="form-control" type="text" name="title" v-model="title" required>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="description" class="col-form-label">Opis:</label>
                                    <div>
                                        <quill-editor v-model="description"
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
                
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Zamknij</button>
                    </div>
                </div>
            </div>
            </div>
            <h1 class="text-center col-12 lead">Kategoria {{category.name}}</h1>
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="row">
                        <h1 class="text-center col-12 lead">Posty <a data-toggle="modal" data-target="#addPost" style="background-color: silver;padding: 5px;">+</a></h1>
                        <div v-for="post in posts.data" :key="post.id" class="col-12 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">{{ post.title }}</h4>
                                    <p v-html="post.description" class="card-text"></p>
                                    <router-link :to="{ name: 'post-details', params: { id: post.id, title: post.title }}" class="btn btn-info">Szczegóły</router-link>
                                </div>
                                <div class="card-footer text-muted d-flex justify-content-between bg-transparent border-top-0">
                                    <div class="views">{{ post.date }}</div>
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="row">
                        <h1 class="text-center col-12 lead">Wydarzenia</h1>
                        <div v-for="event in events.data" :key="event.id" class="col-12 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">{{ event.title }}</h4>
                                    <p v-html="event.description" class="card-text"></p>
                                    <router-link :to="{ name: 'event-details', params: { id: event.id, title: event.title }}" class="btn btn-info">Szczegóły</router-link>
                                </div>
                                <div class="card-footer text-muted d-flex justify-content-between bg-transparent border-top-0">
                                    <div class="views">{{ event.date }}</div>
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </main-layout>
</template>




<script>
    import 'quill/dist/quill.core.css'
    import 'quill/dist/quill.snow.css'
    import 'quill/dist/quill.bubble.css'
    import { quillEditor, Quill } from 'vue-quill-editor'
    import ImageResize from 'quill-image-resize';
    import AdminLayout from '@views/layout/Admin';
    import MainLayout from "@views/layout/Main";
    import PageLoader from "@components/PageLoader";

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
        data() {
            return {
                title: '',
                description: '',
                category: {},
                posts: {},
                events: {},
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
            this.loadCategory();
            this.loadPosts();
            this.loadEvents();
        },
        components: {
            quillEditor,
            MainLayout,
            PageLoader
        },
        methods:{
            imageUpload(e) {
                if (e.target.files.length !== 0) {
                    let quill = this.editor;
                    let reader = new FileReader();
                    reader.readAsDataURL(e.target.files[0]);
                    let self = this;
                    reader.onloadend = function() {
                        let base64data = reader.result;
                        self.form.images.push(base64data);

                        // Get cursor location
                        let length = quill.getSelection().index;

                        // Insert image at cursor location
                        quill.insertEmbed(length, 'image', base64data);

                        // Set cursor to the end
                        quill.setSelection(length + 1);
                    }
                }
            },
            loadPosts:function(page){
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios.get('/api/posts/category/' + this.$route.params.id + '?page=' + page).then(res=>{
                    if(res.status==200){
                        this.posts=res.data;
                    }
                }).catch(err=>{
                    console.log(err)
                });
            },

            loadEvents:function(page){
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios.get('/api/events/category/' + this.$route.params.id + '?page=' + page).then(res=>{
                    if(res.status==200){
                        this.events=res.data;
                    }
                }).catch(err=>{
                    console.log(err)
                });
            },
            
            loadCategory:function(){
                axios.get('/api/category/' + this.$route.params.id + '/' + this.$route.params.name).then(res=>{
                if(res.status==200){
                    this.category=res.data;
                }
                }).catch(err=>{
                    console.log(err)
                });
            },
            addNewPost(){
                axios.post('/api/admin/posts',{title: this.title, description: this.description, user_id: this.user_id, category_id: this.$route.params.id})
                .then((response)=>{
                    $('#success').css("display", "block");
                    $('#success').html(response.data.message);
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
        },
        toolbar: {
            container: toolbarOptions,
            handlers: {
                'image': function (value) {
                    if (value) {
                        document.querySelector('#imageUpload').click();
                    } else {
                        this.quill.format('image', false);
                    }
                }
            },
        },
    }
</script>
