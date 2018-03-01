<template>
    <div>
        <v-card-title>
            <code class="question-title">#{{ index }}. {{ question.question }}</code>
        </v-card-title>
        <v-card-text>
            <template v-for="(item, index) in question.answers">
                <v-checkbox
                        v-model="userAnswers"
                        :label="item.value"
                        :value="item.value"
                        :key="item.value"
                        :index="index"
                        hide-details
                />
            </template>
        </v-card-text>
    </div>
</template>

<script>
    export default {
        name: "question",
        data: () => ({
            userAnswers: []
        }),
        props: {
            index: {required: true},
            question: {required: true},
        }
    }
</script>

<style scoped>

</style>