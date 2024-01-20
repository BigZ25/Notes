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
        <div class="sticky-note" :class="backgroundClass">
            <div class="header">
                <input v-model="note.title" placeholder="Title"/>
                <b-button class="text-dark" @click="deleteNote">
                    <b-icon icon="trash"/>
                </b-button>
            </div>
            <textarea v-model="note.content" placeholder="Content"></textarea>
            <div class="footer">
                <b-button
                    v-for="color in $enum('COLORS_ENUM')"
                    v-bind:key="color.value"
                    :variant="color.label"
                    @click="note.color=color.value"
                />
            </div>
        </div>
    </draggable-resizable>
</template>

<script>
import 'vue-draggable-resizable/dist/VueDraggableResizable.css';
import DraggableResizable from 'vue-draggable-resizable';

export default {
    name: 'StickyNote',
    components: {
        draggableResizable: DraggableResizable,
    },
    props: {
        note: {
            type: Object,
            default: null
        },
    },
    methods: {
        deleteNote() {
            this.$emit('deleteNote', this.note);
        },
        resizeNote(x, y, width, height) {
            this.note.x = x
            this.note.y = y
            this.note.width = width
            this.note.height = height

            this.$emit('resizeNote', this.note);
        },
        dragNote(x, y) {
            this.note.x = x
            this.note.y = y

            this.$emit('dragNote', this.note);
        },
    },
    computed: {
        backgroundClass() {
            return "bg-" + this.$enum('COLORS_ENUM', this.note.color)
        }
    },
    watch: {
        'note.title': function () {
            this.$emit('change', this.note);
        },
        'note.content': function () {
            this.$emit('change', this.note);
        },
        'note.color': function () {
            this.$emit('change', this.note);
        }
    },
};
</script>

<style scoped>

.sticky-note {
    width: 100%;
    height: 100%;
}

.sticky-note > .header {
    width: 100%;
    height: 10%;
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
    width: 100%;
    height: 10%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 5px;
}

.sticky-note > textarea {
    width: 100%;
    height: 80%;
    border: none;
    resize: none;
}
</style>
