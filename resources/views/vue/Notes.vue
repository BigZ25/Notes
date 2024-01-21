<template>
    <div v-if="render">
        <b-card class="mt-3 mb-3" body-class="p-0 m-0" style="height: 1000px; width: 100%;" no-body>
            <b-tabs v-model="activeTab" card>
                <b-tab v-for="tab in tabs" v-bind:key="tab.id">
                    <template #title>
                        <span class="text-dark">
                             {{ tab.name }}
                            <b-icon icon="trash"/>
                        </span>
                    </template>
                    <sticky-note
                        v-for="note in notes.filter((iNote) => iNote.tab_id == tabs[activeTab].id)"
                        v-bind:key="note.id"
                        :note="note"
                        @deleteNote="deleteNote"
                        @resizeNote="resizeNote"
                        @dragNote="dragNote"
                        @change="updateNote"
                    />
                </b-tab>
                <template #tabs-end>
                    <b-nav-item role="presentation" @click.prevent="addTab" href="#"><b class="text-primary">+</b>
                    </b-nav-item>
                </template>
            </b-tabs>
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
            render: false,
            activeTab: 0,
            tabs: [],
            notes: []
        }
    },
    computed: {},
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
        this.getTabs()
    }
}
</script>
