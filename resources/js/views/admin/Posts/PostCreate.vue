<template>
    <admin-layout>
        <div class="container">
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
                    <div class="form-group col-12">
                        <label for="description_short" class="col-form-label">Krótki opis SEO:</label>
                        <div>
                            <input class="form-control" type="text" name="description_short" v-model="description_short" required>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label for="seo_keywords" class="col-form-label">Keywords:</label>
                        <div>
                            <input class="form-control" type="text" name="seo_keywords" v-model="seo_keywords" required>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="form-check px-0">
                            <label for="is_active">
                                <input type="checkbox" v-model="is_active" checked> Pokazuj na stronie
                            </label>
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
                title: '',
                description: '',
                is_active: '',
                description_short: '',
                seo_keywords: '',
                category_id: '',
                images: [],
                categories: [],
                users: [],
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
            addNewPost(){
                axios.post('/api/admin/posts',{title: this.title, description: this.description, description_short: this.description_short, seo_keywords: this.seo_keywords, user_id: this.user_id, is_active: this.is_active})
                .then((response)=>{
                    console.log(this.is_active);
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
