<template>
    <main-layout>
        <div class="container mx-auto">
            <modal id="PostModal" ref="PostModal" :header="'Dodawanie posta'">
                <form class="col-12 col-lg-12" @submit.prevent="addNewPost">
                    <div class="form-group">
                        <div class="form-group">
                            <div>
                                <label for="title" class="text-sm">Tytuł:</label>
                                <input class="rounded-sm px-4 py-3 mt-3 focus:outline-none border border-gray-300 focus:border-red-400 w-full" type="text" name="title" v-model="title" required>
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
                        <button type="submit" class="rounded-full py-1 px-3 bg-red-400">Zapisz</button>
                    </div>
                </form>
            </modal>
            <modal id="EventModal" ref="EventModal" :header="'Dodawanie wydarzenia'">
                <form class="col-12 col-lg-12" @submit.prevent="addNewEvent">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="title" class="text-sm">Tytuł:</label>
                            <div>
                                <input class="rounded-sm px-4 py-3 mt-3 focus:outline-none border border-gray-300 focus:border-red-400 w-full" type="text" name="title_event" v-model="title_event" required>
                            </div>
                        </div>
                        <div class="form-group col-12">
                            <label for="date" class="col-form-label">Data wydarzenia:</label>
                            <div>
                                <input type="datetime-local" id="date" name="date" class="rounded-sm px-3 py-2 mt-3 focus:outline-none border border-gray-300" v-model="date" required>
                            </div>
                        </div>
                        <div class="form-group col-12">
                            <label for="description" class="col-form-label">Opis:</label>
                            <div>
                                <quill-editor v-model="description_event"
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
                        <button type="submit" class="rounded-full py-1 px-3 bg-red-400">Zapisz</button>
                    </div>
                </form>
            </modal>
            <h1 class="text-center text-3xl">{{category.name}}</h1>
            <div class="grid lg:grid-cols-4">
                <div class="lg:col-span-3">
                    <div class="row-span-full grid lg:grid-cols-3">
                        <h1 class="lg:col-span-2 text-2xl">Posty</h1>
                        <div class="text-right">
                            <button @click="$refs.PostModal.showModal()" class="bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-1 px-2 rounded-full">Dodaj post</button>
                        </div>
                        <div class="post-detail rounded-md p-4 my-3 lg:col-span-3" v-for="post in posts.data" :key="post.id">
                            <div class="grid lg:grid-cols-4">
                                <div>
                                    <h2 class="publish-day text-3xl">{{(post.date).substring(8,10)}}</h2>
                                    <div class="publish-month">
                                        <p>{{monthName((post.date).substring(5,7))}} {{(post.date).substring(0,4)}}</p>
                                    </div>
                                    <div class="author mb-3">
                                        <span>
                                            <i class="fas fa-pen-nib fa-lg"></i>
                                            <span class="author-name" v-if="post.name">{{ post.name }}</span>
                                            <span class="author-name" v-else><router-link :to="{name: 'user-profile', params: { id: post.user.id}}">{{ post.user.name }}</router-link></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="lg:col-span-3">
                                    <h2 class="post-title">
                                        <router-link :to="{name: 'post-details', params: { id: post.id, title:  post.title}}" class="post-title text-2xl text-gray-800">{{ post.title }}</router-link>
                                    </h2>
                                    <div class="post-description">
                                        <p v-html="post.description_short" class="card-text"></p>
                                    </div>
                                </div>
                                <div class="col-span-4 text-right">
                                    <router-link :to="{name: 'post-details', params: { id: post.id, title: post.title}}" class="read-more">Czytaj więcej</router-link>
                                </div>
                            </div>
                        </div>
                        <pagination :data="posts" @pagination-change-page="loadPosts"></pagination>
                    </div>
                </div>
                <div class="pl-3">
                    <div class="row-span-full">
                        <div>
                            <div class="grid grid-cols-3">
                                <h1 class="col-span-1 lead mb-0 pl-0 text-2xl">Wydarzenia</h1>
                                <div class="col-span-2 flex justify-end">
                                    <button @click="$refs.EventModal.showModal()" class="bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-1 px-2 rounded-full">Dodaj wydarzenie</button>
                                </div>
                            </div>
                        </div>
                        <div v-for="event in events.data" :key="event.id" class="p-3 my-3 rounded-md post-detail">
                            <div class="card-body">
                                <h4 class="card-title text-2xl">{{ event.title }}</h4>
                                <!-- <p v-html="event.description" class="card-text"></p> -->
                                <div class="views">{{ event.date }}</div>
                            </div>
                            <div class="text-right">
                                <router-link :to="{ name: 'event-details', params: { id: event.id, title: event.title }}" class="read-more gls-btn-black">Szczegóły</router-link>
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
    import MainLayout from "@views/layout/Main";
    import PageLoader from "@components/PageLoader";
    import Modal from '@components/Modal';

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
                title_event: '',
                description_event: '',
                date: '',
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
            PageLoader,
            Modal
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
            monthName:function(mon) {
                return ['stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia'][mon - 1];
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
                    location.reload();
                    $('#success').css("display", "block");
                    $('#success').html(response.data.message);
                    window.location.reload();
                })
            },
            addNewEvent(){
            console.log('teks' + this.date);
                axios.post('/api/events', {title: this.title_event, description: this.description_event, date: this.date, user_id: this.user_id, category_id: this.$route.params.id})
                .then((response)=>{

                    location.reload();
                    $('#success').css("display", "block");
                    $('#success').html(response.data.message);
                    window.location.reload();
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
