<template>
    <section id="login">
        <v-container fill-height>
            <v-layout align-center>
                <v-flex xs12 sm6 offset-sm3>
                    <v-card color="#e8e7c9" class="brown--text">
                        <v-card-title primary-title>
                            <div>
                                <h3 class="headline mb-0">Zaloguj</h3>
                            </div>
                        </v-card-title>

                        <v-card-text>
                            <v-form @keyup.native.enter="authenticate()"
                                    class="form brown--text" ref="form" lazy-validation>
                                <v-text-field
                                        v-validate.in="'required|email'"
                                        v-model="form.email"
                                        :error-messages="errors.collect('email')"
                                        label="Email"
                                        data-vv-name="email"
                                        required>
                                </v-text-field>

                                <v-text-field
                                        v-validate.in="'required|min:6'"
                                        v-model="form.password"
                                        type="password"
                                        :error-messages="errors.collect('hasło')"
                                        label="Hasło"
                                        data-vv-name="hasło"
                                        required>
                                </v-text-field>

                                <div class="button-wrapper">
                                    <v-btn flat class="brown--text" @click="authenticate()">
                                        Zaloguj
                                    </v-btn>
                                </div>
                            </v-form>
                        </v-card-text>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </section>
</template>

<script>
    import {login} from '../../helpers/auth';

    export default {
        name: "Login",
        data() {
            return {
                form: {
                    email: '',
                    password: ''
                },
                error: null
            };
        },
        methods: {
            authenticate() {
                this.$store.dispatch('login');

                login(this.$data.form)
                    .then((res) => {
                        this.$store.commit("loginSuccess", res);
                        this.$router.push({path: '/'});
                    })
                    .catch((error) => {
                        this.$store.commit("loginFailed", {error});
                    });
            },
            clearForm() {
                this.form.email = null;
                this.form.password = null;
            }
        },
        computed: {
        }
    }
</script>

<style scoped>
</style>