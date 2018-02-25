<template>
    <div>
        <v-card-title>
            <code class="headline">#{{ number }}. {{ question.question }}</code>
        </v-card-title>

        <template v-for="(item, key) in question.answers">
            <v-card-text>
                <v-icon large color="green darken-2" v-if="item.user">check</v-icon>
                <v-icon large color="red darken-2" v-if="!item.user">clear</v-icon>
                <span :class="{correct: item.correct}">{{ item.value }}</span>
            </v-card-text>
        </template>
    </div>
</template>

<script>
    export default {
        name: "result",
        props: {
            number: {required: true},
            question: {required: true},
        }
    }
</script>
