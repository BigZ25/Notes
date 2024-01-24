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
                <b-form-input v-model="note.title" placeholder="Tytuł"/>
                <b-button class="text-dark" @click="deleteNote">
                    <b-icon icon="trash"/>
                </b-button>
            </div>
            <hr class="p-0 m-0">
            <b-form-textarea v-model="note.content" placeholder="Treść"/>
            <div class="footer">
                <div
                    v-for="color in $enum('COLORS_ENUM')"
                    v-bind:key="color.value"
                    :class="'mr-2 bg-' + color.label"
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
    background-color: rgba(0, 0, 0, 0) !important;
    border: none !important;
    color: black;
}

.sticky-note > .header > input:focus {
    box-shadow: none;
}

.sticky-note > .header > input::placeholder {
    color: black;
    font-style: italic;
}

.sticky-note > .header > button {
    width: 10%;
    background-color: rgba(0, 0, 0, 0) !important;
    border: none !important;
    color: black;
}

.sticky-note > hr {
    background-color: rgb(0, 0, 0) !important;
}


.sticky-note > textarea {
    width: 100%;
    height: 80%;
    resize: none;
    background-color: rgba(0, 0, 0, 0) !important;
    border: none !important;
    color: black;
}

.sticky-note > textarea:focus {
    box-shadow: none;
}

.sticky-note > textarea::placeholder {
    color: black;
    font-style: italic;
}

.footer {
    background-color: white;
    width: 100%;
    height: 10%;
    display: flex;
    align-items: center;
    margin-bottom: 5px;
}

.footer > div {
    width: 20px;
    height: 20px;
}

.footer > div:hover {
    cursor: pointer;
}

</style>
