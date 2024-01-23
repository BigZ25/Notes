<template>
    <b-modal v-model="show" :title="title">
        {{ question }}
        <template #modal-footer>
            <div>
                <b-button @click="confirm" variant="primary">Tak</b-button>
                <b-button @click="cancel">Nie</b-button>
            </div>
        </template>
    </b-modal>
</template>

<script>

export default {
    name: 'DeleteModal',
    props: {
        show: {
            type: Boolean,
            default: false
        },
        title: {
            type: String,
            default: ""
        },
        question: {
            type: String,
            default: ""
        },
    },
    methods: {
        confirm() {
            this.$emit('confirm');
        },
        cancel() {
            this.$emit('cancel');
        }
    },
}
</script>
