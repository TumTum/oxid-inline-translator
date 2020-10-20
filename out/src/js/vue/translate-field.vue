<template>
    <v-row>
        <v-col cols="12">
            <v-text-field
                type="text"
                v-model="input_text"
                :label="translateObj.from"
                :error-messages="error_messages"
                :messages="messages"
                @keyup.enter="saveString"
            >
                <template v-slot:prepend>
                    <v-icon @click="saveString" color="blue">
                        {{ showSaveButton ()}}
                    </v-icon>
                </template>
            </v-text-field>
        </v-col>
    </v-row>
</template>
<script>
import axios from 'axios'

export default {
    props: ['translateObj', 'ident', 'langId'],
    data: () => ({
        input_text: '',
        prepend_icon_name: 'mdi-content-save-edit',
        error_messages: '',
        messages: ''
    }),

    methods: {
        showSaveButton() {
            return this.input_text !== this.translateObj.to ? this.prepend_icon_name : ''
        },
        async saveString () {
            this.prepend_icon_name = 'mdi-loading';
            this.error_messages = '';

            var bodyFormData = new FormData();
            bodyFormData.append('translation[type]', 'tmtrans')
            bodyFormData.append('translation[adminmode]', 0)
            bodyFormData.append('translation[lang]', this.langId)
            bodyFormData.append('translation[ident]', this.ident)
            bodyFormData.append('newcontent', this.input_text)

            try {
                const { data } = await axios.post(
                    '/index.php?cl=tmTranslator&fnc=' + 'saveTranslatedContent',
                        bodyFormData,
                    {
                        headers: {'Content-Type': 'multipart/form-data' }
                    }
                );

                if (data.error) {
                    this.error_messages = data.error;
                    setTimeout(() => this.error_messages  = '', 4000)
                }
                if (data.content) {
                    this.translateObj.to = this.input_text
                    this.messages = data.content;
                    setTimeout(() => this.messages = '', 2000)
                }
            } catch (err) {
                this.error_messages = err;
                setTimeout(() => this.error_messages  = '', 5000)
                console.error(err);
            } finally {
                this.prepend_icon_name = 'mdi-content-save-edit';
            }
        },
    },
    created() {
        this.$data.input_text = this.$props.translateObj.to
    }
}
</script>
