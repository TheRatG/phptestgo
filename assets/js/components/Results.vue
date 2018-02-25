<template>
    <v-flex xs12>
        <v-card>
            <v-card-title primary-title="">
                <h3 class="score">{{rightCount}} / {{totalCount}}</h3>
            </v-card-title>
            <v-card-actions>
                <v-btn to="/settings">Repeat</v-btn>
                <v-btn @click="explore = true">Explore</v-btn>
            </v-card-actions>
        </v-card>
        <v-divider/>
        <v-card v-if="explore">
            <div v-for="(question, index) in questions">
                <app-result ref="refResult" :question="question" :number="index+1"/>
            </div>
        </v-card>
    </v-flex>
</template>

<script>
    import {mapGetters} from 'vuex';
    import appResult from './Result.vue';

    export default {
        name: "results",
        data: () => ({
            explore: false,
        }),
        computed: mapGetters({
            rightCount: 'rightCount',
            totalCount: 'totalCount',
            questions: 'questions',
        }),
        created() {
            const self = this;

            //todo: use https://router.vuejs.org/en/advanced/navigation-guards.html
            if (!this.totalCount || !this.questions.length) {
                this.$router.push('settings');
            }
        },
        components: {appResult: appResult}
    }
</script>
