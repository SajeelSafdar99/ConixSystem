<template>
<div>
    <vue-snotify></vue-snotify>


<form  @submit.prevent="init()">
    <div  class="row hidden-print">
        <div class="col-lg">
            <div>
                <datepicker  :disabledDates="disabledDates" v-model="start_date" :clear-button="true" placeholder="Date (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="start_date"></datepicker>
            </div>
        </div>
        <div class="col-lg">
            <!-- <p style="color: black;">Category:</p>-->
            <multiselect track-by="name" label="name" placeholder="Choose Category" v-model="category" :multiple="true" :options="(()=>{let x=[];
            categories.forEach((a)=>{
                x.push({name:a.desc+' '+'-'+' '+a.unique_code,id:a.id})
            })
            return x;
            })()"></multiselect>


        </div>

        <div class="col-lg">
            <!-- <p style="color: black;">Status:</p>-->
            <multiselect track-by="name" label="name" placeholder="Choose Status" v-model="memstatus" :multiple="true" :options="(()=>{let x=[];
            stati.forEach((a)=>{
                x.push({name:a.desc,id:a.id})
            })
            return x;
            })()"></multiselect>


        </div>

    </div>
    <div><br></div>
        <div  class="row hidden-print">

        <div class="col-sm">
            <div class="form-group">
                <input v-model="barcode" placeholder="Search Barcode" autocomplete="off" type="text" class="form-control" id="barcode" name="barcode">
            </div>
        </div>

        <div class="col-sm">
            <div class="form-group">
                <input v-model="searchid"  placeholder="Search Member ID" type="text" class="form-control" id="searchid" name="searchid">
            </div>
        </div>

        <div class="col-sm">
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

        <div class="col-sm">
            <div class="form-group">
                <input v-model="cnic" placeholder="Search CNIC" type="text" class="form-control" id="cnic" name="cnic">
            </div>
        </div>
        <div class="col-sm">
            <div class="form-group">
                <input v-model="contact" placeholder="Search Contact (Primary)" type="text" class="form-control" id="contact" name="contact">
            </div>
        </div>
            <div class="col-sm">
                <div class="form-group">
                    <select class="form-control" v-model="quarter">
                        <!--                    <option value="0">Select Quarter</option>-->
                        <option :value="key" v-for="(y,key) in {1:'qt1',2:'qt2',3:'qt3',4:'qt4',5:'qt5',6:'qt6',7:'More than 6 qts'}">{{y}}</option>
                    </select>
                </div>
            </div>
            <div class="col-xs">

               <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> </button>

        </div>
            &nbsp
            <div class="col-xs" >
                <form  method="post" action="/finance-and-management/maintenance-fee-posting/printall2">

                    <input type="hidden" name="_token" :value="csrf">
                    <input type="hidden" name="ids" :value="ids">
                    <button   type="submit" title="print"
                              class="btn btn-success"> Print All
                    </button>
                </form>

            </div>






    </div>
</form>


    <div style="text-align: center; color: black;" class="print-only">
        <p><strong>( Date = {{this.start_date | moment("DD/MM/YYYY")}}, Category = {{this.pluck(this.category,'name')}}, Status = {{this.pluck(this.memstatus,'name')}}, Barcode = {{this.barcode}}, Member ID = {{this.searchid}}, Name = {{this.customer}}, CNIC = {{this.cnic}}, Contact = {{this.contact}}, Quarter = {{this.quarter}} )</strong></p>

    </div>

    <table class="table-striped table-bordered table-hover ">
                <thead :style="'font-size:15px'">
                <tr>
                    <th class="wd-5p">SR #</th>
                    <th class="wd-5p">ID</th>
                    <th class="wd-10p">MEMBERSHIP DATE</th>
                    <th class="wd-10p">MEMBER #</th>
                    <th class="wd-20p">NAME</th>

                    <th class="wd-10p">CONTACT</th>
                    <th class="wd-25p">ADDRESS</th>
                    <th class="wd-10p">MAINTENANCE (PER QUARTER)</th>
                    <th class="wd-10p">DISCOUNT AMOUNT</th>
                    <th class="wd-10p">TOTAL DEBIT</th>
                    <th class="wd-10p">TOTAL CREDIT</th>
                    <th class="wd-10p">BALANCE</th>
                    <th class="wd-10p">STATUS</th>
                    <th  class="wd-5p hidden-print">PRINT </th>
                    <th  class="wd-5p hidden-print">PRINT </th>
<!--                    <th class="wd-5p hidden-print">INVOICE</th>-->
                </tr>
                </thead>
                <tbody :style="'font-size:15px'">
                <template v-for="(tr,key) in  sliceP(
                     (()=>{
                      let  x=maintenance;

                     return x;
                    })()

                    )">
                <tr v-if="tr.debit-tr.credit!=0">
                    <td>{{((page-1)*pagelength)+key+1}}</td>
                    <td>{{tr.id}}</td>
                    <td>{{moment(tr.membership_date).format('DD/MM/YYYY')}}</td>
                    <td>{{tr.mem_no}}</td>
                    <td>{{tr.name}}</td>
                    <td>{{tr.contact}}</td>
                    <td>{{tr.cur_address}}, {{tr.cur_city}}, {{tr.cur_country}}</td>
                    <td>{{ (tr.tmen).toLocaleString()}}</td>
                    <td>{{ tr.discount_amount?(tr.discount_amount).toLocaleString():tr.discount_amount}}</td>
                    <td>{{ (tr.credit) | numFormat}}</td>
                    <td>{{ (tr.debit) | numFormat}}</td>
                    <td>{{ (tr.debit-tr.credit).toLocaleString()}}</td>
                    <td>{{tr.state}}</td>
                    <td>   <form method="post" target="_blank" action="/finance-and-management/maintenance-fee-posting/printall2">
                                <div class="col-sm">
                                    <input type="hidden" name="_token" :value="csrf">
                                    <input type="hidden" name="ids" :value="tr.invoiceid">
                                    <button type="submit" title="print"
                                            class="btn btn-sm  btn-success"> All
                                    </button>
                                </div>
                            </form>
                    </td>
                    <td>
                        <form method="post" target="_blank" action="/finance-and-management/maintenance-fee-posting/printall3">
                            <div class="col-sm">
                                <input type="hidden" name="_token" :value="csrf">
                                <input type="hidden" name="ids" :value="tr.invoiceid">
                                <button type="submit" title="print"
                                        class="btn btn-sm  btn-danger"> Unpaid
                                </button>
                            </div>
                        </form>

                    </td>
<!--                    <td class="hidden-print"><button class="buttoncolor" title="Print Invoice"><a style="color:#000000;" target="_blank" :href="'/finance-and-management/finance-new-invoices/invoice/' + tr.invoiceid"><i class="fa fa-print" aria-hidden="true"></i></a></button></td>
                -->
                </tr>
                </template>
                <tr v-if="tdebit-tcredit!=0">
                    <td colspan="7" style="text-align: right;"><STRONG>GRAND TOTAL:</STRONG></td>
                    <td><STRONG>{{ (ttmen).toLocaleString()}}</STRONG></td>
                    <td><STRONG>{{ (tdiscount_amount).toLocaleString()}}</STRONG></td>
                    <td><STRONG>{{ (tcredit).toLocaleString()}}</STRONG></td>
                    <td><STRONG>{{ (tdebit).toLocaleString()}}</STRONG></td>
                    <td><STRONG>{{ (tcredit-tdebit).toLocaleString()}}</STRONG></td>
<!--                    <td><STRONG> </STRONG></td>-->
                    <td colspan="3"  > </td>
                </tr>
                <tr v-else>
                    <td colspan="7" style="text-align: right;"><STRONG>GRAND TOTAL:</STRONG></td>
                    <td><STRONG>0</STRONG></td>
                    <td><STRONG>0</STRONG></td>
                    <td><STRONG>0</STRONG></td>
                    <td><STRONG>0</STRONG></td>
                    <td><STRONG>0</STRONG></td>
                    <!--                    <td><STRONG> </STRONG></td>-->
                    <td colspan="3"  > </td>
                </tr>

                </tbody>

            </table>

                    <ul class="pagination">
                        <li :class="page==n?'active':''"  v-for="n in (parseInt(leng/pagelength)+((leng%pagelength)>0?1:0))" @click="page=n"><span  >{{n}} </span></li>
                        <li>
                            <select  v-model="pagelength" class="">
                                <option value="30" >30</option>
                                <option value="50" >50</option>
                                <option value="100" >100</option>
                                <option value="150" >150</option>
                                <option :value="maintenance.length" >ALL</option>
                            </select>
                        </li>  </ul>

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
.thds{
    min-width: 125px;
}
.pagination {
    display: block!important;
    padding-left: 0;
    list-style: none;
    border-radius: 3px;
    clear:both;
}
.pagination li{
    float:left
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
    background:#0053a7;

}
table tfoot td{
    color :#fff!important;
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
        name: "pendingmaintenancedt",
        components: {
            Datepicker
        },
        props: ['sdata','csrf'],
        data(){
            return{
                disabledDates: {
                    from: new Date(),
                },
                fkey:-1,
                ffkey:0,
                categories:[],
                category:[],
                stati:[],
                memstatus:[{name:'Active',id:1}],
                page:1,
                pagelength:50,
                leng:0,
                onLine: null,
                onlineSlot: 'online',
                offlineSlot: 'offline',
                maintenance:[],
                maintenanceR:[],
                maintenanceM: [],
                searchid:'',
                cnic:'',
                contact:'',
                car_number:'',
                barcode:'',
                customer:'',
                quarter:moment().quarter(),
                year:'2020',
                status:0,
                years:[],
                start_date:'',
                ttmen:0,
                tdiscount_amount:0,
                tcredit:0,
                tdebit:0,
                ids:'',
customers:[],
ttmo:[
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0,
    0
]

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
            filterData(maintenance){
             let   x=maintenance;
                if(this.barcode){
                    x=x.filter((a)=>{return a.mem_barcode==this.barcode});

                }

                if(this.searchid){
                    x=x.filter((a)=>{return a.id==this.searchid});

                }

                if(this.category.length>0){
                    x=x.filter((a)=>{return this.category.filter((m)=>{
                        return a.mem_category_id==m.id;
                    }).length>0});

                }

                if(this.memstatus.length>0){
                    x=x.filter((a)=>{return this.memstatus.filter((m)=>{
                        return a.active==m.id;
                    }).length>0});

                }
                // if(this.customer){
                //
                //     x=x.filter((a)=>{
                //         let fname=a.first_name?a.first_name+' ':'';
                //         let mname=a.middle_name?a.middle_name+' ':'';
                //         let lname=a.applicant_name?a.applicant_name:'';
                //         let fullname=fname+mname+lname;
                //         return fullname==this.customer});
                //
                // }

                if(this.cnic){
                    x=x.filter((a)=>{return a.cnic==this.cnic});

                }

                else{
                    x=x;
                }
                return x;
            },
            amIOnline(e) {
                this.onLine = e;
            },
            sliceP(maintenance){
                // console.log(123);
                this.maintenanceM=maintenance;
                this.ids=this.pluck(maintenance,'invoiceid').join()
              return  maintenance.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
            },
            init:function () {

                /*this.$http.get('/finance-and-management/reports/pending-maintenance-report-ini?off='+((this.page-1)*this.pagelength)+'&start_date='+(this.start_date?moment(this.start_date).format('YYYY-MM-DD'):'')+'&barcode='+this.barcode+'&cnic='+this.cnic+'&contact='+this.contact+'&searchid='+this.searchid+'&category='+this.pluck(this.category,'id').join(',')+'&memstatus='+this.pluck(this.memstatus,'id').join(',')+'&qt='+this.quarter+'&st='+this.status+'&fullname='+this.mem_id_).then(result=>{
                    this.ttmo.forEach((a,b)=>{
                        this.ttmo[b]=0;
                    });
                    let data=result.data;

                    this.categories=data.categories;
                    this.stati=data.stati;
                    this.maintenance=data.maintenance;
                    this.maintenanceR=data.maintenance;
                    if(data.co/this.pagelength<this.page){
                        this.page=1;
                    }
                    this.leng=data.co;
                })
                return false;*/

               let x='';

                if(this.barcode){
                    x=x+'&barcode='+this.barcode;

                }

                if(this.cnic){
                    x=x+'&cnic='+this.cnic;

                }

                if(this.contact){
                    x=x+'&contact='+this.contact;

                }

                if(this.searchid){
                    x=x+'&searchid='+this.searchid;


                }
                if(this.category){
                    x=x+'&category='+this.pluck(this.category,'id').join(',');
                }
                if(this.memstatus){
                    x=x+'&memstatus='+this.pluck(this.memstatus,'id').join(',');
                }
                if(this.quarter){
                    x=x+'&qt='+this.quarter;
                }if(this.status){
                   if(this.quarter){
                       x=x+'&st='+this.status+'&qt='+this.quarter;
                   }
                }
                if(this.start_date){
                    x=x+'&start_date='+moment(this.start_date).format('YYYY-MM-DD');
                }
                if(this.customer){


                        // let fname=a.first_name?a.first_name+' ':'';
                        // let mname=a.middle_name?a.middle_name+' ':'';
                        // let lname=a.applicant_name?a.applicant_name:'';
                        // let fullname=fname+mname+lname;

                    x=x+'&fullname='+this.mem_id_;


                }






                this.$http.get('/finance-and-management/reports/pending-maintenance-report-ini?off=1'+x).then(result=>{
                    this.ttmo.forEach((a,b)=>{
                        this.ttmo[b]=0;
                    });
                    let data=result.data;

                    let aa=0;
                    let bb=0;
                    let cc=0;
                    let dd=0;
                    let x=data.maintenance;
                    x.forEach(function (s,key) {
                        aa=aa+parseInt(s.tmen);
                        bb=bb+parseInt(s.discount_amount?s.discount_amount:0);
                        cc=cc+parseInt(s.credit);
                        dd=dd+(parseInt(s.debit));
                    })
                    this.ttmen=aa
                    this.tdiscount_amount=bb
                    this.tcredit=cc
                    this.tdebit=dd

                    this.categories=data.categories;
                    this.stati=data.stati;
                    this.maintenance=data.maintenance;
                    this.maintenanceR=data.maintenance;
                    this.leng=data.maintenance.length;

                })

            },
            customerdata(){
                let v = 0;
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

                    if(data){

                        this.customers=data;

                    }
                });

            },
            customerdatavalue(val,m){
                this.customers=[];
                let v = 0;
                let r='';

                if(m){
                    r='&r='+m;
                }
                this.$http.post('/search/customerdata?MOC='+v+r,{customerid:val}).then(result=>{
                    let data =result.data;
                    if(data){

                            this.mem_id = data.mem_no;
                            this.mem_id_ = data.id;
                            let fname=data.first_name?data.first_name+' ':'';
                            let mname=data.middle_name?data.middle_name+' ':'';
                            let lname=data.applicant_name?data.applicant_name:'';

                            this.customer = fname+mname+lname;
                            this.guest_contact = data.mob_a;
                            // console.log(data);


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

            maintenanceM:function(){
                console.log(1);
            },
            customer:function(){
                if(this.customer.length==0){
                    this.alreadySearched=false;
                }

                if(this.customer.length>2 && !this.alreadySearched){
                    this.customerdata();
                }
            },

        },
        mounted() {
            document.addEventListener('keydown', (event)=> {
                if (event.key === 'Enter') {

                        this.init();
                        event.preventDefault();

                }
            });
            if(this.id){
                if(this.sdata){
                    this.category=this.sdata.category;
                    this.start_date=this.sdata.start_date;
                    this.memstatus=this.sdata.memstatus;
                }
                this.start_date=new Date();
                this.init(this.id);

                // this.init(id.id);

            }
            else{
                if(this.sdata){
                    this.category=this.sdata.category;
                    this.start_date=this.sdata.start_date;
                    this.quarter=this.sdata.quarter;
                    this.memstatus=this.sdata.memstatus;
                }
                else{

                    this.start_date=new Date();
                }
                this.init();

            }

        }
    }
</script>

