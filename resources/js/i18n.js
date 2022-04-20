import { createI18n } from "vue-i18n";
import en_EN from './locales/en_EN.json'
import fr_FR from './locales/fr_FR.json'

import i18nService from "./services/i18n.service";

const i18n = createI18n({
  locale: i18nService.getActiveLanguage(), // set locale
  fallbackLocale: i18nService.fallbackLocale, // set fallback locale
  messages: {en_EN:en_EN, fr_FR:fr_FR}
})

export default i18n
