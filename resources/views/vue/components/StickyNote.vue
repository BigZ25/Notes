<template>
    <draggable-resizable
        :parent="true"
        :w="note.width"
        :h="note.height"
        :x="note.x"
        :y="note.y"
        @resizestop="resizeNote"
        @dragstop="dragNote"
    >
        <div class="sticky-note">
            <div class="header">
                <input v-model="note.title" placeholder="Title"/>
                <b-button class="text-dark" @click="deleteNote">
                    <b-icon icon="trash"/>
                </b-button>
            </div>
            <textarea v-model="note.content" placeholder="Content"></textarea>
        </div>
    </draggable-resizable>
</template>

<script>
import 'vue-draggable-resizable/dist/VueDraggableResizable.css';
import DraggableResizable from 'vue-draggable-resizable';

export default {
    name: 'StickyNote',
    props: {
        note: {
            type: Object,
            default: null
        },
    },
    methods: {
        deleteNote() {
            this.$emit('deleteNote', this.note.id);
        },
        resizeNote(x, y, width, height) {
            this.$emit('resizeNote', this.note.id, x, y, width, height);
        },
        dragNote(x, y) {
            this.$emit('dragNote', this.note.id, x, y);
        },
    },
    computed: {
        // noteStyle() {
        //     return {
        //         backgroundColor: this.note.color,
        //         zIndex: this.note.zIndex,
        //     };
        // },
    },
    components: {
        draggableResizable: DraggableResizable,
    },
};
</script>

<style scoped>
.sticky-note {
    width: 100%;
    height: 100%;
//position: absolute; border: 1px solid #ccc; background-color: #fff; overflow: hidden;
}

.sticky-note > .header {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 5px;
}

.sticky-note > .header > input {
    width: 90%;
}

.sticky-note > .header > button {
    width: 10%;
}

.footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 5px;
}

.sticky-note > textarea {
    width: 100%;
    height: 100%;
    border: none;
    resize: none;
}
</style>
