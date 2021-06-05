<template>
    <user-layout>
        <div class="container">
        <div id="success" style="display: none" class="alert alert-success" role="alert">
        </div>
        <form class="col-12 col-lg-12" v-on:submit.prevent="editEvent(event.id)">
            <div class="form-group row">
                <div class="form-group col-12">
                    <label for="title" class="col-form-label">Tytuł:</label>
                    <div>
                        <input class="form-control" type="text" name="title" v-model="event.title" required>
                    </div>
                </div>
                <div class="form-group col-12">
                    <label for="description" class="col-form-label">Opis:</label>
                    <div>
                        <quill-editor v-model="event.description"
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
                    <label for="date" class="col-form-label">Data wydarzenia:</label>
                    <div>
                        <input type="datetime-local" id="date" name="date" v-model="event.date" required>
                    </div>
                </div>
                <div class="form-group col-12">
                    <label for="date" class="col-form-label">Miejsce wydarzenia:</label>
                    <div>
                        <input type="text" id="place" name="place" v-model="event.place" required>
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
                event: {
                    title: '',
                    description: '',
                    date: '',
                    place: '',
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
            this.loadEvent();
        },
        methods:{
            loadEvent:function(){
                axios.get('/api/user/event/' + this.$route.params.id).then(res=>{
                    if(res.status==200){
                        this.event=res.data;
                    }
                }).catch(err=>{
                    console.log(err)
                });
            },
            editEvent(id){
                axios.post('/api/user/event/' + id, {title: this.event.title, description: this.event.description, place: this.event.place, date: this.event.date })
                .then((response)=>{
                    $('#success').css("display", "block");
                    $('#success').html(response.data.message);
                    this.loadEvent();
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
        beforeRouteEnter (to, from, next) {
        if ( ! localStorage.getItem('jwt')) {
            return next('login')
        }
        next()
        },
    }
</script>
