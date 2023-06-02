<template>
    <div>
        <vue-snotify></vue-snotify>

        <div class="row hidden-print">
            <div class="col-lg">
                <input value="" class="form-control "  size="20" type="number"
                       id="memberid" v-model="memberid" autocomplete="off"
                       name="memberid" placeholder="Search by ID">
            </div>
            <div class="col-lg">
                <div>
                    <datepicker :disabledDates="disabledDates" v-model="visit_date" :clear-button="true" placeholder="Visit Date (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="visit_date"></datepicker>
                </div>
            </div>
            <div class="col-lg">
                <div>
                    <datepicker :disabledDates="disabledDates" v-model="next_visit" :clear-button="true"  placeholder="Next Visit Date (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="next_visit"></datepicker>
                </div>
            </div>

            <div class="col-lg">
                <input value="" class="form-control" type="number"
                       id="leadid" v-model="leadid" autocomplete="off"
                       name="leadid" placeholder="Search by Lead ID">
            </div>

            <div class="col-lg">
                <input value="" autocomplete="off" class="form-control "  size="20" type="text"
                       id="name" v-model="name"
                       name="name" placeholder="Search by Name">
            </div>

            <div class="col-lg">
                <input value="" autocomplete="off" class="form-control "  size="20" type="text"
                       id="contact" v-model="contact"
                       name="contact" placeholder="Search by Contact">
            </div>

        </div>
        <br>
        <div class="row hidden-print">
            <div class="col-lg">
                <multiselect track-by="name" label="name" placeholder="Choose BD" v-model="user" :multiple="true" :options="(()=>{let x=[];
            users.forEach((a)=>{
                x.push({name:a.name,id:a.id})
            })
            return x;
            })()"></multiselect>
            </div>

            <div v-if="this.exported" class="col-xs">
                <export-excel
                    class   = "btn btn-primary"
                    :data   = "(()=>{return filterData(leads)})()"
                    worksheet = "My Worksheet"
                    name    = "MemberRecoveries.xls">
                </export-excel>
            </div>

            <div class="col-lg">

            </div>


        </div>

<br>
        <div class="scrollclasstable1">
            <div>
                <table class="table-striped table-bordered table-hover ">
                    <thead :style="'font-size:15px'">
                    <tr>
                        <th class="wd-5p">SR #</th>
                        <th class="wd-5p">ID</th>
                        <th class="wd-5p">LEAD ID</th>
                        <th class="wd-20p">CUSTOMER NAME</th>
                        <th class="wd-10p">CONTACT</th>
                        <th class="wd-10p">QUOTED MEMBERSHIP AMOUNT</th>
                        <th class="wd-10p">ADVANCE AMOUNT</th>
                        <th class="wd-10p">REMAINING AMOUNT</th>
                        <th class="wd-10p">VISIT DATE & TIME</th>
                        <th class="wd-10p">NEXT VISIT DATE & TIME</th>
                        <th class="wd-30p">REMARKS</th>
                        <th class="wd-10p">BD</th>
                    </tr>
                    </thead>
                    <tbody :style="'font-size:15px'">
                    <tr v-for="(tr,key) in

                sliceP(
                      (()=>{
                      let  x=filterData(leads);

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
                        <td>{{tr.lead_id}}</td>
                        <td>{{tr.name}}</td>
                        <td>{{tr.contact}}</td>
                        <td>{{tr.membership_amount}}</td>
                        <td>{{tr.advance_amount}}</td>
                        <td>{{tr.remaining_amount}}</td>
                        <template v-if="tr.visit_date && tr.visit_date!='0000-00-00 00:00:00'"><td>{{moment(tr.visit_date).format('DD/MM/YYYY HH:mm:ss')}}</td></template>
                        <template v-else><td></td></template>
                        <template v-if="tr.next_visit && tr.next_visit!='0000-00-00 00:00:00'"><td>{{moment(tr.next_visit).format('DD/MM/YYYY HH:mm:ss')}}</td></template>
                        <template v-else><td></td></template>
                        <td>{{tr.remarks}}</td>
                        <td>{{users.filter(function(a){return a.id==tr.user}).length>0?users.filter(function(a){return a.id==tr.user})[0].name:''}}</td>
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
                                <option :value="leads.length" >ALL</option>
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
.svg-inline--fa.fa-w-9 {
    width: 1.5625em;
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
    name: "memberrecoveriesdt",
    components: {
        Datepicker
    },
    props: [],
    json_data: [],
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
            leads:[],
            leadsR:[],
            leadsM: [],
            barcode:'',
            memberid:'',

            fkey:-1,
            ffkey:0,
            users:[],
            user:[],

            visit_date:'',
            next_visit:'',
            json_data: [],
            leadid:'',
            name:'',
            exported:'',
            contact:'',
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
        filterData(leads){
            let   x=leads;

            if(this.contact){
                x=x.filter((a)=>{
                    let self = this;
                    return (String(a.contact)).startsWith(self.contact)});
            }
            if(this.memberid){
                x=x.filter((a)=>{return a.id==this.memberid});
            }
            if(this.leadid){
                x=x.filter((a)=>{return a.lead_id==this.leadid});
            }

            if(this.name){
                x=x.filter((a)=>{
                let self=this;
                return (String(a.name)).toLowerCase().startsWith(self.name.toLowerCase())});
                /*or
                return ((a.name?a.name:'')).toLowerCase().startsWith(this.name.toLowerCase())});*/
            }

            if(this.visit_date){
                x=x.filter((a)=>{return moment(a.visit_date,'YYYY-MM-DD').format('x')==moment(moment(this.visit_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
            }

            if(this.next_visit){
                x=x.filter((a)=>{return moment(a.next_visit,'YYYY-MM-DD').format('x')==moment(moment(this.next_visit).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
            }

            if(this.user.length>0){
                x=x.filter((a)=>{return this.user.filter((m)=>{
                    return a.user==m.id;
                }).length>0});
            }

            return x;
        },
        amIOnline(e) {
            this.onLine = e;
        },
        sliceP(leads){
            // console.log(123);
            this.leadsM=leads;
            return  leads.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
        },


        /* FOR DATE PICKER*/

        /*  customFormatter(date) {
            return moment(date).format('MMMM Do YYYY, h:mm:ss a');
          //  use as :format="customFormatter"
        },*/

        init:function () {

            this.$http.get('/crm/member-recoveries/recoveries_init_vue').then(result=>{
                let data=result.data;
                this.exported=data.exported;
                this.leads=data.leads;
                this.leadsR=data.leads;
                this.leng=data.leads.length;
             //   this.json_data=data.leads;
                this.users=data.users;
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
        leadsM:function(){
            console.log(1);
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
        //this.visit_date=new Date();

    }
}
</script>

