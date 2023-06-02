<template>
<div>
    <vue-snotify></vue-snotify>
<!--    <div class="hidden-print">
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


    <div class="row hidden-print">

<!--        <div class="col-sm-3">
                <input value="" class="form-control "  size="20" type="text"
                       id="numeral" autocomplete="off" v-model="numeral"
                       name="numeral" placeholder="Search Available Numbers">
        </div>-->

        <div class="col-sm-2">
            <input value="" class="form-control "   type="number"
                   id="range_a" autocomplete="off" v-model="range_a"
                   name="range_a" placeholder="Range (From)">
        </div>
        <div class="col-sm-2">
            <input value="" class="form-control "    type="number"
                   id="range_b" autocomplete="off" v-model="range_b"
                   name="range_b" placeholder="Range (To)">
        </div>
        <div class="col-xs">
            <div>
                <button type="button" class="btn btn-success" v-on:click="init">Search</button>
            </div>
        </div>



    </div>

    <div style="text-align: center; color: black;" class="print-only">
        <p><strong>Range (From) = {{this.range_a}}, Range (To) = {{this.range_b}}</strong></p>

    </div>

    <br>

    <div class="scrollclasstable1">

        <div>
            <table class="table-striped table-bordered table-hover ">
                <thead :style="'font-size:15px'">
                <tr>

                    <th class="wd-1000p">AVAILABLE MEMBERSHIP NUMBERS</th>

                </tr>
                </thead>
                <tbody :style="'font-size:15px'">
                <tr v-for="tr in

                sliceP(
                     (()=>{
                      let  x=filterData(memberships);

                   leng=x.length;
                  if(parseInt(leng/pagelength)+((leng%pagelength)>0?1:0)<page){
                      page=1;
                  }

                      //

                     return x;
                    })()

                    )" >
                    <td>{{tr}}</td>
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
                                <option :value="memberships.length" >ALL</option>
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
.block-col{

    height: 10px;
    width: 10px;
    display: block;
    float: left;
    margin: 3px;
}
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
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
        name: "availablemems",
        components: {
            Datepicker
        },
        props: [],
        data(){
            return{
                kinship:'Choose Option',
                page:1,
                pagelength:30,
                leng:0,
                onLine: null,
                onlineSlot: 'online',
                offlineSlot: 'offline',
                memberships:[],
                membershipsR:[],
                membershipsM: [],
                barcode:'',
                kinshipid:'',
                memberid:'',
                cnic:'',
                contact:'',
                carno:'',
                customers:[],
                customer:'',
                mog:2,
                searchId:null,
                categories:[],
                category:[],
                stati:[],
                status:[],
                cardstati:[ "In-Process",
                    "Printed",
                    "Received",
                    "Issued",
                    "Re-Printed"] ,
                card_status:[],
                fkey:-1,

                ffkey:0,
                duration:'',
                deletethisid:'',
                DeleteTheInvoice:false,
                remarks:'',
                numeral:'',
                range_b:'',
                range_a:'',
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
                let url='/club-hospitality/membership/delete/'+this.deletethisid;
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
            filterData(memberships){
             let   x=memberships;


                if(this.numeral){
                    x=x.filter((a)=>{return a==this.numeral});
                }



                return x;
            },
            amIOnline(e) {
                this.onLine = e;
            },
            sliceP(memberships){
                // console.log(123);
                this.membershipsM=memberships;
              return  memberships.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
            },
            init:function () {
                let d=''
                if(this.range_a){
                    d=d+'&rangea='+this.range_a;
                }
                if(this.range_b){
                    d=d+'&rangeb='+this.range_b;
                }

                if(this.range_a && this.range_b) {
                    this.$http.get('/finance-and-management/reports/available-membership-numbers-ini?' + d).then(result => {
                        let data = result.data;

if(data.memberships)
{
    this.memberships = data.memberships;
    console.log(this.memberships);
    this.membershipsR = data.memberships;
    this.leng = data.memberships.length;
}
    else{
    this.memberships =[];
}


                    })
                }
                else{
                    this.memberships =[];
                }
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
            membershipsM:function(){
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

