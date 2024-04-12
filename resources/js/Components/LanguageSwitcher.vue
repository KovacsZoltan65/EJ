<script>
    import { ref } from 'vue';
    import axios from 'axios';
    import { loadLanguageAsync } from 'laravel-vue-i18n';

    export default {
        setup() {
            return {
                responsiveSettingsLanguage: ref(false)
            }
        },
        methods: {
            setLocale(locale) {
                //console.log('setLocale')
                axios.post(route('language'), { locale: locale })
                .catch(error => {
                    console.log(error);
                });

                //this.$i18n.locale = locale;
                //this.responsiveSettingsLanguage = false;
                //this.$t.setLocale = locale;
                loadLanguageAsync(locale);
            }
        }
    }
</script>
<template>
    <!-- Locale Selector -->
    <div class="space-y-1">
        <button @click="responsiveSettingsLanguage = !responsiveSettingsLanguage">
            {{ $t("languages") }}
        </button>
        <button v-if="responsiveSettingsLanguage" 
                @click="setLocale('en')">
            <p class="ml-4">English</p>
        </button>
        <button v-if="responsiveSettingsLanguage" 
                @click="setLocale('hu')">
            <p class="ml-4">Hungarian</p>
        </button>
    </div>
</template>