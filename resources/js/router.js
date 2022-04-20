import AppLayout from "./layout/app/Layout";
import FrontExpertList from "./pages/front/expert/ExpertList";
import FrontExpertView from "./pages/front/expert/ExpertView";
import FrontExpertDisciplineList from "./pages/front/expert/ExpertDisciplineList";
import FrontExpertDisciplineView from "./pages/front/expert/ExpertDisciplineView";
import FrontExpertFormationList from "./pages/front/expert/FormationList";
import FrontExpertConsultation from "./pages/front/expert/ExpertConsultation";
import FrontExpertCalendar from "./pages/front/expert/CalendarView";
import FrontFormationList from "./pages/front/formation/FormationList";
import FrontFormationView from "./pages/front/formation/FormationView";
import FrontCalendarList from "./pages/front/calendar/CalendarList";
import FrontDisciplineList from "./pages/front/discipline/DisciplineList";
import CoursDisciplineList from "./pages/front/discipline/CoursDisciplineList";
import FrontDisciplineView from "./pages/front/discipline/DisciplineView";
import FrontDisciplineExpertView from "./pages/front/discipline/DisciplineExpertView";
import FrontDisciplineCalendar from "./pages/front/discipline/CalendarView";
import FrontDisciplineFormationList from "./pages/front/discipline/FormationList";
import FrontDisciplineExpertList from "./pages/front/discipline/ExpertList";
import FrontProductList from "./pages/front/product/ProductList";
import FrontTarifs from "./pages/front/tarifs/TarifsList";
import FrontCgv from "./pages/front/staticPage/Cgv";
import FrontCgu from "./pages/front/staticPage/Cgu";
import FrontPolitiqueConfidentialite from "./pages/front/staticPage/PolitiqueConfidentialite";
import FrontMentionsLegales from "./pages/front/staticPage/MentionsLegales";
import FrontCart from "./pages/front/checkout/Cart";
import FrontCheckout from "./pages/front/checkout/Checkout";
import FrontVoucher from "./pages/front/checkout/Voucher";
import FrontWelcome from "./pages/front/checkout/Welcome";

import AuthLayout from "./layout/auth/Layout";
import KTLogin from "./pages/auth/login/Login";
import KtLogout from "./pages/auth/login/Logout";
import KTRegister from "./pages/auth/register/Register";
import KTPasswordReset from "./pages/auth/password-reset/PasswordReset";
import KTNewPassword from "./pages/auth/new-password/NewPassword";

import AccountLayout from "./layout/account/Layout";
import Chat from "./pages/chat/Chat";
import ChatCancel from "./pages/chat/ChatCancel";
import Video from "./pages/video/Video";

import CustomerLayout from "./layout/customer/Layout";
import CustomerDashboard from "./pages/customer/dashboard/Dashboard";
import CustomerProfileEdit from "./pages/customer/account/CustomerProfileEdit";
import CustomerAccount from "./pages/customer/account/CustomerAccount";
import CustomerOrderList from "./pages/customer/shop/order/OrderList";
import CustomerOrderView from "./pages/customer/shop/order/OrderView";
import CustomerInvoiceList from "./pages/customer/shop/invoice/InvoiceList";
import CustomerInvoiceView from "./pages/customer/shop/invoice/InvoiceView";
import CustomerSaleFormationList from "./pages/customer/sale/formation/FormationList";
import CustomerSaleFormationListToday from "./pages/customer/sale/formation/FormationListToday";
import CustomerSaleFormationListPast from "./pages/customer/sale/formation/FormationListPast";
import CustomerSaleFormationListFuture from "./pages/customer/sale/formation/FormationListFuture";
import CustomerSaleFormationListAgenda from "./pages/customer/sale/formation/FormationListAgenda";
import CustomerSaleFormationView from "./pages/customer/sale/formation/FormationView";
import CustomerSaleConsultationList from "./pages/customer/sale/consultation/ConsultationList";
import CustomerSaleConsultationListToday from "./pages/customer/sale/consultation/ConsultationListToday";
import CustomerSaleConsultationListPast from "./pages/customer/sale/consultation/ConsultationListPast";
import CustomerSaleConsultationListFuture from "./pages/customer/sale/consultation/ConsultationListFuture";
import CustomerSaleConsultationListAgenda from "./pages/customer/sale/consultation/ConsultationListAgenda";
import CustomerSaleConsultationView from "./pages/customer/sale/consultation/ConsultationView";
import CustomerContactForm from "./pages/customer/contact/ContactForm";

import ExpertLayout from "./layout/expert/Layout";
import ExpertDashboard from "./pages/expert/dashboard/Dashboard";
import ExpertChat from "./pages/expert/chat/ExpertChat";
import ExpertProfileEdit from "./pages/expert/account/ExpertProfileEdit";
import ExpertTimeSlots from "./pages/expert/account/ExpertTimeSlots";
import ExpertDisciplines from "./pages/expert/account/ExpertDisciplines";
import ExpertAccount from "./pages/expert/account/ExpertAccount";
import ExpertFormationList from "./pages/expert/catalog/formation/FormationList";
import ExpertFormationCreate from "./pages/expert/catalog/formation/FormationCreate";
import ExpertFormationView from "./pages/expert/catalog/formation/FormationView";
import ExpertFormationEdit from "./pages/expert/catalog/formation/FormationEdit";
import ExpertSaleFormationList from "./pages/expert/sale/formation/FormationList";
import ExpertSaleFormationListToday from "./pages/expert/sale/formation/FormationListToday";
import ExpertSaleFormationListPast from "./pages/expert/sale/formation/FormationListPast";
import ExpertSaleFormationListFuture from "./pages/expert/sale/formation/FormationListFuture";
import ExpertSaleFormationListAgenda from "./pages/expert/sale/formation/FormationListAgenda";
import ExpertSaleFormationView from "./pages/expert/sale/formation/FormationView";
import ExpertSaleConsultationList from "./pages/expert/sale/consultation/ConsultationList";
import ExpertSaleConsultationListToday from "./pages/expert/sale/consultation/ConsultationListToday";
import ExpertSaleConsultationListPast from "./pages/expert/sale/consultation/ConsultationListPast";
import ExpertSaleConsultationListFuture from "./pages/expert/sale/consultation/ConsultationListFuture";
import ExpertSaleConsultationListAgenda from "./pages/expert/sale/consultation/ConsultationListAgenda";
import ExpertSaleConsultationView from "./pages/expert/sale/consultation/ConsultationView";
import ExpertContactForm from "./pages/expert/contact/ContactForm";
import ExpertInvoiceList from "./pages/expert/shop/invoice/InvoiceList";
import ExpertInvoiceListPing from "./pages/expert/shop/invoice/InvoiceListPing";
import ExpertInvoiceView from "./pages/expert/shop/invoice/InvoiceView";
import ExpertUserView from "./pages/expert/user/UserView";

import AdminLayout from "./layout/admin/Layout";
import AdminDashboard from "./pages/admin/dashboard/Dashboard";
import AdminProfileEdit from "./pages/admin/account/AdminProfileEdit";
import DisciplineList from "./pages/admin/catalog/discipline/DisciplineList";
import DisciplineView from "./pages/admin/catalog/discipline/DisciplineView";
import DisciplineCreate from "./pages/admin/catalog/discipline/DisciplineCreate";
import DisciplineEdit from "./pages/admin/catalog/discipline/DisciplineEdit";
import FormationList from "./pages/admin/catalog/formation/FormationList";
import FormationCreate from "./pages/admin/catalog/formation/FormationCreate";
import FormationView from "./pages/admin/catalog/formation/FormationView";
import FormationEdit from "./pages/admin/catalog/formation/FormationEdit";
import ProductList from "./pages/admin/catalog/product/ProductList";
import ProductCreate from "./pages/admin/catalog/product/ProductCreate";
import ProductView from "./pages/admin/catalog/product/ProductView";
import ProductEdit from "./pages/admin/catalog/product/ProductEdit";
import DurationList from "./pages/admin/catalog/duration/DurationList";
import DurationCreate from "./pages/admin/catalog/duration/DurationCreate";
import DurationView from "./pages/admin/catalog/duration/DurationView";
import DurationEdit from "./pages/admin/catalog/duration/DurationEdit";
import InscriptionList from "./pages/admin/user/inscription/InscriptionList";
import CustomerList from "./pages/admin/user/customer/CustomerList";
import CustomerCreate from "./pages/admin/user/customer/CustomerCreate";
import CustomerEdit from "./pages/admin/user/customer/CustomerEdit";
import CustomerView from "./pages/admin/user/customer/CustomerView";
import ExpertList from "./pages/admin/user/expert/ExpertList";
import ExpertCreate from "./pages/admin/user/expert/ExpertCreate";
import ExpertView from "./pages/admin/user/expert/ExpertView";
import ExpertEdit from "./pages/admin/user/expert/ExpertEdit";
import AdminExpertRatingList from "./pages/admin/user/expert/rating/RatingList";
import AdminExpertInvoiceList from "./pages/admin/user/expert/invoice/InvoiceList";
import AdminExpertInvoiceView from "./pages/admin/user/expert/invoice/InvoiceView";
import AdministratorList from "./pages/admin/user/administrator/AdministratorList";
import AdministratorCreate from "./pages/admin/user/administrator/AdministratorCreate";
import AdministratorView from "./pages/admin/user/administrator/AdministratorView";
import AdministratorEdit from "./pages/admin/user/administrator/AdministratorEdit";
import OrderList from "./pages/admin/shop/order/OrderList";
import OrderView from "./pages/admin/shop/order/OrderView";
import InvoiceList from "./pages/admin/shop/invoice/InvoiceList";
import InvoiceView from "./pages/admin/shop/invoice/InvoiceView";
import ConsultationList from "./pages/admin/sale/consultation/ConsultationList";
import ConsultationView from "./pages/admin/sale/consultation/ConsultationView";
import SaleFormationList from "./pages/admin/sale/formation/FormationList";
import SaleFormationView from "./pages/admin/sale/formation/FormationView";
import CouponList from "./pages/admin/marketing/coupon/CouponList";
import CouponView from "./pages/admin/marketing/coupon/CouponView";
import CouponCreate from "./pages/admin/marketing/coupon/CouponCreate";
import CouponEdit from "./pages/admin/marketing/coupon/CouponEdit";
import VoucherList from "./pages/admin/marketing/voucher/VoucherList";
import VoucherView from "./pages/admin/marketing/voucher/VoucherView";
import VoucherCreate from "./pages/admin/marketing/voucher/VoucherCreate";
import VoucherEdit from "./pages/admin/marketing/voucher/VoucherEdit";
import HomePage from "./pages/front/home/HomePage";
import HoroscopeList from "./pages/admin/zodiac/horoscope/HoroscopeList";
import HoroscopeCreate from "./pages/admin/zodiac/horoscope/HoroscopeCreate";
import HoroscopeView from "./pages/admin/zodiac/horoscope/HoroscopeView";
import HoroscopeEdit from "./pages/admin/zodiac/horoscope/HoroscopeEdit";
import NewsletterList from "./pages/admin/newsletter/NewsletterList";

const {createRouter, createWebHistory} = require("vue-router");

const routes = [
  {
    path: '/account',
    component: AccountLayout,
    meta: {requiresAuth: true},
    children: [
      {path: 'chat', name: 'account.chat', component: Chat, meta: { requiresAuth: true },},
      {path: 'chat/:id', name: 'account.chat.room', component: Chat, meta: { requiresAuth: true },},
      {path: 'rooms/:id/cancel', name: 'account.rooms.cancel', component: ChatCancel, meta: { requiresAuth: true },},
      {path: 'video/:id', name: 'account.video', component: Video, meta: { requiresAuth: true },},
    ]
  },
  {
    path: '/customer',
    component: CustomerLayout,
    meta: {requiresAuth: true},
    children: [
      {path: '', name: 'customer.dashboard', component: CustomerDashboard},
      {path: 'profile/edit', name: 'customer.profile.edit', component: CustomerProfileEdit},
      {path: 'account', name: 'customer.account', component: CustomerAccount},

      {path: 'orders', name: 'customer.orders', component: CustomerOrderList},
      {path: 'orders/:id/view', name: 'customer.orders.view', component: CustomerOrderView},
      {path: 'invoices', name: 'customer.invoices', component: CustomerInvoiceList},
      {path: 'invoices/:id/view', name: 'customer.invoices.view', component: CustomerInvoiceView},

      {path: 'contact', name: 'customer.contact', component: CustomerContactForm},

      {
        path: 'sale/consultations',
        component: CustomerSaleConsultationList,
        children: [
          {path: '', name: 'customer.sale.consultations', component: CustomerSaleConsultationListToday},
          {path: 'past', name: 'customer.sale.consultations.past', component: CustomerSaleConsultationListPast},
          {path: 'future', name: 'customer.sale.consultations.future', component: CustomerSaleConsultationListFuture},
          {path: 'agenda', name: 'customer.sale.consultations.agenda', component: CustomerSaleConsultationListAgenda},
        ],
      },
      {path: 'sale/consultations/:id/view', name: 'customer.sale.consultations.view', component: CustomerSaleConsultationView},
      {
        path: 'sale/formations',
        component: CustomerSaleFormationList,
        children: [
          {path: '', name: 'customer.sale.formations', component: CustomerSaleFormationListToday},
          {path: 'past', name: 'customer.sale.formations.past', component: CustomerSaleFormationListPast},
          {path: 'future', name: 'customer.sale.formations.future', component: CustomerSaleFormationListFuture},
          {path: 'agenda', name: 'customer.sale.formations.agenda', component: CustomerSaleFormationListAgenda},
        ],
      },
      {path: 'sale/formations/:id/view', name: 'customer.sale.formations.view', component: CustomerSaleFormationView},
    ]
  },
  {
    path: '/expert',
    component: ExpertLayout,
    meta: {requiresAuth: true},
    children: [
      {path: '', name: 'expert.dashboard', component: ExpertDashboard},
      {path: 'chat', name: 'expert.chat', component: ExpertChat},
      {path: 'chat/:id', name: 'expert.chat.room', component: ExpertChat},
      {path: 'profile/edit', name: 'expert.profile.edit', component: ExpertProfileEdit},
      {path: 'account', name: 'expert.account', component: ExpertAccount},
      {path: 'account/time-slots', name: 'expert.time-slots', component: ExpertTimeSlots},
      {path: 'account/disciplines', name: 'expert.disciplines', component: ExpertDisciplines},

      {path: 'invoices', name: 'expert.invoices', component: ExpertInvoiceList},
      {path: 'invoices/ping', name: 'expert.invoices.ping', component: ExpertInvoiceListPing},
      {path: 'invoices/:id/view', name: 'expert.invoices.view', component: ExpertInvoiceView},

      {path: 'users/:id/view', name: 'expert.users.view', component: ExpertUserView},

      {path: 'formations', name: 'expert.formations', component: ExpertFormationList},
      {path: 'formations/create', name: 'expert.formations.create', component: ExpertFormationCreate},
      {path: 'formations/:id/view', name: 'expert.formations.view', component: ExpertFormationView},
      {path: 'formations/:id/edit', name: 'expert.formations.edit', component: ExpertFormationEdit},

      {path: 'contact', name: 'expert.contact', component: ExpertContactForm},

      {
        path: 'sale/consultations',
        component: ExpertSaleConsultationList,
        children: [
          {path: '', name: 'expert.sale.consultations', component: ExpertSaleConsultationListToday},
          {path: 'past', name: 'expert.sale.consultations.past', component: ExpertSaleConsultationListPast},
          {path: 'future', name: 'expert.sale.consultations.future', component: ExpertSaleConsultationListFuture},
          {path: 'agenda', name: 'expert.sale.consultations.agenda', component: ExpertSaleConsultationListAgenda},
        ],
      },
      {path: 'sale/consultations/:id/view', name: 'expert.sale.consultations.view', component: ExpertSaleConsultationView},
      {
        path: 'sale/formations',
        component: ExpertSaleFormationList,
        children: [
          {path: '', name: 'expert.sale.formations', component: ExpertSaleFormationListToday},
          {path: 'past', name: 'expert.sale.formations.past', component: ExpertSaleFormationListPast},
          {path: 'future', name: 'expert.sale.formations.future', component: ExpertSaleFormationListFuture},
          {path: 'agenda', name: 'expert.sale.formations.agenda', component: ExpertSaleFormationListAgenda},
        ],
      },
      {path: 'sale/formations/:id/view', name: 'expert.sale.formations.view', component: ExpertSaleFormationView},
    ]
  },
  {
    path: '/admin',
    component: AdminLayout,
    meta: { requiresAuth: true },
    children: [
      {path: '', name: 'admin.dashboard', component: AdminDashboard},
      {path: 'profile/edit', name: 'admin.profile.edit', component: AdminProfileEdit},

      {path: 'inscriptions', name: 'admin.inscriptions', component: InscriptionList},

      {path: 'customers', name: 'admin.customers', component: CustomerList},
      {path: 'customers/create', name: 'admin.customers.create', component: CustomerCreate},
      {path: 'customers/:id/view', name: 'admin.customers.view', component: CustomerView},
      {path: 'customers/:id/edit', name: 'admin.customers.edit', component: CustomerEdit},

      {path: 'experts', name: 'admin.experts', component: ExpertList},
      {path: 'experts/create', name: 'admin.experts.create', component: ExpertCreate},
      {path: 'experts/:id/view', name: 'admin.experts.view', component: ExpertView},
      {path: 'experts/:id/edit', name: 'admin.experts.edit', component: ExpertEdit},

      {path: 'administrators', name: 'admin.administrators', component: AdministratorList},
      {path: 'administrators/create', name: 'admin.administrators.create', component: AdministratorCreate},
      {path: 'administrators/:id/view', name: 'admin.administrators.view', component: AdministratorView},
      {path: 'administrators/:id/edit', name: 'admin.administrators.edit', component: AdministratorEdit},

      {path: 'disciplines', name: 'admin.disciplines', component: DisciplineList},
      {path: 'disciplines/create', name: 'admin.disciplines.create', component: DisciplineCreate},
      {path: 'disciplines/:id/view', name: 'admin.disciplines.view', component: DisciplineView},
      {path: 'disciplines/:id/edit', name: 'admin.disciplines.edit', component: DisciplineEdit},

      {path: 'formations', name: 'admin.formations', component: FormationList},
      {path: 'formations/create', name: 'admin.formations.create', component: FormationCreate},
      {path: 'formations/:id/view', name: 'admin.formations.view', component: FormationView},
      {path: 'formations/:id/edit', name: 'admin.formations.edit', component: FormationEdit},

      {path: 'products', name: 'admin.products', component: ProductList},
      {path: 'products/create', name: 'admin.products.create', component: ProductCreate},
      {path: 'products/:id/view', name: 'admin.products.view', component: ProductView},
      {path: 'products/:id/edit', name: 'admin.products.edit', component: ProductEdit},

      {path: 'durations', name: 'admin.durations', component: DurationList},
      {path: 'durations/create', name: 'admin.durations.create', component: DurationCreate},
      {path: 'durations/:id/view', name: 'admin.durations.view', component: DurationView},
      {path: 'durations/:id/edit', name: 'admin.durations.edit', component: DurationEdit},

      {path: 'orders', name: 'admin.orders', component: OrderList},
      {path: 'orders/:id/view', name: 'admin.orders.view', component: OrderView},
      {path: 'invoices', name: 'admin.invoices', component: InvoiceList},
      {path: 'invoices/:id/view', name: 'admin.invoices.view', component: InvoiceView},

      {path: 'sale/consultations', name: 'admin.sale.consultations', component: ConsultationList},
      {path: 'sale/consultations/:id/view', name: 'admin.sale.consultations.view', component: ConsultationView},
      {path: 'sale/formations', name: 'admin.sale.formations', component: SaleFormationList},
      {path: 'sale/formations/:id/view', name: 'admin.sale.formations.view', component: SaleFormationView},

      {path: 'coupons', name: 'admin.coupons', component: CouponList},
      {path: 'coupons/create', name: 'admin.coupons.create', component: CouponCreate},
      {path: 'coupons/:id/view', name: 'admin.coupons.view', component: CouponView},
      {path: 'coupons/:id/edit', name: 'admin.coupons.edit', component: CouponEdit},

      {path: 'vouchers', name: 'admin.vouchers', component: VoucherList},
      {path: 'vouchers/create', name: 'admin.vouchers.create', component: VoucherCreate},
      {path: 'vouchers/:id/view', name: 'admin.vouchers.view', component: VoucherView},
      {path: 'vouchers/:id/edit', name: 'admin.vouchers.edit', component: VoucherEdit},

      {path: 'experts/ratings', name: 'admin.experts.ratings', component: AdminExpertRatingList},
      {path: 'experts/invoices', name: 'admin.experts.invoices', component: AdminExpertInvoiceList},
      {path: 'experts/invoices/:id/view', name: 'admin.experts.invoices.view', component: AdminExpertInvoiceView},

      {path: 'horoscopes', name: 'admin.horoscopes', component: HoroscopeList},
      {path: 'horoscopes/create', name: 'admin.horoscopes.create', component: HoroscopeCreate},
      {path: 'horoscopes/:id/view', name: 'admin.horoscopes.view', component: HoroscopeView},
      {path: 'horoscopes/:id/edit', name: 'admin.horoscopes.edit', component: HoroscopeEdit},

      {path: 'newsletters', name: 'admin.newsletters', component: NewsletterList},
    ],
  },
  {
    path: '/auth',
    component: AuthLayout,
    children: [
      {path: 'login', name: 'login', component: KTLogin, meta: { requiresGuest: true },},
      {path: 'register', name: 'register', component: KTRegister, meta: { requiresGuest: true },},
      {path: 'password-reset', name: 'password.reset', component: KTPasswordReset, meta: { requiresGuest: true },},
      {path: 'new-password/:email/:token', name: 'new.password', component: KTNewPassword, meta: { requiresGuest: true },},
      {path: 'logout', name: 'logout', component: KtLogout, meta: { requiresAuth: true },},
    ],
  },
  {
    path: '',
    component: AppLayout,
    children: [
      {path: '', name: 'home', component: HomePage},

      {path: 'experts', name: 'front.experts.list', component: FrontExpertList},
      {path: 'experts/:id', name: 'front.experts.view', component: FrontExpertView},

      {path: 'experts/:id/disciplines', name: 'front.experts.disciplines.list', component: FrontExpertDisciplineList},
      {path: 'experts/:id/disciplines/:discipline', name: 'front.experts.disciplines.view', component: FrontExpertDisciplineView},
      {path: 'experts/:id/disciplines/:discipline/calendar', name: 'front.experts.disciplines.calendar', component: FrontExpertCalendar, meta: { requiresAuth: true }},
      {path: 'experts/:id/formations', name: 'front.experts.formations.list', component: FrontExpertFormationList},
      {path: 'experts/:id/consultation', name: 'front.experts.consultation', component: FrontExpertConsultation, meta: { requiresAuth: true }},

      {path: 'formations', name: 'front.formations.list', component: FrontFormationList},
      {path: 'formations/:id', name: 'front.formations.view', component: FrontFormationView},

      {path: 'calendar', name: 'front.calendar', component: FrontCalendarList},
      {path: 'disciplines', name: 'front.disciplines.list', component: FrontDisciplineList},
      {path: 'cours/disciplines', name: 'front.cours.disciplines.list', component: CoursDisciplineList},
      {path: 'disciplines/:id', name: 'front.disciplines.view', component: FrontDisciplineView},
      {path: 'disciplines/:id/formations', name: 'front.disciplines.formations.list', component: FrontDisciplineFormationList},
      {path: 'disciplines/:id/experts', name: 'front.disciplines.experts.list', component: FrontDisciplineExpertList},
      {path: 'disciplines/:id/experts/:expert', name: 'front.disciplines.experts.view', component: FrontDisciplineExpertView},
      {path: 'disciplines/:id/experts/:expert/calendar', name: 'front.disciplines.experts.calendar', component: FrontDisciplineCalendar, meta: { requiresAuth: true }},

      {path: 'products', name: 'front.products.list', component: FrontProductList},

      {path: 'tarifs', name: 'front.tarifs', component: FrontTarifs},
      {path: 'cgu', name: 'front.cgu', component: FrontCgu},
      {path: 'cgv', name: 'front.cgv', component: FrontCgv},
      {path: 'politique-de-confidentialite', name: 'front.politique', component: FrontPolitiqueConfidentialite},
      {path: 'mentions-legales', name: 'front.mentions', component: FrontMentionsLegales},

      {path: 'cart', name: 'front.cart', component: FrontCart},
      {path: 'checkout', name: 'front.checkout', component: FrontCheckout, meta: { requiresAuth: true },},
      {path: 'voucher', name: 'front.voucher', component: FrontVoucher, meta: { requiresAuth: true },},

      {path: 'welcome', name: 'front.welcome', component: FrontWelcome,},

    ],
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes: routes,
})

export default router
