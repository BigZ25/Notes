<template>
    <div v-if="render">
        <b-card class="mt-3 mb-3" no-body>
            <b-tabs v-model="activeTab" card>
                <b-tab v-for="tab in tabs" v-bind:key="tab.id">
                    <template #title>
                        <span class="text-dark">
                             {{ tab.name }}
                            <b-icon icon="trash"/>
                        </span>
                    </template>
                    <div style="height: 1000px; width: 100%;">
                        <sticky-note
                            v-for="note in notes.filter((iNote) => iNote.tab_id == tabs[activeTab].id)"
                            v-bind:key="note.id"
                            :note="note"
                            @deleteNote="showDeleteNoteModal"
                            @resizeNote="resizeNote"
                            @dragNote="dragNote"
                            @change="updateNote"
                        />
                    </div>
                </b-tab>
                <template #tabs-end>
                    <b-nav-item role="presentation" @click.prevent="addTab" href="#"><b class="text-primary">+</b>
                    </b-nav-item>
                </template>
            </b-tabs>
        </b-card>
        <delete-modal
            :show="noteToDelete !== null"
            title="Usuwanie notatki"
            :question="deleteNoteModalQuestion"
            @confirm="deleteNote"
            @cancel="closeDeleteNoteModal"/>
    </div>
</template>

<script>

import StickyNote from "./components/StickyNote.vue";
import DeleteModal from "./components/DeleteModal.vue";

export default {
    components: {
        DeleteModal,
        StickyNote
    },
    name: 'Notes',
    data: function () {
        return {
            noteToDelete: null,
            render: false,
            activeTab: 0,
            tabs: [],
            notes: []
        }
    },
    computed: {
        deleteNoteModalQuestion: function () {
            return this.noteToDelete !== null ? (this.noteToDelete.title ? `Czy napewno chcesz usunąć notatkę ${this.noteToDelete.title}?` : "Czy napewno chcesz usunąć tą notatkę?") : ""
        }
    },
    methods: {
        addTab: function () {
            let data = {
                name: 'Moje notatki'
            }

            this.$http.post('/api/tabs', data).then(response => {
                let tab = response.data.data.tab
                this.tabs.push(tab);
                const newTabIndex = this.tabs.length + 1;
                this.activeTab = newTabIndex - 1;
                console.log(this.tabs)
            })
        },
        getTabs: function () {
            this.$http.get('/api/tabs').then(response => {
                this.tabs = response.data.data.tabs
                this.getNotes()
            })
        },
        getNotes: function () {
            this.$http.get('/api/notes').then(response => {
                this.notes = response.data.data.notes
                this.render = true
            })
        },
        storeNote: function (note) {
            console.log(note)
            let data = {
                tab_id: note.tab_id,
                title: note.title,
                content: note.content,
                color: note.color,
                pos_x: note.x,
                pos_y: note.y,
                pos_z: note.zIndex,
                width: note.width,
                height: note.height
            }

            this.$http.post('/api/notes', data).then(response => {

                }
            )
        },
        updateNote: function (note) {
            console.log(note)
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
        showDeleteNoteModal(note) {
            this.noteToDelete = note
        },
        deleteNote() {
            this.$http.delete('/api/notes/' + this.noteToDelete.id).then(() => {
                this.notes = this.notes.filter(note => note.id !== this.noteToDelete.id);
                this.closeDeleteNoteModal()
            })
        },
        resizeNote(note) {
            this.updateNote(note)
        },
        dragNote(note) {
            this.updateNote(note)
        },
        closeDeleteNoteModal() {
            this.noteToDelete = null
        }
    },
    created() {
        this.getTabs()
    }
}
</script>
