<template>
    <div>
        <b-card class="mt-3 mb-3" body-class="p-0 m-0" style="height: 1000px; width: 100%;">
            <sticky-note
                v-for="note in notes"
                v-bind:key="note.id"
                :note="note"
                @deleteNote="deleteNote"
                @resizeNote="resizeNote"
                @dragNote="dragNote"
                @change="updateNote"
            />
        </b-card>
    </div>
</template>

<script>

import StickyNote from "./components/StickyNote.vue";

export default {
    components: {
        StickyNote
    },
    name: 'Notes',
    data: function () {
        return {
            notes: []
        }
    },
    computed: {},
    methods: {
        getNotes: function () {
            this.$http.get('/api/notes').then(response => {
                this.notes = response.data.data.notes
            })
        },
        updateNote: function (note) {
            let data = {
                title: note.title,
                content: note.content,
                color: note.color,
                pos_x: note.x,
                pos_y: note.y,
                pos_z: note.zIndex,
                width: note.width,
                height: note.height
            }

            this.$http.put('/api/notes/' + note.id, data).then(response => {

            })
        },
        deleteNote(note) {
            //alert("DELETE: " + id)
        },
        resizeNote(note) {
            this.updateNote(note)
            //console.log(this.notes.find(item => item.id === note.id))
            //console.log(id + " / " + x + " / " + y + " / " + width + " / " + height)
        },
        dragNote(note) {
            this.updateNote(note)
            //console.log(this.notes.find(item => item.id === note.id))
            //console.log(id + " / " + x + " / " + y)
        },
    },
    created() {
        this.getNotes()
    }
}
</script>
