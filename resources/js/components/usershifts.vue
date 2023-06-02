


<template>

    <div>
      <!--  <div class="row">
            <template v-if="this.shift==''">
            <button @click="start_shift()" class=" btn btn-outline-success ">START SHIFT</button> &nbsp&nbsp <span style="margin-top: 10px;" class="text-danger">PLEASE START SHIFT TO SAVE ORDER !</span>
            </template>
            <template v-else>
                <button @click="end_shift()" class=" btn btn-outline-danger ">END SHIFT &nbsp&nbsp <span style="margin-top: 10px;" class="text-success">({{this.shift | moment("DD/MM/YYYY")}})</span></button>
            </template>
        </div>-->
        <br>
        <vue-snotify></vue-snotify>
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


        <div v-if="shiftAlertEnd">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h5 class="modal-title"><strong>LOGOUT</strong></h5>
                                    <!--<button type="button" class="close" @click="shiftAlertEnd=false">
                                        <span aria-hidden="true">&times;</span>
                                    </button>-->
                                </div>
                                <div class="modal-body">

                                    <span>You are about to logout from the POS Location {{this.pos?this.alllocs.filter((a)=>{return a.id==this.pos})[0].name:''}} !</span>

                                    <br>

                                </div>
                                <div class="modal-footer">
                                    <input @click="end_shift();" :disabled="disableds" :class="' btn btn-success'" type="button" :value="'YES'">
                                    <a href="/food-and-beverage" > <button type="button" class="btn btn-danger">NO</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
        <div v-if="shiftAlert">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h5 class="modal-title"><strong>LOGIN</strong></h5>

                                </div>
                                <div class="modal-body">
                                    <div class="row  mg-t-10">
                                        <label class="col-sm-4 form-control-label"><span style="font-size: 16px;"> POS Location: </span></label>
                                    <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                        <select v-model="pos_location"  class="form-control">
                                            <option value="">Choose Option</option>
                                            <option :value="e.id" v-for="e in alllocs">{{e.name}}</option>
                                        </select>
                                    </div>
                                    </div>

                                    <br>

                                </div>
                                <div class="modal-footer">
                                    <input @click="start_shift(); " :disabled="disableds"  :class="' btn btn-success'" type="button" :value="'YES'">
                                    <a href="/food-and-beverage" ><button type="button" class="btn btn-danger">NO</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
        <template v-if="this.shift==undefined ">
            <div v-if="showStartShift">
                <transition name="modal">
                    <div class="modal-mask">
                        <div class="modal-wrapper">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">

                                        <h5 class="modal-title"><strong>SHIFT DETAILS</strong></h5>
                                        <!-- <button type="button" class="close" @click="showStartShift=false">
                                             <span aria-hidden="true">&times;</span>
                                         </button>-->
                                    </div>
                                    <div class="modal-body">

                                        <span>Please Start your Shift before taking Orders !</span>

                                        <br>

                                    </div>
                                    <div class="modal-footer">
                                        <input @click="shiftAlert=true; showStartShift=false;"  :class="' btn btn-success'" type="button" :value="'START SHIFT'">
                                        <a href="/food-and-beverage" > <button type="button" class="btn btn-secondary" >CANCEL</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </template>
        <template v-else-if="  this.shift==1 ">
            <div v-if="showStartShift">
                <transition name="modal">
                    <div class="modal-mask">
                        <div class="modal-wrapper">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">

                                        <h5 class="modal-title"><strong>SHIFT DETAILS</strong></h5>
                                       <!-- <button type="button" class="close" @click="showStartShift=false">
                                            <span aria-hidden="true">&times;</span>
                                        </button>-->
                                    </div>
                                    <div class="modal-body">

                                            <span>Please Start your Shift before taking Orders !</span>

                                        <br>

                                    </div>
                                    <div class="modal-footer">
                                        <input @click="shiftAlert=true; showStartShift=false;"  :class="' btn btn-success'" type="button" :value="'START SHIFT'">
                                        <a href="/food-and-beverage" > <button type="button" class="btn btn-secondary" >CANCEL</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </template>
        <template v-else>
            <div v-if="showEndShift">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h5 class="modal-title"><strong>SHIFT DETAILS</strong></h5>

                                </div>
                                <div class="modal-body">

                                        <span>You are currently logged in at {{this.pos?this.alllocs.filter((a)=>{return a.id==this.pos})[0].name:''}}.<br>Press "End Shift" if you want to logout of this Shift !</span>

                                    <br>

                                </div>
                                <div class="modal-footer">
                                    <input @click="shiftAlertEnd=true; showEndShift=false;" :class="'btn btn-danger'" type="button" :value="'END SHIFT'">
                                    <a href="/food-and-beverage" ><button type="button" class="btn btn-info">CONTINUE</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
            </div>
        </template>



    </div>
</template>

<script>
    export default {
        name: "usershifts",
        props: ['idm','datatableid'],
        data(){
            let s=this.idm;

          return  {
              id:s,
              onLine: null,
              onlineSlot: 'online',
              offlineSlot: 'offline',

              shift:'',
              showEndShift:true,
              showStartShift:true,
              shiftAlert:false,
              shiftAlertEnd:false,
              pos_location:'',

              alllocs:[],

              pos:'',
              disableds:false,
          }
        },
       /* computed: {
            searcheditemdefs() {

                return this.itemdefs.filter(item => {
                    return item.item_code.toLowerCase().includes(this.search.toLowerCase())
                })
            }
        },*/
        watch:{
            sResturant:function(){
                let self=this;
               /* this.sResturantName=this.resturants.filter(function(a){return a.id==self.sResturant})[0].desc;*/
                this.getTables();
            },
            sCategory:function(){
              //  this.getSubCats();
            },
           /* sAccHead:function(){
                this.getAccountTyes();
            },*/
            sSubCat:function(){
                if(this.sSubCat!=''){
                    this.getItemDefs();
                }

            },
            customer:function(){
                if(this.customer.length==0){
                    this.alreadySearched=false;
                }
                if(this.customer.length>2 && !this.alreadySearched){
                this.customerdata();
                }
            },
            discountcard:function(){
                if(this.discountcard==0){
                    this.alreadySearchedDisc=false;
                }
                if(!this.alreadySearchedDisc && this.discountcard>0 ) {
                    this.discountdata();
                }
            },
            search:function(){
                if(this.search.length==0){
                    this.itemalreadySearched=false;
                }
                if(this.search.length>2 && !this.itemalreadySearched){
                    this.itemsdata();
                }
            },
            hideHeader:function(){

                    $('.breadcrumbee,.border-menu,.br-header,.br-logo,img[title="Reload Page"]').toggle();
                    $('.br-pagebody').css({'padding':'0px','margin':'0px'})

            }
        },

        methods: {
            amIOnline(e) {
                this.onLine = e;
            },
            slideright: function () {
                $('.scrollclass').addClass('slideright');

            },
            table_open: function (tableid) {
                this.init();
                /*
window.location.href='/food-and-beverage/sales/sales-aeu?t='+tableid;*/
            },
            booked_open: function (tableid) {
                let data = {};
                let url = '/food-and-beverage/sales/sales-aeu/booked/' + tableid;
                data.id = tableid;

                this.$http.get(url, data).then(result => {
                    this.init(result.data);
                    /* window.location.href = "/food-and-beverage/sales/sales-aeu/"+result.data;*/
                });

            },
            printed_open: function (tableid) {
                let data = {};
                let url = '/food-and-beverage/sales/sales-aeu/printed/' + tableid;
                data.id = tableid;

                this.$http.get(url, data).then(result => {
                    this.init(result.data);
                    /*window.location.href = "/food-and-beverage/sales/sales-aeu/"+result.data;*/
                });

            },
            validation: function (data, valid) {
                let self = this;
                let mm = 0;
                valid.forEach((a) => {
                    if (data[a] == '' || data[a] == null) {
                        self.$snotify.error(a + ' is required!');
                        mm++
                    }

                })
                return mm;
            },

            start_shift:function(){
                this.disableds=true;
                let data={
                    pos_location: this.pos_location
                };
                let url='/food-and-beverage/sales/start_user_shift';

                data.id=this.id;

                if(this.validation(data,['pos_location'])==0){
                    this.disableds=true;
                this.$http.post(url,data).then(result=>{

                    window.location.href = "/food-and-beverage";

                });
                }
                else{
                    this.disableds=false;

                }

            },
            end_shift:function(){
                this.disableds=true;
                let data={
                    pos_location: this.pos
                };
                let url='/food-and-beverage/sales/end_user_shift';

                data.id=this.id;

                if(this.validation(data,['pos_location'])==0){
                this.$http.post(url,data).then(result=>{
                    this.disableds=true;
                    window.location.href = "/food-and-beverage";

                });
                }
                else{
                    this.disableds=false;

                }

            },
            discountcardamt:function(){
                let pc_var = parseFloat((this.disc)/(this.varGross)*100);
                //console.log(pc_var);

                this.disc_pc=(Math.round((pc_var) * 100) / 100).toFixed(1);
                this.discountcardpc();

            },

            modalopen:function(){
                if(this.selected_items[this.active_el].saved!=1) {
                    if (this.selected_items[this.active_el])
                        this.showModal = true;
                    else
                        this.showModal = false;
                }
            },
            modalpaymentopen:function(){

                    this.showModalPayment = true;

            },
            move_table:function(){
                this.showModaltoMove = true;
            },
            modalok:function(){
                this.instruction='';
                this.showModal=false;
            },
            canceldone:function(){
                if(this.alternativeqty== this.selected_items[this.active_el].qty){
                    if(this.alternativeqty!=''){
                        let save = (JSON.parse(JSON.stringify(this.selected_items[this.active_el])));
                        let myitem =this.selected_items[this.active_el];
                        let alter = this.selected_items[this.active_el].qty - this.alternativeqty;
                        // let clone = (JSON.parse(JSON.stringify(myitem)));
                        myitem.status='Cancelled';
                        myitem.sale_price=0;
                        myitem.kot=null
                        myitem.qty=this.alternativeqty;
                        myitem.item_discount=0;
                        myitem.remark=this.sCancelledRemark;
                        myitem.aftercancel=this.aftercancel;
                        let clone = (JSON.parse(JSON.stringify(myitem)));
                        if(this.alternativeqty!=''){
                            //this.selected_items[this.active_el].qty=this.alternativeqty;
                            if(alter!=0){
                                // clone.qty=alter;
                                this.selected_items[this.active_el]= save;
                                this.selected_items[this.active_el].qty = alter;
                            }
                            else{
                                this.selected_items.splice(this.active_el,1);
                            }

                            clone.sub_category=this.sSubCat;
                            this.selected_items.unshift(clone);



                        }
                        this.alternativeqty='';
                        this.instruction='';
                        this.sCancelledRemark=0;
                        this.aftercancel='Void';
                        this.showCancellationModal=false;
                        let self=this
                        setTimeout(function(){
                            if(self.disc_pc!=''){
                                self.discountcardpc();



                            }
                            else if(self.disc!=''){
                                self.discountcardamt();

                            }

                        },100)
                    }
                }
                else{
                    if(this.alternativeqty!=''){
                        let save = (JSON.parse(JSON.stringify(this.selected_items[this.active_el])));
                        let myitem =this.selected_items[this.active_el];
                        let alter = this.selected_items[this.active_el].qty - this.alternativeqty;
                        // let clone = (JSON.parse(JSON.stringify(myitem)));
                        myitem.status='Cancelled';
                        myitem.sale_price=0;
                        myitem.kot_no=null
                        myitem.qty=this.alternativeqty;
                        myitem.item_discount=0;
                        myitem.remark=this.sCancelledRemark;
                        myitem.aftercancel=this.aftercancel;
                        let clone = (JSON.parse(JSON.stringify(myitem)));
                        if(this.alternativeqty!=''){
                            //this.selected_items[this.active_el].qty=this.alternativeqty;
                            if(alter!=0){
                                // clone.qty=alter;
                                this.selected_items[this.active_el]= save;
                                this.selected_items[this.active_el].qty = alter;
                            }
                            else{
                                this.selected_items.splice(this.active_el,1);
                            }

                            clone.sub_category=this.sSubCat;
                            this.selected_items.unshift(clone);



                        }
                        this.alternativeqty='';
                        this.instruction='';
                        this.sCancelledRemark=0;
                        this.aftercancel='Void';
                        this.showCancellationModal=false;
                        let self=this
                        setTimeout(function(){
                            if(self.disc_pc!=''){
                                self.discountcardpc();



                            }
                            else if(self.disc!=''){
                                self.discountcardamt();

                            }

                        },100)
                    }
                }
            },
            enterinsts:function(el){
                this.selected_items[this.active_el].instruction=this.instruction;
            },
            enterquantity:function(el){

                if(this.quantity<1 && this.quantity!='') alert('Please Enter a valid Quantity !');

               /* this.selected_items[this.active_el].qty=this.quantity;*/
            },
            activate:function(el){
                this.active_el = el;
            },
            updatetrstatus:function(el){
                if(this.selected_items[this.active_el].saved==1){
                    if (this.selected_items[this.active_el])
                        this.showCancellationModal = true;
                    else
                        this.showCancellationModal = false;
                }
                /*if(this.selected_items[this.active_el].saved==1){
                this.selected_items[this.active_el].status='Cancelled';
                this.selected_items[this.active_el].sale_price=0;
                this.selected_items[this.active_el].item_discount=0;
                    if (this.selected_items[this.active_el])
                        this.showModal = true;
                    else
                        this.showModal = false;
                }*/
            },
            updatetrplus:function(el){
                if(this.selected_items[this.active_el].saved!=1){
        this.selected_items[this.active_el].qty=this.selected_items[this.active_el].qty-2+3;
       /* this.selected_items[this.active_el].item_discount=parseFloat(this.selected_items[this.active_el].item_discount)+parseFloat(this.selected_items[this.active_el].item_discount);
          */

                        let self=this;
                        setTimeout(function(){
                            if(self.disc_pc!=''){
                                self.discountcardpc();



                            }
                            else if(self.disc!=''){
                                self.discountcardamt();

                            }
                        },100)

                }
        },
            updatetrminus:function(el){
               if(this.selected_items[this.active_el].saved!=1){
                   this.selected_items[this.active_el].qty=this.selected_items[this.active_el].qty-1;

                   let self=this;
                   setTimeout(function(){
                       if(self.disc_pc!=''){
                           self.discountcardpc();



                       }
                       else if(self.disc!=''){
                           self.discountcardamt();

                       }
                   },100)

                   if(this.selected_items[this.active_el].qty==0)
                   {
                       this.selected_items.splice(this.active_el,1);
                   }

               }

            },
            callme:function(){
                this.sType = 'Home Delivery';
            },
            removetr:function(el){
                if(this.selected_items[this.active_el].saved!=1){
                    this.selected_items.splice(this.active_el,1);
                }

            },
            save_to_selected:function(item){
                if(this.quantity==''){
                    this.quantity=1;
                }
                if(this.quantity>0){
                    let clone = (JSON.parse(JSON.stringify(item)));
                    if(this.sTable=='' || this.sType=='') alert('Please select Table & Order Type first !');

                    else{
                        /*clone.tttttt=1;*/

                        clone.qty=this.quantity;
                        clone.sub_category=this.sSubCat;
                        this.selected_items.unshift(clone);
                    }

                    this.quantity='';
                    let self=this;
                    setTimeout(function(){
                        if(self.disc_pc!=''){
                            self.discountcardpc();



                        }
                        else if(self.disc!=''){
                            self.discountcardamt();

                        }
                    },100)

                }

            },
            alternativeqtyrestrict(){
                if(this.alternativeqty>this.selected_items[this.active_el].qty || this.alternativeqty<1 && this.alternativeqty!='') alert('You have entered an unexpected value !');
                if(this.alternativeqty>this.selected_items[this.active_el].qty || this.alternativeqty<1 && this.alternativeqty!='') this.alternativeqty=this.selected_items[this.active_el].qty;
            },
            scroll_left() {
                let content = document.querySelector(".wrapper-box");
                content.scrollLeft -= 50;
            },
            scroll_right() {
                let content = document.querySelector(".wrapper-box");
                content.scrollLeft += 50;
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
            init:function (m) {
                let r='';
                if(m){
                    r='?r='+m;
                }
                this.$http.get('/food-and-beverage/sales/user-shifts-ini'+r).then(result=>{
                    let data =result.data;
if(data.shift){

        this.shift=data.shift.in_out;
        this.pos=data.shift.pos_location;

}



                    this.alllocs=data.alllocs;


                })
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
                        if(this.quantity==''){
                            this.quantity=1;
                        }
                        if(this.quantity>0){
                            let clone = (JSON.parse(JSON.stringify(data, data.qty=this.quantity)));
                            if(this.sTable=='' || this.sType=='') alert('Please select Table & Order Type first !');

                            else
                                clone.sub_category=this.sSubCat;
                            this.selected_items.unshift(clone);
                            this.quantity='';

                            this.search ='';
                        }

                       /* let clone = (JSON.parse(JSON.stringify(data)));
                        if(this.sTable=='' || this.sType=='') alert('Please select Table & Order Type first !');

                        else  this.selected_items.push(clone);*/

                        let self=this;
                        setTimeout(function(){
                            if(self.disc_pc!=''){
                                self.discountcardpc();

                                console.log(123);

                            }
                            else if(self.disc!=''){
                                self.discountcardamt();

                                console.log(123);
                            }
                        },100)

                    }
                });
            },
            itemsdatavalueEnter(val,m){
                this.searcheditemsdefs=[];
                let r='';

                if(m){
                    r='&r='+m;
                }
                this.$http.post('/search/itemsdataenter?inv=1&MOC='+r,{theid:val}).then(result=>{
                    let data =result.data;
                    if(data){
                        this.itemalreadySearched=true;
                        if(this.quantity==''){
                            this.quantity=1;
                        }
                        if(this.quantity>0){
                            let clone = (JSON.parse(JSON.stringify(data, data.qty=this.quantity)));
                            if(this.sTable=='' || this.sType=='') alert('Please select Table & Order Type first !');

                            else clone.sub_category=this.sSubCat;
                            this.selected_items.unshift(clone);

                            this.quantity='';

                            this.search ='';


                        }

                        /* let clone = (JSON.parse(JSON.stringify(data)));
                         if(this.sTable=='' || this.sType=='') alert('Please select Table & Order Type first !');

                         else  this.selected_items.push(clone);*/
                        let self=this;
                        setTimeout(function(){
                            if(self.disc_pc!=''){
                                self.discountcardpc();

                                console.log(123);

                            }
                            else if(self.disc!=''){
                                self.discountcardamt();

                                console.log(123);
                            }
                        },100)

                    }
                });
            },
            itemsdata(){
                this.$http.post('/search/itemsdatalike',{searchid:this.search}).then(result=>{
                    let data =result.data;

                        data.filter((a)=>{a.search=a.item_code + ' ' + '-'+ ' ' + a.item_details})

                    if(data){

                        this.searcheditemsdefs=data;

                    }
                });
            },
            customerdata(){
                let v = this.type;
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
            discountdata(){

                this.$http.post('/search/discountdatalike',{customerid:this.customer_id,customer:this.customer}).then(result=>{
                    let data =result.data;

                        data.filter((a)=>{a.discountcard=a.card_number})

                    if(data) {
                        if(this.customer=='') alert('Please select Customer first !');

                        else

                        this.discountcards=data;

                    }
                });
            },
            customerdatavalue(val,m){
                this.customers=[];
                let v = this.type;
                let r='';

                if(m){
                    r='&r='+m;
                }
                this.$http.post('/search/customerdata?inv=1&MOC='+v+r,{customerid:val}).then(result=>{
                    let data =result.data;
                    if(data){

                        if (v == 0) {
                            this.customer_id = data.id;
                            this.member_id = data.id;
                            let fname=data.first_name?data.first_name+' ':'';
                            let mname=data.middle_name?data.middle_name+' ':'';
                            let lname=data.applicant_name?data.applicant_name:'';

                            this.customer = fname+mname+lname;
                            this.families=data.family;
                            this.ledger_amount=data.balance;
                        }
                        else if (v == 1) {
                            this.customer_id = data.id;
                            this.member_id = '';
                            this.customer = data.customer_name;
                            this.ledger_amount=data.balance;
                        }
                        else if (v == 3) {
                            this.customer_id = data.id;
                            this.member_id = '';
                            this.customer = data.name;
                            this.ledger_amount=data.balance;
                        }

this.alreadySearched=true;
                    }
                });
            },
            discountcardvalue(val){
                this.discountcards=[];

                this.$http.post('/search/discountdata',{discountid:val}).then(result=>{
                    let data =result.data;
                    if(data){
                        this.alreadySearchedDisc=true;
                            this.discountcard = data.card_number;

                            if(data.discount_amount){
                                this.disc = data.discount_amount;
                                this.disc_pc = 0;
                            }
                            else{
                                this.disc_pc = data.discount_percentage;
                                this.disc = 0;
                            }


                    }
                });
            },
            getTables:function(){
                    this.$http.get('/food-and-beverage/sales/tables/'+this.sResturant).then(result=>{
                        let data=result.data;
                        if(data){
                            this.tables=data;
                        }
                    })
            },
            getSubCats:function(){
                this.$http.get('/food-and-beverage/sales/subcategory/0').then(result=>{
                    let data=result.data;
                    if(data){
                        this.subcats=data;
                    }
                })
            },
           /* getAccountTyes:function(){
                this.$http.get('/food-and-beverage/sales/accounttypes/'+this.sAccHead).then(result=>{
                    let data=result.data;
                    if(data){
                        this.acctypes=data;
                    }
                })
            },*/
            getItemDefs:function(){
                this.$http.get('/food-and-beverage/sales/items/'+this.sSubCat).then(result=>{
                    let data=result.data;
                    if(data){
                        this.itemdefs=data;
                    }
                })
            },
            getItemDefs2:function(){
                this.$http.get('/food-and-beverage/sales/items').then(result=>{
                    let data=result.data;
                    if(data){
                        this.itemdefs=data;
                    }
                })
            },
        },

        mounted() {
            setInterval(()=>{
                this.$forceUpdate();
            },500)
            this.$http.get('/printerip').then((a)=>{
                this.printerip=a.data;

            });

            this.getSubCats();
        if(this.id){
            this.init(this.id);
            // this.init(id.id);

        }
        else{
            this.init();

        }

        let x=new URLSearchParams(window.location.search)
        if(x.get('t')){
            this.$http.get('/food-and-beverage/sales/restaurants/'+x.get('t')).then(result=>{
                let data=result.data;
                if(data){
                    this.sResturant=data[0];
                }
            })
            this.sTable=x.get('t');
            /*console.log(x.get('t'));*/
        }

        }
    }
</script>

<style scoped>
.active{
    /*background: green;*/
    background-color: #23BF08;
    color: white;
}
.booked{
    background-color: red;
    color: white;
}
.printed{
    background-color: blue;
    color: white;
}
.ractive{
    border-radius: 25px;
    background-color: #23BF08;
    border: 2px solid #23BF08;
    color: white;
}
.ractive3{
    background-color: #23BF08;
   /* border: 2px solid #23BF08;*/
    color: white;
}
    td{border: 1px solid #f1f1f1;white-space: nowrap; }

th {

    background-color: #49a2fb;
    color: white;
    width: auto;
    border-right: 2px solid #fff;
    font-size: 13px;
    padding: 0px 2px;
    min-width: 33px;
}

    .cursor{cursor: pointer;}
.scrollclass {
    vertical-align: middle;
    overflow-x: scroll;
    overflow: hidden;/* new*/
    height:50px;/* new*/
}

.scrollclasscategory {
    vertical-align: middle;
    overflow-x: scroll;
    overflow: hidden;/* new*/
    height:100px;/* new*/
}
.scrollclasscategory .scrollsub{
    display: inline-block;
    vertical-align: middle;
    height: 50px;/*
    margin-right: -4px;*/
}
.scrollclasstable1{
    vertical-align: middle;
    overflow-x: scroll;
}
.scrollclasstable2{
    height: 229px;
    overflow-y: scroll;
    overflow-y: auto;
}
.slidedown{
    margin-top: -30px;
}

.scrollclassrests{
    vertical-align: middle;
    overflow-y: scroll;
    overflow-y: auto;
    overflow:hidden;
}
.scrollclassrests .scrollsubrests{
    display: inline-block;
    vertical-align: middle;
    text-align: center;
}

.scrollclassy {
    vertical-align: middle;
    overflow-y: scroll;
    overflow-y: auto;
}

.scrollclassy .scrollsuby2{
    display: inline-block;
    vertical-align: middle;
    margin-right: -4px;
}
.scrollclassy .scrollsuby{
    display: inline-block;
    vertical-align: middle;
    height: 50px;
    margin-right: -4px;
}
.scrollclass .scrollsub{
    display: inline-block;
    vertical-align: middle;
    height: 50px;/*
    margin-right: -4px;*/
}
.scrollclass .inner{
}

    .btnfont{
        font-size: 18px !important;
    }

tr > td:hover {
    cursor:pointer;
}

.activatedtr {
    background-color: steelblue;
}
.header
{background-color: cadetblue;}

.slideright{
    margin-left: -200px;
}
.hideShow{
    font-size: 20px;
    top: -33px;
    position: absolute;
    right: 14px;
    background: #7b1c1c;
    height: 30px;
    width: 30px;
    text-align: center;
    padding-top: 3px;
    border-radius: 50%;
    color: #fff;
}
.form-layout-4{
    padding: 8px;
}
.tabledefs {
    border: 2px solid #f1f1f1;
    padding: 12px;
    width: 47px;
    height: 30px;
    cursor: pointer;
    font-size: 13px;
    font-weight: bold;
    padding: 3px;
}
.btn-xsss{
    padding: 0;
    font-size: 10px;
    padding: 3px 4px;
    /* float: right; */
    background: transparent;
    color: #000;
    border: 1px solid #ccc;
    border-radius: 0;
    border: none;
    float: right;
}
input.form-control,select.form-control{
    padding:3px
}
select.family{
    height: 22px!important;
}
.form-group{
    margin-bottom:2px;
}
.btnfont{
    font-size: 16px!important;
    padding: 0;
    height: 25px;
    width: 25px;
    border-radius: 50%;
    text-align: center;
    padding: 0px;
    color: #fff;
    background: #5a5a5a;
    margin-bottom: 4px;
    margin-left: 4px;
}
.finishbuttons input, .finishbuttons button {
    height: 30px;
    width: 88px;
    padding: 1px;
    margin-bottom: 6px;
    text-align: center;
}
.finishbuttons{
    text-align: center;
}
.catdiv {
    border: 2px solid #f1f1f1;
    width: 160px;
    height: 80px;
    cursor: pointer;
    font-size: 14px;
}
.offline {
    background-color: #fc9842;
    background-image: linear-gradient(315deg, #fc9842 0%, #fe5f75 74%);
}
.online {
    background-color: #00b712;
    background-image: linear-gradient(315deg, #00b712 0%, #5aff15 74%);
}
.modal-mask {
    background-color: rgb(0, 0, 0);
}
</style>
