<template>
    <admin-layout>
        <div class="container">
            <div id="success" style="display: none" class="alert alert-success" role="alert">
            </div>
            <form class="col-12 col-lg-12" v-on:submit.prevent="editStaticSite(static_site.id)">
                <div class="form-group row">
                    <div class="form-group col-12">
                        <label for="name" class="col-form-label">Tytuł:</label>
                        <div>
                            <input class="form-control" type="text" name="name" v-model="static_site.name" required>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label for="contents" class="col-form-label">Opis:</label>
                        <div>
                            <quill-editor v-model="static_site.contents"
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
                    <button type="submit" class="bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-1 px-2 rounded-full">Zapisz</button>
                </div>
            </form>
        </div>
    </admin-layout>
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
    import AdminLayout from '@views/layout/Admin'

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
            AdminLayout,
        },
        data() {
            return {
                static_site: {
                    name: '',
                    contents: '',
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
            this.loadStaticSite();
        },
        methods:{
            loadStaticSite:function(){
                axios.get('/api/admin/static-site/' + this.$route.params.id).then(res=>{
                    if(res.status==200){
                        this.static_site=res.data;
                    }
                }).catch(err=>{
                    console.log(err)
                });
            },
            editStaticSite(id){
                axios.post('/api/admin/static-site/' + id, {name: this.static_site.name, contents: this.static_site.contents}).then((response)=>{
                    $('#success').css("display", "block");
                    $('#success').html(response.data.message);
                    this.loadStaticSite();
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
