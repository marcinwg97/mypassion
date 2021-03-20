<template>
    <div>
        <router-link :to="{ name: href }"  :class="classes">
            <slot></slot>
        </router-link>
    </div>
</template>
<script>
    export default {
        props: ['active', 'href'],

        computed: {
            classes() {
                return this.active
                    ? 'sidebar-link active'
                    : 'sidebar-link'
            }
        }
    }
</script>
