<template>
    <v-flex>
        <v-form v-model="valid" ref="form">
            <v-card>
                <v-card-text>
                    <v-layout row wrap>
                        <v-flex xs12 sm3>
                            <div class="title">General</div>
                            <v-subheader class="subheading">Question count <span color="red">*</span></v-subheader>
                            <div class="title">Categories</div>
                            <template v-for="(categories, packName) in packs">
                                <v-subheader class="subheading">{{ packName }}</v-subheader>
                            </template>
                        </v-flex>
                        <v-flex xs12 sm9>
                            <v-text-field
                                    v-model="questionCount"
                                    :rules="questionCountRules"
                                    :counter="10"
                                    required
                                    flat
                            />
                            <div v-for="(categories, packName) in packs">
                                <v-select
                                        label=""
                                        v-bind:items="categories"
                                        v-model="selectedCategories"
                                        item-text="name"
                                        item-value="key"
                                        multiple
                                        multi-line
                                        chips
                                        max-height="auto"
                                        autocomplete
                                        hide-details
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
                        </v-flex>
                    </v-layout>
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
