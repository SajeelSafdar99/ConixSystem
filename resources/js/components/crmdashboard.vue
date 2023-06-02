<template>
    <div>
        <vue-snotify></vue-snotify>

        <section class="content">
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>
                                {{totals.totalled | numFormat}}
                            </h3>
                            <p>TOTAL LEADS</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-tasks"></i>
                        </div>
                        <a href="/crm/leads-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>
                                {{totals.totalopen | numFormat}}
                            </h3>
                            <p>OPEN LEADS</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <a href="/crm/leads-vue" target="_blank" class="small-box-footer">More information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>
                                {{totals.totalinpro | numFormat}}
                            </h3>
                            <p>IN PROCESS LEADS</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <a href="/crm/leads-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-sea-green">
                        <div class="inner">
                            <h3>
                                {{totals.totalmem | numFormat}}
                            </h3>
                            <p>MEMBERSHIPS DONE</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <a href="/crm/leads-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua-two">
                        <div class="inner">
                            <h3>
                                {{totals.totalvis | numFormat}}
                            </h3>
                            <p>TOTAL VISITS</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="/crm/visits-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow-two">
                        <div class="inner">
                            <h3>
                                {{totals.totaltodayvis | numFormat}}
                            </h3>
                            <p>TODAY'S VISITS</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-walking"></i>
                        </div>
                        <a href="/crm/visits-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green-two">
                        <div class="inner">
                            <h3>
                                {{totals.totalyesvis | numFormat}}
                            </h3>
                            <p>YESTERDAY'S VISITS</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-minus"></i>
                        </div>
                        <a href="/crm/visits-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-light-green">
                        <div class="inner">
                            <h3>
                                {{totals.totaltomvis | numFormat}}
                            </h3>
                            <p>TOMORROW'S VISITS</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-plus"></i>
                        </div>
                        <a href="/crm/visits-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>

                </div>

            </div>

            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3>
                                {{totals.totalcal | numFormat}}
                            </h3>
                            <p>TOTAL CALLS</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <a href="/crm/call-details-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-light-red">
                        <div class="inner">
                            <h3>
                                {{totals.totaltodaycal | numFormat}}
                            </h3>
                            <p>TODAY'S CALLS</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <a href="/crm/call-details-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-dark-red">
                        <div class="inner">
                            <h3>
                                {{totals.totalyescal | numFormat}}
                            </h3>
                            <p>YESTERDAY'S CALLS</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <a href="/crm/call-details-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-grey">
                        <div class="inner">
                            <h3>
                                {{totals.totaltodayappvis | numFormat}}
                            </h3>
                            <p>TODAY'S APPEARED VISITS</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <a href="/crm/visits-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>

                </div>
            </div>

            <div class="row">

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-light-yellow">
                        <div class="inner">
                            <h3>
                                {{totals.totalyesappvis | numFormat}}
                            </h3>
                            <p>YESTERDAY'S APPEARED VISITS</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-minus"></i>
                        </div>
                        <a href="/crm/visits-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>

                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>
                                {{complaints | numFormat}}
                            </h3>
                            <p>COMPLAINTS</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-book"></i>
                        </div>
                        <a href="/crm/complaints-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>

                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <h3>
                                {{totals.totaluser | numFormat}}
                            </h3>
                            <p>USERS</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-user"></i>
                        </div>
                        <a href="/admin-settings/users" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

            </div>


        </section>
    </div>
</template>
<style>
.vdp-datepicker__clear-button{

    position: absolute;
    right: 10px;
    top: 5px;
    font-size: 20px;
    color: #000;

}
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>

.groove{
    overflow: auto;
    height: 300px !important;
}
.offline {
    background-color: #fc9842;
    background-image: linear-gradient(315deg, #fc9842 0%, #fe5f75 74%);
}
.online {
    background-color: #00b712;
    background-image: linear-gradient(315deg, #00b712 0%, #5aff15 74%);
}
.small-box {
    border-radius: 2px;
    position: relative;
    display: block;
    margin-bottom: 20px;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}
.small-box h3 {
    font-size: 38px;
    font-weight: bold;
    /* margin: 0 0 10px 0; */
    white-space: nowrap;
    padding: 0;
    color:white;
}
.small-box .icon {
    -webkit-transition: all 0.3s linear;
    -o-transition: all 0.3s linear;
    transition: all 0.3s linear;
    position: absolute;
    top: -10px;
    right: 10px;
    z-index: 0;
    font-size: 90px;
    color: rgba(0, 0, 0, 0.15);
}
.small-box:hover .icon {
    font-size: 95px;
}
.alert .icon {
    margin-right: 10px;
}
.small-box > .inner {
    padding: 10px;
}
.content {
    min-height: 250px;
    padding: 15px;
    margin-right: auto;
    margin-left: auto;
    padding-left: 15px;
    padding-right: 15px;
}
.small-box .small-box-footer {
    position: relative;
    text-align: center;
    padding: 3px 0;
    color: #fff;
    color: rgba(255,255,255,0.8);
    display: block;
    z-index: 10;
    background: rgba(0,0,0,0.1);
    text-decoration: none;
}
.small-box>.small-box-footer:hover {
    color: #fff;
    background: rgba(0,0,0,0.15);
}
.small-box p {
    font-size: 15px;
    color:white;
}
.bg-aqua {
    background-color: #00c0ef !important;
}
.bg-aqua-two {
    background-color: #6a96a0 !important;
}
.bg-red{
    background-color: #dd4b39 !important;
}
.bg-yellow {
    background-color: #f39c12 !important;
}
.bg-yellow-two {
    background-color: #927f92 !important;
}
.bg-green {
    background-color: #00a65a !important;
}
.bg-green-two {
    background-color: #68c39a !important;
}
.bg-light-green{
    background-color: #859a29 !important;
}
.bg-light-red{
    background-color: #dc887e !important;
}
.bg-dark-red{
    background-color: #01a4cc !important;
}
.bg-grey{
    background-color: #617070 !important;
}
.bg-sea-green{
    background-color: #28afa1 !important;
}
.bg-light-yellow{
    background-color: #efac43 !important;
}
.bg-blue {
    background-color: #0073b7 !important;
}
.bg-purple{
    background-color: #708b9ebf !important;
}
.svg-inline--fa {
    margin-top: 14px;
}
</style>
<script>
import Datepicker from 'vuejs-datepicker';
export default {
    name: "crmdashboard",
    components: {
        Datepicker
    },
    props: [],
    json_data: [],
    data(){
        return{
            page:1,
            pagelength:50,
            leng:0,
            onLine: null,
            onlineSlot: 'online',
            offlineSlot: 'offline',
            leads:[],
            leadsR:[],
            leadsM: [],
            barcode:'',
            memberid:'',
            cnic:'',
            contact:'',
            name:'',
            mog:2,
            searchId:null,
            stati:[],
            status:[],
            fkey:-1,
            ffkey:0,
            showModal: false,
            showCallTime: false,
            showVisits: false,
            users:[],
            user:[],
            lead_source:[],
            assigned_to:'0',
            assignthisid:'',
            call_time:'',
            follow_up:'',
            visit_date:'',
            advance_amount:0,
            remaining_amount:0,
            next_visit:'',

            remarks:'',
            call_status:'1',
            responses:[],
            callthisid:'',
            visitthisid:'',
            selected_items:[],
            selected_visits:[],
            start_date:'',
            end_date:'',
            sources:[],
            json_data: [],
            complaints:'',
        }
    },
    computed: {
        totals() {
            let  x=this.leads;

            let totalled=0;
            let totalopen=0;
            let totalinpro=0;
            let totalmem=0;

            let totaluser=0;
            let totalvis=0;
            let totaltodayvis=0;
            let totalyesvis=0;
            let totaltomvis=0;

            let totalcal=0;
            let totaltodaycal=0;
            let totalyescal=0;
            let totaltodayappvis=0;
            let totalyesappvis=0;

            x.forEach(function (item) {
                totalled=totalled + parseInt(item.leadd?item.leadd:0);
                totalopen=totalopen + parseInt(item.opens?item.opens:0);
                totalinpro=totalinpro + parseInt(item.inpro?item.inpro:0);
                totalmem=totalmem + parseInt(item.memberships?item.memberships:0);
                totaluser=totaluser + parseInt(item.user?item.user:0);
                totalvis=totalvis + parseInt(item.visits?item.visits:0);
                totaltodayvis=totaltodayvis + parseInt(item.todayvis?item.todayvis:0);
                totalyesvis=totalyesvis + parseInt(item.yesvis?item.yesvis:0);
                totaltomvis=totaltomvis + parseInt(item.tomvis?item.tomvis:0);

                totalcal=totalcal + parseInt(item.callss?item.callss:0);
                totaltodaycal=totaltodaycal + parseInt(item.todaycal?item.todaycal:0);
                totalyescal=totalyescal + parseInt(item.yescal?item.yescal:0);

                totaltodayappvis=totaltodayappvis + parseInt(item.todayappvis?item.todayappvis:0);
                totalyesappvis=totalyesappvis + parseInt(item.yesappvis?item.yesappvis:0);

            })
            return {
                totalled:totalled,
                totalopen:totalopen,
                totalinpro:totalinpro,
                totalmem:totalmem,
                totaluser:totaluser,
                totalvis:totalvis,
                totaltodayvis:totaltodayvis,
                totalyesvis:totalyesvis,
                totaltomvis:totaltomvis,

                totalcal:totalcal,
                totaltodaycal:totaltodaycal,
                totalyescal:totalyescal,

                totaltodayappvis:totaltodayappvis,
                totalyesappvis:totalyesappvis,
            }
        }
    },
    methods:{
        amIOnline(e) {
            this.onLine = e;
        },
        sliceP(leads){
            // console.log(123);
            this.leadsM=leads;
            return  leads.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
        },

        init:function () {
            this.$http.get('/crm/dashboard/dashboard_init_vue').then(result=>{
                let data=result.data;

                this.leads=data.leads;
                this.complaints=data.complaints;
                this.leadsR=data.leads;
                this.leng=data.leads.length;

            })
        },

        pluck: function (objs, name) {
            var sol = [];
            for(var i in objs){
                if(objs[i].hasOwnProperty(name)){
                    // console.log(objs[i][name]);
                    sol.push(objs[i][name]);
                }
            }
            return sol;
        },
        sum:  function (input){

            if (toString.call(input) !== "[object Array]")
                return false;

            var total =  0;
            for(var i=0;i<input.length;i++)
            {
                if(isNaN(input[i])){
                    continue;
                }
                total += Number(input[i]);
            }
            return total;
        },
        amountChange:function(k,e){
            if(parseInt(e.target.value)>parseInt(e.target.max)){
                this.invoices[k].p=e.target.max;
            }
        }
        ,
        validation:function(data,valid){
            let self=this;
            let  mm=0;
            valid.forEach((a)=> {
                if(data[a]=='' || data[a]==null){
                    self.$snotify.error(a+' is required!');
                    mm++
                }

            })
            return mm;
        },
    },
    watch:{

    },
    mounted() {
        if(this.id){
            this.init(this.id);

            // this.init(id.id);

        }
        else{
            this.init();

        }


    }
}
</script>

