<template>
    <b-form-group :label="label + ':'" class="text-dark m-2 mb-0">
        <b-form-input :value="value" :class="customClass" @input="$emit('input', $event)"/>
    </b-form-group>
</template>

<script>
export default {
    name: 'TextInput',
    props: {
        customClass: {
            type: [String, Object],
            default: ''
        },
        label: {
            type: String,
            default: ''
        },
        value: {
            type: [String, Number],
            default: ''
        }
    }
};
</script>
