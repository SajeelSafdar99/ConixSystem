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

                                <span style="color: black;">Do you really want to Delete this Order Sheet ?</span>
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

                <input value="" class="form-control tablikebutton" type="number"
                       id="serial_no" v-model="serial_no"
                       name="serial_no" placeholder="Search ID">
        </div>
        <div class="col-lg">
            <div>

                <datepicker :disabledDates="disabledDates" v-model="start_date" :clear-button="true" placeholder="From Issue Date (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="start_date"></datepicker>

            </div>
        </div>
        <div class="col-lg">
            <div>

                <datepicker :disabledDates="disabledDates" v-model="end_date" :clear-button="true" placeholder="To Issue Date (dd/mm/yyyy)" format="dd/MM/yyyy" input-class="form-control" name="end_date"></datepicker>
            </div>
        </div>

        <div class="col-lg">

            <multiselect track-by="name" label="name" placeholder="Choose Departments" v-model="department" :multiple="true" :options="(()=>{let x=[];
            departments.forEach((a)=>{
                x.push({name:a.desc,id:a.id})
            })
            return x;
            })()"></multiselect>
        </div>

    </div>
<br>
    <div class="scrollclasstable1">

        <div>


            <table class="table-striped table-bordered table-hover ">
                <thead :style="'font-size:15px'">
                <tr>

                    <th class="wd-5p">SR #</th>
                    <th class="wd-5p">ORDER SHEET #</th>
                    <th class="wd-10p">ISSUE DATE</th>
                    <th class="wd-15p">DEPARTMENT</th>
                    <th class="wd-60p">DESCRIPTION</th>
                    <th class="wd-5p hidden-print">INVOICE</th>
                    <th class="wd-5p hidden-print">EDIT</th>
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
                    <td>{{tr.serial_no}}</td>
                    <td>{{moment(tr.issue_date).format('DD/MM/YYYY')}}</td>

                    <td>{{tr.department}}</td>
                    <td>{{tr.description}}</td>
                    <td class="hidden-print"><button class="buttoncolor" title="Print Invoice"><a style="color:#000000;" target="_blank" :href="'/maintenance-management/work-order-sheet/work-order-sheet-invoice/' + tr.id"><i class="fa fa-print" aria-hidden="true"></i></a></button></td>
                    <td class="hidden-print"><button class="buttoncolor" title="Edit"><a style="color:#000000;" target="_blank" :href="'/maintenance-management/work-order-sheet/work-order-sheet-aeu-vue/' + tr.id"><i class="fas fa-edit"></i></a></button></td>
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
        name: "workordersheetdt",
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
                sales:[],
                salesR:[],
                salesM: [],
                json_data: [],
                fkey:-1,
                ffkey:0,
                departments:[],
                department:[],
                serial_no:'',
                start_date:'',
                end_date:'',
                customers:[],
                deletethisid:'',
                DeleteTheInvoice:false,
                remarks:'',
            }
        },
        computed: {

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
                let url='/maintenance-management/work-order-sheet/delete/'+this.deletethisid;
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
                if(this.serial_no){
                    x=x.filter((a)=>{return a.serial_no==this.serial_no});
                }

                if(this.department.length>0){
                    x=x.filter((a)=>{return this.department.filter((m)=>{
                        return a.department==m.name;
                    }).length>0});

                }

                if(this.start_date){
                    x=x.filter((a)=>{return moment(a.issue_date,'YYYY-MM-DD').format('x')>=moment(moment(this.start_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});

                }
                if(this.end_date){
                    x=x.filter((a)=>{return moment(a.issue_date,'YYYY-MM-DD').format('x')<=moment(moment(this.end_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
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

                this.$http.get('/maintenance-management/work-order-sheet/sheet_init_vue').then(result=>{
                    let data=result.data;

                    this.departments=data.departments;
                    this.sales=data.sales;
                    this.json_data=data.sales;
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
                        else if (v == 1) {
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

