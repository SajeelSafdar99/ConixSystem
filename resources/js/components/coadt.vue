<template>
    <div>
        <vue-snotify></vue-snotify>

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

                                    <span style="color: black;">Do you really want to Delete this Control ?</span>
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

        <div class="row hidden-print">


            <div class="col-lg">

                <div class="form-group" v-on:keydown.up.prevent="udf3(1)" v-on:keydown.down.prevent="udf3(0)">

                    <input  v-model="unitsearch" name="unitsearch" id="unitsearch" value="" class="typeahead form-control" autocomplete="off" type="text" placeholder="Search by Unit...">

                    <input  type="hidden" class="form-control typeahead" autocomplete="off" v-model="unitsearchid"     name="unitsearchid" placeholder="Search by Unit...">

                    <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="searchedunits.length>0 && unitsearch!=''" >

                        <li  :class="'fbb fba'+key"  @click="unitdatavalue(c.id)"  v-on:keyup.enter="unitdatavalue(c.id)" v-for="(c,key) in searchedunits">
                            <a href="javascript:void(0)">{{c.code}} - {{c.name}} (<template v-if="ccs.filter(function(a){return a.code==c.desc})[0]">{{ccs.filter(function(a){return a.code==c.desc})[0].name}}</template>)</a>
                        </li>

                    </ul>
                </div>

            </div>

            <div class="col-lg">

                <div class="form-group has-search"  v-on:keydown.up.prevent="udf4(1)" v-on:keydown.down.prevent="udf4(0)">
                    <input  type="text" class="form-control typeahead" autocomplete="off" v-model="accsearch"     name="accsearch" id="accsearch" placeholder="Search COA...">
                    <input  type="hidden" class="form-control typeahead" autocomplete="off" v-model="accsearchid"     name="accsearchid" id="accsearchid" placeholder="Search COA...">
                    <ul id="areabox5" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.accsearch && searchedaccounts.length>0">

                        <li class="fbb" :class="'ccs'+key" @click="accountdatavalue(itd.id)" v-for="(itd,key) in searchedaccounts.filter((a)=>{return a.cost_center==this.unitsearchid})">
                            <a href="javascript:void(0)">{{itd.code}} - {{itd.name}}</a>
                        </li>
                    </ul>
                </div>

            </div>


            <div class="col-lg">

                <multiselect track-by="name" label="name" placeholder="Choose Categories" v-model="category" :multiple="true" :options="(()=>{let x=[];
            categories.forEach((a)=>{
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
                        <th class="wd-20p">COST CENTER</th>
                        <th class="wd-15p">CODE</th>
                        <th class="wd-25p">NAME</th>
                        <th class="wd-25p">PARENT</th>
                        <th class="wd-15p">CATEGORY</th>

<!--   <th class="wd-5p hidden-print">EDIT</th>    -->
                        <th class="wd-5p hidden-print">DELETE</th>
                    </tr>
                    </thead>
                    <tbody :style="'font-size:15px'">
                    <tr v-for="(tr,key) in

                sliceP(
                     (()=>{
                      let  x=filterData(sales);

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
                        <td>{{tr.costcentername}}</td>
                        <td>{{tr.code}}</td>
                        <td>{{tr.name}}</td>
                        <td>{{tr.parentname}}</td>
                        <td>{{tr.categoryname}}</td>


<!--                        <td class="hidden-print"><button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" :href="'/food-and-beverage/sales/sales-aeu/' + tr.id"><i class="fas fa-edit"></i></a></button></td>
                       -->

                        <td class="hidden-print"><button class="buttoncolor" @click="deleteme(tr.id,tr.remarks);" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
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
                                <option :value="sales.length" >ALL</option>
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
    name: "coadt",
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
            gts:[],
            status:'All',
            ent:'Include ENT & CTS',
            cts:'Include CTS',
            page:1,
            pagelength:50,
            leng:0,
            onLine: null,
            onlineSlot: 'online',
            offlineSlot: 'offline',
            sales:[],
            salesR:[],
            salesM: [],
            booking_no:'',
            start_date:'',
            end_date:'',
            customers:[],
            customer:'',
            mog:2,
            searchId:null,
            restaurant_locations:[],
            restaurant:[],
            table_defs:[],
            tabledef:[],
            waiter_defs:[],
            users:[],
            waiter:[],
            cashier:[],
            specific:0,
            json_data: [],
            fkey:-1,
            ffkey:0,
            exported:'',
            deletethisid:'',
            DeleteTheInvoice:false,
            remarks:'',
            ent_details:[],
            ent_detail:[],

            ccs:[],
            searchedunits:[],
            searchedaccounts:[],
            unitalreadySearched:false,
            accountalreadySearched:false,
            unitsearch:'',
            accsearch:'',
            unitsearchid:'',
            accsearchid:'',
            categories:[],
            category:[],
        }
    },
    computed: {

    },
    methods:{
        fup(){

        },fdown(){
            console.log(1)

        },
    udf3(event){

        if(event==0){
            if(this.fkey!=this.searchedunits.length){

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




    },udf4(event){

        if(event==0){
            if(this.ffkey!=this.searchedaccounts.length-1){

                this.ffkey=this.ffkey+1
            }
            $('.ccs'+this.ffkey +' a').focus();

            // $('.fba'+this.ffkey).focus();
            // event.preventDefault()
        }if(event==1){

            if(this.ffkey!=0){

                this.ffkey=this.ffkey-1
            }
            $('.ccs'+this.ffkey+' a').focus();

            // event.preventDefault()
        }




    },
        unitsdata(){
            this.$http.post('/search/coa/unitsdatalike',{searchid:this.unitsearch}).then(result=>{
                let data =result.data;
                console.log(result.data);
                data.filter((a)=>{a.unitsearch=a.name })

                if(data){

                    this.searchedunits=data;

                }
            });
        },
        unitdatavalue(val,m){
            this.searchedunits=[];
            let r='';

            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/coa/unitdata?MOC='+r,{theid:val}).then(result=>{
                let data =result.data;
                if(data){
                    this.unitalreadySearched=true;
                    this.unitsearch=data.name;
                    this.unitsearchid=data.code;

                }
            });
        },
        accountdata(){
            this.$http.post('/search/coa/coaaccountdatalike',{searchid:this.accsearch}).then(result=>{
                let data =result.data;
                console.log(result.data);
                data.filter((a)=>{a.accsearch=a.name})

                if(data){

                    this.searchedaccounts=data;

                }
            });
        },
        accountdatavalue(val,m){
            this.searchedaccounts=[];
            let r='';

            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/coa/coaaccountdata?MOC='+r,{theid:val}).then(result=>{
                let data =result.data;
                if(data){
                    this.accountalreadySearched=true;
                    this.accsearch=data.name;
                    this.accsearchid=data.code;

                }
            });
        },
        afterdel:function(){
            let data={
                remarks:this.remarks
            };
            let url='/coa-new/delete/controls/'+this.deletethisid;
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
        filterData(sales){
            let   x=sales;

            if(this.category.length>0){
                x=x.filter((a)=>{return this.category.filter((m)=>{
                    return a.category_id==m.id;
                }).length>0});
            }
            if (this.unitsearch){
                x=x.filter((a)=>{return a.cost_center==this.unitsearchid});
            }
            if (this.accsearch){
                x=x.filter((a)=>{return a.code==this.accsearchid});
            }
            else{
                x=x;
            }
            return x;
        },
        amIOnline(e) {
            this.onLine = e;
        },
        sliceP(sales){
            // console.log(123);
            this.salesM=sales;
            // this.json_data=this.salesM;
            return  sales.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
        },
        init:function () {

            this.$http.get('/finance-and-management/COA-listing/init_vue').then(result=>{
                let data=result.data;
                this.categories=data.categories;
                this.ccs=data.ccs;
                this.sales=data.sales;
                this.salesR=data.sales;
                this.leng=data.sales.length;

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

                        if(a.active==1){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Active' + ')'
                        }
                        else if(a.active==2){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Expired' + ')'
                        }
                        else if(a.active==3){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Suspended' + ')'
                        }
                        else if(a.active==4){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Terminated' + ')'
                        }
                        else if(a.active==5){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Absent' + ')'
                        }
                        else if(a.active==6){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Cancelled' + ')'
                        }
                        else if(a.active==7){
                            a.name=fullname + ':' + a.mem_no + ' ' + '(' + 'Not Assigned' + ')'
                        }
                    })
                }
                else if(v==3){
                    data.filter((a)=>{a.name=a.name + ' ' + a.id + ' ' + '('+ a.hrcompany.desc + ' '+ '-' + ' ' + a.designation +')'})
                    data.filter((a)=>{a.name=a.name + ' ' + a.id + ' ' + '('+ a.hrcompany.desc + ' '+ '-' + ' ' + a.designation +')'})
                }
                else{
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
            this.$http.post('/search/customerdata?inv=1&MOC='+v+r,{customerid:val}).then(result=>{
                let data =result.data;

                if(data){
                    this.searchId
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
                        this.ledger_amount=data.balance;
                        this.invoices=data.invoices;
                        let self=this;
                        this.invoices.forEach(function(i){
                            i.sum=0;
                            i.sum2=0;
                            i.receipts.forEach(function(x){
                                i.sum=i.sum+x.receipt_details.trans_amount;

                            })

                            if(self.id){
                                i.receipts2.forEach(function(x){
                                    i.sum2=i.sum2+x.receipt_details.trans_amount;

                                })
                                i.p=(i.sum2);
                                if(i.p>0){
                                    self.transChecked.push(i.id);

                                }
                            }

                        })
                    }
                    else if (v == 3) {
                        this.employee_id = data.id;
                        this.customer = data.name;
                        this.guest_contact = data.mob_a;
                        this.ledger_amount=data.balance;
                        this.invoices=data.invoices;
                        let self=this;
                        this.invoices.forEach(function(i){
                            i.sum=0;
                            i.sum2=0;
                            i.receipts.forEach(function(x){
                                i.sum=i.sum+x.receipt_details.trans_amount;

                            })

                            if(self.id){
                                i.receipts2.forEach(function(x){
                                    i.sum2=i.sum2+x.receipt_details.trans_amount;

                                })
                                i.p=(i.sum2);
                                if(i.p>0){
                                    self.transChecked.push(i.id);

                                }
                            }

                        })
                    }
                    else{
                        this.customer_id = data.id;
                        this.customer = data.customer_name;
                        this.guest_contact = data.customer_contact;
                        this.ledger_amount=data.balance;
                        this.invoices=data.invoices;
                        let self=this;
                        this.invoices.forEach(function(i){
                            i.sum=0;
                            i.sum2=0;
                            i.receipts.forEach(function(x){
                                i.sum=i.sum+x.receipt_details.trans_amount;

                            })

                            if(self.id){
                                i.receipts2.forEach(function(x){
                                    i.sum2=i.sum2+x.receipt_details.trans_amount;

                                })
                                i.p=(i.sum2);
                                if(i.p>0){
                                    self.transChecked.push(i.id);

                                }
                            }

                        })
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
        unitsearch:function(){
            if(this.unitsearch.length==0){
                this.unitalreadySearched=false;
            }
            if(!this.unitalreadySearched){
                this.unitsdata();
            }
        },
        accsearch:function(){
            if(this.accsearch.length==0){
                this.accountalreadySearched=false;
            }
            if( !this.accountalreadySearched){
                this.accountdata();
            }
        },
        salesM:function(){
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
