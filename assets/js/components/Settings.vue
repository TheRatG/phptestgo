<template>
    <v-flex xs12>
        <v-card>
            <v-card-text>
                <v-form v-model="valid" ref="form">
                    <v-text-field
                            label="Question count"
                            v-model="questionCount"
                            :rules="questionCountRules"
                            :counter="10"
                            required
                    />
                    <div v-for="(categories, packName) in packs">
                        <h2>{{ packName }}</h2>
                        <v-select
                                label="Categories"
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
                    <v-btn
                            @click="submit"
                            :disabled="!valid"
                    >
                        submit
                    </v-btn>
                    <v-btn @click="clear">clear</v-btn>
                </v-form>
            </v-card-text>
        </v-card>
    </v-flex>
</template>

<script>

    export default {
        name: "settings",
        data: () => ({
            valid: false,
            selectedCategories: [],
            questionCount: 10,
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
        },
        methods: {
            submit() {
                if (this.$refs.form.validate()) {
                    this.$store.dispatch(
                        'updateSettings', {
                            'questionCount': this.questionCount,
                            'selectedCategories': this.selectedCategories
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
