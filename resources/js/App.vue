<template>
    <div>
        <v-main>
            <v-container class="fill-height" fluid>
                <router-view>
                </router-view>
            </v-container>
            <sidebar />
        </v-main>
    </div>
</template>
<script>
import Vuetify from "vuetify";
import sidebar from "./modules/sidebar.vue";
export default {
    name: "app",
    components: {
        sidebar
        // dashboard
    }
}
</script>  