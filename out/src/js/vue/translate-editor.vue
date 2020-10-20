<template>
    <v-container id="input-usage"  fluid>
        <translate-field v-for="(translateObj, ident) in lang_strings" :translateObj="translateObj" :ident="ident" :langId="$attrs.langid"></translate-field>
    </v-container>
</template>
<script>
export default {
    props: ['lang_strings'],
    data() {
        return {};
    },
    methods: {},
    created() {}
}
</script>
