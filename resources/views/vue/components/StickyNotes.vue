<template>
    <div class="bg-info" style="height: 1000px; width: 100%;">
        <sticky-note v-for="note in notes" v-bind:key="note.id" :note="note"/>
    </div>
</template>

<script>
import StickyNote from './StickyNote.vue'

export default {
    name: 'StickyNotes',
    components: {
        StickyNote
    },
    props: {
        notes: {
            type: Array,
            default: []
        },
    },
    methods: {},
    computed: {},
};
</script>
