<template>
    <div>
        <vue-snotify></vue-snotify>


        <div class="row hidden-print">


            <div class="col-sm-3">
                <datepicker :disabledDates="disabledDates" v-model="start_date" placeholder="From (dd/mm/yyyy)" :clear-button="true" format="dd/MM/yyyy" input-class="form-control" name="start_date"></datepicker>
            </div>

            <div class="col-sm-3">
                <datepicker :disabledDates="disabledDates" v-model="end_date" placeholder="To (dd/mm/yyyy)" :clear-button="true" format="dd/MM/yyyy" input-class="form-control" name="end_date"></datepicker>
            </div>



            <div class="col-sm-4">
                <multiselect track-by="name" label="name" placeholder="Choose Types" v-model="transtype" :multiple="true" :options="(()=>{let x=[];
            transtypes.forEach((a)=>{
                x.push({name:a.name,id:a.id})
            })
            return x;
            })()"></multiselect>
            </div>


            <div class="col-sm-2">
                <button type="button" @click="init(); showTable=true; showFilters=false; " class="btn btn-success">Search</button>
            </div>



        </div>


        <br>

            <div style="text-align: center; color: black; letter-spacing: 0.2em !important;">
                <h5>AFOHS <br>SALES REPORT </h5>

            </div>
            <div style="text-align: center; color: black;">
                <p><strong>Date = Between {{this.start_date | moment("DD/MM/YYYY")}} To {{this.end_date | moment("DD/MM/YYYY")}}, Type = {{this.pluck(this.transtype,'name')}}</strong></p>

            </div>

            <div class="blackcolor headingsetting ">
                <div class="scrollclasstable1">

                    <div>


                        <table class="myFormat table-hover " style="width: 100%;">
                            <tbody>

                            <tr style="border-bottom: 2px solid black;" class="head" >
                                <td><STRONG></STRONG></td>
                                <td><STRONG>GROSS SALE</STRONG></td>
                                <td><STRONG>DISC.</STRONG></td>
                                <td><STRONG>NET SALE</STRONG></td>
                                <td><STRONG>S. TAX</STRONG></td>
                                <td><STRONG>TOTAL SALE</STRONG></td>
                                <td><STRONG>CASH SALE</STRONG></td>
                                <td><STRONG>CREDIT SALE</STRONG></td>
                                <td><STRONG>OTHER SALE</STRONG></td>
                                <td><STRONG>PAID SALE</STRONG></td>
                                <td><STRONG>UNPAID SALE</STRONG></td>
                                <td><STRONG>COVERS / DAYS /NIGHTS</STRONG></td>
                            </tr>
                            <tr>
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                            </tr>




                            <template v-for="(s,key) in sales">




                                <template v-if="s.transid==5 && s.grosssale!=0">
                                    <tr v-if="(key==0) || sales[key-1].cat!=s.cat">
                                        <td colspan="12" class="sub"><u style="text-transform: uppercase;">{{s.cat}}</u></td>
                                    </tr>
                               <tr >
<td></td>
                                    <td>{{s.grosssale | numFormat }}</td>
                                    <td>{{(s.diss).toLocaleString() }}</td>
                                   <td>{{(s.netsale).toLocaleString() }}</td>
                                   <td>{{s.taxx | numFormat }}</td>
                                   <td>{{s.grandd | numFormat }}</td>
                                    <td>{{s.cashgross | numFormat }}</td>
                                    <td>{{s.creditgross | numFormat }}</td>
                                    <td>{{s.othergross | numFormat }}</td>
                                   <td>{{s.paid_amount | numFormat }}</td>
                                   <td>{{parseInt(s.grandd)-parseInt(s.paid_amount) | numFormat }}</td>
                                   <td>{{s.netcovers | numFormat }}</td>
                                </tr>
                                </template>
                                <template v-else-if="s.transid==1 && s.booking_gross!=0">
                                    <tr v-if="(key==0) || sales[key-1].cat!=s.cat">
                                        <td colspan="12" class="sub"><u style="text-transform: uppercase;">{{s.cat}}</u></td>
                                    </tr>
                                    <tr >
                                        <td></td>
                                        <td>{{s.booking_gross | numFormat }}</td>
                                        <td>{{(s.booking_diss) | numFormat}}</td>
                                        <td>{{parseInt(s.booking_grand)-parseInt(s.booking_diss) | numFormat }}</td>
                                        <td>-</td>
                                        <td>{{s.booking_grand | numFormat }}</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>{{s.booking_paid | numFormat }}</td>
                                        <td>{{parseInt(s.booking_grand)-parseInt(s.booking_paid) | numFormat }}</td>
                                        <td>{{s.booking_nights | numFormat }}</td>
                                    </tr>
                                </template>
                                <template v-else-if="s.transid==2 && s.events_gross!=0">
                                    <tr v-if="(key==0) || sales[key-1].cat!=s.cat">
                                        <td colspan="12" class="sub"><u style="text-transform: uppercase;">{{s.cat}}</u></td>
                                    </tr>
                                    <tr >
                                        <td></td>
                                        <td>{{s.events_gross | numFormat }}</td>
                                        <td>{{(s.events_diss) | numFormat }}</td>
                                        <td>{{parseInt(s.events_gross)-parseInt(s.events_diss) | numFormat }}</td>
                                        <td>{{s.events_surcharge | numFormat }}</td>
                                        <td>{{s.events_grand | numFormat }}</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>{{s.events_paid | numFormat }}</td>
                                        <td>{{parseInt(s.events_grand)-parseInt(s.events_paid) | numFormat }}</td>
                                        <td>{{parseInt(s.events_guests)+parseInt(s.extra_guests)  | numFormat }}</td>
                                    </tr>
                                </template>
                                <template v-else-if="s.invoices_gross!=0">
                                    <tr v-if="(key==0) || sales[key-1].cat!=s.cat">
                                        <td colspan="12" class="sub"><u style="text-transform: uppercase;">{{s.cat}}</u></td>
                                    </tr>
                                    <tr >
                                        <td></td>
                                        <td>{{s.invoices_gross | numFormat }}</td>
                                        <td>{{(s.invoices_diss) | numFormat}}</td>
                                        <td>{{parseInt(s.invoices_gross)-parseInt(s.events_diss) | numFormat }}</td>
                                        <td>{{s.invoices_taxx | numFormat }}</td>
                                        <td>{{s.invoices_grand | numFormat }}</td>
                                        <td>{{s.invoices_cash | numFormat }}</td>
                                        <td>{{s.invoices_credit | numFormat }}</td>
                                        <td>{{s.invoices_other | numFormat }}</td>
                                        <td>{{s.invoices_paid | numFormat }}</td>
                                        <td>{{parseInt(s.invoices_grand)-parseInt(s.invoices_paid) | numFormat }}</td>
                                        <td>{{s.invoices_days | numFormat }}</td>
                                    </tr>
                                </template>
                                <template v-else>
                                    <tr>
                                    </tr>
                                </template>
                              <!--  <tr v-if="sales[key+1]==undefined || sales[key+1].cat!=s.cat">

                                     <td style="text-transform: uppercase;  border-top: 1px solid #000!important;"><STRONG>TOTAL:</STRONG></td>
                                     <td style="text-transform: uppercase;  border-top: 1px solid #000!important;"><STRONG>{{s.gsales}}</STRONG></td>
                                     <td style="text-transform: uppercase;  border-top: 1px solid #000!important;"><STRONG>{{Math.round(s.dsales).toFixed(2)}}</STRONG></td>
                                     <td style="text-transform: uppercase;  border-top: 1px solid #000!important;"><STRONG>{{Math.round(s.nsales).toFixed(2)}}</STRONG></td>
                                     <td style="text-transform: uppercase;  border-top: 1px solid #000!important;"><STRONG>{{s.tsales}}</STRONG></td>
                                    <td style="text-transform: uppercase;  border-top: 1px solid #000!important;"><STRONG>{{s.grandsales}}</STRONG></td>
                                    <td style="text-transform: uppercase;  border-top: 1px solid #000!important;"><STRONG>{{s.cashsales}}</STRONG></td>
                                    <td style="text-transform: uppercase;  border-top: 1px solid #000!important;"><STRONG>{{s.creditsales}}</STRONG></td>
                                    <td style="text-transform: uppercase;  border-top: 1px solid #000!important;"><STRONG>{{s.othersales}}</STRONG></td>
                                     <td style="text-transform: uppercase;  border-top: 1px solid #000!important;"><STRONG>{{s.csales}}</STRONG></td>


                                 </tr>-->


                            </template>
                            <tr v-if="sales[key+1]==undefined || sales[key+1].cat!=s.cat">
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                                <td>&nbsp</td>
                            </tr>

                          <tr style="border-top: 2px solid black;">
                                <td><STRONG>GRAND TOTAL:</STRONG></td>
                                <td><STRONG></STRONG></td>
                                <td><STRONG>{{(bb).toLocaleString() }}</STRONG></td>
                                <td><STRONG></STRONG></td>
                                <td><STRONG>{{dd | numFormat }}</STRONG></td>
                                <td><STRONG></STRONG></td>
                              <td><STRONG>{{ff | numFormat }}</STRONG></td>
                              <td><STRONG></STRONG></td>
                              <td><STRONG>{{hh | numFormat }}</STRONG></td>
                              <td><STRONG></STRONG></td>
                              <td><STRONG>{{parseInt(ee)-parseInt(jj) | numFormat }}</STRONG></td>
                              <td><STRONG></STRONG></td>
                            </tr>
                            <tr style="border-bottom: 2px solid black;">
                                <td><STRONG></STRONG></td>
                                <td><STRONG>{{aa | numFormat }}</STRONG></td>
                                <td><STRONG></STRONG></td>
                                <td><STRONG>{{ (parseInt(aa)-parseInt(bb))+parseInt(cc) | numFormat }}</STRONG></td>
                                <td><STRONG></STRONG></td>
                                <td><STRONG>{{ee | numFormat }}</STRONG></td>
                                <td><STRONG></STRONG></td>
                                <td><STRONG>{{gg | numFormat }}</STRONG></td>
                                <td><STRONG></STRONG></td>
                                <td><STRONG>{{jj | numFormat }}</STRONG></td>
                                <td><STRONG></STRONG></td>
                                <td><STRONG>{{ii | numFormat }}</STRONG></td>

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
                        <br>
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
.cat{
    background: #ffff;
    font-weight: bold;
    padding: 9px 0 9px;
}
.sub{
    /*  border-top: 1px solid #000!important;*/
    text-align: center;
    font-weight: bold;
    padding: 0 0 20px;
}

</style>
<script>
import Datepicker from 'vuejs-datepicker';
export default {
    name: "salesdt",
    components: {
        Datepicker
    },
    props: [],
    data(){
        return{
            disabledDates: {
                from: new Date(),
            },
            order_type:[],
            itemalreadySearched:false,
            searcheditemsdefs:[],
            status:'All',
            page:1,
            keysss:0,
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
            transtypes:[],
            transtype:[],
            table_defs:[],
            tabledef:[],
            waiter_defs:[],
            waiter:[],
            cate:0,
            sub_cat:0,
            categories:[],
            subcategories:[],
            users:[],
            cashier:[],
            items:[],
            item:0,
            specific:0,
            getRe:false,
            showFilters:true,
            showTable:false,
            stsalePrice:0,
            aa:0,
            bb:0,
            cc:0,
            dd:0,
            ee:0,
            ff:0,
            gg:0,
            hh:0,
            ii:0,
            jj:0,
            stdics:0,
            ssubtt:0,
        }
    },
    computed: {
        totals() {
            let  x=(this.sales);



        }
    },
    methods:{
        filterData(sales){
            let   x=sales;
            if(this.booking_no){
                x=x.filter((a)=>{return a.invoice_no==this.booking_no});

            }

            if(this.specific){
                if(this.specific==1){
                    x=x.filter((a)=>{return a.discount!=0 && a.discount!=null});

                }
                if(this.specific==2){
                    x=x.filter((a)=>{return a.tax!=0 && a.tax!=null});

                }

            }

            if(this.transtype.length>0){
                x=x.filter((a)=>{return this.transtype.filter((m)=>{
                    return a.transid==m.id;
                }).length>0});

            }

            /*if(this.tabledef.length>0){
                x=x.filter((a)=>{return this.tabledef.indexOf(parseInt(a.table_definition))!=-1});

            }*/

            if(this.tabledef.length>0){
                x=x.filter((a)=>{return this.tabledef.filter((m)=>{
                    return a.table_definition==m.id;
                }).length>0});

            }

            if(this.waiter.length>0){
                x=x.filter((a)=>{return this.waiter.filter((m)=>{
                    return a.waiter_definition==m.id;
                }).length>0});

            }


            if(this.start_date){
                x=x.filter((a)=>{return moment(a.date,'YYYY-MM-DD').format('x')>=moment(moment(this.start_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});

            }
            if(this.end_date){
                x=x.filter((a)=>{return moment(a.date,'YYYY-MM-DD').format('x')<=moment(moment(this.end_date).format('YYYY-MM-DD'),'YYYY-MM-DD').format('x')});
            }  if(this.status){

                if(this.status=='Paid'){
                    x=x.filter((a)=>{return (parseInt(a.grand_total-a.paid_amount))==0});

                }   else if(this.status=='Unpaid'){
                    x=x.filter((a)=>{return (parseInt(a.grand_total-a.paid_amount))>0});

                }   else if(this.status=='Advance'){
                    x=x.filter((a)=>{return (parseInt(a.grand_total-a.paid_amount))<0});

                }
                else{
                    x=x;
                }
            }
            if (this.searchId){

                x=x.filter((a)=>{return a.customer_id==this.searchId});

            }
            if(this.mog!=2) {

                x=x.filter((a)=>{
                    if(this.mog==1)
                        return a.type==1
                    else if(this.mog==0)
                        return a.type==0
                    else if(this.mog==3)
                        return a.type==3
                });
            }
            else{
                x=x;
            }
            return x;
        },
        itemsdata(){
            this.$http.post('/search/itemsdatalike',{searchid:this.booking_no}).then(result=>{
                let data =result.data;

                data.filter((a)=>{a.booking_no=a.item_code + ' ' + '-'+ ' ' + a.item_details})

                if(data){

                    this.searcheditemsdefs=data;

                }
            });
        },
        itemsdatavalue(val,m){
            this.searcheditemsdefs=[];
            let r='';

            if(m){
                r='&r='+m;
            }
            this.$http.post('/search/itemsdata?inv=1&MOC='+r,{theid:val}).then(result=>{
                let data =result.data;
                if(data){
                    this.itemalreadySearched=true;
                    this.booking_no=data.item_code;

                }
            });
        },
        amIOnline(e) {
            this.onLine = e;
        },
        sliceP(sales){
            // console.log(123);
            this.salesM=sales;
            return  sales.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
        },
        init:function () {

            let x='';
            if(this.transtype){
                x+='&transtype='+this.pluck(this.transtype,'id').join(',');
            }
            if(this.tabledef){
                x+='&tables='+this.pluck(this.tabledef,'id').join(',');
            }
            if(this.waiter){
                x+='&waiter='+this.pluck(this.waiter,'id').join(',');
            }
            if(this.order_type){
                x+='&order_type='+this.pluck(this.order_type, 'name').join(',');
            }
            if(this.mem_id_){

                x+='&mem='+this.mem_id_;
            } if(this.mog){

                x+='&mog='+this.mog;
            } if(this.specific){

                x+='&discounted='+this.specific;
            } if(this.customer_id){

                x+='&mem='+this.customer_id;
            }
            if(this.cate){
                x+='&category='+this.cate;
            }
            if(this.sub_cat){
                x+='&sub_category='+this.sub_cat;
            }
            if(this.item){
                x+='&item='+this.item;
            }


            /*if(this.cate){
                x+='&category='+this.pluck(this.cate,'id').join(',');
            } */
            /*if(this.sub_cat){
                x+='&sub_category='+this.pluck(this.sub_cat,'id').join(',');
            } */
            if(this.booking_no){
                x+='&item_code='+this.booking_no;
            } if(this.cashier){
                x+='&cashier='+this.pluck(this.cashier,'id').join(',');
            }  if(this.start_date){
                x+='&start_date='+moment(this.start_date).format('YYYY-MM-DD');
            }  if(this.end_date){
                x+='&end_date='+moment(this.end_date).format('YYYY-MM-DD');
            }if(this.getRe){
                x+='&r='+1;
            }/*if(this.item){
                    x+='&item='+this.pluck(this.item,'id').join(',');
                }*/
            this.$http.get('/finance-and-management/reports/finance-sales-report/salesreport_init_vue?1=1'+x).then(result=>{
                let data=result.data;
                if(!data.sales){
                    data.sales=[];
                }
                this.transtypes=data.transtypes;
                this.table_defs=data.table_defs;
                this.waiter_defs=data.waiter_defs;

                if(this.getRe){
                    let a=0;
                    let b=0;
                    let c=0;
                    let d=0;
                    let e=0;
                    let f=0;
                    let g=0;
                    let h=0;
                    let i=0;
                    let aa=0;
                    let bb=0;
                    let cc=0;
                    let dd=0;
                    let ee=0;
                    let ff=0;
                    let gg=0;
                    let hh=0;
                    let ii=0;
                    let jj=0;
                    let x=data.sales;
                    //console.log(1);
                    x.forEach(function (s,key) {
                        a=a+parseInt(s.grosssale);
                        b=b+parseFloat(s.diss);
                        c=c+parseFloat(s.netsale);
                        d=d+(parseInt(s.taxx));
                        e=e+(parseInt(s.grandd));
                        f=f+(parseInt(s.cashgross));
                        g=g+(parseInt(s.creditgross));
                        h=h+(parseInt(s.othergross));
                        i=i+(parseInt(s.netcovers?s.netcovers:0));
                        aa=aa+parseInt(s.grosssale ? s.grosssale:0)+parseInt(s.booking_gross?s.booking_gross:0)+parseInt(s.events_gross?s.events_gross:0)+parseInt(s.invoices_gross?s.invoices_gross:0);
                        bb=bb+parseFloat(s.diss?s.diss:0)+parseInt(s.booking_diss?s.booking_diss:0)+parseInt(s.events_diss?s.events_diss:0)+parseInt(s.invoices_diss?s.invoices_diss:0);
                        cc=cc+parseFloat(s.netsale?s.netsale:0);
                        dd=dd+(parseInt(s.taxx?s.taxx:0))+parseInt(s.events_surcharge?s.events_surcharge:0)+parseInt(s.invoices_taxx?s.invoices_taxx:0);
                        ee=ee+(parseInt(s.grandd?s.grandd:0))+parseInt(s.booking_grand?s.booking_grand:0)+parseInt(s.events_grand?s.events_grand:0)+parseInt(s.invoices_grand?s.invoices_grand:0);
                        ff=ff+(parseInt(s.cashgross?s.cashgross:0));
                        gg=gg+(parseInt(s.creditgross?s.creditgross:0));
                        hh=hh+(parseInt(s.othergross?s.othergross:0));
                        ii=ii+(parseInt(s.netcovers?s.netcovers:0))+parseInt(s.booking_nights?s.booking_nights:0)+parseInt(s.events_guests?s.events_guests:0)+parseInt(s.extra_guests?s.extra_guests:0)+parseInt(s.invoices_days?s.invoices_days:0);
                        jj=jj+(parseInt(s.paid_amount?s.paid_amount:0))+parseInt(s.booking_paid?s.booking_paid:0)+parseInt(s.events_paid?s.events_paid:0)+parseInt(s.invoices_paid?s.invoices_paid:0);
                        if( x[key+1]==undefined ||  x[key+1].cat!=s.cat){
                            s.gsales=a;
                            s.dsales=b;
                            s.nsales=c;
                            s.tsales=d;
                            s.grandsales=e;
                            s.cashsales=f;
                            s.creditsales=g;
                            s.othersales=h;
                            s.csales=i;
                            a=0;
                            b=0;
                            c=0;
                            d=0;
                            e=0;
                            f=0;
                            g=0;
                            h=0;
                            i=0;
                        }

                    })
                    this.aa=aa
                    this.bb=bb
                    this.cc=cc
                    this.dd=dd
                    this.ee=ee
                    this.ff=ff
                    this.gg=gg
                    this.hh=hh
                    this.ii=ii
                    this.jj=jj
                }
                this.sales=data.sales;
                this.salesR=data.sales;
                this.leng=data.sales.length;
                this.getRe=true;
                this.categories=data.category;
                this.subcategories=data.sub_category;
                this.users=data.created_by;
                this.items=data.items;

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
        booking_no:function(){
            if(this.booking_no.length==0){
                this.itemalreadySearched=false;
            }
            if(this.booking_no.length>2 && !this.itemalreadySearched){
                this.itemsdata();
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
            //  this.init(this.id);

            // this.init(id.id);

        }
        else{
            //this.init();

        }
        this.init();
    }
}
</script>

