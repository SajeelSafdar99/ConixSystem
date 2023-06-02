/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
const m=require('moment-timezone');

window.Vue = require('vue');
window.moment=m;
Vue.prototype.moment=m;
import axios from 'axios'
import VueAxios from 'vue-axios'
import Snotify from 'vue-snotify';
import 'vue-snotify/styles/material.css';

import "vue-virtual-scroller/dist/vue-virtual-scroller.css";
import VueVirtualScroller from "vue-virtual-scroller";

import Multiselect from 'vue-multiselect';

import numeral from 'numeral';
import numFormat from 'vue-filter-number-format';
import Highcharts from 'highcharts';
import exportingInit from 'highcharts/modules/exporting'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
Vue.component('v-select', vSelect)
exportingInit(Highcharts)
Highcharts.setOptions({
    lang: {
        numericSymbols: null
    },
    time: {
        timezone: 'Asia/Karachi'
    }
});
import VueHighcharts from 'vue-highcharts';

// Main JS (in UMD format)
import VueTimepicker from 'vue2-timepicker'

// CSS
import 'vue2-timepicker/dist/VueTimepicker.css'

import Datepicker from 'vuejs-datepicker';
import datetime from 'vuejs-datetimepicker';

import VueUploadMultipleImage from 'vue-upload-multiple-image'


import Vue from 'vue';
import excel from 'vue-excel-export';

Vue.use(excel);


Vue.use(VueHighcharts, { Highcharts });

Vue.filter('numFormat', numFormat(numeral));

Vue.use(VueVirtualScroller);
Vue.use(require('vue-moment'));
Vue.use(m);
Vue.use(Snotify);

var converter = require('number-to-words');
window.toWords=converter.toWords;
Vue.prototype.toWords=converter.toWords;

Vue.filter('toWords', function (value) {
  if (!value) return '';
  return converter.toWords(value);
})

Vue.use(VueAxios, axios)

Vue.mixin("can", (permissionName) => {
    let hasAccess;
    axios.get(`/permission/${permissionName}`)
        .then(()=> {
            hasAccess = true;
        })
        .catch(()=> {
            hasAccess = false;
        });
    console.log(hasAccess)
    return hasAccess;
});


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
Vue.component('multiselect', Multiselect);
Vue.component('VueUploadMultipleImage', require('vue-upload-multiple-image').default);
Vue.component('VueTimepicker', require('vue2-timepicker').default);
Vue.component('Datepicker', require('vuejs-datepicker').default);
Vue.component('datetime', require('vuejs-datetimepicker').default);
Vue.component('VOffline', require('v-offline').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('invoices', require('./components/invoices.vue').default);
Vue.component('receipts', require('./components/receipts.vue').default);
Vue.component('checkoutdt', require('./components/checkoutdt.vue').default);
Vue.component('invoicesdt', require('./components/invoicesdt.vue').default);
Vue.component('cashrecsdt', require('./components/cashrecsdt.vue').default);
Vue.component('paymentrecsdt', require('./components/paymentrecsdt.vue').default);
Vue.component('salesdt', require('./components/salesdt.vue').default);
Vue.component('saleslistdt', require('./components/saleslistdt.vue').default);
Vue.component('quarterlymaintenancedt', require('./components/quarterlymaintenancedt.vue').default);
Vue.component('quarterlymaintenancerev', require('./components/quarterlymaintenancerev.vue').default);
Vue.component('sales', require('./components/sales').default);
Vue.component('expensesdt', require('./components/expensesdt.vue').default);
Vue.component('ledgersdt', require('./components/ledgersdt.vue').default);
Vue.component('trialbalancedt', require('./components/trialbalancedt.vue').default);
Vue.component('coatrialbalancedt', require('./components/coatrialbalancedt.vue').default);
Vue.component('accledgersdt', require('./components/accledgersdt.vue').default);
Vue.component('membershipdt', require('./components/membershipdt.vue').default);
Vue.component('purchases', require('./components/purchases.vue').default);
Vue.component('dishbreakdown', require('./components/dishbreakdown.vue').default);
Vue.component('restaurantdishbreakdown', require('./components/restaurantdishbreakdown.vue').default);
Vue.component('storepurchasesdt', require('./components/storepurchasesdt.vue').default);
Vue.component('subscriptionsdt', require('./components/subscriptionsdt.vue').default);
Vue.component('soldquantity', require('./components/soldquantity.vue').default);
Vue.component('dumpitems', require('./components/dumpitems.vue').default);
Vue.component('closingsales', require('./components/closingsales.vue').default);
Vue.component('maintenancefeedt', require('./components/maintenancefeedt.vue').default);
Vue.component('cardprintingdt', require('./components/cardprintingdt.vue').default);
Vue.component('shifts', require('./components/shifts.vue').default);
Vue.component('itemssalessummary', require('./components/itemssalessummary.vue').default);
Vue.component('salesdashboard', require('./components/salesdashboard.vue').default);
Vue.component('newinvoicesdt', require('./components/newinvoicesdt.vue').default);
Vue.component('memberactivitiesdt', require('./components/memberactivitiesdt.vue').default);
Vue.component('familymembershipdt', require('./components/familymembershipdt.vue').default);
Vue.component('hourlysales', require('./components/hourlysales.vue').default);
Vue.component('runningsaleslistdt', require('./components/runningsaleslistdt.vue').default);
Vue.component('salesreport', require('./components/salesreport.vue').default);
Vue.component('chartofaccounts', require('./components/chartofaccounts.vue').default);
Vue.component('accountsbalance', require('./components/accountsbalance.vue').default);
Vue.component('weekdaysgraphicalsales', require('./components/weekdaysgraphicalsales.vue').default);
Vue.component('restaurantgraphicalsales', require('./components/restaurantgraphicalsales.vue').default);
Vue.component('subcatgraphicalsales', require('./components/subcatgraphicalsales.vue').default);
Vue.component('cakebooking', require('./components/cakebooking.vue').default);
Vue.component('cakebookingdt', require('./components/cakebookingdt.vue').default);
Vue.component('cancelledcakebookingdt', require('./components/cancelledcakebookingdt.vue').default);
Vue.component('dailycashiersales', require('./components/dailycashiersales.vue').default);
Vue.component('dailyrestaurantsales', require('./components/dailyrestaurantsales.vue').default);
Vue.component('itemdefinitiondt', require('./components/itemdefinitiondt.vue').default);
Vue.component('datedishbreakdown', require('./components/datedishbreakdown.vue').default);
Vue.component('yearlydishbreakdown', require('./components/yearlydishbreakdown.vue').default);
Vue.component('saleserrors', require('./components/saleserrors.vue').default);
Vue.component('storesalesdt', require('./components/storesalesdt.vue').default);
Vue.component('storesales', require('./components/storesales.vue').default);
Vue.component('storeissuenotedt', require('./components/storeissuenotedt.vue').default);
Vue.component('storeissuenote', require('./components/storeissuenote.vue').default);
Vue.component('dishbreakdownpurchases', require('./components/dishbreakdownpurchases.vue').default);
Vue.component('closingpurchases', require('./components/closingpurchases.vue').default);
Vue.component('itemspurchasessummary', require('./components/itemspurchasessummary.vue').default);
Vue.component('purchaseserrors', require('./components/purchaseserrors.vue').default);
Vue.component('dishbreakdownstoresales', require('./components/dishbreakdownstoresales.vue').default);
Vue.component('closingstoresales', require('./components/closingstoresales.vue').default);
Vue.component('itemstoresalesummary', require('./components/itemstoresalesummary.vue').default);
Vue.component('storesaleserrors', require('./components/storesaleserrors.vue').default);
Vue.component('issuenotesummary', require('./components/issuenotesummary.vue').default);
Vue.component('itemissuesummary', require('./components/itemissuesummary.vue').default);
Vue.component('issuenotesummarydetail', require('./components/issuenotesummarydetail.vue').default);
Vue.component('itemissuedetail', require('./components/itemissuedetail.vue').default);
Vue.component('itemdefinitions', require('./components/itemdefinitions.vue').default);

// Vue.component('searchmembers', require('./components/searchmembers.vue').default);
Vue.component('cancelledinvoicesdt', require('./components/cancelledinvoicesdt.vue').default);
Vue.component('kotreport', require('./components/kotreport.vue').default);

Vue.component('employeeattendance', require('./components/employeeattendance.vue').default);
Vue.component('employmentdt', require('./components/employmentdt.vue').default);
Vue.component('employeepayroll', require('./components/employeepayroll.vue').default);
Vue.component('dailyemployeeattendance', require('./components/dailyemployeeattendance.vue').default);
Vue.component('employeesalarydt', require('./components/employeesalarydt.vue').default);
Vue.component('del_employeesalarydt', require('./components/del_employeesalarydt.vue').default);

Vue.component('leadsdt', require('./components/leadsdt.vue').default);
Vue.component('leads', require('./components/leads.vue').default);
Vue.component('followupsdt', require('./components/followupsdt.vue').default);
Vue.component('visitsdt', require('./components/visitsdt.vue').default);
Vue.component('bdreport', require('./components/bdreport.vue').default);
Vue.component('crmdashboard', require('./components/crmdashboard.vue').default);
Vue.component('calldetailsdt', require('./components/calldetailsdt.vue').default);
Vue.component('complaintsdt', require('./components/complaintsdt.vue').default);
Vue.component('del_complaintsdt', require('./components/del_complaintsdt.vue').default);
Vue.component('complaints', require('./components/complaints.vue').default);

Vue.component('employeeinout', require('./components/employeeinout.vue').default);
Vue.component('employeeinoutdt', require('./components/employeeinoutdt.vue').default);
Vue.component('del_employeeinoutdt', require('./components/del_employeeinoutdt.vue').default);
Vue.component('leadreport', require('./components/leadreport.vue').default);
Vue.component('memberrecoveriesdt', require('./components/memberrecoveriesdt.vue').default);

Vue.component('roombookingdt', require('./components/roombookingdt.vue').default);
Vue.component('roomtablemappingdt', require('./components/roomtablemappingdt.vue').default);
Vue.component('checkoutunpaiddt', require('./components/checkoutunpaiddt.vue').default);
Vue.component('coa', require('./components/COA.vue').default);

Vue.component('paymentsheet', require('./components/paymentsheet.vue').default);
Vue.component('cancelremarks', require('./components/cancelremarks.vue').default);
Vue.component('cancelremarksdt', require('./components/cancelremarksdt.vue').default);
Vue.component('del_cancelremarksdt', require('./components/del_cancelremarksdt.vue').default);

Vue.component('workordersheetdt', require('./components/workordersheetdt.vue').default);
Vue.component('workordersheet', require('./components/workordersheet.vue').default);

Vue.component('eventbookingdt', require('./components/eventbookingdt.vue').default);
Vue.component('cancelledeventbookingdt', require('./components/cancelledeventbookingdt.vue').default);
Vue.component('eventcheckoutdt', require('./components/eventcheckoutdt.vue').default);

Vue.component('pendingmaintenancedt', require('./components/pendingmaintenancedt.vue').default);
Vue.component('categorypendingmaintenancedt', require('./components/categorypendingmaintenancedt.vue').default);

Vue.component('revenuesummary', require('./components/revenuesummary.vue').default);
Vue.component('memberrevenuesummary', require('./components/memberrevenuesummary.vue').default);

Vue.component('carddetail', require('./components/carddetail.vue').default);
Vue.component('suppcarddetail', require('./components/suppcarddetail.vue').default);

Vue.component('transactionbook', require('./components/transactionbook.vue').default);
Vue.component('cashbook', require('./components/cashbook.vue').default);
Vue.component('bankledger', require('./components/bankledger.vue').default);
Vue.component('paymentsheetdt', require('./components/paymentsheetdt.vue').default);

Vue.component('coanew', require('./components/COAnew.vue').default);
Vue.component('employeefoodbills', require('./components/employeefoodbills.vue').default);
Vue.component('employeetotalfoodbills', require('./components/employeetotalfoodbills.vue').default);


Vue.component('membershipsummary', require('./components/membershipsummary.vue').default);
Vue.component('categorymembershipsummary', require('./components/categorymembershipsummary.vue').default);

Vue.component('subscriptionsummary', require('./components/subscriptionsummary.vue').default);
Vue.component('catsubscriptionsummary', require('./components/catsubscriptionsummary.vue').default);

Vue.component('usershifts', require('./components/usershifts.vue').default);
Vue.component('coadt', require('./components/coadt.vue').default);
Vue.component('invoicesprint', require('./components/invoicesprint.vue').default);

Vue.component('coaledgersdt', require('./components/coaledgersdt.vue').default);
Vue.component('monthlystorereport', require('./components/monthlystorereport.vue').default);

Vue.component('supledgersdt', require('./components/supledgersdt.vue').default);
Vue.component('suptrialbalancedt', require('./components/suptrialbalancedt.vue').default);

Vue.component('accledgerdt', require('./components/accledgerdt.vue').default);
Vue.component('acctrialbalancedt', require('./components/acctrialbalancedt.vue').default);
Vue.component('availablemems', require('./components/availablemems.vue').default);
Vue.component('financeinvoices', require('./components/financeinvoices.vue').default);

Vue.component('itemsaleclosingstock', require('./components/itemsaleclosingstock.vue').default);
Vue.component('itemissueclosingstock', require('./components/itemissueclosingstock.vue').default);
Vue.component('itemissueclosingstockdetails', require('./components/itemissueclosingstockdetails.vue').default);
Vue.component('itemsaleclosingstockdetails', require('./components/itemsaleclosingstockdetails.vue').default);

Vue.component('newpendingmaintenancedt', require('./components/newpendingmaintenancedt.vue').default);
Vue.component('newcategorypendingmaintenancedt', require('./components/newcategorypendingmaintenancedt.vue').default);
Vue.component('revenuedashboard', require('./components/revenuedashboard.vue').default);
Vue.component('roomcalendar', require('./components/roomcalendar.vue').default);
Vue.component('runningorders', require('./components/runningorders.vue').default);


Vue.component('corporatemembershipdt', require('./components/corporatemembershipdt.vue').default);
Vue.component('reinstatingfeedt', require('./components/reinstatingfeedt.vue').default);


Vue.component('corporatemaintenancefeedt', require('./components/corporatemaintenancefeedt.vue').default);
Vue.component('corporatecardprintingdt', require('./components/corporatecardprintingdt.vue').default);

Vue.component('corporatereinstatingfeedt', require('./components/corporatereinstatingfeedt.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.config.devtools = true
moment.tz.setDefault('Asia/Karachi');
const app = new Vue({
    el: '#app',
});
