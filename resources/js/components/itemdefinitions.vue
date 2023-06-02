


<template>

    <div>

        <vue-snotify></vue-snotify>

                        <div class="row">
                            <div class="col-sm-10">

                                <div class="row mg-t-10">
                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                            <input type="checkbox" name="salable" id="salable" v-model="salable" >
                                            <label for="salable">Salable</label>
                                    </div>


                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                        <input type="checkbox" name="purchasable" id="purchasable" v-model="purchasable" >
                                        <label for="purchasable">Purchasable</label>
                                    </div>


                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                        <input type="checkbox" name="returnable" id="returnable" v-model="returnable">
                                        <label for="returnable">Returnable</label>
                                    </div>

                                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                        <div class="form-group has-search"  v-on:keydown.up.prevent="udf3(1)" v-on:keydown.down.prevent="udf3(0)">
                                            <input  type="text" class="form-control typeahead" autocomplete="off" v-model="accsearch"  name="accsearch" id="accsearch" placeholder="Search COA...">
                                            <input  type="hidden" class="form-control typeahead" autocomplete="off" v-model="coa_code"  name="coa_code" id="coa_code"  >
                                            <ul id="areabox3" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.accsearch && searchedaccounts.length>0">

                                                <li class="fbb" :class="'ccs'+key" @click="accountdatavalue(itd.id)" v-for="(itd,key) in searchedaccounts">
                                                    <a href="javascript:void(0)">{{itd.code}} - {{itd.name}}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>


                                <div class="row mg-t-10">
                                    <label class="col-sm-1 form-control-label">Item Category:  <span class="tx-danger">  * </span>  </label>
                                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                        <select id="category" v-model="category" name="category" class="form-control input-height select2">
                                            <option label="Choose Option" value=""></option>
                                            <option :value="main.id" v-for="main in mains">
                                                {{ main.desc }}
                                            </option>

                                        </select>
                                    </div>


                                    <label class="col-sm-1 form-control-label">Item Sub-Category:  <span class="tx-danger">  * </span>  </label>
                                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                        <select id="sub_category" v-model="sub_category" name="sub_category" class="form-control input-height select2">
                                            <option label="Choose Option" value=""></option>
                                            <option :value="subcat.id" v-for="subcat in subcats.filter((a)=>{return a.item_category==this.category})">
                                                {{ subcat.desc }}
                                            </option>

                                        </select>

                                    </div>
                                    <label class="col-sm-1 form-control-label">
                                        Manufacturer:

                                    </label>
                                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                        <select id="manufacturer" v-model="manufacturer" name="manufacturer" class="form-control input-height select2">
                                            <option label="Choose Option" value="0"></option>
                                            <option :value="manufacturer.id" v-for="manufacturer in manufacturers">
                                                {{ manufacturer.desc }}
                                            </option>

                                        </select>
                                    </div>

                                </div>
                                <!-- row -->
                                <div class="row mg-t-10">

                                    <label class="col-sm-1 form-control-label">Item Code:  <span class="tx-danger">  * </span>  </label>
                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                        <input :readonly="edime==false?true:false" type="number" id="item_code" name="item_code" v-model="item_code" class="form-control input-height" autocomplete="off" placeholder="Enter Code">
                                    </div>

                                    <div class="col-sm-1 mg-t-10 mg-sm-t-0">
                                        <input type="checkbox" id="edime" name="edime" v-model="edime" class="form-control input-height"  >
                                    </div>


                                    <label class="col-sm-1 form-control-label">Item Name:  <span class="tx-danger">  * </span>  </label>
                                    <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                        <input @if type="text" id="item_details" name="item_details" v-model="item_details" class="form-control input-height" autocomplete="off" placeholder="Enter Name">
                                    </div>
                                 <!--   <label class="col-sm-1 form-control-label">
                                        Opening Stock:
                                    </label>
                                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                        <input type="number" id="opening_stock" name="opening_stock" v-model="opening_stock" class="form-control input-height" autocomplete="off" placeholder="Enter Quantity">
                                    </div>-->

                                </div>

                                <!-- row -->




                                <div class="row mg-t-10">
                                    <label class="col-sm-1 form-control-label">Purchase Price:   </label>
                                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                        <input type="number" id="purchase_price" name="purchase_price" v-model="purchase_price" class="form-control input-height" autocomplete="off" placeholder="Enter Amount">
                                    </div>




                                    <label class="col-sm-1 form-control-label">Sale Price:  <span class="tx-danger">  * </span>  </label>
                                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                        <input type="number" id="sale_price" name="sale_price" v-model="sale_price" class="form-control input-height" autocomplete="off" placeholder="Enter Amount">
                                    </div>
                                    <label class="col-sm-1 form-control-label">
                                        Unit of Measurement: <span class="tx-danger"> * </span>
                                    </label>
                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                        <select id="unit" v-model="unit" name="unit" class="form-control input-height select2">
                                            <option label="Choose Option" value="0"></option>
                                            <option :value="measurement_unit.id" v-for="measurement_unit in measurement_units">
                                                {{ measurement_unit.code }}
                                            </option>

                                        </select>
                                    </div>

                                </div>
                                <!-- row -->
                                <div class="row mg-t-10">

                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                        <input type="checkbox" name="discountable" id="discountable" v-model="discountable" >
                                        <label for="discountable">Discountable</label>
                                    </div>

                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                        <input type="checkbox" name="taxable" id="taxable" v-model="taxable">
                                        <label for="taxable">Taxable</label>
                                    </div>


                                    <label class="col-sm-1 form-control-label">
                                        Maximum Item Discount: </label>
                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                        <input type="number" id="discount_amount" name="discount_amount" v-model="discount_amount" class="form-control input-height" autocomplete="off" placeholder="Enter Amount" :disabled="disablebool">
                                    </div>
                                    <div class="col-sm-1 mg-t-10 mg-sm-t-0 pc">
                                        <input type="number" id="discount_percentage"
                                        class="form-control input-height" name="discount_percentage" v-model="discount_percentage" :disabled="disableboolpc">
                                    </div>
                                </div>
                                <!-- row -->

                                <div class="row mg-t-10">
                                    <label class="col-sm-1 form-control-label">Product Classification:  <span class="tx-danger">  * </span>  </label>
                                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                        <select id="product_classification" v-model="product_classification" name="product_classification" class="form-control input-height select2">
                                            <option label="Choose Option" value="0"></option>
                                            <option :value="product.id" v-for="product in products">
                                                {{ product.desc }}
                                            </option>

                                        </select>
                                    </div>

                                    <label class="col-sm-1 form-control-label">
                                        Status:
                                        <span class="tx-danger">
                                *
                            </span>
                                    </label>
                                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">
                                        <select v-model="status"  class="form-control input-height">
                                            <option value="1">Active</option>
                                            <option value="0">In-Active</option>
                                        </select>
                                    </div>

                                    <label class="col-sm-1 form-control-label">
                                        Remarks:
                                    </label>
                                    <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                        <textarea type="text" id="remarks" class="form-control" placeholder="Enter Details" name="remarks" v-model="remarks" autocomplete="off"></textarea>
                                    </div>

                                </div>

                                <br>
                                <STRONG>RECIPE:</STRONG>
                                <div class="form-layout form-layout-4 blackcolor">
                                    <div class="row mg-t-10">


                                        <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                            <div class="form-group has-search"  v-on:keydown.up.prevent="udf2(1)" v-on:keydown.down.prevent="udf2(0)">
                                                <input  type="text" class="form-control input-height typeahead" autocomplete="off" v-model="search" tabindex="1" v-on:keyup.enter="itemsdatavalueEnter(search)"  name="search" placeholder="Search by Item Name / Code...">
                                                <ul id="areabox3" class="areabox" style="color: #fff;background: aliceblue;
                list-style-type: none;color: black;" v-if="this.search && searcheditemsdefs.length>0">

                                                    <li class="fbb" :class="'ccs'+key" @click="itemsdatavalue(itd.id)" v-for="(itd,key) in searcheditemsdefs">
                                                        <a href="javascript:void(0)"> {{itd.item_code}} - {{itd.item_details}}</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 mg-t-10 mg-sm-t-0" style="width:25%"><input class="form-control input-height" v-model="selected_items[active_el].purchase_price"  name="price" id="price" tabindex="2" type="number" placeholder="Price">
                                        </div>
                                        <div class="col-sm-1 mg-t-10 mg-sm-t-0" style="width:25%"><input  v-on:keyup.enter="refres" class="form-control input-height" v-model="selected_items[active_el].qty" name="quantity" id="quantity" tabindex="3" type="number" placeholder="Qty.">
                                        </div>
                                        <div class="col-sm-1 mg-t-10 mg-sm-t-0" style="width:25%">
                                            <select tabindex="4" id="unit" v-model="selected_items[active_el].unit" name="unit" class="form-control">
                                                <option label="Choose Option" :value="undefined"></option>
                                                <option :value="measurement_unit.id" v-for="measurement_unit in measurement_units">
                                                    {{ measurement_unit.code }}
                                                </option>
                                            </select>
                                        </div>


                                        <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                            <select tabindex="5" id="sCategory" v-model="sCategory" class="form-control ">
                                                <option label="Choose Category" value="0">  </option>
                                                <option v-if="cat_permission.indexOf('Store'+' '+cat.desc+' '+cat.id)!=-1" :value="cat.id" v-for="cat in mains">
                                                    {{cat.desc}}
                                                </option>
                                            </select>
                                        </div>


                                        <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                            <select tabindex="6" id="sSubCat" v-model="sSubCat" class="form-control  ">
                                                <option label="Choose Sub-Category" value="0">  </option>
                                                <option :value="sub.id" v-for="sub in subcats.filter((a)=>{return a.item_category==this.sCategory})">
                                                    {{sub.desc}}
                                                </option>
                                            </select>
                                        </div>


                                        <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                            <select tabindex="7" id="selecteditem" v-model="selecteditem" class="form-control  " >
                                                <option label="Choose Item" value="0">  </option>
                                                <option :value="item" v-for="item in itemdefs">
                                                    {{item.item_code}} -
                                                    <span class="itemname"><b>{{item.item_details}}</b></span>
                                                    <br>
                                                    (Rs.  {{item.purchase_price}})
                                                </option>
                                            </select>
                                        </div>

                                    </div>
                                    <br>
                                    <div>
                                        <div>
                                            <table width="100%">
                                                <thead :style="'font-size:16px'">
                                                <tr>

                                                    <th class="wd-15p">CODE</th>
                                                    <th class="wd-40p">ITEM DETAILS</th>
                                                    <th class="wd-5p">UNIT</th>
                                                    <th class="wd-10p">QTY</th>
                                                    <th class="wd-15p">PURCHASE PRICE</th>
                                                    <th class="wd-15p">SUB TOTAL</th>
                                                    <th class="wd-15p">&nbsp</th>

                                                </tr>
                                                </thead>
                                                <tbody :style="'font-size:15px'">
                                                <tr v-if="tr.item_code && tr.hdel==0" @click="activate(key)" :class="{ activatedtr : active_el == key }" v-for="(tr,key) in selected_items">
                                                    <td>{{tr.item_code}}</td>
                                                    <td>{{tr.item_details}}</td>
                                                    <td>{{measurement_units.filter(function(a){return a.id==tr.unit})[0].code}}</td>
                                                    <td> {{tr.qty}}  <input type="hidden" v-model="tr.hid"></td>
                                                    <td>{{tr.purchase_price}}</td>
                                                    <td>{{tr.product=(tr.qty*tr.purchase_price).toFixed(1)}}</td>

                                                    <template v-if="tr.hid!=1">
                                                        <td><button @click="removetr(key);" class="btn btnfont"><b>/</b></button></td>
                                                    </template>
                                                    <template v-else>
                                                        <td><button @click="canceldone(key)" class="btn btnfont"><i class="fa fa-times"></i></button>
                                                            <input type="hidden" v-model="tr.hdel"></td>
                                                    </template>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row mg-t-10">
                                        <label class="col-sm-1 form-control-label">
                                            Grand Total:
                                        </label>
                                        <div class="col-sm-2 mg-t-10 mg-sm-t-0">
                                            <input type="number" v-model="showinggross" class="form-control input-height" autocomplete="off" readonly="" style="background-color: #c1c1c1" >

                                            <input type="hidden" v-model="gross" class="form-control input-height" autocomplete="off" readonly="" style="background-color: #c1c1c1" >
                                        </div>
                                    </div>
                                </div>



                                <!-- row -->
<br> <br>
                                <div class="float-left">

                                <input @click="save_sales(id)" :disabled="disableds"  :class="id?'btn-info':'btn-info'" type="submit" name="save" class="btn" :value="id?'Update':'Save'">
                                <input @click="save_addmore(id)" :disabled="disableds"  :class="id?'btn-warning':'btn-warning'" type="submit" name="save" class="btn" :value="id?'Update & Add More':'Save & Add More'">
                                <a href="/food-and-beverage/item-definitions-vue"><button class="btn btn-secondary">Cancel</button></a>

                                </div><!-- form-layout -->
                            </div>
                        </div>

    </div>

</template>

<script>
    export default {
        name: "itemdefinitions",
        props: ['idm','datatableid'],
        data(){
            let s=this.idm;
          return  {
              edime:false,
              fkey:-1,
              ffkey:0,
              gross:0,
              showinggross:0,
              coa_code:'',
              accsearch:'',
              searchedaccounts:[],
              disableds:false,
              id:s,
              onLine: null,
              onlineSlot: 'online',
              offlineSlot: 'offline',
              refreshmyinterval:false,
              salable:false,
              purchasable:false,
              returnable:false,
              subcats:[],
              mains:[],
              manufacturers:[],
              category:'',
              sub_category:'',
              manufacturer:'0',
              item_code:'',
              item_details:'',
              opening_stock:'',
              purchase_price:0,
              sale_price:0,
              measurement_units:[],
              unit:'0',
              discountable:false,
              taxable:false,
              discount_amount:'',
              discount_percentage:'',
              products:[],
              product_classification:'0',
              status:'1',
              remarks:'',
              disablebool:false,
              disableboolpc:false,

              quantity:'',
              searcheditemsdefs:[],
              search:'',
              sCategory:'0',
              sSubCat:'0',
              itemdefs:[],
              selecteditem:'0',
              selected_items:[[]],
              active_el:0,
              itemalreadySearched:false,
              accountalreadySearched:false,
              cat_permission:'',
          }
        },

        watch:{


            accsearch:function(){
                if(this.accsearch.length==0){
                    this.accountalreadySearched=false;
                }
                if( !this.accountalreadySearched){
                    this.accountdata();
                }
            },
            discountable:function (){
                if(this.discountable==true){
                    this.disablebool=false;
                    this.disableboolpc=false;
                }
                else{
                    this.disablebool=true;
                    this.disableboolpc=true;
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
            selecteditem:function(){
                this.save_to_selected();
            },
            sSubCat:function(){
                if(this.sSubCat!=''){
                    this.getItemDefs();
                }

            },
        },

        methods: {
            canceldone:function(key) {

                let myitem = this.selected_items[key];

                myitem.hdel = 1;


            },
            activate:function(el){
                this.active_el = el;
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
                this.$http.post('/search/coa/coaaccountdata?balance=1&MOC='+r,{theid:val}).then(result=>{
                    let data =result.data;
                    if(data){
                        this.accountalreadySearched=true;


                        let clone = (JSON.parse(JSON.stringify(data)));


                        this.accsearch =data.name;
                        this.coa_code =data.code;


                    }
                });
            },
            refres:function(){
                $('input[name="search"]').focus();
                this.active_el=this.selected_items.length-1;
            },
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

            },udf2(event){

                if(event==0){
                    if(this.ffkey!=this.searcheditemsdefs.length-1){

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
        udf3(event){

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
            amIOnline(e) {
                this.onLine = e;
            },
            slideright: function () {
                $('.scrollclass').addClass('slideright');

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
            removetr:function(el){
                    this.selected_items.splice(el,1);
            },
            save_to_selected:function(){
                if(this.quantity==''){
                    this.quantity=1;
                }
                if(this.price==''){
                    this.price=0;
                }
                if(this.quantity>0){
                    let clone = (JSON.parse(JSON.stringify(this.selecteditem)));
                        clone.qty=this.quantity;
                        clone.purchase_price=this.price;
                        this.selected_items.unshift(clone);
                        this.active_el=0;
                }
                    this.quantity='';
                    this.search='';
                    this.price='';

            },
            getItemDefs:function(){
                this.$http.get('/store-management/store-purchases/items/'+this.sSubCat).then(result=>{
                    let data=result.data;
                    if(data){
                        this.itemdefs=data;
                    }
                })
            },
            itemsdatavalue(val,m){
                this.searcheditemsdefs=[];
                let r='';

                if(m){
                    r='&r='+m;
                }
                this.$http.post('/search/storeitemsdata?inv=1&MOC='+r,{theid:val}).then(result=>{
                    let data =result.data;
                    if(data){
                        this.itemalreadySearched=true;
                        if(this.quantity==''){
                            this.quantity=1;
                        }
                        if(this.price==''){
                            this.price=0;
                        }
                        if(this.quantity>0){
                            let clone = (JSON.parse(JSON.stringify(data)));

                                clone.qty=this.quantity;

                                this.selected_items.unshift(clone);
                            this.active_el=0;
                        }
                            this.quantity='';
                        this.search='';
                        this.price='';
                        $('#price').focus();


                    }
                });
            },
            itemsdatavalueEnter(val,m){
                this.searcheditemsdefs=[];
                let r='';

                if(m){
                    r='&r='+m;
                }
                this.$http.post('/search/storeitemsdataenter?inv=1&MOC='+r,{theid:val}).then(result=>{
                    let data =result.data;
                    if(data){
                        this.itemalreadySearched=true;
                        if(this.quantity==''){
                            this.quantity=1;
                        }
                        if(this.price==''){
                            this.price=0;
                        }
                        if(this.quantity>0){
                            let clone = (JSON.parse(JSON.stringify(data)));

                                clone.qty=this.quantity;
                                this.selected_items.unshift(clone);
                            this.active_el=0;
                        }
                            this.quantity='';
                        this.search='';
                        this.price='';

                    }
                });
            },
            itemsdata(){
                this.$http.post('/search/storeitemsdatalike',{searchid:this.search}).then(result=>{
                    let data =result.data;

                    data.filter((a)=>{a.search=a.item_code + ' ' + '-'+ ' ' + a.item_details})

                    if(data){

                        this.searcheditemsdefs=data;

                    }
                });
            },
            save_sales:function(m){

                this.refreshmyinterval=true;


                let data={
                    selected_items: this.selected_items.filter((a)=>{return a.item_code!=null}),
                    salable:this.salable==true?1:0,
                    purchasable:this.purchasable==true?1:0,
                    returnable:this.returnable==true?1:0,
                    category:this.category,
                    sub_category:this.sub_category,
                    manufacturer:this.manufacturer,
                    item_code:this.item_code,
                    item_details:this.item_details,
                    opening_stock:this.opening_stock,
                    purchase_price:this.purchase_price,
                    sale_price:this.sale_price,
                    unit:this.unit==0?this.unit=='':this.unit,
                    discountable:this.discountable==true?1:0,
                    taxable:this.taxable==true?1:0,
                    discount_amount:this.discount_amount,
                    discount_percentage:this.discount_percentage,
                    product_classification:this.product_classification,
                    status:this.status,
                    remarks:this.remarks,
                    accsearch:this.accsearch,
                    coa_code:this.coa_code,

                };
                let url='/food-and-beverage/item-definitions/item-definitions-aeu/save';
                if(m){
                    url='/food-and-beverage/item-definitions/item-definitions-aeu/update';
                    data.id=this.id;
                }
if(this.validation(data,['category','sub_category', 'item_code','item_details', 'unit', 'product_classification', 'status'])==0){
    this.disableds=true;
    this.$http.post(url,data).then(result=> {
        if(this.m){
            window.location.href = "/food-and-beverage/item-definitions/item-definitions-aeu-vue/"+this.m;
        }else{
            window.location.href = "/food-and-beverage/item-definitions-vue";
        }

    }).catch(error=> {
        this.$snotify.error('This Item Code is already taken ! Please try a different one.');
        this.disableds=false;
    });


}
else{
    this.disableds=false;

}
            },

            save_addmore:function(m){

                this.refreshmyinterval=true;


                let data={
                    selected_items: this.selected_items.filter((a)=>{return a.item_code!=null}),
                    salable:this.salable==true?1:0,
                    purchasable:this.purchasable==true?1:0,
                    returnable:this.returnable==true?1:0,
                    category:this.category,
                    sub_category:this.sub_category,
                    manufacturer:this.manufacturer,
                    item_code:this.item_code,
                    item_details:this.item_details,
                    opening_stock:this.opening_stock,
                    purchase_price:this.purchase_price,
                    sale_price:this.sale_price,
                    unit:this.unit==0?this.unit=='':this.unit,
                    discountable:this.discountable==true?1:0,
                    taxable:this.taxable==true?1:0,
                    discount_amount:this.discount_amount,
                    discount_percentage:this.discount_percentage,
                    product_classification:this.product_classification,
                    status:this.status,
                    remarks:this.remarks,
                    accsearch:this.accsearch,
                    coa_code:this.coa_code,
                };
                let url='/food-and-beverage/item-definitions/item-definitions-aeu/save';
                if(m){
                    url='/food-and-beverage/item-definitions/item-definitions-aeu/update';
                    data.id=this.id;
                }
                //'accsearch', 'coa_code',
                if(this.validation(data,['category','sub_category', 'item_code','item_details', 'unit', 'product_classification', 'status'])==0){
                    this.disableds=true;
                    this.$http.post(url,data).then(result=> {
                        window.location.href = "/food-and-beverage/item-definitions/item-definitions-aeu-vue";
                       /*this.init();*/
                    }).catch(error=> {
                        this.$snotify.error('This Item Code is already taken ! Please try a different one.');
                        this.disableds=false;
                    });

                }
                else{
                    this.disableds=false;

                }
            },

            modalopen:function(){
                $(this).find($.attr('#instruction')).focus();
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

            modalok:function(){
                this.instruction='';
                this.showModal=false;
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
                for (var i = 1; i < 9999; i++) {
                    window.clearInterval(i);
                }
                let r='';
                if(m){
                    r='?r='+m;
                }
                this.$http.get('/food-and-beverage/item-definitions-aeu/itemdefs_init_vue'+r).then(result=>{
                    let data =result.data;
                    this.refreshmyinterval=false;
                    if(m){

                        this.coa_code=data.coa_code;
                        this.accountdatavalue(data.coa_code,m);
                    if(data.selected_items && data.selected_items.length!=0){
                        this.selected_items=data.selected_items;
                    }


                        this.salable=data.salable;
                        this.purchasable=data.purchasable;
                        this.returnable=data.returnable;
                        this.category=data.category;
                        this.sub_category=data.sub_category;
                        this.manufacturer=data.manufacturer;
                        this.item_code=data.item_code;
                        this.item_details=data.item_details;
                        this.opening_stock=data.opening_stock;
                        this.purchase_price=data.purchase_price;
                        this.sale_price=data.sale_price;
                        this.unit=data.unit;
                        this.discountable=data.discountable;
                        this.taxable=data.taxable;
                        this.discount_amount=data.discount_amount;
                        this.discount_percentage=data.discount_percentage;
                        this.product_classification=data.product_classification;
                        this.status=data.status;
                        this.remarks=data.remarks;
                    }else{

                        this.item_code = parseInt(data.maxcode)+parseInt(1);
                        this.discount_amount=data.predefined.discount_amount;
                        this.discount_percentage=data.predefined.discount_percentage;
                        this.discountable=true;
                    }
                    this.cat_permission=data.catspermit;
                    this.manufacturers=data.manufacturers;
                    this.measurement_units=data.measurement_units;
                    this.products=data.products;
                    this.mains=data.mains;
                    this.subcats=data.subcats;

                })

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

            customerdatavalue(val,m){
                this.customers=[];
                let v = this.type;
                let r='';

                if(m){
                    r='&r='+m;
                }
                this.$http.post('/search/salescustomerdata?inv=1&MOC='+v+r,{customerid:val}).then(result=>{
                    let data =result.data;
                    if(data){

                        if (v == 0) {
                            this.customer_id = data.id;
                            this.member_id = data.id;
                            this.contact = data.mob_a;
                            let fname=data.first_name?data.first_name+' ':'';
                            let mname=data.middle_name?data.middle_name+' ':'';
                            let lname=data.applicant_name?data.applicant_name:'';

                            this.customer = fname+mname+lname;
                            this.families=data.family;
                            this.ledger_amount=data.balance;
                        }
                        else if (v == 1) {
                            this.contact = data.customer_contact;
                            this.customer_id = data.id;
                            this.member_id = '';
                            this.customer = data.customer_name;
                            this.ledger_amount=data.balance;
                        }
                        else if (v == 3) {
                            this.contact = data.mob_a;
                            this.customer_id = data.id;
                            this.member_id = '';
                            this.customer = data.name;
                            this.ledger_amount=data.balance;
                        }

this.alreadySearched=true;
                    }
                });
            },

        },

        mounted() {
            setInterval(()=>{
                this.$forceUpdate();
            },500)


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
            let self=this;
            setInterval(function(){
                self.gross=self.sum(self.pluck(self.selected_items.filter((a)=>{return a.hdel==0}),'product'))
                self.showinggross=Math.round(self.sum(self.pluck(self.selected_items.filter((a)=>{return a.hdel==0}),'product')))
            },200)
        }
    }
</script>

<style scoped>

.active{
    /*background: green;*/
    background-color: #23BF08 !important;
    color: white !important;
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
     background-color: #00d1d6;
    color: black;
    border-right: 2px solid #fff;
    font-size: 13px;
    padding: 0px 2px;
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
.fbb{
    padding: 0!important;
    border: none!important;
    border-bottom: 1px solid #e7e7e7!important;
}
.fbb a{
    opacity: 1;
    background: #fdf7f7;
    text-decoration: none;
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
