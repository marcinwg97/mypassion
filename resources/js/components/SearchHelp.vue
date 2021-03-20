<template>
    <div v-if="hints.length" class="search-hints shadow-sm rounded-lg col-12">
        <ul>
            <li class="hint-link" v-for="(hint, index) in hints" :key="index">
                <router-link :to="{name: 'post-details', params: { id: hint.id, title: hint.title}}">{{ hint.title }}</router-link>
            </li>
        </ul>
    </div>
</template>
<style lang="scss" scoped>
    .search-hints {
        position: absolute;
        color: #252f3f;
        background-color: white;
        padding: unset;
        max-height: 128px;
        overflow-y: auto;

        &::-webkit-scrollbar {
            width: 4px;
        }
        &::-webkit-scrollbar-thumb {
            background-color: gray;
            border-radius: 25px;
            border: 1px solid transparent;
        }
    }
    ul {
        list-style: none;
        padding-left: unset;
        margin-bottom: unset;
    }
    li {
        a {
            color: black;
            display: inline-block;
            padding: 0.25rem 0 0.25rem 0.75rem;
            width: 100%;

            &:hover {
            background-color: #2574a9;
            color: white;
        }
        }
    }
</style>
<script>
    export default {
        props: ['hints']
    }
</script>
