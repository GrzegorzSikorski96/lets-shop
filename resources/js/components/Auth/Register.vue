<template>
    <section id="login">
        <v-container fill-height>
            <v-layout align-center>
                <v-flex xs12 sm6 offset-sm3>
                    <v-card class="brown--text">
                        <v-card-title primary-title>
                            <div>
                                <h3 class="headline mb-0">Zarejestruj</h3>
                            </div>
                        </v-card-title>

                        <v-card-text>
                            <v-form @keyup.native.enter="authenticate()"
                                    class="form brown--text" ref="form" lazy-validation>
                                <v-text-field
                                        v-validate.in="'required'"
                                        v-model="form.name"
                                        :error-messages="errors.collect('name')"
                                        label="Nazwa użytkownika"
                                        data-vv-name="name"
                                        required>
                                </v-text-field>

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
                                        data-vv-name="password"
                                        required>
                                </v-text-field>

                                <v-text-field
                                        v-validate.in="'required|min:6|confirmed:password'"
                                        v-model="form.password_confirmation"
                                        type="password"
                                        :error-messages="errors.collect('hasło')"
                                        label="Powtórz hasło"
                                        data-vv-name="password_confirmation"
                                        required>
                                </v-text-field>

                                <div class="button-wrapper">
                                    <v-btn flat class="brown--text" @click="register()">
                                        Zarejestruj
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
    import {register} from '../../helpers/auth';

    export default {
        name: "Register",
        data() {
            return {
                form: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                error: null
            };
        },
        methods: {
            register() {
                this.$store.dispatch('register');

                register(this.$data.form)
                    .then((res) => {
                        this.$store.commit("registerSuccess", res);
                        this.$router.push({path: '/'});
                    })
                    .catch((error) => {
                        this.$store.commit("registerFailed", {error});
                    });
            },
            clearForm() {
                this.form.name = null;
                this.form.email = null;
                this.form.password = null;
                this.form.password_confirmation = null;
            }
        },
        computed: {}
    }
</script>

<style scoped>

</style>