<?php

$_addHead="
 		<link href='".URL_BASE."assets/inspinia/css/plugins/footable/footable.core.css' rel='stylesheet'> 		
 		";

$_addScript=" 		
 		<script src=\"".URL_BASE."assets/inspinia/js/plugins/footable/footable.all.min.js\"></script>
 		";
?>

<button class="btn btn-primary" @click.prevent="addElement">add</button>

<div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-content">

                            <table id="tblFootable" class="footable table table-stripped toggle-arrow-tiny" data-page-size="5">
                                <thead>
                                <tr>

                                    <th>Order ID</th>
                                    <th data-hide="phone">Customer</th>
                                    <th data-hide="phone">Amount</th>
                                    <th data-hide="phone">Date added</th>
                                    <th data-hide="phone,tablet" >Date modified</th>
                                    <th data-hide="phone">Status</th>
                                    <th class="text-right">Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                 <tr v-for="item in elementos"> 
                                    <td>
                                       {{ item.id }}
                                    </td>
                                    <td>
                                        {{ item.customer }}
                                    </td>
                                    <td>
                                        ${{ item.amount }}
                                    </td>
                                    <td>
                                        {{ item.dateadd }}
                                    </td>
                                    <td>
                                        {{ item.datemod }}                                        
                                    </td>
                                    <td>
                                        <span class="label label-primary">{{ item.status	 }}</span>
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group">
                                            <button class="btn-white btn btn-xs">View</button>
                                            <button class="btn-white btn btn-xs">Edit</button>
                                            <button class="btn-white btn btn-xs">Delete</button>
                                        </div>
                                    </td>
                                </tr>




                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="7">
                                        <ul class="pagination pull-right"></ul>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            
            