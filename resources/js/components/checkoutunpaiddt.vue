<template>
<div>
    <vue-snotify></vue-snotify>
<!--    <div class="hidden-print">
    <v-offline
        online-class="online"
        offline-class="offline"
        @detected-condition="amIOnline">
        <template v-slot:[onlineSlot] :slot-name="onlineSlot">
            ( Online: {{ onLine }} )
        </template>
        <template v-slot:[offlineSlot] :slot-name="offlineSlot">
            ( Online: {{ onLine }} )
        </template>
    </v-offline>
        <br>
    </div>-->


    <div class="row hidden-print">

        <div class="col-lg">
        <div class="row mb-2">

            <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                <label class="rdiobox">
                    <input  type="radio"  name="mog" v-model="mog" value="2"><span class="pabs">All</span>
                </label>
            </div> <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                <label class="rdiobox">
                    <input  type="radio"  name="mog" v-model="mog" value="0"><span class="pabs">Member</span>
                </label>
            </div>
            <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                <label class="rdiobox">
                    <input type="radio" name="mog" v-model="mog" value="1"><span class="pabs">Guest</span>
                </label>
            </div>
        </div>
            <div class="form-group" v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">

                <input style="margin-top: -3px;" v-model="customer" name="name" id="name" value="" class="typeahead form-control" autocomplete="off" type="text" placeholder="Search by Name...">


                <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="customers.length>0 && customer!=''" >

                    <li  :class="'fbb fba'+key"  @click="customerdatavalue(c.id)"  v-on:keyup.enter="customerdatavalue(c.id)" v-for="(c,key) in customers">
                        <a href="javascript:void(0)" v-html="c.name"></a>
                    </li>

                </ul>
            </div>

        </div>



        <div class="col-lg">
                <p style="color: black;">Booking No.</p>
                <input value="" class="form-control tablikebutton"  size="20" type="number"
                       id="booking_no" v-model="booking_no"
                       name="booking_no" placeholder="Search Id...">
        </div>
        <div class="col-lg">
            <div>
                <p style="color: black;">Begin Date:</p>
                <datepicker :disabledDates="disabledDates" v-model="start_date" :clear-button="true" placeholder="From Check-Out Date (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="start_date"></datepicker>

            </div>
        </div>
        <div class="col-lg">
            <div>
                <p style="color: black;">End Date:</p>
                <datepicker :disabledDates="disabledDates" v-model="end_date" :clear-button="true" placeholder="To Check-Out Date (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="end_date"></datepicker>
            </div>
        </div>

        <div class="col-lg">
            <p style="color: black;">Room #:</p>
            <select v-model="roomno" id="roomno" name="roomno" class="form-control">
                <option value="0">Choose Option</option>
                <option v-for="room in roomnos" :value="room.room_no">
                    {{room.room_no}}
                </option>
            </select>
        </div>
<!--        <div class="col-lg">
            <div>
                <p style="color: black;">Status:</p>
                <select v-model="status"  class="form-control">
                    <option v-for="s in ['All','Advance','Paid','Unpaid']">{{s}}</option>
                </select>
            </div>
        </div>-->


           <!-- <div class="col-md-3">
                <label class="rdiobox">
                    <input type="radio" name="type" v-model="type" value="0"><span class="pabs">Member</span></label>
                <label class="rdiobox">
                    <input type="radio" name="type" v-model="type" value="1"><span class="pabs">Guest</span>
                </label>
                <label class="rdiobox">
                    <input type="radio" name="type" v-model="type" value="3"><span class="pabs">Employee</span>
                </label>


            </div>


                <div class="col-lg">

                    <input v-model="customer"  name="name" id="name" value="" class="typeahead form-control" autocomplete="off" type="text" :placeholder="'Search '+(type==0?'Member':type==1?'Guest':'Employee')">


                    <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="customers.length>0">

                        <li @click="customerdatavalue(c.id)" v-for="c in customers">
                            {{c.name}}
                        </li>
                    </ul>

                </div>
-->

    </div>

    <div class="scrollclasstable1">

        <div>


            <table class="table-striped table-bordered table-hover ">
                <thead :style="'font-size:15px'">
                <tr>

                    <th class="wd-5p">SR #</th>
                    <th class="wd-5p">BOOKING #</th>
                    <th class="wd-5p">ROOM #</th>
                    <th class="wd-10p">IN DATE</th>
                    <th class="wd-10p">OUT DATE</th>
                    <th class="wd-15p">MEMBER / GUEST NAME</th>
                    <th class="wd-10p">TYPE</th>
                    <th class="wd-15p">OCCUPIED BY</th>
                    <th class="wd-5p">ROOM RENT</th>
                    <th class="wd-5p">NIGHTS #</th>
                    <th class="wd-10p">CHARGES</th>
                    <th class="wd-10p">OTHER CHARGES</th>
                    <th class="wd-5p">DISC</th>
                    <th class="wd-10p">GRAND TOTAL</th>
                    <th class="wd-10p">AMOUNT PAID</th>
                    <th class="wd-10p">BALANCE</th>
                    <th class="wd-10p">DETAILS</th>
                    <th class="wd-10p">STATUS</th>
                    <th class="wd-5p hidden-print">MARK</th>
                    <th class="wd-10p">USER</th>
                    <th class="wd-5p hidden-print">INVOICE</th>
                    <th class="wd-5p hidden-print">EDIT</th>
                </tr>
                </thead>
                <tbody :style="'font-size:15px'">
                <tr v-for="(tr,key) in

                sliceP(
                     (()=>{
                      let  x=filterData(bookings);

                   leng=x.length;
                  if(parseInt(leng/pagelength)+((leng%pagelength)>0?1:0)<page){
                      page=1;
                  }

                      //

                     return x;
                    })()

                    )" >
                    <td>{{((page-1)*pagelength)+key+1}}</td>
                    <td>{{tr.booking_no}}</td>
                    <td>{{tr.room}}</td>
                    <td>{{moment(tr.check_in_date).format('DD/MM/YYYY')}}</td>
                    <td>{{moment(tr.check_out_date).format('DD/MM/YYYY')}}</td>
                    <td>{{tr.nameMOC}}</td>
                    <template v-if="tr.booking_type==1">
                        <td>Guest ({{tr.customer_id}})</td>
                    </template>
                    <template v-else-if="tr.booking_type==0">
                        <td>Member ({{tr.mem_no}}) - {{tr.activity}}</td>
                    </template>
                    <template v-else><td></td></template>
                    <td>{{tr.first_name}} {{tr.last_name}}</td>
                    <td>{{tr.pday_charges_id}}</td>
                    <td>{{tr.nights}}</td>
                    <td>{{parseInt(tr.charges)}}</td>
                    <td>{{parseInt(tr.total_room_charges)}}</td>
                    <td>{{(tr.discount_amount)}}</td>
                    <td>{{parseInt(tr.grand_total)}}</td>
                    <td>{{tr.paid_amount?parseInt(tr.paid_amount):0}}</td>
                    <td>{{ (tr.grand_total?parseInt(tr.grand_total):0)-(tr.paid_amount?parseInt(tr.paid_amount):0)}}</td>

                    <td style="color:#0053a7;">{{tr.reciept_id}}</td>
                    <template v-if="(parseInt(tr.grand_total-tr.paid_amount))<0">
                        <template v-if="tr.booking_type==1">
                            <td><button class=" btn btn-outline-warning active">Advance</button></td>
                        </template>
                        <template v-else-if="tr.booking_type==0">
                            <td><button class=" btn btn-outline-warning active">Advance</button></td>
                        </template>
                        <template v-else><td></td></template>
                    </template>
                    <template v-else-if="(parseInt(tr.grand_total-tr.paid_amount))>0">
                        <template v-if="tr.booking_type==1">
                        <td><button class="btn btn-sm btn-outline-danger active"><a style="color:white;" target="_blank" :href="'/finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu'+'?'+'guestid=' + tr.customer_id">Unpaid</a></button></td>
                        </template>
                        <template v-else-if="tr.booking_type==0">
                            <td><button class="btn btn-sm btn-outline-danger active"><a style="color:white;" target="_blank" :href="'/finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu'+'?'+'memid=' + tr.member_id">Unpaid</a></button></td>
                        </template>
                        <template v-else><td></td></template>
                   </template>
                    <template v-else>
                        <td><button class=" btn btn-outline-success active">Paid</button></td>
                    </template>

                    <template v-if="tr.is_active==1">
                        <td class="hidden-print"><button type='button' class='btn btn-success btn-sm'><a style="color:white;" :href="'/finance-and-management/finance-cash-receipts/inactivate/' + tr.transid">INV</a></button></td>
                    </template>
                    <template v-else-if="tr.is_active==0">
                        <td class="hidden-print"><button class='btn btn-danger btn-sm'><a style="color:white;" :href="'/finance-and-management/finance-cash-receipts/activate/' + tr.transid">GEN</a></button></td>
                    </template>
                    <template v-else>
                        <td class="hidden-print"><button type='button' class='btn btn-warning btn-sm'>?</button></td>
                    </template>
<td>{{tr.cashiername}}</td>
                    <td class="hidden-print"><button class="buttoncolor" title="Print Invoice"><a style="color:#000000;" target="_blank" :href="'/room-management/room-invoice/' + tr.id"><i class="fa fa-print" aria-hidden="true"></i></a></button></td>
                    <td class="hidden-print"><button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" :href="'/room-management/room-check-out/room-check-out-edit/' + tr.id"><i class="fas fa-edit"></i></a></button></td>
                </tr>

                </tbody>

            </table>
            <div class="pagination">
                    <ul class="pagination">
                        <li :class="page==n?'active':''"  v-for="n in (parseInt(leng/pagelength)+((leng%pagelength)>0?1:0))" @click="page=n"><span  >{{n}} </span></li>
                        <li>
                            <select  v-model="pagelength" class="">
                                <option value="30" >30</option>
                                <option value="50" >50</option>
                                <option value="100" >100</option>
                                <option value="150" >150</option>
                                <option :value="bookings.length" >ALL</option>
                            </select>
                        </li>  </ul>
            </div>

        </div>
    </div>


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
<style scoped>
.table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
    background-color:#bcd3e3;
}
.pagination li {
    padding: 5px 10px;
    border: 1px solid #0a4177;
    margin-right: 2px;
    /* border-radius: 50%; */
    /* height: 40px; */
    /* width: 40px; */
    text-align: center;

    cursor: pointer;
    transition: all 0.3s;
}
.pagination li.active{
    background: #49a2fb;
    color: #fff;
}
.pagination li:hover{
    background: #49a2fb;
    color: #fff;
}

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
/*table thead th{
    position: sticky;
    top: 80px;
    background: #000;
}*/
table th{
    background:#0c3661;
    height: 50px !important;
}
table tfoot{
    background:#0c91ed;
}
table tfoot td{
    color :black !important;
    height: 30px !important;

}

.fbb{
    padding: 0!important;
    border: none!important;
    border-bottom: 1px solid #e7e7e7!important;
}
.fbb a{
    opacity: 1;
    background: #fdf7f7;

    display: block;
    color: #000;
}
.fbb a:focus{
    opacity: 1;
    background:#49a2fb;
    color: #fff;
    font-weight:bold;
}
.areabox{
    padding:0!important
}
</style>
<script>
import Datepicker from 'vuejs-datepicker';
    export default {
        name: "checkoutunpaiddt",
        components: {
            Datepicker
        },
        props: [],
        data(){
            return{
                disabledDates: {
                    from: new Date(),
                },
                status:'Unpaid',
                page:1,
                pagelength:50,
                leng:0,
                onLine: null,
                onlineSlot: 'online',
                offlineSlot: 'offline',
                bookings:[],
                bookingsR:[],
                bookingsM: [],
                booking_no:'',
                start_date:'',
                end_date:'',
                customers:[],
                customer:'',
                mog:2,
                searchId:null,
                fkey:-1,
                ffkey:0,
                roomno:0,
                roomnos:[],

            }
        },
        computed: {
            totals() {
                let  x=this.filterData(this.bookings);

                let charges=0;
                let total_room_charges=0;
                let discount_amount=0;
                let grand_total=0;
                let paid_amount=0;
                //console.log(1);
                 x.forEach(function (item) {

                        charges=charges + parseInt(item.charges?item.charges:0);
                        total_room_charges=total_room_charges + parseInt(item.total_room_charges?item.total_room_charges:0);
                        discount_amount=discount_amount + parseInt(item.discount_amount?item.discount_amount:0);
                        grand_total=grand_total + parseInt(item.grand_total?item.grand_total:0);
                        paid_amount=paid_amount + parseInt(item.paid_amount?item.paid_amount:0);
                        // grand_total:grand_total + parseInt(item.grand_total?item.grand_total:0),

                })
                return {
                    charges:charges,
                    total_room_charges:total_room_charges,
                    discount_amount:discount_amount,
                    grand_total:grand_total,
                    paid_amount:paid_amount,
                }
            }
        },
        methods:{
            fup(){

            },fdown(){
                console.log(1)

            },udf(event){

                if(event==0){
                    if(this.fkey!=this.customers.length){

                        this.fkey=this.fkey+1
                    }
                    $('.fba'+this.fkey +' a').focus();

                    // $('.fba'+this.fkey).focus();
                    // event.preventDefault()
                }if(event==1){

                    if(this.fkey!=-1){

                        this.fkey=this.fkey-1
                    }
                    $('.fba'+this.fkey+' a').focus();

                    // event.preventDefault()
                }




            },
           /* generate: function (theid) {
                let data = {};
                let url = '/finance-and-management/finance-cash-receipts/activate/' + theid;
                data.id = theid;

                this.$http.get(url, data).then(result => {
location.reload();
                });

            },*/
            filterData(bookings){
             let   x=bookings;
                if (this.roomno!=0){
                    x=x.filter((a)=>{return a.room==this.roomno});
                }

                if(this.booking_no){
                    x=x.filter((a)=>{
                        let self = this;
                        return (String(a.booking_no)).startsWith(self.booking_no)});
                }

                if(this.start_date){
                    x=x.filter((a)=>{return moment(a.check_out_date,'YYYY-MM-DD').format('x')>=moment(moment(this.start_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});

                }
                if(this.end_date){
                    /*x=x.filter((a)=>{return moment(a.check_out_date,'YYYY-MM-DD')<=moment(this.end_date)});*/
                    x=x.filter((a)=>{return moment(a.check_out_date,'YYYY-MM-DD').format('x')<=moment(moment(this.end_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
                }  if(this.status){

                    if(this.status=='Paid'){
                        x=x.filter((a)=>{return (parseInt(a.grand_total-a.paid_amount))==0});

                    }   else if(this.status=='Unpaid'){
                        x=x.filter((a)=>{return (parseInt(a.grand_total-a.paid_amount))>0});

                    }   else if(this.status=='Advance'){
                        x=x.filter((a)=>{return (parseInt(a.grand_total-a.paid_amount))<0});

                    }
                    else{
                        x=x;
                    }
                }
                if (this.searchId){
                    if(this.mog==0){
                        x=x.filter((a)=>{return a.member_id==this.searchId});

                    }
                    else{
                        x=x.filter((a)=>{return a.customer_id==this.searchId});

                    }
                }
                if(this.mog!=2) {

                    x=x.filter((a)=>{
                        if(this.mog==1)
                        return a.member_id==null
                        else return a.customer_id==null});

                }
                else{
                    x=x;
                }
                return x;
            },
            amIOnline(e) {
                this.onLine = e;
            },
            sliceP(bookings){
                // console.log(123);
                this.bookingsM=bookings;
              return  bookings.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
            },
            init:function () {

                this.$http.get('/room-management/room-check-out-unpaid/unpaid_init').then(result=>{
                    let data=result.data;

                    this.roomnos=data.roomnos;
                    this.bookings=data.bookings;
                    this.bookingsR=data.bookings;
                    this.leng=data.bookings.length;
                })
            },

            customerdata(){
                let v = this.mog;
                this.$http.post('/search/customerdatalike',{customerid:this.customer,MOC:v}).then(result=>{
                    let data =result.data;
                    if(v==0){
                        data.filter((a)=>{
                            let fname=a.first_name?a.first_name+' ':'';
                            let mname=a.middle_name?a.middle_name+' ':'';
                            let lname=a.applicant_name?a.applicant_name:'';
                            let fullname=fname+mname+lname;

                            a.name=fullname + ':' + a.mem_no + ' ' + '<span style="color: '+a.mem_status.color+'">(' + a.mem_status.desc + ')</span>'
                            a.color=a.mem_status.color
                        })
                    }
                    else if(v==1){
                        data.filter((a)=>{a.name=a.customer_name + ' ' + a.id})
                    }
                    else if(v==3){
                        data.filter((a)=>{a.name=a.name + ' ' + '('+ a.barcode +')'})
                    }
                    if(data){

                        this.customers=data;

                    }
                });

            },
            customerdatavalue(val,m){
                this.customers=[];
                let v = this.mog;
                let r='';

                if(m){
                    r='&r='+m;
                }
                this.$http.post('/search/customerdata?MOC='+v+r,{customerid:val}).then(result=>{
                    let data =result.data;

                    if(data){
                        this.searchId
                        this.families=[];
                        this.searchId=data.id;

                        if (v == 0) {
                            this.mem_id = data.mem_no;
                            this.mem_id_ = data.id;
                            let fname=data.first_name?data.first_name+' ':'';
                            let mname=data.middle_name?data.middle_name+' ':'';
                            let lname=data.applicant_name?data.applicant_name:'';

                            this.customer = fname+mname+lname;
                            this.guest_contact = data.mob_a;
                            // console.log(data);
                            this.families=data.family;

                        }
                        else if (v == 1) {
                            this.customer_id = data.id;
                            this.customer = data.customer_name;
                            this.guest_contact = data.customer_contact;

                        }
                        else if (v == 3) {
                            this.employee_id = data.id;
                            this.customer = data.name;
                            this.guest_contact = data.mob_a;

                        }

                        this.alreadySearched=true;
                    }
                });
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
            bookingsM:function(){
                console.log(1);
            },
            customer:function(){
                if(this.customer.length==0){
                    this.alreadySearched=false;
                    this.searchId=null;
                }

                if(this.customer.length>2 && !this.alreadySearched){
                    this.customerdata();
                }
            },

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

