<div class="row">
    <div class="col-sm-3">
        <div class="info-box">
            <span class="info-box-icon bg-aqua">
                <i class="ion ion-ios-gear-outline"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-text">Uso de CPU</span>
                <span class="info-box-number"><span id="cpuUsage">0</span><small>%</small></span>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="info-box">
            <span class="info-box-icon bg-green">
                <i class="fa fa-microchip"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-text">Uso de RAM</span>
                <span class="info-box-number"><span id="memoryUsage">0</span><small>%</small></span>
                <span class="info-box-more"><span id="memoryFree">0</span>M / <span id="memoryTotal">0</span>M</span>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="info-box">
            <span class="info-box-icon bg-gray">
                <i class="fa fa-server"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-text">HDD</span>
                <span class="info-box-number"><span id="diskUsage">0</span><small>%</small></span>
                <span class="info-box-more"><span id="diskFree">0</span> GB / <span id="diskTotal">0</span> GB</span>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="info-box">
            <span id="maintenance-box" class="info-box-icon bg-red">
                <a href="#" onclick="artisanDown(); return false;" class="text-gray">
                    <i id="maintenance" class="fa fa-toggle-off"></i>
                </a>
            </span>

            <div class="info-box-content">
                <span class="info-box-text">Manutenção</span>

                <div id="divAllowed">
                    <span class="info-box-more">Permitidos:</span>
                    <span class="info-box-more"><span id="allowed">0</span></span>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js')
    @parent

    <script type="text/javascript">
        let isDown = false;

        function artisanDown() {
            jQuery.ajax({
                url: (isDown) ? `api/admin/up` : `api/admin/down`,
                dataType: 'json',
                method: 'POST',
            });
        }

        jQuery(document).ready(function () {
            function getServerInfo() {
                jQuery.ajax({
                    url: `{{ route('api.admin.sysUsage') }}`,
                    dataType: 'json',
                    method: 'GET',
                    success: function (data) {
                        jQuery('#cpuUsage').text(Math.round(data.cpu));

                        jQuery('#memoryUsage').text(Math.round(100 - data.memory.free * 100 / data.memory.total));
                        jQuery('#memoryFree').text(Math.round((data.memory.total - data.memory.free) / (1024 * 1024)));
                        jQuery('#memoryTotal').text(Math.round(data.memory.total / (1024 * 1024)));

                        jQuery('#diskUsage').text(Math.round(100 - data.disk.free * 100 / data.disk.total));
                        jQuery('#diskFree').text(Math.round(data.disk.free / (1024 * 1024 * 1024)));
                        jQuery('#diskTotal').text(Math.round(data.disk.total / (1024 * 1024 * 1024)));

                        isDown = data.maintenance.isDown;
                        jQuery('#divAllowed').toggle(isDown);
                        if (isDown) {
                            jQuery('#maintenance').addClass('fa-toggle-on').removeClass('fa-toggle-off');
                            jQuery('#maintenance-box').addClass('bg-red').removeClass('bg-light-blue');
                            jQuery('#allowed').text(data.maintenance.allowed.join(' | '));
                        } else {
                            jQuery('#maintenance').addClass('fa-toggle-off').removeClass('fa-toggle-on');
                            jQuery('#maintenance-box').addClass('bg-light-blue').removeClass('bg-red');
                        }
                    },
                    error: function () {

                    },
                });
            }

            setInterval(() => {
                getServerInfo();
            }, 1000);
        });
    </script>
@endsection
