<template>
    <div>
        <transition name="modal">
            <div class="modal show" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <slot name="header">
                                default header

                            </slot>
<!--                            <button type="button" @click="$emit('close')" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>-->

                        </div>
                        <div class="modal-body">
                            <slot name="body">
                                default body
                            </slot>
                        </div>
                        <div class="modal-footer">
                            <slot name="footer">
                                <button class="btn btn-outline-danger" @click="$emit('close')">
                                    Close
                                </button>
                                <button class="btn btn-outline-success" @click="$emit('save',form)">
                                    Save
                                </button>
                            </slot>
                        </div>
                    </div>
                </div>
            </div>

        </transition>
        </div>

</template>

<script>
export default {
    name: "modal",

    data(){
return {
form:{

}
}
    },
    computed: {

    },
    methods:{

    },
    watch:{


    },
    mounted() {


    }
}
</script>

