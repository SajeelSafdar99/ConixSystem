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
<br>
        <div class="row hidden-print">


            <div class="col-lg">
<!--                <input value="" class="form-control "  size="20" type="number"
                       id="memberid" v-model="memberid" autocomplete="off"
                       name="memberid" placeholder="Search by ID">-->
                <div class="form-group" v-on:keydown.up.prevent="udf(1)" v-on:keydown.down.prevent="udf(0)">

                    <input  v-model="customer" name="name" id="name" value="" class="typeahead form-control" autocomplete="off" type="text" placeholder="Search Employee by Name / Barcode...">


                    <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="customers.length>0 && customer!=''" >

                        <li  :class="'fbb fba'+key"  @click="customerdatavalue(c.id)"  v-on:keyup.enter="customerdatavalue(c.id)" v-for="(c,key) in customers">
                            <a href="javascript:void(0)">   {{c.name}}</a>
                        </li>

                    </ul>
                </div>
            </div>

            <div class="col-lg">
                <div>
                    <datepicker :disabledDates="disabledDates" v-model="in_date" :clear-button="true" placeholder="In (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="in_date"></datepicker>
                </div>
            </div>
            <div class="col-lg">
                <div>
                    <datepicker :disabledDates="disabledDates" v-model="out_date" :clear-button="true" placeholder="Out (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="out_date"></datepicker>
                </div>
            </div>


<!--            <div class="col-xs">
                <export-excel
                    class   = "btn btn-primary"
                    :data   = "(()=>{return filterData(employees)})()"
                    worksheet = "My Worksheet"
                    name    = "Complaints.xls">
                </export-excel>
            </div>-->

        </div>


        <div class="scrollclasstable1">
            <div>
                <table class="table-striped table-bordered table-hover ">
                    <thead :style="'font-size:15px'">
                    <tr>
                        <th class="wd-5p">SR #</th>
                        <th class="wd-5p">EMPLOYEE ID</th>
                        <th class="wd-30p">EMPLOYEE NAME</th>
                        <th class="wd-20p">IN</th>
                        <th class="wd-20p">OUT</th>
                        <th class="wd-5p hidden-print">EDIT</th>
                        <th class="wd-5p hidden-print">DELETE</th>
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
                        <td>{{tr.employee_id}}</td>
                        <td>{{tr.name}}</td>
                        <td>{{moment(tr.in).format('DD/MM/YYYY hh:mm:ss A')}}</td>
                        <td>{{moment(tr.out).format('DD/MM/YYYY hh:mm:ss A')}}</td>
                        <td class="hidden-print"><button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" :href="'/human-resource/employee-in-out-aeu-vue/' + tr.id"><i class="fas fa-edit"></i></a></button></td>
                        <td class="hidden-print"><button class="buttoncolor" title="Delete"><a style="color:#000000;" :href="'/human-resource/employee-in-out/delete/' + tr.id"><i class="fa fa-trash" aria-hidden="true"></i></a></button></td>
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
.svg-inline--fa.fa-w-10 {
    width: 1.625em;
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
    name: "employeeinoutdt",
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
            memberid:'',
            in_date:'',
            out_date:'',
            customers:[],
            customer:'',
            alreadySearched:false,
            fkey:-1,
            ffkey:0,
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

                    this.memberid = data.id;
                    this.customer = data.name;


                    this.alreadySearched=true;
                }
            });
        },
        filterData(employees){
            let   x=employees;

            if(this.memberid){
                x=x.filter((a)=>{return a.employee_id==this.memberid});
            }
            if(this.in_date){
                x=x.filter((a)=>{return moment(a.in,'YYYY-MM-DD').format('x')==moment(moment(this.in_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
            }
            if(this.out_date){
                x=x.filter((a)=>{return moment(a.out,'YYYY-MM-DD').format('x')==moment(moment(this.out_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
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

        /* FOR DATE PICKER*/

        /*  customFormatter(date) {
            return moment(date).format('MMMM Do YYYY, h:mm:ss a');
          //  use as :format="customFormatter"
        },*/

        init:function () {

            this.$http.get('/human-resource/employee-in-out/inout_init_vue').then(result=>{
                let data=result.data;

                this.employees=data.employees;
                this.employeesR=data.employees;
                this.leng=data.employees.length;
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
        customer:function(){
            if(this.customer.length==0){
                this.alreadySearched=false;
                this.memberid=null;
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

