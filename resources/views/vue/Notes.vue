<template>
    <div>
        <b-card class="mt-3 mb-3">
            <b-col class="md-12">
                <b-row>
                    <StickyNotes :notes="notes"/>
                </b-row>
            </b-col>
        </b-card>
    </div>
</template>

<script>

import {Chart, registerables} from 'chart.js/auto'
import StickyNotes from './components/StickyNotes.vue'

export default {
    components: {
        StickyNotes,
    },
    name: 'Notes',
    data: function () {
        return {
            data: null,
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
    computed: {
    },
    methods: {
        getData: function () {
            this.$http.get('/api/desktop').then(response => {
                this.data = response.data.data
                this.renderChart()
            })
        },
    },
    created() {
        this.getData()
    }
}
</script>
