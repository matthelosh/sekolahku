<div class="row">
    <div class="col-sm-4">
        <div class="card bg-c-yellow update-card">
            <div class="card-block">
                <div class="row align-items-end">
                    <div class="col-8">
                        <h4 class="text-white">$30200</h4>
                        <h6 class="text-white m-b-0">All Earnings</h6>
                    </div>
                    <div class="col-4 text-right">
                        <canvas id="update-chart-1" height="50"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>update : 2:15 am</p>
            </div>
        </div>
        
    </div>
    <div class="col-sm-8">
        <div class="card">
            <div class="card-body">
                {{-- <h3 class="card-title">File di Drive</h3>
                <ifame src="https://drive.google.com/embeddedfolderview?id={{ env('GOOGLE_DRIVE_FOLDER_ID') }}#list" width="100%" height="500" frameborder="0"></iframe> --}}
            </div>
        </div>
    </div>
    <div class="col-xl-9 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Sales Analytics</h5>
                <span class="text-muted">For more details about usage, please refer <a href="https://www.amcharts.com/online-store/" target="_blank">amCharts</a> licences.</span>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="feather icon-maximize full-card"></i></li>
                        <li><i class="feather icon-minus minimize-card"></i></li>
                        <li><i class="feather icon-trash-2 close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <div id="sales-analytics" style="height: 265px;"></div>
            </div>
        </div>
    </div>
</div>
@include('layout.main')