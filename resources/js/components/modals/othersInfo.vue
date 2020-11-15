<template>
    <v-row justify="center">
        <v-dialog v-model="dialogOthers" persistent max-width="600px">
            <v-card>
                <v-toolbar class="mb-2" color="blue darken-1" dark flat>
                    <v-card-title>
                        <span class="headline-bold">Other Information</span>
                    </v-card-title>
                </v-toolbar>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    class="input-name"
                                    v-model="pag_ibig_number"
                                    label="Pag-ibig No."
                                    prepend-icon="mdi-credit-card"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    class="input-name"
                                    v-model="sss_number"
                                    label="SSS No."
                                    prepend-icon="mdi-credit-card"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    class="input-name"
                                    v-model="tin_number"
                                    label="TIN"
                                    prepend-icon="mdi-credit-card"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="6">
                                <v-text-field
                                    class="input-name"
                                    v-model="philhealth_number"
                                    label="PhilHealth No."
                                    prepend-icon="mdi-credit-card"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-btn
                        color="blue darken-1"
                        dark
                         style="float-left"
                        @click="dialogOthers = false"
                    >
                     <v-icon>mdi-arrow-left-bold</v-icon>
                        Back
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue darken-1"
                        dark
                        @click="dialogOthers = false"
                    >
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>
<script>
export default {
    data: () => ({
        dialogOthers: false,
        sss_number: null,
        tin_number: null,
        philhealth_number: null
    }),
    methods: {
        others() {
            this.dialogOthers = true;
        }
    }
};
</script>
