<?php $__env->startSection('content'); ?>
<b-row>
    <b-table :items="item.list">
        <template slot="id" scope="cell">
            <b-btn size="sm" v-on:click="showModal(cell.item.id)"> ID : {{ cell.item.id }} | Take Action</b-btn>
        </template>
    </b-table>
</b-row>
<b-modal ref="myModalRef" hide-footer size="lg" id="modal1" title="Licensee">
    <form id="addEdit" @submit="onSubmit">
        <b-row>
            <b-col>
                ID : <b-form-input readonly="true"
                                   :value.set="item && item.data && item.data.id ? item.data.id : null"
                                   name="id"
                                   type="text"></b-form-input>
            </b-col>
            <b-col>
                ROLE : <b-form-input
                    :value="item && item.data && item.data.admin_role_slug ? item.data.admin_role_slug : null"
                    name="admin_role_slug"
                    type="text"></b-form-input>

            </b-col>
        </b-row>
        <b-row>
            &nbsp;
        </b-row>
        <b-row>
            <b-col>
                <b-form-textarea placeholder="Enter description"
                                 name="admin_role_description"
                                 :value="item && item.data && item.data.admin_role_description ? item.data.admin_role_description : null"
                                 :rows="3"
                                 :max-rows="6">
            </b-form-textarea>
        </b-col>
    </b-row>
    <b-row>
        &nbsp;
    </b-row>
    <b-row>
        <b-col v-for="(permission, index) in (item && item.data && item.data.permission ? item.data.permission : item.permission)">
            <b-list-group-item>
                <b-list-group-item active>
                    {{ index }}
                </b-list-group-item>
                <b-list-group-item v-for="permissionInner in permission">
                    <span>{{ permissionInner.name }}</span>
                    <br>
                    <input value="true" v-bind:checked="permissionInner.checked ? true : ''" type="radio" :name="'permission[' + permissionInner.name + ']'">
                           <label for="one">On</label>
                    <input value="false" v-bind:checked="!permissionInner.checked ? true : ''" type="radio" :name="'permission[' + permissionInner.name + ']'">
                           <label for="two">Off</label>
                </b-list-group-item>
            </b-list-group-item>
        </b-col>
    </b-row>
    <b-row>
        &nbsp;
    </b-row>
    <b-alert v-for="errors in error" show variant="danger">
        {{ errors }}
    </b-alert>
    <b-row>
        <b-col>
            <b-button type="submit" variant="primary">Save</b-button>
        </b-col>
        <b-col v-if="item && item.data && item.data.id" right>
            <span>Delete this role?</span>
            &nbsp;
            <input value="yes" type="radio" name="delete">
            <label for="yes">Yes</label>
            <input value="no" checked="true" type="radio" name="delete">
            <label for="no">No</label>
        </b-col>
    </b-row>
</form>
</b-modal>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            item: [],
            form: [],
            error: [],
        },
        created() {
            this.fetchData();
        },
        ready: function () {
            this.fetchData();
        },
        methods: {
            showModal(id) {
                var string = '<?php echo route('licensee_roleMaker') ?>';
                if (id) {
                    string += '?id=' + id;
                }
                axios.get(string).then(response => {
                    this.item = response.data;
                });
                this.$refs.myModalRef.show();
            },
            onSubmit(evt) {
                evt.preventDefault();
                axios.post('<?php echo route('licensee_roleMaker') ?>', $('#addEdit').serialize())
                        .then(response => {
                            this.$refs.myModalRef.hide();
                            this.item = response.data;
                        })
                        .catch(error => {
                            this.error = error.response.data.errors;
                        });
            },
            fetchData() {
                axios.get('<?php echo route('licensee_roleMaker') ?>').then(response => {
                    this.item = response.data;
                });
            },
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('licensee::master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>