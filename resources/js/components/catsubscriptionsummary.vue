<template>
<div>
    <vue-snotify></vue-snotify>
    <div v-if="showModal">
        <transition name="modal">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">

                                <h5 class="modal-title">SUBSCRIPTIONS & MAINTENANCE SUMMARY:</h5>
                                <button type="button" class="close" @click="showModal=false">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <subscriptionsummary :sdata="ssdata" v-if="ssdata" :key="'am'+k"></subscriptionsummary>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="showModal=false">CLOSE</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>

<form  @submit.prevent="init()">
    <div class="row hidden-print">
        <div class="col-lg">
            <div>
                <datepicker :disabledDates="disabledDates" v-model="start_date" :clear-button="true" placeholder="From (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="start_date"></datepicker>
            </div>
        </div>
        <div class="col-lg">
            <div>
                <datepicker :disabledDates="disabledDates" v-model="end_date" :clear-button="true" placeholder="To (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="end_date"></datepicker>
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

<!--        <div class="col-lg">

            <multiselect track-by="name" label="name" placeholder="Choose Status" v-model="memstatus" :multiple="true" :options="(()=>{let x=[];
            stati.forEach((a)=>{
                x.push({name:a.desc,id:a.id})
            })
            return x;
            })()"></multiselect>


        </div>-->

<!--        <div class="col-sm">
            <div class="form-group">
                <select class="form-control" v-model="quarter">
                    &lt;!&ndash;                    <option value="0">Select Quarter</option>&ndash;&gt;
                    <option :value="key" v-for="(y,key) in {1:'qt1',2:'qt2',3:'qt3',4:'qt4'}">{{y}}</option>
                </select>
            </div>
        </div>-->
        <div class="col-sm">
        <div class="form-group">

            <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> </button>
        </div>
    </div>
    </div>
    <!--  <br>
          <div class="row hidden-print">

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



      </div>-->
</form>


    <div style="text-align: center; color: black;" class="print-only">
        <p><strong>( Date = Between {{this.start_date | moment("DD/MM/YYYY")}} To {{this.end_date | moment("DD/MM/YYYY")}}, Categories = {{this.pluck(this.category,'name')}} )</strong></p>

    </div>
            <table class="table-striped table-bordered table-hover ">
                <thead :style="'font-size:15px'">
                <tr>
                    <th class="thdss">SR #</th>
                    <th class="thdss">CATEGORY</th>
                    <th  class="thdss">CASH</th>
                    <th  class="thdss">CREDIT CARD</th>
                    <th  class="thdss">BANK / ONLINE</th>
                    <th class="thdss">TOTAL REVENUE</th>
                </tr>
                </thead>
                <tbody :style="'font-size:15px'">
                <tr v-for="(tr,key) in


                     (()=>{
                      let  x=(maintenance);




                      //

                     return x;
                    })()

                    " >
                    <td>{{((page-1)*pagelength)+key+1}}</td>
                    <td><template v-if="categories.filter(function(a){return a.id==tr.mem_category_id})[0]">{{categories.filter(function(a){return a.id==tr.mem_category_id})[0].desc}}</template></td>

                    <td>{{tr.cashgross}} <span v-on:click="updatesdata(tr)" style="color:white; float: right !important;"><span class="text-primary"><i class="fa fa-info-circle"></i></span></span></td>
                    <td>{{tr.creditgross}} <span v-on:click="updatesdata(tr)" style="color:white; float: right !important;"><span class="text-primary"><i class="fa fa-info-circle"></i></span></span></td>
                    <td>{{tr.othergross}} <span v-on:click="updatesdata(tr)" style="color:white; float: right !important;"><span class="text-primary"><i class="fa fa-info-circle"></i></span></span></td>
                    <td><STRONG>{{parseInt(tr.cashgross) + parseInt(tr.creditgross) + parseInt(tr.othergross)}}</STRONG></td>

                </tr>

                <tr>
                    <td colspan="2" style="text-align: right;"><STRONG>GRAND TOTAL:</STRONG></td>
                    <td><STRONG>{{tq1}} <span v-on:click="gupdatesdata()" style="color:white; float: right !important;"><span class="text-primary"><i class="fa fa-info-circle"></i></span></span></STRONG></td>
                    <td><STRONG>{{tq2}} <span v-on:click="gupdatesdata()" style="color:white; float: right !important;"><span class="text-primary"><i class="fa fa-info-circle"></i></span></span></STRONG></td>
                    <td><STRONG>{{tq3}} <span v-on:click="gupdatesdata()" style="color:white; float: right !important;"><span class="text-primary"><i class="fa fa-info-circle"></i></span></span></STRONG></td>
                    <td><STRONG>{{parseInt(tq1) + parseInt(tq2) + parseInt(tq3)}}</STRONG></td>
                </tr>
                </tbody>

            </table>


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
    min-width: 170px;
}
.thdss{
    min-width: 320px;
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
.modal-dialog{
    overflow-y: initial !important;
    max-width: 975px !important;
}
.modal-content{
    width: 1065px !important;
}
.modal-body{
    height: 80vh;
    overflow-y: auto;
}

.modal-wrapper {
    display: table-cell;
    vertical-align: middle;
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
        name: "catsubscriptionsummary",
        components: {
            Datepicker
        },
        props: [],
        data(){
            return{
                disabledDates: {
                    from: new Date(),

                },
                showModal: false,
                k:0,
                ssdata:false,
                fkey:-1,
                ffkey:0,
                categories:[],
                category:[],
                stati:[],
                memstatus:[],
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
                tq1:0,
                tq2:0,
                tq3:0,
                tq4:0,
                tq11:0,
                tq22:0,
                tq33:0,
                tq44:0,
                ttm:0,
                end_date:'',
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
            updatesdata(d){
                this.ssdata={
                    start_date:this.start_date,
                    end_date:this.end_date,
                    category:[{id:d.mem_category_id,name:this.categories.filter(function(a){return a.id==d.mem_category_id})[0].desc}],
                }
                this.k=this.k+1;
                this.showModal=true;
            },
            gupdatesdata(){
                this.ssdata= {
                    start_date: this.start_date,
                    end_date: this.end_date,
                }
                this.k=this.k+1;
                this.showModal=true;
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
              return  maintenance.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
            },
            init:function () {

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
               if(this.status){
                       x=x+'&st='+this.status;
                }
                if(this.start_date){
                    x=x+'&start_date='+moment(this.start_date).format('YYYY-MM-DD');
                }
                if(this.end_date){
                    x=x+'&end_date='+moment(this.end_date).format('YYYY-MM-DD');
                }
                if(this.start_date){
                    x=x+'&year='+moment(this.start_date).format('YYYY');
                }
                if(this.customer){


                        // let fname=a.first_name?a.first_name+' ':'';
                        // let mname=a.middle_name?a.middle_name+' ':'';
                        // let lname=a.applicant_name?a.applicant_name:'';
                        // let fullname=fname+mname+lname;

                    x=x+'&fullname='+this.mem_id_;


                }






                this.$http.get('/finance-and-management/reports/category-subscriptions-maintenance-summary-ini?off='+((this.page-1)*this.pagelength)+x).then(result=>{
                    this.ttmo.forEach((a,b)=>{
                        this.ttmo[b]=0;
                    });
                    let data=result.data;

                        let aa=0;
                        let bb=0;
                        let cc=0;

                        let x=data.membership;
                        x.forEach(function (s,key) {
                            aa=aa+parseInt(s.cashgross);
                            bb=bb+parseInt(s.creditgross);
                            cc=cc+parseInt(s.othergross);

                        })
                        this.tq1=aa
                        this.tq2=bb
                        this.tq3=cc



                    this.categories=data.categories;
                    this.stati=data.stati;
                    this.maintenance=data.membership;
                    this.maintenanceR=data.membership;
                    if(data.co/this.pagelength<this.page){
                        this.page=1;
                    }
                    this.leng=data.co;
                })
                return false;
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
                this.$http.post('/search/customerdata?inv=1&MOC='+v+r,{customerid:val}).then(result=>{
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
            page:function (){
              this.init();
            },
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
            if(this.id){
                this.start_date=new Date();
                this.end_date=new Date();
                this.init(this.id);

                // this.init(id.id);

            }
            else{
                this.start_date=new Date();
                this.end_date=new Date();
                this.init();

            }

        }
    }
</script>

