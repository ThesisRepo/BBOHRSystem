<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" persistent max-width="600px">
            <template v-slot:activator="{ on, attrs}">
               <v-btn  color = "primary" rounded large dark v-bind="attrs" v-on="on">
                   <v-icon left>mdi-pencil</v-icon> Edit Picture
                </v-btn>
            </template>
        </v-dialog>
    </v-row>
</template>

<script>
export default {
    data: () => ({
        dialog: false
    }),
}
</script>
