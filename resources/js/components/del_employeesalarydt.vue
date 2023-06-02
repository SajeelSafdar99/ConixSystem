<template>
<div>
    <vue-snotify></vue-snotify>



    <div class="row hidden-print">

        <div class="col-lg">
            <div>
                <datepicker :disabledDates="disabledDates" v-model="start_date" :clear-button="true" placeholder="From Voucher Date (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="start_date"></datepicker>

            </div>
        </div>
        <div class="col-lg">
            <div>
                <datepicker :disabledDates="disabledDates" v-model="end_date" :clear-button="true" placeholder="To Voucher Date (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="end_date"></datepicker>
            </div>
        </div>

        <div class="col-lg">
            <input value="" class="form-control "  size="20" type="number"
                   id="voucherid" v-model="voucherid" autocomplete="off"
                   name="voucherid" placeholder="Search by Voucher ID">
        </div>

        <div class="col-lg">

            <input value="" class="form-control "  size="20" type="number"
                   id="memberid" v-model="memberid" autocomplete="off"
                   name="memberid" placeholder="Search by Employee ID">
        </div>


    </div>
<br>
    <div class="row hidden-print">

        <div class="col-lg">

                <input value="" class="form-control "  size="20" type="text"
                       id="barcode" autocomplete="off" v-model="barcode"
                       name="barcode" placeholder="Search by Barcode">
        </div>


        <div class="col-lg">

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

            <input value="" autocomplete="off" class="form-control "  size="20" type="text"
                   id="cnic" v-model="cnic"
                   name="cnic" placeholder="Search by CNIC">
        </div>
        <div class="col-lg">

            <input value="" autocomplete="off" class="form-control "  size="20" type="number"
                   id="contact" v-model="contact"
                   name="contact" placeholder="Search by Contact">
        </div>

        <div class="col-lg">
            <multiselect track-by="name" label="name" placeholder="Choose Users" v-model="user" :multiple="true" :options="(()=>{let x=[];
            users.forEach((a)=>{
                x.push({name:a.name,id:a.id})
            })
            return x;
            })()"></multiselect>
        </div>

    </div>


    <div class="scrollclasstable1">

        <div>
            <table class="table-striped table-bordered table-hover ">
                <thead :style="'font-size:15px'">
                <tr>
                    <th class="wd-5p">SR #</th>
                    <th class="wd-5p">ID</th>
                    <th class="wd-5p">DATE</th>
                    <th class="wd-20p">NAME</th>
                    <th class="wd-5p">NO.</th>
                    <th class="wd-10p">CNIC #</th>
                    <th class="wd-10p">CONTACT</th>
                    <th class="wd-10p">BARCODE #</th>
                    <th class="wd-10p">CURRENT SALARY</th>
                    <th class="wd-5p">WORKING DAYS</th>
                    <th class="wd-5p">OVERTIME DAYS</th>
                    <th class="wd-10p">PAYABLE SALARY</th>

                    <th class="wd-10p">DELETED AT</th>
                    <th class="wd-10p">DELETED BY</th>
                   <th class="wd-5p hidden-print">RESTORE</th>
                </tr>
                </thead>
                <tbody :style="'font-size:15px'">
                <tr v-for="(tr,key) in

                sliceP(
                     (()=>{
                      let  x=filterData(employees);

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
                    <td>{{moment(tr.pay_date).format('DD/MM/YYYY')}}</td>
                    <td>{{tr.name}}</td>
                    <td>{{tr.employeeid}}</td>
                    <td>{{tr.cnic}}</td>
                    <td>{{tr.mob_a}}</td>
                    <td>{{tr.barcode}}</td>
                    <td>{{tr.current_salary}}</td>
                    <td>{{tr.working_days}}</td>
                    <td>{{tr.overtime_days}}</td>
                    <td>{{tr.grand_total}}</td>
                    <td>{{moment(tr.deleted_at).format('DD/MM/YYYY HH:mm:ss')}}</td>
                    <td>{{users.filter(function(a){return a.id==tr.deleted_by})[0].name}}</td>
                 <td class="hidden-print"><button class="buttoncolor" title="Restore"><a style="color:#000000;" :href="'/human-resource/employment/voucher/restore/' + tr.id"><i class="fa fa-trash-restore" aria-hidden="true"></i></a></button></td>
                </tr>

                </tbody>

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
                                <option :value="employees.length" >ALL</option>
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
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
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
        name: "del_employeesalarydt",
        components: {
            Datepicker
        },
        props: [],
        data(){
            return{
                disabledDates: {
                    from: new Date(),
                },
                page:1,
                pagelength:50,
                leng:0,
                onLine: null,
                onlineSlot: 'online',
                offlineSlot: 'offline',
                employees:[],
                employeesR:[],
                employeesM: [],
                barcode:'',
                memberid:'',
                cnic:'',
                contact:'',
                customers:[],
                customer:'',
                searchId:null,
                fkey:-1,
                ffkey:0,
                voucherid:'',
                start_date:'',
                end_date:'',
                users:[],
                user:[],
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
            filterData(employees){
             let   x=employees;

                if(this.barcode){
                    x=x.filter((a)=>{return a.barcode==this.barcode});
                }

                if(this.voucherid){
                    x=x.filter((a)=>{return a.id==this.voucherid});

                }

                if(this.memberid){
                    x=x.filter((a)=>{return a.employeeid==this.memberid});

                }
                if(this.cnic){
                    x=x.filter((a)=>{return a.cnic==this.cnic});

                }
                if(this.contact){
                    x=x.filter((a)=>{return a.mob_a==this.contact});

                }

                if (this.searchId){
                    x=x.filter((a)=>{return a.employeeid==this.searchId});
                }

                if(this.start_date){
                    x=x.filter((a)=>{return moment(a.pay_date,'YYYY-MM-DD').format('x')>=moment(moment(this.start_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});

                }
                if(this.end_date){
                    x=x.filter((a)=>{return moment(a.pay_date,'YYYY-MM-DD').format('x')<=moment(moment(this.end_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
                }

                if(this.user.length>0){
                    x=x.filter((a)=>{return this.user.filter((m)=>{
                        return a.deleted_by==m.id;
                    }).length>0});
                }

                return x;
            },
            amIOnline(e) {
                this.onLine = e;
            },
            sliceP(employees){
                // console.log(123);
                this.employeesM=employees;
              return  employees.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
            },
            init:function () {

                this.$http.get('/human-resource/employment/voucher/indexdt_deleted').then(result=>{
                    let data=result.data;
                    this.users=data.users;
                    this.employees=data.employees;
                    this.employeesR=data.employees;
                    this.leng=data.employees.length;
                })
            },


            customerdata(){
                let v = 3;
                this.$http.post('/search/customerdatalike',{customerid:this.customer,MOC:v}).then(result=>{
                    let data =result.data;
                    data.filter((a)=>{a.name=a.name + ' ' + '('+ a.barcode +')'})

                    if(data){

                        this.customers=data;

                    }
                });

            },
            customerdatavalue(val,m){
                this.customers=[];
                let v = 3;
                let r='';

                if(m){
                    r='&r='+m;
                }
                this.$http.post('/search/customerdata?inv=1&MOC='+v+r,{customerid:val}).then(result=>{
                    let data =result.data;

                    if(data){

                        this.searchId=data.id;

                        this.customer = data.name;

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
            employeesM:function(){
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

