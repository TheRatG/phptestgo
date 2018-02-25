<template>
    <v-flex xs12>
        <v-card>
            <v-form ref="form">
                <template v-for="(question, index) in questions">
                    <app-question ref="refQuestion" :question="question" :index="index+1"/>
                </template>
                <v-btn @click="submit">submit</v-btn>
                <v-btn @click="clear">clear</v-btn>
            </v-form>
        </v-card>
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