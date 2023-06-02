<template>
<div>
    <vue-snotify></vue-snotify>


    <img class="float-left" :src="'/'+this.profiledata.company_logo" height="100" width="200">



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
    export default {
        name: "invoicesprint",
        json_data: [],
        props: ['member','receiptdata', 'resultant', 'amount_paid', 'storage', 'profiledata','bookingsubdata'],
        data(){
            return{
                page:1,
                pagelength:50,
                leng:0,
                onLine: null,
                onlineSlot: 'online',
                offlineSlot: 'offline',
                items:[],
                itemsR:[],
                itemsM: [],
                item_code:'',
                memberid:'',
                cnic:'',
                contact:'',
                carno:'',
                customers:[],
                customer:'',
                mog:2,
                searchId:null,
                categories:[],
                subcats:[],
                sub_category:[],
                item_def:[],
                item_defs:[],
                category:[],
                itemalreadySearched:false,
                searcheditemsdefs:[],
                code:'',
                searchid:'',
                status:'All',
                json_data: [],
                fkey:-1,
                ffkey:0,
                deletethisid:'',
                DeleteTheInvoice:false,
                remarks:'',
            }
        },

        methods:{
            fup(){

            },fdown(){
                console.log(1)

            },udf(event){
                if(event==0){
                    if(this.fkey!=this.searcheditemsdefs.length){

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
                let url='/food-and-beverage/item-definitions/delete/'+this.deletethisid;
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
            itemsdata(){
                this.$http.post('/search/itemsdatalike',{searchid:this.code}).then(result=>{
                    let data =result.data;

                    data.filter((a)=>{a.code=a.item_details})

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
                        this.code=data.item_details;

                    }
                });
            },
            filterData(items){
             let   x=items;

                if(this.searchid){
                    x=x.filter((a)=>{return a.id==this.searchid});
                }

                if(this.item_code){
                    x=x.filter((a)=>{return a.item_code==this.item_code});
                }

                if(this.code){
                    x=x.filter((a)=>{return a.item_details==this.code});
                }

                if(this.category.length>0){
                    x=x.filter((a)=>{return this.category.filter((m)=>{
                        return a.cate==m.name;
                    }).length>0});

                }

                if(this.sub_category.length>0){
                    x=x.filter((a)=>{return this.sub_category.filter((m)=>{
                        return a.subcat==m.name;
                    }).length>0});

                }

                if(this.item_def.length>0){
                    x=x.filter((a)=>{return this.item_def.filter((m)=>{
                        return a.id==m.id;
                    }).length>0});

                }

                if(this.status){

                    if(this.status=='Active'){
                        x=x.filter((a)=>{return a.activestatus==1});

                    }   else if(this.status=='In-Active'){
                        x=x.filter((a)=>{return a.activestatus==0});
                    }
                    else{
                        x=x;
                    }
                }

                return x;
            },
            amIOnline(e) {
                this.onLine = e;
            },
            sliceP(items){
                // console.log(123);
                this.itemsM=items;
              return  items.slice((this.page-1)*this.pagelength,this.page*this.pagelength)
            },
            init:function () {

                    this.categories=data.cats;
                    this.subcats=data.subcats;
                    this.item_defs=data.item_defs;
                    this.items=data.items;
                    this.itemsR=data.items;
                    this.leng=data.items.length;
                    this.json_data=data.items;

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
            code:function(){
                if(this.code.length==0){
                    this.itemalreadySearched=false;
                }
                if(this.code.length>2 && !this.itemalreadySearched){
                    this.itemsdata();
                }
            },
            itemsM:function(){
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

