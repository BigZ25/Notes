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
            notes: [
                {
                    id: 1,
                    title: 'Note 1',
                    content: 'Lorem ipsum...',
                    color: '#ffffcc',
                    x: 50,
                    y: 50,
                    zIndex: 1,
                    width: 200,
                    height: 150,
                },
                {
                    id: 2,
                    title: 'Notka',
                    content: 'Content',
                    color: '#ffffcc',
                    x: 300,
                    y: 300,
                    zIndex: 2,
                    width: 300,
                    height: 250,
                },
            ]
        }
    },
    computed: {},
    methods: {
        getNotes: function () {
            this.$http.get('/api/notes').then(response => {
                this.data = response.data.data
            })
        },
        updateNote: function (id, data) {
            this.$http.put('/api/notes/' + id, data).then(response => {

            })
        },
        deleteNote(id) {
            //alert("DELETE: " + id)
        },
        resizeNote(id, x, y, width, height) {
            console.log(id + " / " + x + " / " + y + " / " + width + " / " + height)
        },
        dragNote(id, x, y) {
            console.log(id + " / " + x + " / " + y)
        },
    },
    created() {
        this.getNotes()
    }
}
</script>
