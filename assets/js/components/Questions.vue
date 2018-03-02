<template>
    <v-flex>
        <v-card color="indigo lighten-3" class="white--text">
            <v-card-title primary-title>
                <h3 class="headline mb-0">Questions</h3>
            </v-card-title>
        </v-card>
        <v-form ref="form">
            <v-card>
                <template v-for="(question, index) in questions">
                    <app-question
                            ref="refQuestion" :question="question"
                            :index="index+1"
                    />
                    <v-divider v-if="index + 1 < questions.length"/>
                </template>
                <v-card-actions>
                    <v-btn @click="submit">submit</v-btn>
                    <v-btn @click="clear">clear</v-btn>
                </v-card-actions>
            </v-card>
        </v-form>
    </v-flex>
</template>

<script>
    import {mapGetters} from 'vuex';
    import axios from 'axios';
    import appQuestion from './Question.vue';

    export default {
        name: "questions",
        data: () => ({
            // show: true,
            questions: []
        }),
        methods: {
            submit() {
                const self = this;
                let userAnswers = [];
                this.$refs.refQuestion.forEach((child) => {
                    userAnswers.push(child.$data.userAnswers);
                });

                axios
                    .post(
                        '/api/results',
                        {
                            userAnswers: userAnswers,
                        }
                    )
                    .then(function (response) {
                        self.$store.dispatch('updateResults', response.data);
                        self.$router.push('results');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            clear() {
                this.$refs.form.reset()
            }
        },
        computed: mapGetters({
            questionCount: 'questionCount',
            selectedCategories: 'selectedCategories',
        }),
        created() {
            const self = this;

            if (!this.questionCount || !this.selectedCategories.length) {
                this.$router.push('settings');
            } else {
                axios
                    .post(
                        '/api/questions',
                        {
                            questionCount: this.questionCount,
                            selectedCategories: this.selectedCategories,
                        }
                    )
                    .then(function (response) {
                        self.questions = response.data.questions;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        },
        components: {appQuestion: appQuestion}
    }
</script>

<style scoped>

</style>