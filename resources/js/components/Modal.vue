<template>
    <div v-if="isVisible" class="modal grid grid-cols-1 bg-white w-2/4 rounded-lg">
        <!-- Modal header -->
        <div class="p-3 border-b-2 border-red-300">
            <h4 class="text-2xl">{{ header }}</h4>
            <button @click="closeModal()" style="position: absolute;right: 10px;top: 10px;">&times;</button>
        </div>
        <!-- Modal content -->
        <div class="p-3 ">
            <slot></slot>
        </div>
    </div>
</template>
<style lang="scss" scoped>
    .modal {
        position: absolute;
        top: 50px;
        left: 25%;
    }
</style>
<script>
    export default {
        data () {
            return {
                isVisible: false,
            }
        },
        props: ['header'],
        methods:{
            showModal:function() {
                this.isVisible = true;
            },
            closeModal:function() {
                this.isVisible = false;
            },
        },
    }
</script>
