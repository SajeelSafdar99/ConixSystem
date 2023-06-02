<template>
    <div>
        <vue-snotify></vue-snotify>
<!--        <div class="hidden-print">
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


        <div class="row  hidden-print">

            <div class="col-lg">

                <div class="form-group" v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">

                    <input  v-model="customer" name="name" id="name" value="" class="typeahead form-control" autocomplete="off" type="text" placeholder="Search by Name...">


                    <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="customers.length>0 && customer!=''" >

                        <li  :class="'fbb fba'+key"  @click="customerdatavalue(c.id)"  v-on:keyup.enter="customerdatavalue(c.id)" v-for="(c,key) in customers">
                            <a href="javascript:void(0)" v-html="c.name"></a>
                        </li>

                    </ul>
                </div>
            </div>



            <div class="col-lg">
<!--                <p style="color: black;">Invoice No.</p>-->
                <input value="" class="form-control tablikebutton"  size="20" type="number"
                       id="invoice_no" v-model="invoice_no"
                       name="invoice_no" placeholder="Search by Invoice No.">
            </div>
            <div class="col-lg">
                <div>
<!--                    <p style="color: black;">Begin Date:</p>-->
                    <datepicker  :disabledDates="disabledDates" v-model="start_date" :clear-button="true" placeholder="From (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="start_date"></datepicker>
                </div>
            </div>
            <div class="col-lg">
                <div>
<!--                    <p style="color: black;">End Date:</p>-->
                   <datepicker :disabledDates="disabledDates" v-model="end_date" :clear-button="true" placeholder="To (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="end_date"></datepicker>
                </div>
            </div>

          <!--  <div class="col-lg">
                <div>
                    <p style="color: black;">Details:</p>
                    <select v-model="details"  class="form-control">
                        <option value="0">All</option>
                        <optgroup label="Main Charges">
                        <option v-for="main in mains" :value="main.name">{{ main.name }}</option>
                        </optgroup>
                        <optgroup label="Charges Types">
                            <option v-for="charge in charges" :value="charge.name">{{ charge.name }}</option>
                        </optgroup>
                        <optgroup label="Subscription Types">
                            <option v-for="subs in subscriptions" :value="subs.name">{{ subs.name }}</option>
                        </optgroup>
                    </select>
                </div>
            </div>-->
            <div class="col-lg">
                <div>
<!--                    <p style="color: black;">Gender:</p>-->
                    <select v-model="status"  class="form-control">
                        <option v-for="s in ['All Genders','Male','Female','Other']">{{s}}</option>
                    </select>
                </div>
            </div>

        </div>
        <div class="row  hidden-print">
            <div class="col-lg">
<!--                <p style="color: black;">City:</p>-->
                <input value="" class="form-control tablikebutton"  size="20" type="text"
                       id="cityname" v-model="cityname"
                       name="cityname" placeholder="Search by City">
            </div>

            <div class="col-lg">
<!--                <p style="color: black;">Payment Methods:</p>-->
                <multiselect track-by="name" label="name" placeholder="Choose Payment Methods" v-model="payment" :multiple="true" :options="(()=>{let x=[];
            paymentmethods.forEach((a)=>{
                x.push({name:a.name,id:a.id})
            })
            return x;
            })()"></multiselect>
            </div>

            <div class="col-lg">
<!--                <p style="color: black;">Category:</p>-->
                <multiselect track-by="name" label="name" placeholder="Choose Categories" v-model="cate" :multiple="true" :options="(()=>{let x=[];
            categories.forEach((a)=>{
                x.push({name:a.desc,id:a.id})
            })
            return x;
            })()"></multiselect>
            </div>

            <div class="col-lg">

                <multiselect track-by="name" label="name" placeholder="Choose Receiving Cashiers" v-model="rcashier" :multiple="true" :options="(()=>{let x=[];
            users.forEach((a)=>{
                x.push({name:a.name,id:a.id})
            })
            return x;
            })()"></multiselect>
            </div>
        </div>
<br>

        <div style="text-align: center; color: black;" class="print-only">
            <p><strong>( Date = Between {{this.start_date | moment("DD/MM/YYYY")}} To {{this.end_date | moment("DD/MM/YYYY")}}, Name = {{this.customer}}, Invoice # = {{this.invoice_no}}, Gender = {{this.status}}, City = {{this.cityname}}, Payment Method = {{this.pluck(this.payment,'name')}}, Category = {{this.pluck(this.cate,'name')}}, Receiving Cashiers = {{this.pluck(this.rcashier,'name')}} )</strong></p>

        </div>
        <div class="scrollclasstable1">

            <div>


                <table class="table-striped table-bordered  table-hover">
                    <thead :style="'font-size:15px'">
                    <tr>

                        <th class="wd-5p">INVOICE #</th>
                        <th class="wd-10p">ADDRESS (CITY)</th>
                        <th class="wd-20p">MEMBER NAME</th>
                       <!-- <th class="wd-10p">Cash</th>-->
                        <th class="wd-10p">AMOUNT RECEIVED</th>
                        <th class="wd-10p">PAYMENT METHOD</th>
                      <!--  <th class="wd-10p">FAMILY MEMBER</th>
                        <th class="wd-10p">INVOICE DETAILS</th>
                        <th class="wd-10p">DURATION</th>-->
                        <th class="wd-15p">CATEGORY</th>
                        <th class="wd-10p">DATED</th>
                        <th class="wd-15p">DURATION</th>
                        <th class="wd-10p">MEMBERSHIP NO.</th>
                        <th class="wd-10p">R.USER</th>

                    </tr>
                    </thead>
                    <tbody :style="'font-size:15px'">
                    <tr v-for="(tr,key) in

                sliceP(
                     (()=>{
                      let  x=filterData(invoices);

                   leng=x.length;
                  if(parseInt(leng/pagelength)+((leng%pagelength)>0?1:0)<page){
                      page=1;
                  }

                      //

                     return x;
                    })()

                    )" >
                        <td>{{tr.idi}}</td>
                        <td><b>{{tr.mcity}}</b></td>
                        <td v-if="tr.fname!='   '">{{tr.fname}}</td>
                        <td v-else>{{tr.name}}</td>
                        <td>{{tr.total | numFormat }}</td>
  <!--                      <td>{{tr.paidamount}}</td>-->
                        <td>{{tr.paymentMethod}}</td>

                            <td>{{tr.catname}}</td>

                        <td>{{moment(tr.rd).format('DD/MM/YYYY')}}</td>
                        <td>{{moment(tr.start_date).format('MMM')}}-{{moment(tr.end_date).format('MMM')}}-{{moment(tr.end_date).format('YY')}}</td>

<!--                        <td>{{moment(tr.invoice_date).format('DD/MM/YYYY')}}</td>-->






                      <!--  <td>{{tr.tfamily}} {{tr.ffamily}} {{tr.mfamily}} {{tr.lfamily}}</td>
                        <td>{{tr.type_name}}</td>
                        <td>{{moment(tr.start_date).format('DD/MM/YYYY')}} <br> {{moment(tr.end_date).format('DD/MM/YYYY')}}</td>
-->


                    <!--    <template v-if="tr.invoice_type==1">
                            <td> ({{tr.customer_id}})</td>
                        </template>
                        <template v-else-if="tr.invoice_type==0">-->
                        <td> <b>{{tr.mem_no}}</b></td>
                        <td>{{tr.rcashiername}}</td>
                       <!-- </template>
                        <template v-else>
                            <td></td>
                        </template>-->
  </tr>

                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3" class="text-right"><strong>TOTAL : </strong></td>

                        <td><strong>{{totals.amount | numFormat }} ({{totals.c | numFormat }})</strong></td>
                        <td colspan="6"></td>
                    </tr>
                   <!-- <tr>
                        <td colspan="5" class="text-right"></td>
                        <td></td>
                        <td></td>
                        <td><strong>{{toWords(totals.amount)}}</strong></td>
                        <td colspan="2"></td>
                    </tr>-->
                    </tfoot>
                </table>
                <div class="hidden-print">
                <ul class="pagination">
                    <li :class="page==n?'active':''"  v-for="n in (parseInt(leng/pagelength)+((leng%pagelength)>0?1:0))" @click="page=n"><span  >{{n}} </span></li>
                    <li>
                        <select  v-model="pagelength" class="">
                            <option value="30" >30</option>
                            <option value="50" >50</option>
                            <option value="100" >100</option>
                            <option value="150" >150</option>
                            <option :value="invoices.length" >ALL</option>
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
.print-only{
    display: none;
}@media print {
    .no-print {
        display: none;
    }

    .print-only{
        display: block;
    }
}

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
table th{
    background:#288bd0;
    height: 50px !important;
}
table tfoot{
    background:#0c91ed;
}
table tfoot td{
    color :black !important;
    height: 30px !important;

}
table thead th{
    color :black !important;

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
    name: "corporatemaintenancefeedt",
    components: {
        Datepicker
    },
    props: ['csrf'],
    data(){
        return{
            disabledDates: {
                from: new Date(),
            },
            status:'All Genders',
            page:1,
            pagelength:50,
            leng:0,
            onLine: null,
            onlineSlot: 'online',
            offlineSlot: 'offline',
            invoices:[],
            invoicesR:[],
            invoicesM: [],
            invoice_no:'',
            start_date:'',
            end_date:'',
            customers:[],
            customer:'',
            mog:6,
            mains:[],
            charges:[],
            subscriptions:[],
    /*        details:'0',*/
            invoicesYears:[],
            invoice_Date:'',
            searchId:null,
            fkey:-1,
            ffkey:0,
            paymentmethods:[],
            payment:[],
            categories:[],
            cate:[],
            cityname:'',
            rcashier:[],
            users:[],
        }
    },
    computed: {
        totals() {
            let  x=this.filterData(this.invoices);

            let grand_total=0;
            let paid_amount=0;
            //console.log(1);
            x.forEach(function (item) {

                grand_total=grand_total + parseInt(item.total?item.total:0);
                paid_amount=paid_amount + 1;


            })
            return {
                amount:grand_total,
                c:paid_amount,
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
        filterData(invoices){
            let   x=invoices;

            if(this.invoice_no){
              x=x.filter((a)=>{
                    let self = this;
                    return (String(a.idi)).startsWith(self.invoice_no)});
            }

            if(this.cityname){
                x=x.filter((a)=>{
                    let self = this;
                    return (String(a.mcity)).toLowerCase().startsWith(self.cityname.toLowerCase())});
            }


 /*           if(this.details){
                if(this.details!=0){
                    x=x.filter((a)=>{return a.tname==this.details});
                }
            else{
                    x=x;
                }
            }*/

            if(this.rcashier.length>0){
                x=x.filter((a)=>{return this.rcashier.filter((m)=>{
                    return a.ruserid==m.id;
                }).length>0});

            }

            if(this.payment.length>0){
                x=x.filter((a)=>{return this.payment.filter((m)=>{
                    return a.paymentMethod==m.name;
                }).length>0});

            }

            if(this.cate.length>0){
                x=x.filter((a)=>{return this.cate.filter((m)=>{
                    return a.catname==m.name;
                }).length>0});

            }

            if(this.start_date){
                x=x.filter((a)=>{return moment(a.rd,'YYYY-MM-DD').format('x')>=moment(moment(this.start_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
            }
            if(this.end_date){
                    x=x.filter((a)=>{return moment(a.rd,'YYYY-MM-DD').format('x')<=moment(moment(this.end_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
            }  if(this.status){

                if(this.status=='Male'){
                    x=x.filter((a)=>{return a.mfgender?a.mfgender==this.status:a.mgender==this.status});

                }   else if(this.status=='Female'){
                    x=x.filter((a)=>{return a.mfgender?a.mfgender==this.status:a.mgender==this.status});

                } else if(this.status=='Other'){
                    x=x.filter((a)=>{return a.mfgender?a.mfgender==this.status:a.mgender==this.status});

                }
                else{
                    x=x;
                }
            }
            if (this.searchId){
                if(this.mog==0){
                    x=x.filter((a)=>{return a.member_id==this.searchId});

                }

               else if(this.mog==6){
                    x=x.filter((a)=>{return a.corporate_id==this.searchId});

                }
                else{
                    x=x.filter((a)=>{return a.customer_id==this.searchId});

                }
            }
            if(this.mog!=2) {

                x=x.filter((a)=>{
                    if(this.mog>10)
                        return a.member_id==null && a.corporate_id==null;

                    else if(this.mog==0) return a.customer_id==null && a.corporate_id==null;

                    else if(this.mog==6) return a.customer_id==null && a.member_id==null;

                    else return true});

            }
            else{
                x=x;
            }
            return x;
        },
        amIOnline(e) {
            this.onLine = e;
        },
        sliceP(invoices){
            // console.log(123);
            this.invoicesM=invoices;
            return  invoices.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
        },
        init:function () {

            this.$http.get('/sports-subscription/corporate-maintenance-fee-datatable-ini').then(result=>{
                let data=result.data;

                this.invoicesYears=data.invoicesYears;
                this.subscriptions=data.subscriptions;
                this.charges=data.charges;
                this.mains=data.mains;
                this.invoices=data.invoices;
                this.invoicesR=data.invoices;
                this.leng=data.invoices.length;
                this.paymentmethods=data.paymentmethods;
                this.categories=data.categories;
                this.users=data.users;
            })
        },

        customerdata(){
            let v = this.mog;
            this.$http.post('/search/customerdatalike',{customerid:this.customer,MOC:v}).then(result=>{
                let data =result.data;
                if(v==6){
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
            this.$http.post('/search/customerdata?inv=1&MOC='+v+r,{customerid:val}).then(result=>{
                let data =result.data;
                if(data){
                    this.families=[];
                    this.searchId=data.id;

                    if (v == 6) {
                        this.mem_id = data.mem_no;
                        this.mem_id_ = data.id;
                        let fname=data.first_name?data.first_name+' ':'';
                        let mname=data.middle_name?data.middle_name+' ':'';
                        let lname=data.applicant_name?data.applicant_name:'';

                        this.customer = fname+mname+lname;
                        this.guest_contact = data.mob_a;
                        // console.log(data);
                        this.families=data.family;
                        this.ledger_amount=data.balance;

                    }
                    else if (v == 1) {
                        this.customer_id = data.id;
                        this.customer = data.customer_name;
                        this.guest_contact = data.customer_contact;
                        this.ledger_amount=data.balance;

                    }
                    else if (v == 3) {
                        this.employee_id = data.id;
                        this.customer = data.name;
                        this.guest_contact = data.mob_a;
                        this.ledger_amount=data.balance;

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
        invoicesM:function(){
            console.log(1);
        },
        customer:function(){
            if(this.customer.length==0){
                this.alreadySearched=false;
                this.searchId=null
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

