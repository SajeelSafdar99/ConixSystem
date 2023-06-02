<template>
<div>
    <vue-snotify></vue-snotify>


<form  @submit.prevent="init()">
    <div class="row hidden-print">
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
    <br>
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
        <div class="col-sm">
            <div class="form-group">

                <select class="form-control" v-model="year">
                    <option value="0">Select Year</option>
                    <option :value="y.y" v-for="y in years">{{y.y}}</option>
                </select>
            </div>
<!--            </div>  <div class="form-group">-->
<!--                <label for="car_number">Year</label>-->
<!--                <select class="form-control" v-model="quarter">-->
<!--                    <option value="0">Select Quarter</option>-->
<!--                    <option :value="y" v-for="(y,key) in {1:'qt1',2:'qt2',3:'qt3',4:'qt4'}">{{y}}</option>-->
<!--                </select>-->
<!--            </div>  <div class="form-group">-->
<!--                <label for="car_number">Status</label>-->
<!--                <select class="form-control" v-model="status">-->
<!--                    <option value="0">All</option>-->
<!--                    <option value="1">PAID</option>-->
<!--                    <option value="2">UNPAID</option>-->
<!--                    <option value="3">NO INVOICE</option>-->

<!--                </select>-->
<!--            </div>-->
        </div>  <div class="col-sm">
            <div class="form-group">

               <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> </button>
            </div>
        </div>


    </div>
</form>


            <table class="table-striped table-bordered table-hover ">
                <thead :style="'font-size:15px'">
                <tr>

                    <th class="thds">SR #</th>
                    <th class="thds">ID</th>
                    <th class="thds">MEMBERSHIP DATE</th>
                    <th class="thds">MEMBER #</th>
                    <th class="thds">NAME</th>
                    <th class="thds">Maintenance</th>
                    <th class="thds">Prev. Balance</th>
                    <th class="thds">1ST QUARTER</th>
                    <th class="thds">2ND QUARTER</th>
                    <th class="thds">3RD QUARTER</th>
                    <th class="thds">4TH QUARTER</th>
                    <th class="thds">Total</th>
                    <th class="thds">Balance</th>
                    <th class="thds">STATUS</th>

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
                    <td>{{tr.id}}</td>
                    <td>{{moment(tr.membership_date).format('DD/MM/YYYY')}}</td>
                    <td>{{tr.mem_no}}</td>

                    <td>{{tr.name}}</td>
                    <td>{{tr.tmen | numFormat }}</td>
                    <td>{{tr.opening}}</td>

                    <td :style="tr.qt1?tr.qt1.split('&&&&')[1]?parseInt(tr.qt1.split('&&&&')[1].split('-')[0])-parseInt(tr.qt1.split('&&&&')[1].split('-')[1])==0?parseInt(tr.qt1.split('&&&&')[1].split('-')[1])+';background:#c1fbb3':parseInt(tr.qt1.split('&&&&')[1].split('-')[1])+';background:#d2878e':'background:#d2878e':''" :s="ttmo[key]+=parseInt(tr.qt1?tr.qt1.split('&&&&')[1]?tr.qt1.split('&&&&')[1].split('-')[0]:0:0)" v-html="tr.qt1?tr.qt1.split('&&&&')[0]:''"></td>
                    <td :style="tr.qt2?tr.qt2.split('&&&&')[1]?parseInt(tr.qt2.split('&&&&')[1].split('-')[0])-parseInt(tr.qt2.split('&&&&')[1].split('-')[1])==0?parseInt(tr.qt2.split('&&&&')[1].split('-')[1])+';background:#c1fbb3':parseInt(tr.qt2.split('&&&&')[1].split('-')[1])+';background:#d2878e':'background:#d2878e':''" :s="ttmo[key]+=parseInt(tr.qt2?tr.qt2.split('&&&&')[1]?tr.qt2.split('&&&&')[1].split('-')[0]:0:0)" v-html="tr.qt2?tr.qt2.split('&&&&')[0]:''"></td>
                    <td :style="tr.qt3?tr.qt3.split('&&&&')[1]?parseInt(tr.qt3.split('&&&&')[1].split('-')[0])-parseInt(tr.qt3.split('&&&&')[1].split('-')[1])==0?parseInt(tr.qt3.split('&&&&')[1].split('-')[1])+';background:#c1fbb3':parseInt(tr.qt3.split('&&&&')[1].split('-')[1])+';background:#d2878e':'background:#d2878e':''" :s="ttmo[key]+=parseInt(tr.qt3?tr.qt3.split('&&&&')[1]?tr.qt3.split('&&&&')[1].split('-')[0]:0:0)" v-html="tr.qt3?tr.qt3.split('&&&&')[0]:''"></td>
                    <td :style="tr.qt4?tr.qt4.split('&&&&')[1]?parseInt(tr.qt4.split('&&&&')[1].split('-')[0])-parseInt(tr.qt4.split('&&&&')[1].split('-')[1])==0?parseInt(tr.qt4.split('&&&&')[1].split('-')[1])+';background:#c1fbb3':parseInt(tr.qt4.split('&&&&')[1].split('-')[1])+';background:#d2878e':'background:#d2878e':''" :s="ttmo[key]+=parseInt(tr.qt4?tr.qt4.split('&&&&')[1]?tr.qt4.split('&&&&')[1].split('-')[0]:0:0)" v-html="tr.qt4?tr.qt4.split('&&&&')[0]:''"></td>
                    <td>{{tr.tot | numFormat }}</td>
                    <td>{{ (parseInt(tr.tot)-ttmo[key]>=0?parseInt(tr.tot)-ttmo[key]:tr.tot) | numFormat }}</td>

                    <template v-if="tr.descc=='Active' || tr.descc=='ACTIVE' || tr.descc=='active'">
                    <td><button class="btn btn-outline-success btn-sm active"><a style="color:white;" >{{tr.descc}}</a></button></td>
                </template>
                    <template v-else>
                        <td><button class="btn btn-outline-danger btn-sm active"><a style="color:white;" >{{tr.descc}}</a></button></td>
                    </template>

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
.thds{
    min-width: 120px;
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
        name: "quarterlymaintenancedt",
        components: {
            Datepicker
        },
        props: [],
        data(){
            return{
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
                quarter:0,
                year:'2020',
                status:0,
                years:[],
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

                if(this.contact){
                    x=x.filter((a)=>{return a.mob_a==this.contact});
                }


                if(this.car_number){
                    x=x.filter((a)=>{return a.carno==this.car_number});
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

                if(this.searchid){
                    x=x+'&searchid='+this.searchid;


                }
                if(this.category){
                    x=x+'&search='+this.category;


                }
                if(this.memstatus){
                    x=x+'&search='+this.memstatus;


                }
                if(this.year){
                    x=x+'&year='+this.year;


                }if(this.status){
                   if(this.quarter){
                       x=x+'&st='+this.status+'&qt='+this.quarter;
                   }


                }

                if(this.customer){


                        // let fname=a.first_name?a.first_name+' ':'';
                        // let mname=a.middle_name?a.middle_name+' ':'';
                        // let lname=a.applicant_name?a.applicant_name:'';
                        // let fullname=fname+mname+lname;

                    x=x+'&fullname='+this.mem_id_;


                }






                this.$http.get('/finance-and-management/reports/maintenance-report-ini?off='+((this.page-1)*this.pagelength)+x).then(result=>{
                    this.ttmo.forEach((a,b)=>{
                        this.ttmo[b]=0;
                    });
                    let data=result.data;

                    this.categories=data.categories;
                    this.stati=data.stati;
                    this.maintenance=data.membership;
                    this.maintenanceR=data.membership;
                    if(data.co/this.pagelength<this.page){
                        this.page=1;
                    }
                    this.leng=data.co;
                    this.years=data.cm;
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
                this.init(this.id);

                // this.init(id.id);

            }
            else{
                this.init();

            }

        }
    }
</script>

