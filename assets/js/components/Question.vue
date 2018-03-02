<template>
    <div>
        <v-card-title>
            <code class="question-title">#{{ index }}. {{ question.question }}</code>
        </v-card-title>
        <v-card-text>
            <template v-if="!hideMultipleChoice && !question.multipleChoice">
                <v-radio-group
                        v-model="userAnswers"
                        hide-details
                >
                    <template v-for="(item, index) in question.answers">
                        <v-radio
                                :label="item.value"
                                :value="item.value"
                                :key="item.value"
                                :index="index"
                                hide-details
                        />
                    </template>
                </v-radio-group>
            </template>
            <template v-else>
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
            </template>
        </v-card-text>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        name: "question",
        data: () => ({
            userAnswers: []
        }),
        computed: mapGetters({
            hideMultipleChoice: 'hideMultipleChoice',
        }),
        props: {
            index: {required: true},
            question: {required: true},
        }
    }
</script>
