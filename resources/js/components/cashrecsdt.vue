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

                                    <span style="color: black;">Do you really want to Delete this Receipt ?</span>
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
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                        <label class="rdiobox">
                            <input  type="radio"  name="mog" v-model="mog" value="9"><span class="pabs">All</span>
                        </label>
                    </div> <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                    <label class="rdiobox">
                        <input  type="radio"  name="mog" v-model="mog" value="0"><span class="pabs">Mem</span>
                    </label>
                </div>
                    <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                        <label class="rdiobox">
                            <input  type="radio"  name="mog" v-model="mog" value="6"><span class="pabs">Corporate Mem</span>
                        </label>
                    </div>
                   <div v-for="gt in gts" class="col-sm-2 mg-t-10 mg-sm-t-0">
                        <label class="rdiobox">
                            <input type="radio" name="type" v-model="mog" :value="10+gt.id"><span class="pabs">{{gt.desc}}</span>
                            <br><br>
                        </label>
                    </div>
                  <!--  <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                     <label class="rdiobox">
                         <input type="radio" name="mog" v-model="mog" value="1"><span class="pabs">Guest</span>
                      </label>
                    </div>-->
                    <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                        <label class="rdiobox">
                            <input type="radio" name="mog" v-model="mog" value="3"><span class="pabs">Emp</span>
                        </label>
                    </div>
                </div>
                <div class="form-group" v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">

                    <input  v-model="customer" name="name" id="name" value="" class="typeahead form-control" autocomplete="off" type="text" placeholder="Search by Name...">


                    <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="customers.length>0 && customer!=''" >

                        <li  :class="'fbb fba'+key"  @click="customerdatavalue(c.id)"  v-on:keydown.enter.prevent="customerdatavalue(c.id)"  v-on:keyup.enter.prevent="customerdatavalue(c.id)" v-for="(c,key) in customers">
                            <a href="javascript:void(0)" v-html="c.name"></a>
                        </li>

                    </ul>
                </div>

            </div>



            <div class="col-lg">
                <p style="color: black;">Receipt No.</p>
                <input value="" class="form-control tablikebutton"  size="20" type="number"
                       id="invoice_no" v-model="invoice_no"
                       name="invoice_no" placeholder="Search By ID...">
            </div>
            <div class="col-lg">
                <div>
                    <p style="color: black;">Begin Date:</p>
                    <datepicker :disabledDates="disabledDates" v-model="start_date" :clear-button="true" format="dd/MM/yyyy" input-class="form-control" name="start_date"></datepicker>
                </div>
            </div>
            <div class="col-lg">
                <div>
                    <p style="color: black;">End Date:</p>
                   <datepicker :disabledDates="disabledDates" v-model="end_date" :clear-button="true" format="dd/MM/yyyy" input-class="form-control" name="end_date"></datepicker>
                </div>
            </div>

            <div class="col-lg">
                <div>
                    <p style="color: black;">Receipt Type:</p>
                    <select v-model="details"  class="form-control">
                        <option value="0">All</option>
                        <optgroup label="Main Charges">
                        <option v-for="main in mains" :value="main.id">{{ main.name }}</option>
                        </optgroup>
                        <optgroup label="Charges Types">
                            <option v-for="charge in charges" :value="charge.id">{{ charge.name }}</option>
                        </optgroup>
                        <optgroup label="Subscription Types">
                            <option v-for="subs in subscriptions" :value="subs.id">{{ subs.name }}</option>
                        </optgroup>
                    </select>
                </div>
            </div>   <div class="col-lg">
                <div>
                    <p style="color: black;">Payment Method:</p>
                    <select v-model="acftype"  class="form-control">
                        <option value="0">All</option>
                        <option v-if="acc_permission.indexOf(ac.name+' '+ac.mod_id)!=-1" v-for="ac in accTypes" :value="ac.name">{{ac.name}}</option>
                    </select>
                </div>
            </div>
            <div class="col-xs">
                <div>
                    <p style="color: black;">&nbsp</p>
                    <button type="button" class="btn btn-success" v-on:click="init" >Search</button>

                </div>
            </div>


        </div>



        <div class="scrollclasstable1">

            <div>

                <table class="table-striped table-bordered  table-hover">
                    <thead :style="'font-size:15px'">
                    <tr>

                        <th class="wd-5p">SR #</th>
                        <th class="wd-5p">RECEIPT #</th>
                        <th class="wd-10p">RECEIPT DATE</th>
                        <th class="wd-20p">NAME</th>
                        <th class="wd-10p">TYPE</th>
                        <th class="wd-20p">DETAILS</th>
                        <th class="wd-15p">PAYMENT METHOD</th>
                        <th class="wd-10p">TOTAL</th>
                        <th class="wd-10p">USER</th>
                        <th class="wd-5p hidden-print">INVOICE</th>
                        <th class="wd-5p  hidden-print">EDIT</th>
                        <th class="wd-5p  hidden-print">DELETE</th>
                    </tr>
                    </thead>
                    <tbody :style="'font-size:15px'">
                    <tr v-for="(tr,key) in

                sliceP(
                     (()=>{
                      let  x=filterData(cashrecs);

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

                        <template v-if="tr.mem_number!=null">
                        <td>{{tr.tname}} {{tr.fname}} {{tr.mname}} {{tr.lname}}</td>
                        </template>
                        <template v-else-if="tr.corporate_id!=null">
                            <td>{{tr.ctname}} {{tr.cfname}} {{tr.cmname}} {{tr.clname}}</td>
                        </template>
                        <template v-else-if="tr.customer_id!=null">
                            <td>{{tr.customer}}</td>
                        </template>
                        <template v-else-if="tr.employee_id!=null">
                            <td>{{tr.employee}}</td>
                        </template>
                        <template v-else>
                            <td></td>
                        </template>

                        <template v-if="tr.mem_number!=null">
                            <td>Member ({{tr.mem_no}}) - {{tr.activity}}</td>
                        </template>
                        <template v-else-if="tr.corporate_id!=null">
                            <td>Corporate Member ({{tr.co_mem_no}}) - {{tr.cactivity}}</td>
                        </template>
                        <template v-else-if="tr.customer_id!=null">
                            <template v-if="tr.cgt">
                                <td>{{tr.guesttype}}</td>
                            </template>
                            <template v-else>
                                <td>Guest</td>
                            </template>
                           <!-- <template v-if="tr.cgt==1">
                            <td>Applied Member ({{tr.customer_id}})</td>
                            </template>
                            <template v-else-if="tr.cgt==2">
                            <td>Affiliated Member ({{tr.customer_id}})</td>
                            </template>
                            <template v-else>
                            <td></td>
                            </template>-->
                        </template>
                        <template v-else-if="tr.employee_id!=null">
                            <td>Employee ({{tr.employee_id}})</td>
                        </template>
                        <template v-else>
                            <td></td>
                        </template>

                        <td v-html="tr.tid" style="color:#0053a7;"></td>

                        <td>{{tr.payment_method}}</td>
                        <td>{{(parseInt(tr.total)) | numFormat }}</td>
                        <td>{{tr.cashiername}}</td>
                        <td class="hidden-print"><button class="buttoncolor" title="Print Invoice"><a style="color:#000000;" target="_blank" :href="'/finance-and-management/finance-cash-receipts/finance-cash-receipts-invoice/' + tr.id"><i class="fa fa-print" aria-hidden="true"></i></a></button></td>
                        <td class="hidden-print"><button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" :href="'/finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/' + tr.id"><i class="fas fa-edit"></i></a></button></td>
                    <td class="hidden-print"><button class="buttoncolor" @click="deleteme(tr.id,tr.remarks);" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                    </tr>

                    </tbody>
                    <tfoot>
                    <tr>
                        <td></td>
                        <td colspan="6" class="text-right"><strong>TOTAL : </strong></td>
                        <td><strong>{{(totals.total) | numFormat }}</strong></td>
                        <td colspan="4"></td>
                    </tr>
                   <!-- <tr>

                        <td colspan="7" class="text-right"></td>
                        <td><strong>{{toWords(totals.total)}}</strong></td>
                        <td colspan="3"></td>
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
                            <option :value="cashrecs.length" >ALL</option>
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
export default {
    name: "cashrecsdt",
    props: ['csrf'],
    data(){
        return{
            gts:[],
            disabledDates: {
                from: new Date(),
            },
            page:1,
            pagelength:50,
            leng:0,
            onLine: null,
            onlineSlot: 'online',
            offlineSlot: 'offline',
            cashrecs:[],
            cashrecsR:[],
            cashrecsM: [],
            invoice_no:'',
            start_date:'',
            end_date:'',
            customers:[],
            customer:'',
            mog:9,
            mains:[],
            charges:[],
            subscriptions:[],
            details:'0',
            searchId:null,
            acftype:0,
            accTypes:[],
            detailsAll:[],
            cashrecsL:0,
            acc_permission:'',
            fkey:-1,
            ffkey:0,
            deletethisid:'',
            DeleteTheInvoice:false,
            remarks:'',
            cuss:[],
        }
    },
    computed: {
        totals() {
            let  x=this.filterData(this.cashrecs);

            let total=0;

            x.forEach(function (item) {

                total=total + parseInt(item.total?item.total:0);

            })
            return {
                total:total,
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
            let url='/finance-and-management/finance-cash-receipts/delete/'+this.deletethisid;
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
        filterData(cashrecs){
            let   x=cashrecs;
           /* if(this.invoice_no){
                x=x.filter((a)=>{return a.id==this.invoice_no});

            } if(this.acftype!=0){
                x=x.filter((a)=>{return a.payment_method==this.acftype});

            }

            if (this.searchId){
                if(this.mog=='01'){
                    x=x.filter((a)=>{return a.customer_id==this.searchId});
                }
                else if(this.mog=='02'){
                    x=x.filter((a)=>{return a.customer_id==this.searchId});
                }
                else if(this.mog>10){
                    x=x.filter((a)=>{return a.customer_id==this.searchId});
                }
                if(this.mog==1){
                    x=x.filter((a)=>{return a.customer_id==this.searchId});
                }
                else if(this.mog==0){
                    x=x.filter((a)=>{return a.mem_number==this.searchId});
                }
                else if(this.mog==3){
                    x=x.filter((a)=>{return a.employee_id==this.searchId});
                }
            }
            if(this.mog!=6) {
                x=x.filter((a)=>{
                    if(this.mog=='01'){
                        return (a.mem_number==null) &&
                            (a.person_id==null) &&
                            (a.employee_id==null) &&
                            (a.customer_id!=null)
                    }
                    else if(this.mog=='02'){
                        return a.mem_number==null &&
                            a.person_id==null &&
                            a.employee_id==null &&
                            (a.customer_id!=null)
                        // && (a.customer_id?self.cuss.filter((b)=>{return b.id==a.customer_id})[0].guest_type:0==2)
                    }
                    else if(this.mog>10){
                        return (a.mem_number==null) &&
                            (a.person_id==null) &&
                            (a.employee_id==null) &&
                            (a.customer_id!=null)
                    }
                    else if(this.mog==1){
                        return (a.mem_number==null) &&
                            (a.person_id==null) &&
                            (a.employee_id==null) &&
                            (a.customer_id!=null)
                    }
                    else if(this.mog==0){
                        return a.customer_id==null &&
                        a.person_id==null &&
                        a.employee_id==null
                    }
                    else if(this.mog==3){
                        return a.customer_id==null &&
                        a.person_id==null &&
                        a.mem_number==null
                    }
                });

            }
            if(this.details){
                if(this.details!=0){
                    console.log(this.details);
                    x=x.filter((a)=>{return a.transtype2?a.transtype2.split(',').indexOf(this.details.toString())!=-1:false});
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
            }
            else{
                x=x;
            }*/
            return x;
        },
        amIOnline(e) {
            this.onLine = e;
        },
        sliceP(cashrecs){
            // console.log(123);
            this.cashrecsM=cashrecs;
            return  cashrecs.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
        },
        init:function () {
            let d='';
            if(this.start_date){
                d=d+'&start_date='+moment(this.start_date).format('YYYY-MM-DD');
            }if(this.end_date){
                d=d+'&end_date='+moment(this.end_date).format('YYYY-MM-DD');
            }
            if(this.invoice_no){
                d=d+'&invoiceno='+this.invoice_no;
            }
            if(this.mog){
                d=d+'&mog='+this.mog;
            }
            if(this.searchId){
                d=d+'&mocid='+this.searchId;
            }
            if(this.details!=0){
                d=d+'&details='+this.details;
            }
            if(this.acftype!=0){
                d=d+'&acftype='+this.acftype;
            }
            if(this.start_date ||  this.end_date || this.invoice_no || this.searchId || this.details!=0 || this.acftype!=0 || this.mog!=9){
                d=d+'&r='+1;
            }
            this.$http.get('/finance-and-management/finance-cash-receipts/cashrecs_init?1=1'+d).then(result=>{
                let data=result.data;
                this.gts=data.gts;
                this.cuss=data.cuss;
                this.subscriptions=data.subscriptions;
                this.charges=data.charges;
                this.mains=data.mains;
                this.detailsAll=data.aa;
                this.cashrecs=data.cashrecs;
                this.cashrecsR=data.cashrecs;
                this.leng=data.cashrecs.length;
                this.accTypes=data.accTypes;
                this.acc_permission=data.accpermit;
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
                else if(v==6){
                    data.filter((a)=>{
                        let fname=a.first_name?a.first_name+' ':'';
                        let mname=a.middle_name?a.middle_name+' ':'';
                        let lname=a.applicant_name?a.applicant_name:'';
                        let fullname=fname+mname+lname;

                        a.name=fullname + ':' + a.mem_no + ' ' + '<span style="color: '+a.mem_status.color+'">(' + a.mem_status.desc + ')</span>'
                        a.color=a.mem_status.color
                    })
                }
                else if(v==3){
                    data.filter((a)=>{a.name=a.name + ' ' + '('+ a.barcode +')'})
                }
                else  {
                    data.filter((a)=>{a.name=a.customer_name + ' ' + a.id})
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

                        //this.cashrecs=data.cashrecs;
                    }

                    else if (v == 6) {
                        this.cop_id = data.mem_no;
                        this.cop_id_ = data.id;

                        let fname=data.first_name?data.first_name+' ':'';
                        let mname=data.middle_name?data.middle_name+' ':'';
                        let lname=data.applicant_name?data.applicant_name:'';

                        this.customer = fname+mname+lname;
                        this.guest_contact = data.mob_a;
                        // console.log(data);
                        this.families=data.family;

                        //this.cashrecs=data.cashrecs;
                    }
                    else if (v == 3) {
                        this.employee_id = data.id;
                        this.customer = data.name;
                        this.guest_contact = data.mob_a;

                        //this.cashrecs=data.cashrecs;

                    }
                    else {
                        this.customer_id = data.id;
                        this.customer = data.customer_name;
                        this.guest_contact = data.customer_contact;

                        //this.cashrecs=data.cashrecs;
                    }
                    this.init();
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
                this.cashrecs[k].p=e.target.max;
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
        cashrecsM:function(){
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
        document.addEventListener('keydown', (event)=> {
            if (event.key === 'Enter') {
                if(this.searchId){
                    this.init();
                    event.preventDefault();
                }
                else if(this.start_date ||  this.end_date || this.invoice_no || this.details!=0 || this.acftype!=0 ){
                    this.init();
                    event.preventDefault();
                }
                else if(!this.customer && this.mog!=9){
                    this.init();
                    event.preventDefault();
                }
            }
        });

        if(this.id){
            this.init(this.id);

            // this.init(id.id);

        }
        else{
            this.init();

        }
        /*this.start_date=new Date();
        this.end_date=new Date();*/

    }
}
</script>

