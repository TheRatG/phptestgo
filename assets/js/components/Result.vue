<template>
    <div>
        <v-card-title>
            <code class="question-title">#{{ number }}. {{ question.question }}</code>
        </v-card-title>
        <v-card-text>
            <template v-for="(item, key) in question.answers">
                <div>
                    <v-icon small color="" v-if="item.user === null">remove</v-icon>
                    <v-icon small color="green" v-if="item.user !== null && item.user">check_circle</v-icon>
                    <v-icon small color="red" v-if="item.user !== null && !item.user">error</v-icon>
                    <span :class="{correct: item.correct}">{{ item.value }}</span>
                </div>
            </template>
        </v-card-text>
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
