<template>
    <v-container id="input-usage"  fluid>
        <translate-field v-for="(translateObj, ident) in lang_strings" :key='index' :translateObj="translateObj" :ident="ident" :langId="$attrs.langid"></translate-field>
    </v-container>
</template>

<script>
import translateField from './translateField'

export default {
    name: 'translate-editor',
    props: ['lang_strings'],
    components: {
        translateField
    },
    data() {
        return {};
    },
    methods: {},
    created() {}
}
</script>

