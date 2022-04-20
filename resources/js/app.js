import tzService from "./services/tz.service";
import moment from 'moment-timezone'

require('./bootstrap')

import BaseInput from "./components/form/BaseInput";
import BaseError from "./components/form/BaseError";
import BaseLabel from "./components/form/BaseLabel";
import KtToolbar from "./layout/base/content/Toolbar";
import BtnSubmit from "./components/form/BtnSubmit";
import InputBirthday from "./components/form/InputBirthday";
import InputDate from "./components/form/InputDate";
import InputDateTime from "./components/form/InputDateTime";
import InputTime from "./components/form/InputTime";
import InputError from "./components/form/InputError";
import InputImage from "./components/form/InputImage";
import InputPassword from "./components/form/InputPassword";
import InputSearch from "./components/form/InputSearch";
import InputSelect from "./components/form/InputSelect";
import InputText from "./components/form/InputText";
import BaseAvatar from "./components/utils/BaseAvatar";
import Pagination from "./components/utils/Pagination";
import TimezoneSelect from "./components/utils/TimezoneSelect";
import UserMenu from "./components/utils/UserMenu";

const {createApp} = require("vue");
import App from "./pages/App";
import router from "./router";
import i18n from "./i18n";
import store from "./services/store/store";
import CKEditor from '@ckeditor/ckeditor5-vue';
import i18nService from "./services/i18n.service";

const vm = createApp(App)
vm.use(router)
vm.use(i18n)
vm.use(store)
vm.use(CKEditor)

vm.directive('focus', {
    mounted(el) {
        el.focus()
    }
})

require('moment/locale/fr');
const timezone = tzService.getActiveTimezone(moment.tz.guess())
const locale = i18nService.getActiveLanguage()
moment.locale(locale)
moment.tz.setDefault(timezone)

vm.config.globalProperties.$filters = {
  diff(value) {
    if(value){
      return Math.floor(moment(value).diff(moment()) / 1000)
    }
    return 0;
  },
  isBefore(value) {
    if(value){
      return moment(value).isBefore()
    }
    return false;
  },
  isAfter(value) {
    if(value){
      return moment(value).isAfter()
    }
    return false;
  },
  isPast(value) {
    if(value){
      return moment(value).format("YYYY-MM-DD") < moment().format("YYYY-MM-DD")
    }
    return true;
  },
  formatDayMonth(value) {
    if(value){
      return moment(value).format('DD MMMM')
    }
    return '-';
  },
  formatHour(value) {
    if(value){
      return moment(value).format('HH:mm')
    }
    return '-';
  },
  formatDate(value) {
    if(value){
      return moment(value).format('L')
    }
    return '-';
  },
  formatDateTime(value) {
    if(value){
      return moment(value).format('L HH:mm')
    }
    return '-';
  },
  formatTime(value) {
    if(value){
      return moment(value).format('HH:mm')
    }
    return '-';
  },
  formatDayTz(value) {
    if(value){
      return moment(value).tz(moment.tz.guess()).format('D')
    }
    return '-';
  },
  formatDay(value) {
    if(value){
      return moment(value).format('D')
    }
    return '-';
  },
  formatMonth(value) {
    if(value){
      return moment(value).locale(locale).format('MMM')
    }
    return '-';
  },
  formatWeekDay(value) {
    if(value){
      return moment(value).format('dddd')
    }
    return '-';
  },
  formatDayOfWeek(index) {
    if(index >= 0){
      return moment().day(index).format('dddd');
    }
    return '-';
  },
  format(date, format) {
    if(date){
      return moment(date).locale(locale).format(format)
    }
    return null;
  }
}

vm.component(KtToolbar.name, KtToolbar)
vm.component(BaseError.name, BaseError)
vm.component(BaseInput.name, BaseInput)
vm.component(BaseLabel.name, BaseLabel)
vm.component(BtnSubmit.name, BtnSubmit)
vm.component(InputBirthday.name, InputBirthday)
vm.component(InputDate.name, InputDate)
vm.component(InputDateTime.name, InputDateTime)
vm.component(InputError.name, InputError)
vm.component(InputImage.name, InputImage)
vm.component(InputPassword.name, InputPassword)
vm.component(InputSearch.name, InputSearch)
vm.component(InputSelect.name, InputSelect)
vm.component(InputText.name, InputText)
vm.component(InputTime.name, InputTime)
vm.component(Pagination.name, Pagination)
vm.component(BaseAvatar.name, BaseAvatar)
vm.component(TimezoneSelect.name, TimezoneSelect)
vm.component(UserMenu.name, UserMenu)

vm.mount('#app')
