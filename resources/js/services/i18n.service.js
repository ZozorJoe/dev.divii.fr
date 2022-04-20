const i18nService = {
  fallbackLocale: "en_EN",
  defaultLanguage: "fr_FR",
  languages: [
    {
      lang: "en_EN",
      name: "English",
      flag: "/svg/flag/united-states.svg"
    },
    {
      lang: "fr_FR",
      name: "Français",
      flag: "/svg/flag/france.svg"
    }
  ],

  /**
   * Keep the active language in the localStorage
   * @param lang
   */
  setActiveLanguage(lang) {
    localStorage.setItem("language", lang);
  },

  /**
   * Get the current active language
   * @returns {string | string}
   */
  getActiveLanguage() {
    if(localStorage.getItem("language")){
      return localStorage.getItem("language");
    }

    if(document.documentElement.lang === 'en-EN'){
      return 'en_EN';
    }

    return this.defaultLanguage;
  }
};

export default i18nService;
