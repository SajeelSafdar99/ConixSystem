<template>
    <div>
        <vue-snotify></vue-snotify>
<!--
        <div class="hidden-print">
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
        </div>

-->
        <div v-if="DeleteTheInvoice">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h5 class="modal-title" style="color: black;">ARE YOU SURE ?</h5>
                                    <button type="button" class="close" @click="DeleteTheInvoice=false">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <span style="color: black;">Do you really want to Delete this Expense ?</span>
                                    <br> <br>
                                    <input placeholder="Enter Remarks" class="form-control input-height" v-model="remarks" id="remarks">

                                    <br>

                                </div>
                                <div class="modal-footer">
                                    <button @click="afterdel();" class="btn btn-outline-warning active">Yes</button>
                                    <button type="button" class="btn btn-secondary" @click="DeleteTheInvoice=false">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
        <div class="row  hidden-print">

            <div class="col-lg">
<!--                <p style="color: black;">Name:</p>-->
                <div class="form-group" v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">

                    <input  v-model="customer" name="name" id="name" value="" class="typeahead form-control" autocomplete="off" type="text" placeholder="Search by Name...">


                    <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="customers.length>0 && customer!=''" >

                        <li  :class="'fbb fba'+key"  @click="customerdatavalue(c.id)"  v-on:keyup.enter="customerdatavalue(c.id)" v-for="(c,key) in customers">
                            <a href="javascript:void(0)">   {{c.name}}</a>
                        </li>

                    </ul>
                </div>

            </div>



            <div class="col-lg">
<!--                <p style="color: black;">Voucher No.</p>-->
                <input value="" class="form-control tablikebutton"  size="20" type="number"
                       id="invoice_no" v-model="invoice_no"
                       name="invoice_no" placeholder="Search by Voucher No.">
            </div>
            <div class="col-lg">
                <div>
<!--                    <p style="color: black;">Begin Date:</p>-->
                    <datepicker :disabledDates="disabledDates" v-model="start_date" :clear-button="true" placeholder="From (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="start_date"></datepicker>
                </div>
            </div>
            <div class="col-lg">
                <div>
<!--                    <p style="color: black;">End Date:</p>-->
                   <datepicker :disabledDates="disabledDates" v-model="end_date" :clear-button="true" placeholder="To (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="end_date"></datepicker>
                </div>
            </div>
            <div class="col-lg">
                <div>
<!--                    <p style="color: black;">Status:</p>-->
                    <select v-model="status"  class="form-control">
                        <option v-for="s in ['All','Advance','Paid','Unpaid']">{{s}}</option>
                    </select>
                </div>
            </div>

        </div>



        <div class="scrollclasstable1">

            <div>


                <table class="table-striped table-bordered  table-hover">
                    <thead :style="'font-size:15px'">
                    <tr>

                        <th class="wd-5p">SR #</th>
                        <th class="wd-5p">VOUCHER #</th>
                        <th class="wd-10p">VOUCHER DATE</th>
                        <th class="wd-20p">NAME</th>
                        <th class="wd-10p">LEDGER A/C #</th>
                        <th class="wd-10p">PAYABLE</th>
                        <th class="wd-15p">EXPENSE DETAILS</th>
                        <th class="wd-10p">GRAND TOTAL</th>
                        <th class="wd-10p">AMOUNT PAID</th>
                        <th class="wd-10p">BALANCE</th>
                        <th class="wd-15p">DETAILS</th>
                        <th class="wd-10p">STATUS</th>
                        <th class="wd-10p">USER</th>
                        <th class="wd-5p hidden-print">DOC</th>
                        <th class="wd-5p hidden-print">VOUCHER</th>
                        <th class="wd-5p  hidden-print">EDIT</th>
                        <th class="wd-5p  hidden-print">DELETE</th>
                    </tr>
                    </thead>
                    <tbody :style="'font-size:15px'">
                    <tr v-for="(tr,key) in

                sliceP(
                     (()=>{
                      let  x=filterData(expenses);

                   leng=x.length;
                  if(parseInt(leng/pagelength)+((leng%pagelength)>0?1:0)<page){
                      page=1;
                  }

                      //

                     return x;
                    })()

                    )" >
                        <td>{{((page-1)*pagelength)+key+1}}</td>
                        <td>{{tr.id}}</td>
                        <td>{{moment(tr.invoice_date).format('DD/MM/YYYY')}}</td>

                        <template v-if="tr.person_id!=null">
                            <td>{{tr.personname}}</td>
                        </template>
                        <template v-else>
                            <td></td>
                        </template>

                        <template v-if="tr.person_id!=null">
                            <td>{{tr.person_id}}</td>
                        </template>
                        <template v-else>
                            <td></td>
                        </template>

                        <td>{{tr.type_name}}</td>
                        <td>{{tr.expense_details}}</td>

                        <td>{{parseInt(tr.total) | numFormat }}</td>
                        <td>{{(parseInt(tr.paid_amount)) | numFormat }}</td>
                        <td>{{(parseInt(tr.total)-parseInt(tr.paid_amount)) | numFormat }}</td>

                        <td style="color:#0053a7;">{{tr.reciept_id}}</td>
                        <template v-if="(parseInt(tr.total)-parseInt(tr.paid_amount))<0">
                                <td><button class=" btn btn-outline-warning active">Advance</button></td>
                        </template>
                        <template v-else-if="(parseInt(tr.total)-parseInt(tr.paid_amount))>0">
                            <template v-if="tr.person_id!=null">
                                <td><button class="btn btn-sm btn-outline-danger active"><a style="color:white;" target="_blank" :href="'/finance-and-management/finance-payment-receipts/finance-payment-receipts-aeu'+'?'+'accid=' + tr.person_id">Unpaid</a></button></td>
                            </template>
                            <template v-else><td></td></template>
                        </template>
                        <template v-else>
                            <td><button class=" btn btn-outline-success active">Paid</button></td>
                        </template>
                        <td>{{tr.cashiername}}</td>
                        <td class="hidden-print"><button class="buttoncolor" title="View Expense Documents"><a style="color:#000000;" target="_blank" :href="'/finance-and-management/finance-expenses/finance-expenses-documents/' + tr.id"><i class="fas fa-eye"></i></a></button></td>
                        <td class="hidden-print"><button class="buttoncolor" title="Print Voucher"><a style="color:#000000;" target="_blank" :href="'/finance-and-management/finance-expenses/finance-expenses-invoice/' + tr.id"><i class="fa fa-print" aria-hidden="true"></i></a></button></td>
                        <td class="hidden-print"><button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" :href="'/finance-and-management/finance-expenses/finance-expenses-aeu/' + tr.id"><i class="fas fa-edit"></i></a></button></td>
                    <td class="hidden-print"><button class="buttoncolor" @click="deleteme(tr.id,tr.remarks);" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                    </tr>

                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="7" class="text-right"><strong>TOTAL : </strong></td>
                        <td><strong>{{(totals.total) | numFormat }}</strong></td>
                        <td><strong>{{(totals.paid_amount) | numFormat }}</strong></td>
                        <td><strong>{{ (totals.total-totals.paid_amount) | numFormat }}</strong></td>
                        <td colspan="7"></td>
                    </tr>
                  <!--  <tr>
                        <td colspan="7" class="text-right"></td>
                        <td><strong>{{toWords(totals.total)}}</strong></td>
                        <td><strong>{{toWords(totals.paid_amount)}}</strong></td>
                        <td><strong>{{toWords(totals.total-totals.paid_amount)}}</strong></td>
                        <td colspan="6"></td>
                    </tr>-->
                    </tfoot>
                </table>
                <div class="hidden-print">
                <ul class="pagination hidden-print">
                    <li :class="page==n?'active':''"  v-for="n in (parseInt(leng/pagelength)+((leng%pagelength)>0?1:0))" @click="page=n"><span  >{{n}} </span></li>
                    <li>
                        <select  v-model="pagelength" class="">
                            <option value="30" >30</option>
                            <option value="50" >50</option>
                            <option value="100" >100</option>
                            <option value="150" >150</option>
                            <option :value="expenses.length" >ALL</option>
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
.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    display: table;
    transition: opacity .3s ease;
}
.modal-wrapper {
    display: table-cell;
    vertical-align: middle;
}
</style>
<script>
import Datepicker from 'vuejs-datepicker';
export default {
    name: "expensesdt",
    components: {
        Datepicker
    },
    data(){
        return{
            disabledDates: {
                from: new Date(),
            },
            status:'All',
            page:1,
            pagelength:50,
            leng:0,
            onLine: null,
            onlineSlot: 'online',
            offlineSlot: 'offline',
            expenses:[],
            expensesR:[],
            expensesM: [],
            invoice_no:'',
            start_date:'',
            end_date:'',
            customers:[],
            customer:'',
            mains:[],
            charges:[],
            subscriptions:[],
            details:'0',
            invoice_Date:'',
            searchId:null,
            fkey:-1,
            ffkey:0,
            deletethisid:'',
            DeleteTheInvoice:false,
            remarks:'',
        }
    },
    computed: {
        totals() {
            let  x=this.filterData(this.expenses);

            let total=0;
            let paid_amount=0;
            //console.log(1);
            x.forEach(function (item) {

                total=total + parseInt(item.total?item.total:0);
                paid_amount=paid_amount + parseInt(item.paid_amount?item.paid_amount:0);

            })
            return {
                total:total,
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
        afterdel:function(){
            let data={
                remarks:this.remarks
            };
            let url='/finance-and-management/finance-expenses/delete/'+this.deletethisid;
            if(this.validation(data,['remarks'])==0){
                this.DeleteTheInvoice=false;
                this.$http.post(url,data).then(result=> {
                    this.init();
                });
            }
        },
        deleteme: function (k,com) {
            this.DeleteTheInvoice=true;
            this.deletethisid=k;
            this.remarks=com;
        },
        filterData(expenses){
            let   x=expenses;
            if(this.invoice_no){
                x=x.filter((a)=>{return a.id==this.invoice_no});

            }



            if(this.details){
                if(this.details!=0){
                    x=x.filter((a)=>{return a.charges_type==this.details});
                }
            else{
                    x=x;
                }
            }

            if(this.start_date){
                x=x.filter((a)=>{return moment(a.invoice_date,'YYYY-MM-DD').format('x')>=moment(moment(this.start_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
            }
            if(this.end_date){
                    x=x.filter((a)=>{return moment(a.invoice_date,'YYYY-MM-DD').format('x')<=moment(moment(this.end_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
            }  if(this.status){

                if(this.status=='Paid'){
                    x=x.filter((a)=>{return (parseInt(a.total)-parseInt(a.paid_amount))==0});

                }   else if(this.status=='Unpaid'){
                    x=x.filter((a)=>{return (parseInt(a.total)-parseInt(a.paid_amount))>0});

                }   else if(this.status=='Advance'){
                    x=x.filter((a)=>{return (parseInt(a.total)-parseInt(a.paid_amount))<0});

                }
                else{
                    x=x;
                }
            }
            if (this.searchId){

                    x=x.filter((a)=>{return a.person_id==this.searchId});

            }

            else{
                x=x;
            }
            return x;
        },
        amIOnline(e) {
            this.onLine = e;
        },
        sliceP(expenses){
            // console.log(123);
            this.expensesM=expenses;
            return  expenses.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
        },
        init:function () {

            this.$http.get('/finance-and-management/finance-expenses/expenses_init_vue').then(result=>{
                let data=result.data;

                this.subscriptions=data.subscriptions;
                this.charges=data.charges;
                this.mains=data.mains;
                this.expenses=data.expenses;
                this.expensesR=data.expenses;
                this.leng=data.expenses.length;
            })
        },

        customerdata(){
            let v = 2;
            this.$http.post('/search/customerdatalike',{customerid:this.customer,MOC:v}).then(result=>{
                let data =result.data;
                data.filter((a)=>{a.name=a.person_name + ' ' + a.id})
                if(data){

                    this.customers=data;

                }
            });

        },
        customerdatavalue(val,m){
            this.customers=[];
            let v = 2;
            let r='';

            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/customerdata?inv=1&MOC='+v+r,{customerid:val}).then(result=>{
                let data =result.data;
                if(data){
                    this.families=[];
                    this.searchId=data.id;

                    this.person_id = data.id;
                    this.customer = data.person_name;
                    this.guest_contact = data.person_contact;
                    this.ledger_amount=data.balance;

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
                this.expenses[k].p=e.target.max;
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
        expensesM:function(){
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
