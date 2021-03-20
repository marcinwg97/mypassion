<template>
    <admin-layout>
        <div class="container">
            <div id="success" class="alert alert-success" role="alert">
            </div>
            <form class="col-12 col-lg-12" @submit.prevent="addNewStaticSite">
                <div class="form-group row">
                    <div class="form-group col-12">
                        <label for="name" class="col-form-label">Tytuł:</label>
                        <div>
                            <input class="form-control" type="text" name="name" v-model="name" required>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label for="contents" class="col-form-label">Treść:</label>
                        <div>
                            <quill-editor v-model="contents"
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
                name: '',
                contents: '',
                images: [],

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
            addNewStaticSite(){
                axios.post('/api/admin/static-sites',{name: this.name, contents: this.contents}).then((response)=>{
                    $('#success').html(response.data.message)
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
