<template>
    <v-flex>
        <v-card color="indigo lighten-3" class="white--text">
            <v-card-title primary-title>
                <h3 class="headline mb-0">Settings</h3>
            </v-card-title>
        </v-card>
        <v-form v-model="valid" ref="form">
            <v-card>
                <v-card-text>
                    <v-text-field
                            label="Question count"
                            v-model="questionCount"
                            :rules="questionCountRules"
                            :counter="10"
                            required
                    />
                    <v-checkbox
                            label="Hide the information that questions are/aren't multiple choice"
                            v-model="hideMultipleChoice"
                    />
                    <div class="title">Packs</div>
                    <div v-for="(categories, packName) in packs">
                        <v-select
                                :label="packName"
                                v-bind:items="categories"
                                v-model="selectedCategories"
                                item-text="name"
                                item-value="key"
                                multiple
                                multi-line
                                chips
                                max-height="auto"
                                autocomplete
                        >
                            <template slot="selection" slot-scope="data">
                                <v-chip
                                        close
                                        @input="data.parent.selectItem(data.item)"
                                        :selected="data.selected"
                                        class="chip--select-multi"
                                        :key="data.item.id"
                                >
                                    {{ data.item.name }}
                                </v-chip>
                            </template>
                        </v-select>
                    </div>
                </v-card-text>
                <v-card-actions>
                    <v-btn @click="submit" :disabled="!valid">submit</v-btn>
                    <v-btn @click="clear">clear</v-btn>
                </v-card-actions>
            </v-card>
        </v-form>
    </v-flex>
</template>

<script>

    export default {
        name: "settings",
        data: () => ({
            valid: false,
            selectedCategories: [],
            questionCount: 10,
            hideMultipleChoice: true,
            questionCountRules: [
                v => {
                    return !!v || 'Question count is required';
                },
                v => /^\d+$/.test(v) || 'Question count must be numeric',
            ],
        }),
        created() {
            this.packs = window.__INITIAL_PACKS__;

            this.questionCount = this.$store.getters.questionCount;
            this.selectedCategories = this.$store.getters.selectedCategories;
            this.hideMultipleChoice = this.$store.getters.hideMultipleChoice;
        },
        methods: {
            submit() {
                if (this.$refs.form.validate()) {
                    this.$store.dispatch(
                        'updateSettings', {
                            'questionCount': this.questionCount,
                            'selectedCategories': this.selectedCategories,
                            'hideMultipleChoice': this.hideMultipleChoice
                        }
                    );
                    this.$router.push('questions');
                }
            },
            clear() {
                this.$refs.form.reset()
            }
        }
    }
</script>
