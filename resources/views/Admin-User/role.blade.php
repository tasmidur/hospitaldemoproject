@extends("layouts.dashboard-master")

@section("title","Admin|Role")


@section("content")
<section id="column-selectors">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Role</h4>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">

                         <button id="add-new" class="btn btn-primary mb-2"><i class="feather icon-plus"></i>&nbsp; Add New</button>
                        <br><br>
                        <form class="form" id="input-form">

                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-label-group">
                                            <input type="text" id="name" class="form-control" name="name">
                                            <label for="first-name-column">Role Name</label>
                                            <input type="hidden" id="id" name="id">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                       
                                        <div class="custom-control custom-checkbox" id="role">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <p id="status-msg"></p>
                                        <button type="submit" id="form-action-btn" class="btn btn-primary mr-1 mb-1">Submit</button>
                                        <button type="reset" id="close-btn" class="btn btn-outline-warning mr-1 mb-1">Close</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <br><br>
                        <div class="table-responsive">
                            <table class="table table-striped dataex-html5-selectors">
                                <thead>
                                    <tr>
                                        <th>Role Name</th>
                                        <th>Permission Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                               
                                <tbody id="table-data">
                                   
                                </tbody>
                                    
                            <tfoot>
                                <tr>
                                    <th>Role Name</th>
                                    <th>Permission Name</th>
                                    <th>Action</th>
                                   
                                </tr>
                            </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('rolejs')
<script type="text/javascript" src="{{url('dashboard-customjs/role.js')}}"></script> 
@endsection

{{-- 
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header text-uppercase">
                <h2>
                    Role
                </h2>
            </div>
            <div class="body">
                <button class="btn bg-cyan waves-effect m-b-15" type="button" data-toggle="collapse" data-target="#open" aria-expanded="false" aria-controls="collapseExample" id="form-open-btn">
                 Add Role
                </button>
                <div class="collapse" id="open">
                    <div class="w-100">
                        <form id="form_validation">
                            <div class="form-group form-float">
                                <div class="form-line">
                                  <input type="text" class="form-control" name="name" required id="name" placeholder="As like Super Admin">
                                 <input type="hidden" id="id" name="id">
                                 <label class="form-label"></label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line" id="role">
                                
                                </div>
                            </div>
                            <p id="status-msg"></p>
                            <button class="btn btn-primary waves-effect" id="action-btn" type="submit">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end of form div -->

<!-- data show table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header text-uppercase">
                <h2>
                   Role Name
                </h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead>
                            <tr>
                                <th>Role Name</th>
                                <th>Permission Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Role Name</th>
                                <th>Permission Name</th>
                                <th>Action</th>
                               
                            </tr>
                        </tfoot>
                        <tbody id="table-data">
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> --}}