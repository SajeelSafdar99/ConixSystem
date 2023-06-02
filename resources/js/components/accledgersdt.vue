<template>
    <div>
        <vue-snotify></vue-snotify>
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


        <div class="row  hidden-print">

            <div class="col-lg">

                <div class="row">
                    <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                        <label class="rdiobox">
                            <input value="0"  v-model="type" name="type" type="radio" ><span class="pabs">All</span>
                        </label>
                    </div>
                    <div class="col-sm-4 mg-t-10 mg-sm-t-0"  v-for="t in types">
                        <label class="rdiobox">
                            <input type="radio"  name="type" v-model="type" :value="t.id" ><span class="pabs">{{t.desc}}</span>
                        </label>
                    </div>

                </div>
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
                    <p style="color: black;">Filters:</p>
                    <select class="form-control" v-model="filter" name="filter" id="filter">
                        <option value="0">All</option>
                        <option v-for="f in t2" :value="f.id">{{f.name}}</option>

                    </select>

                </div>
            </div>

        </div>


        <br>
        <div class="row">
            <div class="col-sm-12">
            <div>
                <button class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Total Credit:
                </button>
            </div>
            <div>
                <button class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Total Debit:
                </button>
            </div>
            <div>
                <button class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Total Balance:
                </button>
            </div>
            </div>
        </div>

        <div class="scrollclasstable1">

            <div>


                <table class="table-striped table-bordered  table-hover">
                    <thead :style="'font-size:15px'">
                    <tr>

                        <th class="wd-5p">SR #</th>
                        <th class="wd-10p">DATE</th>
                        <th class="wd-20p">NAME</th>
                        <th class="wd-5p">M / G TYPE</th>
                        <th class="wd-10p">M / G ID</th>
                        <th class="wd-10p">DETAILS</th>
                        <th class="wd-10p">ACCOUNT TYPE</th>
                        <th class="wd-10p">DEBIT</th>
                        <th class="wd-10p">CREDIT</th>
                        <th class="wd-10p">BALANCE</th>

                    </tr>
                    </thead>
                    <thead>
                    <tr style="background-color: #55bff9 !important;">
                        <td colspan="9" class="text-right"><STRONG>OPENING BALANCE:</STRONG></td>

                        <td colspan="2"  class="text-left balance"><STRONG></STRONG></td>
                    </tr>
                    </thead>
                    <tbody :style="'font-size:15px'">


                    <tr v-for="(tr,key) in

               cm = sliceP(
                     (()=>{
                      let  x=filterData(ledgers);

                   leng=x.length;
                  if(parseInt(leng/pagelength)+((leng%pagelength)>0?1:0)<page){
                      page=1;
                  }

                      //

                     return x;
                    })()

                    )" >
                        <td>{{((page-1)*pagelength)+key+1}}</td>
                        <td>{{moment(tr.date).format('DD/MM/YYYY')}}</td>

                      <td>{{tr.name}}</td>

                        <template v-if="tr.trans_moc_type==1">
                            <td><span class="text-success">(Guest)</span></td>
                        </template>
                        <template v-else-if="tr.trans_moc_type==0">
                            <td><span class="text-success">(Member)</span></td>
                        </template>
                        <template v-else>
                            <td></td>
                        </template>


                            <td>{{tr.mem_no}}</td>


                        <td>{{tr.tname}} {{tr.trans_type_id2}}</td>
                        <td>{{tr.type_name}}</td>

                        <template v-if="tr.debit_or_credit==1">
                            <td>{{tr.debit =0}}</td>
                            <td>{{tr.credit = parseInt(tr.trans_amount)}}</td>
                        </template>
                        <template v-else-if="tr.debit_or_credit==0">
                            <td>{{tr.debit = parseInt(tr.trans_amount)}}</td>
                            <td>{{tr.credit =0}}</td>
                        </template>
                        <template v-else>
                            <td>{{tr.debit =0}}</td>
                            <td>{{tr.credit =0}}</td>
                        </template>

                        <td>{{key==0?tr.b=tr.debit-tr.credit:tr.b=(cm[key-1].b)+(tr.debit-tr.credit)}}</td>


                       </tr>

                    </tbody>
                    <tfoot>
                    <tr style="background-color: #55bff9 !important;">
                        <td colspan="9" class="text-right"><STRONG>CLOSING BALANCE:</STRONG></td>

                        <td colspan="2"  class="text-left balance"><STRONG>{{totals.balance}}</STRONG></td>
                    </tr>
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
                            <option :value="ledgers.length" >ALL</option>
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

</style>
<script>
import Datepicker from 'vuejs-datepicker';
export default {
    name: "accledgersdt",
    components: {
        Datepicker
    },
    data(){
        return{
            disabledDates: {
                from: new Date(),
            },
            types:[],
            type:'0',
            filter:'0',
            page:1,
            pagelength:50,
            leng:0,
            onLine: null,
            onlineSlot: 'online',
            offlineSlot: 'offline',
            ledgers:[],
            ledgersR:[],
            ledgersM: [],
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
            mog:5,
            t2:[]


        }
    },
    computed: {
        totals() {
            let  x=this.filterData(this.ledgers);

            let total=0;
            let paid_amount=0;
            //console.log(1);
            x.forEach(function (item) {
                    if(item.debit_or_credit==1){
                        total=total - parseInt(item.trans_amount?item.trans_amount:0);

                    }

                    else{
                        total=total + parseInt(item.trans_amount?item.trans_amount:0);

                    }
            })
            return {
               balance:total
            }
        }
    },
    methods:{
        filterData(ledgers){
            let   x=ledgers;

            if(this.filter){
                if(this.filter!=0){
                    x=x.filter((a)=>{return a.trans_type2==this.filter});
                }
            else{
                    x=x;
                }
            }
            if(this.type!=0){
                x=x.filter((a)=>{return a.accid==this.type});
            }




            if (this.searchId){
                    x=x.filter((a)=>{return a.trans_moc==this.searchId});
            }


         /*   else{
                x=x;
            }*/
            return x;
        },
        amIOnline(e) {
            this.onLine = e;
        },
        sliceP(ledgers){
            // console.log(123);
            this.ledgersM=ledgers;
            return  ledgers.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
        },
        init:function () {
            let filter='';
            if(this.start_date){
                filter+='&start_date='+moment(this.start_date).format('YYYY-MM-DD');
            }
            if(this.end_date){
                filter+='&end_date='+moment(this.end_date).format('YYYY-MM-DD');

            }
            this.$http.get('/finance-and-management/accounts-ledgers/accledgers_init_vue?1=1'+filter).then(result=>{
                let data=result.data;

                this.types=data.types;
                this.t2=data.types2;
                this.ledgers=data.ledgers;
                this.ledgersR=data.ledgers;
                this.leng=data.ledgers.length;
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
            this.$http.post('/search/customerdata?inv=1&MOC='+v+r,{customerid:val}).then(result=>{
                let data =result.data;

                if(data){
                    this.searchId
                    this.searchId=data.id;

                    if (v == 0) {
                        this.mem_id = data.mem_no;
                        this.mem_id_ = data.id;
                        let fname=data.first_name?data.first_name+' ':'';
                        let mname=data.middle_name?data.middle_name+' ':'';
                        let lname=data.applicant_name?data.applicant_name:'';

                        this.customer = fname+mname+lname;
                        this.guest_contact = data.mob_a;

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
                this.ledgers[k].p=e.target.max;
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
        start_date:function(){
            this.init();
        },
        end_date:function(){
            this.init();
        },
        ledgersM:function(){
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

