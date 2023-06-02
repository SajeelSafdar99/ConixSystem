<template>
    <div>
        <vue-snotify></vue-snotify>

        <div style="text-align: center; color: black; letter-spacing: 0.2em !important;">
            <h5>ROOM BOOKING</h5>
        </div>
        <section class="content">

            <div class="row"  >
                <div class="col-lg-1 col-xs-1"></div>
                <div class="col-lg-2 col-xs-2">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>
                                {{totals.today_room | numFormat}}
                            </h3>
                            <p>TODAY'S REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <a href="/room-management/room-booking-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-2 col-xs-2">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>
                                {{totals.yes_room | numFormat}}
                            </h3>
                            <p>YESTERDAY'S REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-minus"></i>
                        </div>
                        <a href="/room-management/room-booking-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-xs-2">
                    <div class="small-box bg-light-red">
                        <div class="inner">
                            <h3>
                                {{totals.week_room | numFormat}}
                            </h3>
                            <p>WEEKLY REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-plus"></i>
                        </div>
                        <a href="/room-management/room-booking-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-xs-2">
                    <div class="small-box bg-aqua-two">
                        <div class="inner">
                            <h3>
                                {{totals.month_room | numFormat}}
                            </h3>
                            <p>MONTHLY REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-alt"></i>
                        </div>
                        <a href="/room-management/room-booking-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>

                </div>

                <div class="col-lg-2 col-xs-2">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>
                                {{totals.year_room | numFormat}}
                            </h3>
                            <p>YEARLY REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-check"></i>
                        </div>
                        <a href="/room-management/room-booking-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>

                </div>

                <div class="col-lg-1 col-xs-1"></div>
            </div>

            <div style="text-align: center; color: black; letter-spacing: 0.2em !important;">
                <h5>EVENT BOOKING</h5>
            </div>

            <div class="row"  >
                <div class="col-lg-1 col-xs-1"></div>
                <div class="col-lg-2 col-xs-2">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>
                                {{totals.today_event | numFormat}}
                            </h3>
                            <p>TODAY'S REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <a href="/events-management/event-booking-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-2 col-xs-2">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>
                                {{totals.yes_event | numFormat}}
                            </h3>
                            <p>YESTERDAY'S REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-minus"></i>
                        </div>
                        <a href="/events-management/event-booking-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-xs-2">
                    <div class="small-box bg-light-red">
                        <div class="inner">
                            <h3>
                                {{totals.week_event | numFormat}}
                            </h3>
                            <p>WEEKLY REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-plus"></i>
                        </div>
                        <a href="/events-management/event-booking-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-xs-2">
                    <div class="small-box bg-aqua-two">
                        <div class="inner">
                            <h3>
                                {{totals.month_event | numFormat}}
                            </h3>
                            <p>MONTHLY REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-alt"></i>
                        </div>
                        <a href="/events-management/event-booking-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>

                </div>

                <div class="col-lg-2 col-xs-2">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>
                                {{totals.year_event | numFormat}}
                            </h3>
                            <p>YEARLY REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-check"></i>
                        </div>
                        <a href="/events-management/event-booking-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>

                </div>

                <div class="col-lg-1 col-xs-1"></div>
            </div>


            <div style="text-align: center; color: black; letter-spacing: 0.2em !important;">
                <h5>MONTHLY MAINTENANCE FEE</h5>
            </div>


            <div class="row"  >
                <div class="col-lg-1 col-xs-1"></div>
                <div class="col-lg-2 col-xs-2">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>
                                {{totals.today_fee | numFormat}}
                            </h3>
                            <p>TODAY'S REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <a href="/sports-subscription/maintenance-fee-datatable-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-2 col-xs-2">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>
                                {{totals.yes_fee | numFormat}}
                            </h3>
                            <p>YESTERDAY'S REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-minus"></i>
                        </div>
                        <a href="/sports-subscription/maintenance-fee-datatable-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-xs-2">
                    <div class="small-box bg-light-red">
                        <div class="inner">
                            <h3>
                                {{totals.week_fee | numFormat}}
                            </h3>
                            <p>WEEKLY REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-plus"></i>
                        </div>
                        <a href="/sports-subscription/maintenance-fee-datatable-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-xs-2">
                    <div class="small-box bg-aqua-two">
                        <div class="inner">
                            <h3>
                                {{totals.month_fee | numFormat}}
                            </h3>
                            <p>MONTHLY REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-alt"></i>
                        </div>
                        <a href="/sports-subscription/maintenance-fee-datatable-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>

                </div>

                <div class="col-lg-2 col-xs-2">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>
                                {{totals.year_fee | numFormat}}
                            </h3>
                            <p>YEARLY REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-check"></i>
                        </div>
                        <a href="/sports-subscription/maintenance-fee-datatable-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>

                </div>

                <div class="col-lg-1 col-xs-1"></div>
            </div>


            <div style="text-align: center; color: black; letter-spacing: 0.2em !important;">
                <h5>FOOD & BEVERAGE</h5>
            </div>


            <div class="row"  >
                <div class="col-lg-1 col-xs-1"></div>
                <div class="col-lg-2 col-xs-2">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>
                                {{totals.today_food | numFormat}}
                            </h3>
                            <p>TODAY'S REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <a href="/food-and-beverage/sales-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-2 col-xs-2">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>
                                {{totals.yes_food | numFormat}}
                            </h3>
                            <p>YESTERDAY'S REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-minus"></i>
                        </div>
                        <a href="/food-and-beverage/sales-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-xs-2">
                    <div class="small-box bg-light-red">
                        <div class="inner">
                            <h3>
                                {{totals.week_food | numFormat}}
                            </h3>
                            <p>WEEKLY REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-plus"></i>
                        </div>
                        <a href="/food-and-beverage/sales-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-xs-2">
                    <div class="small-box bg-aqua-two">
                        <div class="inner">
                            <h3>
                                {{totals.month_food | numFormat}}
                            </h3>
                            <p>MONTHLY REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-alt"></i>
                        </div>
                        <a href="/food-and-beverage/sales-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>

                </div>

                <div class="col-lg-2 col-xs-2">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>
                                {{totals.year_food | numFormat}}
                            </h3>
                            <p>YEARLY REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-check"></i>
                        </div>
                        <a href="/food-and-beverage/sales-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>

                </div>
                <div class="col-lg-1 col-xs-1"></div>

            </div>



            <div style="text-align: center; color: black; letter-spacing: 0.2em !important;">
                <h5>STORE SALES</h5>
            </div>


            <div class="row"  >
                <div class="col-lg-1 col-xs-1"></div>
                <div class="col-lg-2 col-xs-2">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>
                                {{totals.today_sale | numFormat}}
                            </h3>
                            <p>TODAY'S REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <a href="/store-management/store-sales-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-2 col-xs-2">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>
                                {{totals.yes_sale | numFormat}}
                            </h3>
                            <p>YESTERDAY'S REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-minus"></i>
                        </div>
                        <a href="/store-management/store-sales-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-xs-2">
                    <div class="small-box bg-light-red">
                        <div class="inner">
                            <h3>
                                {{totals.week_sale | numFormat}}
                            </h3>
                            <p>WEEKLY REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-plus"></i>
                        </div>
                        <a href="/store-management/store-sales-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-xs-2">
                    <div class="small-box bg-aqua-two">
                        <div class="inner">
                            <h3>
                                {{totals.month_sale | numFormat}}
                            </h3>
                            <p>MONTHLY REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-alt"></i>
                        </div>
                        <a href="/store-management/store-sales-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>

                </div>

                <div class="col-lg-2 col-xs-2">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>
                                {{totals.year_sale | numFormat}}
                            </h3>
                            <p>YEARLY REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-check"></i>
                        </div>
                        <a href="/store-management/store-sales-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>

                </div>

                <div class="col-lg-1 col-xs-1"></div>
            </div>


            <div style="text-align: center; color: black; letter-spacing: 0.2em !important;">
                <h5>SPORT SUBSCRIPTIONS</h5>
            </div>


            <div class="row"  >
                <div class="col-lg-1 col-xs-1"></div>
                <div class="col-lg-2 col-xs-2">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>
                                {{totals.today_subs | numFormat}}
                            </h3>
                            <p>TODAY'S REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <a href="/sports-subscription/subscriptions-datatable-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->

                <div class="col-lg-2 col-xs-2">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>
                                {{totals.yes_subs | numFormat}}
                            </h3>
                            <p>YESTERDAY'S REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-minus"></i>
                        </div>
                        <a href="/sports-subscription/subscriptions-datatable-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-xs-2">
                    <div class="small-box bg-light-red">
                        <div class="inner">
                            <h3>
                                {{totals.week_subs | numFormat}}
                            </h3>
                            <p>WEEKLY REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-plus"></i>
                        </div>
                        <a href="/sports-subscription/subscriptions-datatable-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-2 col-xs-2">
                    <div class="small-box bg-aqua-two">
                        <div class="inner">
                            <h3>
                                {{totals.month_subs | numFormat}}
                            </h3>
                            <p>MONTHLY REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-alt"></i>
                        </div>
                        <a href="/sports-subscription/subscriptions-datatable-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>

                </div>

                <div class="col-lg-2 col-xs-2">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>
                                {{totals.year_subs | numFormat}}
                            </h3>
                            <p>YEARLY REVENUE</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-calendar-check"></i>
                        </div>
                        <a href="/sports-subscription/subscriptions-datatable-vue" target="_blank" class="small-box-footer">More Information
                            <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>

                </div>
                <div class="col-lg-1 col-xs-1"></div>

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
    name: "revenuedashboard",
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
            let today_room=0;
            let yes_room=0;
            let week_room=0;
            let month_room=0;
            let year_room=0;
            let today_event=0;
            let yes_event=0;
            let week_event=0;
            let month_event=0;
            let year_event=0;
            let today_fee=0;
            let yes_fee=0;
            let week_fee=0;
            let month_fee=0;
            let year_fee=0;
            let today_food=0;
            let yes_food=0;
            let week_food=0;
            let month_food=0;
            let year_food=0;
            let today_sale=0;
            let yes_sale=0;
            let week_sale=0;
            let month_sale=0;
            let year_sale=0;
            let today_subs=0;
            let yes_subs=0;
            let week_subs=0;
            let month_subs=0;
            let year_subs=0;



            x.forEach(function (item) {
                today_room=today_room + parseInt(item.today_room?item.today_room:0);
                yes_room=yes_room + parseInt(item.yes_room?item.yes_room:0);
                week_room=week_room + parseInt(item.week_room?item.week_room:0);
                month_room=month_room + parseInt(item.month_room?item.month_room:0);
                year_room=year_room + parseInt(item.year_room?item.year_room:0);

                today_event=today_event + parseInt(item.today_event?item.today_event:0);
                yes_event=yes_event + parseInt(item.yes_event?item.yes_event:0);
                week_event=week_event + parseInt(item.week_event?item.week_event:0);
                month_event=month_event + parseInt(item.month_event?item.month_event:0);
                year_event=year_event + parseInt(item.year_event?item.year_event:0);


                today_fee=today_fee + parseInt(item.today_fee?item.today_fee:0);
                yes_fee=yes_fee + parseInt(item.yes_fee?item.yes_fee:0);
                week_fee=week_fee + parseInt(item.week_fee?item.week_fee:0);
                month_fee=month_fee + parseInt(item.month_fee?item.month_fee:0);
                year_fee=year_fee + parseInt(item.year_fee?item.year_fee:0);

                today_food=today_food + parseInt(item.today_food?item.today_food:0);
                yes_food=yes_food + parseInt(item.yes_food?item.yes_food:0);
                week_food=week_food + parseInt(item.week_food?item.week_food:0);
                month_food=month_food + parseInt(item.month_food?item.month_food:0);
                year_food=year_food + parseInt(item.year_food?item.year_food:0);


                today_sale=today_sale + parseInt(item.today_sale?item.today_sale:0);
                yes_sale=yes_sale + parseInt(item.yes_sale?item.yes_sale:0);
                week_sale=week_sale + parseInt(item.week_sale?item.week_sale:0);
                month_sale=month_sale + parseInt(item.month_sale?item.month_sale:0);
                year_sale=year_sale + parseInt(item.year_sale?item.year_sale:0);


                today_subs=today_subs + parseInt(item.today_subs?item.today_subs:0);
                yes_subs=yes_subs + parseInt(item.yes_subs?item.yes_subs:0);
                week_subs=week_subs + parseInt(item.week_subs?item.week_subs:0);
                month_subs=month_subs + parseInt(item.month_subs?item.month_subs:0);
                year_subs=year_subs + parseInt(item.year_subs?item.year_subs:0);

            })
            return {
                today_room:today_room,
                yes_room:yes_room,
                week_room:week_room,
                month_room:month_room,
                year_room:year_room,

                today_event:today_event,
                yes_event:yes_event,
                week_event:week_event,
                month_event:month_event,
                year_event:year_event,

                today_fee:today_fee,
                yes_fee:yes_fee,
                week_fee:week_fee,
                month_fee:month_fee,
                year_fee:year_fee,

                today_food:today_food,
                yes_food:yes_food,
                week_food:week_food,
                month_food:month_food,
                year_food:year_food,

                today_sale:today_sale,
                yes_sale:yes_sale,
                week_sale:week_sale,
                month_sale:month_sale,
                year_sale:year_sale,

                today_subs:today_subs,
                yes_subs:yes_subs,
                week_subs:week_subs,
                month_subs:month_subs,
                year_subs:year_subs,


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
            this.$http.get('/dashboards/revenue-dashboard/dash_init_vue').then(result=>{
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

