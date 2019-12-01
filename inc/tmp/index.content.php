
<section class="content-header">
    <h1>
        Общая статистика по АТС <a class="helpicon" href="https://wiki.vistep.ru/doku.php?id=faq:main_general" target="blank" title="Подробнее в wiki..."><i class="fa fa-question-circle"></i></a>
    </h1>
        <br>
    <div class="bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-on bootstrap-switch-id-switch-onText bootstrap-switch-animate" style="width: 144px;"><div class="bootstrap-switch-container" style="width: 214px; margin-left: 0px;"><span class="bootstrap-switch-handle-on bootstrap-switch-primary" style="width: 71px;">Номера</span><span class="bootstrap-switch-label" style="width: 71px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 71px;">Группы</span><input style="width: 188px;" id="switch-onText" type="checkbox" checked="" value="numbers" data-on-text="Номера" data-off-text="Группы" onchange="NumbersGroupsCheck('switch-onText');"></div></div>
    <input type="hidden" id="report" value="main_overall">

</section>




<section class="content">

    <div class="box">
        <div class="box-header with-border">
            Фильтры
        </div>
        <div class="box-body scrolldiv">
            <div cals="row">
                <div class="form-group col-md-8">
                    <h5>Укажите период</h5>
                    <div class="input-group dataturn">
                        <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                        <input type="text" class="form-control pull-right" value="2018-10-15 9:00 - 2018-10-21 18:00" id="reservationtime">

                    </div>
                </div>
                <div class="form-group col-md-2">
                    <div style="padding-top: 32px;">
                        <button class="btn btn-info btn-flat" onclick="App.goTurn();" type="button">Искать!</button>
                        <a id="export" style="margin-left: 15px;" href="#" onclick="App.goTurn(true);"><img class="ico" src="/images/excel.ico" width="40px" title="Экспорт отчета"></a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row row-flex row-flex-wrap" "="">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Сводная статистика по АТС</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered" style="height: 290px; ">
                    <tbody>
                                        <tr>
                        <td>Период</td>
                        <td align="center" colspan="2">2018-10-15 9:00 - 2018-10-21 18:00</td>
                        <!--<td height="72"></td> -->
                    </tr>
                    <tr>
                        <td>Всего входящих</td>
                        <td align="center">42 (<span class="stat_work">36</span>/<span class="stat_not_work">6</span>)</td>
                        <td align="right"><span class="badge bg-red">100%</span></td>
                    </tr>
                    <tr>
                        <td><span>Отвеченные</span></td>
                        <td align="center">10 (<span class="stat_work">10</span>/<span class="stat_not_work">0</span>)</td>
                        <td align="right"><span class="badge bg-red">23%</span></td>
                    </tr>
                    <tr>
                        <td><span>Пропущенные</span></td>
                        <td align="center">32 (<span class="stat_work">26</span>/<span class="stat_not_work">6</span>)
                        </td>
                        <td align="right"><span class="badge bg-red">76%</span></td>
                    </tr>
                    <tr>
                        <td><span style="margin-left: 5%">но обработанные АТС</span></td>
                        <td align="center">30 (<span class="stat_work">25</span>/<span class="stat_not_work">5</span>)</td>
                        <td align="right"><span class="badge bg-red">75%</span></td>
                    </tr>
                    <tr>
                        <td><span style="margin-left: 5%">пропущенные сотрудниками</span><br><span style="margin-left: 5%">(из них до 3с)</span></td>
                        <td align="center">2 (<span class="stat_work">1</span>/<span class="stat_not_work">1</span>) (0)</td>
                        <td align="right"><span class="badge bg-red">4%</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <div class="grph col-md-6">

        <!-- DONUT CHART -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Отвеченные и пропущенные вызовы (Общее)</h3>
            </div>
            <div class="box-body chart-responsive">
                <div class="chart" id="sales-chart-1" style="height: 290px;  position: relative; "><svg height="290" version="1.1" width="787" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative; left: -0.3125px; top: -0.8125px;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><path fill="none" stroke="#3cb371" d="M393.5,235A90,90,0,0,0,483.2653349734968,151.4949701381849" stroke-width="2" opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 1;"></path><path fill="#3cb371" stroke="#ffffff" d="M393.5,238A93,93,0,0,0,486.2575128059467,151.71146914279106L528.1480024602452,154.74245520727737A135,135,0,0,1,393.5,280Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#ffa500" d="M483.2653349734968,151.4949701381849A90,90,0,1,0,358.45006127585947,227.8945221075192" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#ffa500" stroke="#ffffff" d="M486.2575128059467,151.71146914279106A93,93,0,1,0,357.28172998505477,230.65767284443655L342.87231073179703,264.7365319330833A130,130,0,1,1,523.161039406162,154.38162353293376Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#f56954" d="M358.45006127585947,227.8945221075192A90,90,0,0,0,388.4743411547791,234.85957240701435" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#f56954" stroke="#ffffff" d="M357.28172998505477,230.65767284443655A93,93,0,0,0,388.30681919327174,237.85489148724815L386.24071500134755,274.79716014346513A130,130,0,0,1,342.87231073179703,264.7365319330833Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#fff380" d="M388.4743411547791,234.85957240701435A90,90,0,0,0,393.4717256665827,234.99999555867805" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#fff380" stroke="#ffffff" d="M388.30681919327174,237.85489148724815A93,93,0,0,0,393.47078318880216,237.999995410634L393.459159296175,274.9999935847572A130,130,0,0,1,386.24071500134755,274.79716014346513Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="393.5" y="135" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 800 15px Arial;" font-size="15px" font-weight="800" transform="matrix(1.5533,0,0,1.5533,-217.7029,-80.7757)" stroke-width="0.6438078703703703"><tspan dy="6" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Отвеченные</tspan></text><text x="393.5" y="155" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 14px Arial;" font-size="14px" transform="matrix(1.875,0,0,1.875,-344.3945,-128.625)" stroke-width="0.5333333333333333"><tspan dy="5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">10</tspan></text></svg></div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

    </div>
    <script>
        $(function () {
            var donut = new Morris.Donut({
                element: 'sales-chart-1',
                resize: true,
                colors: ["#3CB371", "#FFA500", "#f56954", "#FFF380"],
                data: [
                    {label: "Отвеченные", value: 10},
                    {label: "Пропущенные, но обработанные АТС", value: 30},
                    {label: "Пропущенные сотрудниками", value: 2 },
                    {
                        label: "Пропущенные до 3 секунд",
                        value: 0}
                ],
                formatter: function (y, data) {
                    return y
                },
                hideHover: 'auto'
            });

            var donut = new Morris.Donut({
                element: 'sales-chart-2',
                resize: true,
                colors: ["#3CB371", "#FFA500", "#f56954", "#FFF380"],
                data: [
                    {label: "Отвеченные", value: 10},
                    {label: "Пропущенные, но обработанные АТС", value: 25},
                    {label: "Пропущенные сотрудниками", value: 1 },
                    {
                        label: "Пропущенные до 3 секунд",
                        value: 0}
                ],
                formatter: function (y, data) {
                    return y
                },
                hideHover: 'auto'
            });

            var donut = new Morris.Donut({
                element: 'sales-chart-3',
                resize: true,
                colors: ["#3CB371", "#FFA500", "#f56954", "#FFF380"],
                data: [
                    {label: "Отвеченные", value: 0},
                    {label: "Пропущенные, но обработанные АТС", value: 5},
                    {label: "Пропущенные сотрудниками", value: 1 },
                    {
                        label: "Пропущенные до 3 секунд",
                        value: 0}
                ],
                formatter: function (y, data) {
                    return y
                },
                hideHover: 'auto'
            });

        });
    </script>
    </div>
    <div class="row">
        <div class="grph col-md-6">

            <!-- DONUT CHART -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Отвеченные и пропущенные вызовы (В рабочее время)</h3>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart" id="sales-chart-2" style="height: 290px;  position: relative; "><svg height="290" version="1.1" width="787" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative; top: -0.625px;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><path fill="none" stroke="#3cb371" d="M393.5,235A90,90,0,0,0,482.22879546702654,129.92681669418914" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#3cb371" stroke="#ffffff" d="M393.5,238A93,93,0,0,0,485.1864219825941,129.4243772506621L521.6638156745938,123.22762411382874A130,130,0,0,1,393.5,275Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#ffa500" d="M482.22879546702654,129.92681669418914A90,90,0,1,0,368.6473126852162,231.50054296496398" stroke-width="2" opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 1;"></path><path fill="#ffa500" stroke="#ffffff" d="M485.1864219825941,129.4243772506621A93,93,0,1,0,367.8188897747234,234.38389439712947L356.22096902782425,274.75081444744603A135,135,0,1,1,526.5931932005398,122.3902250412837Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#f56954" d="M368.6473126852162,231.50054296496398A90,90,0,0,0,388.47434115477915,234.85957240701435" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#f56954" stroke="#ffffff" d="M367.8188897747234,234.38389439712947A93,93,0,0,0,388.3068191932718,237.85489148724815L386.24071500134767,274.79716014346513A130,130,0,0,1,357.6016738786456,269.9452287271702Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#fff380" d="M388.47434115477915,234.85957240701435A90,90,0,0,0,393.4717256665828,234.99999555867805" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#fff380" stroke="#ffffff" d="M388.3068191932718,237.85489148724815A93,93,0,0,0,393.4707831888022,237.999995410634L393.45915929617513,274.9999935847572A130,130,0,0,1,386.24071500134767,274.79716014346513Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="393.5" y="135" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 800 15px Arial;" font-size="15px" font-weight="800" transform="matrix(0.5078,0,0,0.5078,193.7567,71.8594)" stroke-width="1.9692322530864197"><tspan dy="6" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Пропущенные, но обработанные АТС</tspan></text><text x="393.5" y="155" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 14px Arial;" font-size="14px" transform="matrix(1.875,0,0,1.875,-344.3945,-128.625)" stroke-width="0.5333333333333333"><tspan dy="5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">25</tspan></text></svg></div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

        </div>
        <div class="grph col-md-6">

            <!-- DONUT CHART -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Отвеченные и пропущенные вызовы (В нерабочее время)</h3>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart" id="sales-chart-3" style="height: 290px;  position: relative; "><svg height="290" version="1.1" width="787" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative; left: -0.5px; top: -0.625px;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><path fill="none" stroke="#3cb371" d="M393.5,235A90,90,0,0,0,398.4974283804261,234.861146829887" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#3cb371" stroke="#ffffff" d="M393.5,238A93,93,0,0,0,398.66400932644024,237.85651839088325L400.7185076606154,274.7994343098368A130,130,0,0,1,393.5,275Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#ffa500" d="M398.4974283804261,234.861146829887A90,90,0,1,0,312.4309277110563,184.08715285371937" stroke-width="2" opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 1;"></path><path fill="#ffa500" stroke="#ffffff" d="M398.66400932644024,237.85651839088325A93,93,0,1,0,309.72862530142487,185.39005794884335L271.8963915665845,203.63072928057906A135,135,0,1,1,400.99614257063905,279.7917202448305Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#f56954" d="M312.4309277110563,184.08715285371937A90,90,0,0,0,388.4743411547791,234.85957240701435" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#f56954" stroke="#ffffff" d="M309.72862530142487,185.39005794884335A93,93,0,0,0,388.30681919327174,237.85489148724815L386.24071500134755,274.79716014346513A130,130,0,0,1,276.4002289159702,201.45922078870575Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#fff380" d="M388.4743411547791,234.85957240701435A90,90,0,0,0,393.4717256665827,234.99999555867805" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#fff380" stroke="#ffffff" d="M388.30681919327174,237.85489148724815A93,93,0,0,0,393.47078318880216,237.999995410634L393.459159296175,274.9999935847572A130,130,0,0,1,386.24071500134755,274.79716014346513Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="393.5" y="135" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 800 15px Arial;" font-size="15px" font-weight="800" transform="matrix(0.5078,0,0,0.5078,193.7567,71.8594)" stroke-width="1.9692322530864197"><tspan dy="6" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Пропущенные, но обработанные АТС</tspan></text><text x="393.5" y="155" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 14px Arial;" font-size="14px" transform="matrix(1.875,0,0,1.875,-344.3945,-128.625)" stroke-width="0.5333333333333333"><tspan dy="5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">5</tspan></text></svg></div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Входящие звонки по внешним номерам</h3>
                </div>
                <div class="box-body scrolldiv">
                    <div id="callstat_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer"><div class="dataTables_paginate paging_simple_numbers" id="callstat_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="callstat_previous"><a href="#" aria-controls="callstat" data-dt-idx="0" tabindex="0">Назад</a></li><li class="paginate_button active"><a href="#" aria-controls="callstat" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button next disabled" id="callstat_next"><a href="#" aria-controls="callstat" data-dt-idx="2" tabindex="0">Далее</a></li></ul></div><table class="table table-bordered dataTable no-footer" id="callstat" role="grid">
                                                <thead>
                        <tr role="row"><th width="25%" class="sorting_asc" tabindex="0" aria-controls="callstat" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Номер: activate to sort column descending" style="width: 352px;">Номер</th><th width="12%" class="sorting" tabindex="0" aria-controls="callstat" rowspan="1" colspan="1" aria-label="Всего входящих: activate to sort column ascending" style="width: 152px;">Всего входящих</th><th width="12%" class="sorting" tabindex="0" aria-controls="callstat" rowspan="1" colspan="1" aria-label="Принято: activate to sort column ascending" style="width: 151px;">Принято</th><th width="12%" class="sorting" tabindex="0" aria-controls="callstat" rowspan="1" colspan="1" aria-label="Пропущено: activate to sort column ascending" style="width: 152px;">Пропущено</th><th width="16%" class="sorting" tabindex="0" aria-controls="callstat" rowspan="1" colspan="1" aria-label="Пропущено, но обработано АТС: activate to sort column ascending" style="width: 215px;">Пропущено,<br> но обработано АТС</th><th width="19%" class="sorting" tabindex="0" aria-controls="callstat" rowspan="1" colspan="1" aria-label="Пропущено сотрудниками (из них до 3c): activate to sort column ascending" style="width: 262px;">Пропущено сотрудниками<br> (из них до 3c)</th><th width="16%" class="sorting" tabindex="0" aria-controls="callstat" rowspan="1" colspan="1" aria-label="% от всех входящих: activate to sort column ascending" style="width: 65px;">% от всех входящих</th></tr>
                        </thead>
                        <tbody>
                                                    
                                                    
                                                    
                                                <tr role="row" class="odd">
                                <td width="25%" class="sorting_1">mob1 89130751580 </td>
                                <td width="12%">0</td>
                                <td width="12%"><a href="/detailedstatistics?direction=input&amp;whomcalled=89130751580&amp;disposition=ANSWERED" target="_blank">0</a></td>
                                <td width="12%">0</td>
                                <td width="16%">0</td>
                                <td width="19%">
                                    <a href="/missedstatistics?whomcalled=89130751580" target="_blank">0</a>
                                    <a href="/missedstatistics?whomcalled=89130751580&amp;durationcallstart=0&amp;durationcallend=3" target="_blank">(0)</a>
                                </td>
                                <td width="16%"><span class="badge bg-red">0%</span></td>
                            </tr><tr role="row" class="even">
                                <td width="25%" class="sorting_1">mob2 89234776763 </td>
                                <td width="12%">0</td>
                                <td width="12%"><a href="/detailedstatistics?direction=input&amp;whomcalled=89234776763&amp;disposition=ANSWERED" target="_blank">0</a></td>
                                <td width="12%">0</td>
                                <td width="16%">0</td>
                                <td width="19%">
                                    <a href="/missedstatistics?whomcalled=89234776763" target="_blank">0</a>
                                    <a href="/missedstatistics?whomcalled=89234776763&amp;durationcallstart=0&amp;durationcallend=3" target="_blank">(0)</a>
                                </td>
                                <td width="16%"><span class="badge bg-red">0%</span></td>
                            </tr><tr role="row" class="odd">
                                <td width="25%" class="sorting_1">msk 4951341307 </td>
                                <td width="12%">42</td>
                                <td width="12%"><a href="/detailedstatistics?direction=input&amp;whomcalled=4951341307&amp;disposition=ANSWERED" target="_blank">10</a></td>
                                <td width="12%">2</td>
                                <td width="16%">30</td>
                                <td width="19%">
                                    <a href="/missedstatistics?whomcalled=4951341307" target="_blank">2</a>
                                    <a href="/missedstatistics?whomcalled=4951341307&amp;durationcallstart=0&amp;durationcallend=3" target="_blank">(0)</a>
                                </td>
                                <td width="16%"><span class="badge bg-red">0%</span></td>
                            </tr></tbody>
                    </table></div>
                </div>

            </div>

        </div>
    </div>

    
    <div class="row">
        <div class="grph col-md-4">

            <!-- DONUT CHART -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Всего входящих</h3>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart" id="allinputcalls" style="min-height: px;  position: relative; "><svg height="342" version="1.1" width="508" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative; top: -0.625px;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><path fill="none" stroke="#78866b" d="M254,282.5A109,109,0,1,0,243.97992323965687,282.0384635127881" stroke-width="2" opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 1;"></path><path fill="#78866b" stroke="#ffffff" d="M254,285.5A112,112,0,1,0,243.70414131047312,285.0257606736905L238.96988485948532,336.3076952691821A163.5,163.5,0,1,1,254,337Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#318dbc" d="M243.97992323965687,282.0384635127881A109,109,0,0,0,248.96754622392342,282.38376558969503" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#318dbc" stroke="#ffffff" d="M243.70414131047312,285.0257606736905A112,112,0,0,0,248.82903832182956,285.38056647748476L246.68216583937487,331.83098023822623A158.5,158.5,0,0,1,239.42952140812488,331.3288666676781Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#3cb371" d="M248.96754622392342,282.38376558969503A109,109,0,0,0,253.96575664063926,282.49999462106564" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#3cb371" stroke="#ffffff" d="M248.82903832182956,285.38056647748476A112,112,0,0,0,253.9648141628587,285.4999944730216L253.95020575725985,331.9999921783386A158.5,158.5,0,0,1,246.68216583937487,331.83098023822623Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="254" y="163.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 800 15px Arial;" font-size="15px" font-weight="800" transform="matrix(1.3625,0,0,1.3625,-92.0722,-66.5188)" stroke-width="0.7339449541284403"><tspan dy="-3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">4951341307</tspan><tspan dy="18" x="254" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">msk</tspan></text><text x="254" y="183.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 14px Arial;" font-size="14px" transform="matrix(2.2708,0,0,2.2708,-322.9108,-238.0231)" stroke-width="0.4403669724770642"><tspan dy="-11.796875" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></tspan><tspan dy="16.8" x="254" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">42</tspan></text></svg></div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

        </div>
        <script>
            $(function () {
                var donut = new Morris.Donut({
                    element: 'allinputcalls',
                    colors: ["#78866B","#318dbc", "#3CB371", "#6960EC","#98AFC7","#7BCCB5","#01a65a","#FFA62F","#5E5A80","#6D7B8D","#566D7E","#737CA1","#2B547E","#368BC1","#8BB381","#FFF380","#FBF6D9","#CD7F32"],
                    resize: true,
                    data: [
                                                {
                            label: "4951341307" + "\n" + "msk",
                            value: "\n" +42},
                                                {
                            label: "89234776763" + "\n" + "mob2",
                            value: "\n" +0},
                                                {
                            label: "89130751580" + "\n" + "mob1",
                            value: "\n" +0},
                                            ],
                    formatter: function (y, data) {
                        return y
                    },
                    hideHover: 'auto'
                });
//$("div svg text").attr("style", "line-height:1.8;");
            });
        </script>

        <div class="grph col-md-4">

            <!-- DONUT CHART -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Принято</h3>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart" id="answeredcalls" style="min-height: px;  position: relative; "><svg height="342" version="1.1" width="508" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative; left: -0.65625px; top: -0.625px;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><path fill="none" stroke="#78866b" d="M254,282.5A109,109,0,1,0,243.97992323965687,282.0384635127881" stroke-width="2" opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 1;"></path><path fill="#78866b" stroke="#ffffff" d="M254,285.5A112,112,0,1,0,243.70414131047312,285.0257606736905L238.96988485948532,336.3076952691821A163.5,163.5,0,1,1,254,337Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#318dbc" d="M243.97992323965687,282.0384635127881A109,109,0,0,0,248.96754622392342,282.38376558969503" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#318dbc" stroke="#ffffff" d="M243.70414131047312,285.0257606736905A112,112,0,0,0,248.82903832182956,285.38056647748476L246.68216583937487,331.83098023822623A158.5,158.5,0,0,1,239.42952140812488,331.3288666676781Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#3cb371" d="M248.96754622392342,282.38376558969503A109,109,0,0,0,253.96575664063926,282.49999462106564" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#3cb371" stroke="#ffffff" d="M248.82903832182956,285.38056647748476A112,112,0,0,0,253.9648141628587,285.4999944730216L253.95020575725985,331.9999921783386A158.5,158.5,0,0,1,246.68216583937487,331.83098023822623Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="254" y="163.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 800 15px Arial;" font-size="15px" font-weight="800" transform="matrix(1.3625,0,0,1.3625,-92.0722,-66.5188)" stroke-width="0.7339449541284403"><tspan dy="-3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">4951341307</tspan><tspan dy="18" x="254" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">msk</tspan></text><text x="254" y="183.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 14px Arial;" font-size="14px" transform="matrix(2.2708,0,0,2.2708,-322.9108,-238.0231)" stroke-width="0.4403669724770642"><tspan dy="-11.796875" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></tspan><tspan dy="16.8" x="254" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">10</tspan></text></svg></div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

        </div>

        <script>
            $(function () {
                var donut = new Morris.Donut({
                    element: 'answeredcalls',
                    colors: ["#78866B","#318dbc", "#3CB371", "#6960EC","#98AFC7","#7BCCB5","#01a65a","#FFA62F","#5E5A80","#6D7B8D","#566D7E","#737CA1","#2B547E","#368BC1","#8BB381","#FFF380","#FBF6D9","#CD7F32"],
                    resize: true,
                    data: [
                                                {
                            label: "4951341307" + "\n" + "msk",
                            value: "\n" +10},
                                                {
                            label: "89234776763" + "\n" + "mob2",
                            value: "\n" +0},
                                                {
                            label: "89130751580" + "\n" + "mob1",
                            value: "\n" +0},
                                            ],
                    formatter: function (y, data) {
                        return y
                    },
                    hideHover: 'auto'
                });

            });
        </script>


        <div class="grph col-md-4">

            <!-- DONUT CHART -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Пропущено</h3>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart" id="missedcalls" style="min-height: px;  position: relative; "><svg height="342" version="1.1" width="508" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative; left: -0.3125px; top: -0.625px;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><path fill="none" stroke="#78866b" d="M254,282.5A109,109,0,1,0,243.97992323965687,282.0384635127881" stroke-width="2" opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 1;"></path><path fill="#78866b" stroke="#ffffff" d="M254,285.5A112,112,0,1,0,243.70414131047312,285.0257606736905L238.96988485948532,336.3076952691821A163.5,163.5,0,1,1,254,337Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#318dbc" d="M243.97992323965687,282.0384635127881A109,109,0,0,0,248.96754622392342,282.38376558969503" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#318dbc" stroke="#ffffff" d="M243.70414131047312,285.0257606736905A112,112,0,0,0,248.82903832182956,285.38056647748476L246.68216583937487,331.83098023822623A158.5,158.5,0,0,1,239.42952140812488,331.3288666676781Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#3cb371" d="M248.96754622392342,282.38376558969503A109,109,0,0,0,253.96575664063926,282.49999462106564" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#3cb371" stroke="#ffffff" d="M248.82903832182956,285.38056647748476A112,112,0,0,0,253.9648141628587,285.4999944730216L253.95020575725985,331.9999921783386A158.5,158.5,0,0,1,246.68216583937487,331.83098023822623Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="254" y="163.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 800 15px Arial;" font-size="15px" font-weight="800" transform="matrix(1.3625,0,0,1.3625,-92.0722,-66.5188)" stroke-width="0.7339449541284403"><tspan dy="-3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">4951341307</tspan><tspan dy="18" x="254" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">msk</tspan></text><text x="254" y="183.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 14px Arial;" font-size="14px" transform="matrix(2.2708,0,0,2.2708,-322.9108,-238.0231)" stroke-width="0.4403669724770642"><tspan dy="-11.796875" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></tspan><tspan dy="16.8" x="254" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">32</tspan></text></svg></div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

        </div>

        <script>
            $(function () {
                var donut = new Morris.Donut({
                    element: 'missedcalls',
                    colors: ["#78866B","#318dbc", "#3CB371", "#6960EC","#98AFC7","#7BCCB5","#01a65a","#FFA62F","#5E5A80","#6D7B8D","#566D7E","#737CA1","#2B547E","#368BC1","#8BB381","#FFF380","#FBF6D9","#CD7F32"],
                    resize: true,
                    data: [
                                                {
                            label: "4951341307" + "\n" + "msk",
                            value: "\n" +32},
                                                {
                            label: "89234776763" + "\n" + "mob2",
                            value: "\n" +0},
                                                {
                            label: "89130751580" + "\n" + "mob1",
                            value: "\n" +0},
                                            ],
                    formatter: function (y, data) {
                        return y
                    },
                    hideHover: 'auto'
                });

            });
        </script>


    </div>


    <div class="row">
        <div class="grph col-md-4">

            <!-- DONUT CHART -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Пропущено, но обработано АТС</h3>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart" id="ProcessedPbx" style="min-height: px;  position: relative; "><svg height="342" version="1.1" width="508" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative; top: -0.625px;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><path fill="none" stroke="#78866b" d="M254,282.5A109,109,0,1,0,243.97992323965687,282.0384635127881" stroke-width="2" opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 1;"></path><path fill="#78866b" stroke="#ffffff" d="M254,285.5A112,112,0,1,0,243.70414131047312,285.0257606736905L238.96988485948532,336.3076952691821A163.5,163.5,0,1,1,254,337Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#318dbc" d="M243.97992323965687,282.0384635127881A109,109,0,0,0,248.96754622392342,282.38376558969503" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#318dbc" stroke="#ffffff" d="M243.70414131047312,285.0257606736905A112,112,0,0,0,248.82903832182956,285.38056647748476L246.68216583937487,331.83098023822623A158.5,158.5,0,0,1,239.42952140812488,331.3288666676781Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#3cb371" d="M248.96754622392342,282.38376558969503A109,109,0,0,0,253.96575664063926,282.49999462106564" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#3cb371" stroke="#ffffff" d="M248.82903832182956,285.38056647748476A112,112,0,0,0,253.9648141628587,285.4999944730216L253.95020575725985,331.9999921783386A158.5,158.5,0,0,1,246.68216583937487,331.83098023822623Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="254" y="163.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 800 15px Arial;" font-size="15px" font-weight="800" transform="matrix(1.3625,0,0,1.3625,-92.0722,-66.5188)" stroke-width="0.7339449541284403"><tspan dy="-3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">4951341307</tspan><tspan dy="18" x="254" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">msk</tspan></text><text x="254" y="183.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 14px Arial;" font-size="14px" transform="matrix(2.2708,0,0,2.2708,-322.9108,-238.0231)" stroke-width="0.4403669724770642"><tspan dy="-11.796875" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></tspan><tspan dy="16.8" x="254" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">30</tspan></text></svg></div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

        </div>
        <script>
            $(function () {
                var donut = new Morris.Donut({
                    element: 'ProcessedPbx',
                    colors: ["#78866B","#318dbc", "#3CB371", "#6960EC","#98AFC7","#7BCCB5","#01a65a","#FFA62F","#5E5A80","#6D7B8D","#566D7E","#737CA1","#2B547E","#368BC1","#8BB381","#FFF380","#FBF6D9","#CD7F32"],
                    resize: true,
                    data: [
                                                {
                            label: "4951341307" + "\n" + "msk",
                            value: "\n" +30},
                                                {
                            label: "89234776763" + "\n" + "mob2",
                            value: "\n" +0},
                                                {
                            label: "89130751580" + "\n" + "mob1",
                            value: "\n" +0},
                                            ],
                    formatter: function (y, data) {
                        return y
                    },
                    hideHover: 'auto'
                });
//$("div svg text").attr("style", "line-height:1.8;");
            });
        </script>

        <div class="grph col-md-4">

            <!-- DONUT CHART -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Пропущено сотрудниками</h3>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart" id="missedcalls-staff" style="min-height: px;  position: relative; "><svg height="342" version="1.1" width="508" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative; left: -0.65625px; top: -0.625px;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><path fill="none" stroke="#78866b" d="M254,282.5A109,109,0,1,0,243.97992323965687,282.0384635127881" stroke-width="2" opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 1;"></path><path fill="#78866b" stroke="#ffffff" d="M254,285.5A112,112,0,1,0,243.70414131047312,285.0257606736905L238.96988485948532,336.3076952691821A163.5,163.5,0,1,1,254,337Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#318dbc" d="M243.97992323965687,282.0384635127881A109,109,0,0,0,248.96754622392342,282.38376558969503" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#318dbc" stroke="#ffffff" d="M243.70414131047312,285.0257606736905A112,112,0,0,0,248.82903832182956,285.38056647748476L246.68216583937487,331.83098023822623A158.5,158.5,0,0,1,239.42952140812488,331.3288666676781Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#3cb371" d="M248.96754622392342,282.38376558969503A109,109,0,0,0,253.96575664063926,282.49999462106564" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#3cb371" stroke="#ffffff" d="M248.82903832182956,285.38056647748476A112,112,0,0,0,253.9648141628587,285.4999944730216L253.95020575725985,331.9999921783386A158.5,158.5,0,0,1,246.68216583937487,331.83098023822623Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="254" y="163.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 800 15px Arial;" font-size="15px" font-weight="800" transform="matrix(1.3625,0,0,1.3625,-92.0722,-66.5188)" stroke-width="0.7339449541284403"><tspan dy="-3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">4951341307</tspan><tspan dy="18" x="254" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">msk</tspan></text><text x="254" y="183.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 14px Arial;" font-size="14px" transform="matrix(2.2708,0,0,2.2708,-322.9108,-238.0231)" stroke-width="0.4403669724770642"><tspan dy="-11.796875" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></tspan><tspan dy="16.8" x="254" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2</tspan></text></svg></div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

        </div>

        <script>
            $(function () {
                var donut = new Morris.Donut({
                    element: 'missedcalls-staff',
                    colors: ["#78866B","#318dbc", "#3CB371", "#6960EC","#98AFC7","#7BCCB5","#01a65a","#FFA62F","#5E5A80","#6D7B8D","#566D7E","#737CA1","#2B547E","#368BC1","#8BB381","#FFF380","#FBF6D9","#CD7F32"],
                    resize: true,
                    data: [
                                                {
                            label: "4951341307" + "\n" + "msk",
                            value: "\n" +2},
                                                {
                            label: "89234776763" + "\n" + "mob2",
                            value: "\n" +0},
                                                {
                            label: "89130751580" + "\n" + "mob1",
                            value: "\n" +0},
                                            ],
                    formatter: function (y, data) {
                        return y
                    },
                    hideHover: 'auto'
                });

            });
        </script>

        <div class="grph col-md-4">

            <!-- DONUT CHART -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Пропущено до 3с</h3>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart" id="missedcalls-less-Nsec" style="min-height: px;  position: relative; "><svg height="342" version="1.1" width="508" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative; left: -0.3125px; top: -0.625px;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><path fill="none" stroke="#78866b" d="M254,282.5" stroke-width="2" opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 1;"></path><path fill="#78866b" stroke="#ffffff" d="M254,285.5A163.5,163.5,0,0,1,254,337Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#318dbc" d="M,0,0" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#318dbc" stroke="#ffffff" d="Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#3cb371" d="M,0,0" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#3cb371" stroke="#ffffff" d="Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="254" y="163.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 800 15px Arial;" font-size="15px" font-weight="800" transform="matrix(1.3625,0,0,1.3625,-92.0722,-66.5188)" stroke-width="0.7339449541284403"><tspan dy="-3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">4951341307</tspan><tspan dy="18" x="254" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">msk</tspan></text><text x="254" y="183.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 14px Arial;" font-size="14px" transform="matrix(2.2708,0,0,2.2708,-322.9108,-238.0231)" stroke-width="0.4403669724770642"><tspan dy="-11.796875" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></tspan><tspan dy="16.8" x="254" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan></text></svg></div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

        </div>

        <script>
            $(function () {
                var donut = new Morris.Donut({
                    element: 'missedcalls-less-Nsec',
                    colors: ["#78866B","#318dbc", "#3CB371", "#6960EC","#98AFC7","#7BCCB5","#01a65a","#FFA62F","#5E5A80","#6D7B8D","#566D7E","#737CA1","#2B547E","#368BC1","#8BB381","#FFF380","#FBF6D9","#CD7F32"],
                    resize: true,
                    data: [
                                                {
                            label: "4951341307" + "\n" + "msk",
                            value: "\n" +0},
                                                {
                            label: "89234776763" + "\n" + "mob2",
                            value: "\n" +0},
                                                {
                            label: "89130751580" + "\n" + "mob1",
                            value: "\n" +0},
                                            ],
                    formatter: function (y, data) {
                        return y
                    },
                    hideHover: 'auto'
                });

            });
        </script>


    </div>


    <div class="row">
        <div class="col-md-12">
            <!-- AREA CHART -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Вызовы </h3>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart" id="revenue-chart" style="height: 300px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"><svg height="300" version="1.1" width="1623" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative; top: -0.625px;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><text x="26.171875" y="261" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font: 12px sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan></text><path fill="none" stroke="#aaaaaa" d="M38.671875,261H1598" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="26.171875" y="202" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font: 12px sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">5</tspan></text><path fill="none" stroke="#aaaaaa" d="M38.671875,202H1598" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="26.171875" y="143" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font: 12px sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">10</tspan></text><path fill="none" stroke="#aaaaaa" d="M38.671875,143H1598" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="26.171875" y="84" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font: 12px sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">15</tspan></text><path fill="none" stroke="#aaaaaa" d="M38.671875,84H1598" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="26.171875" y="25" text-anchor="end" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font: 12px sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">20</tspan></text><path fill="none" stroke="#aaaaaa" d="M38.671875,25H1598" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="1208.16796875" y="273.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 12px sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2018-10-18</tspan></text><text x="818.3359375" y="273.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 12px sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2018-10-17</tspan></text><text x="428.50390625" y="273.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 12px sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2018-10-16</tspan></text><text x="38.671875" y="273.5" text-anchor="middle" font="10px &quot;Arial&quot;" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 12px sans-serif;" font-size="12px" font-family="sans-serif" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2018-10-15</tspan></text><path fill="#dbecf1" stroke="none" d="M38.671875,154.8C136.1298828125,148.9,331.0458984375,137.1,428.50390625,131.2C525.9619140625,125.29999999999998,720.8779296875,101.69999999999999,818.3359375,107.6C915.7939453125,113.5,1110.7099609375,162.17499999999998,1208.16796875,178.39999999999998C1305.6259765625,194.62499999999997,1500.5419921875,222.65,1598,237.4L1598,261L38.671875,261Z" fill-opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 0;"></path><path fill="none" stroke="#a0d0e0" d="M38.671875,154.8C136.1298828125,148.9,331.0458984375,137.1,428.50390625,131.2C525.9619140625,125.29999999999998,720.8779296875,101.69999999999999,818.3359375,107.6C915.7939453125,113.5,1110.7099609375,162.17499999999998,1208.16796875,178.39999999999998C1305.6259765625,194.62499999999997,1500.5419921875,222.65,1598,237.4" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><circle cx="38.671875" cy="154.8" r="4" fill="#a0d0e0" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="428.50390625" cy="131.2" r="4" fill="#a0d0e0" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="818.3359375" cy="107.6" r="4" fill="#a0d0e0" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="1208.16796875" cy="178.39999999999998" r="4" fill="#a0d0e0" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="1598" cy="237.4" r="4" fill="#a0d0e0" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><path fill="#079107" stroke="none" d="M38.671875,237.4C136.1298828125,231.5,331.0458984375,215.275,428.50390625,213.8C525.9619140625,212.32500000000002,720.8779296875,221.175,818.3359375,225.6C915.7939453125,230.02499999999998,1110.7099609375,244.77499999999998,1208.16796875,249.2C1305.6259765625,253.625,1500.5419921875,258.05,1598,261L1598,261L38.671875,261Z" fill-opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 0;"></path><path fill="none" stroke="#008000" d="M38.671875,237.4C136.1298828125,231.5,331.0458984375,215.275,428.50390625,213.8C525.9619140625,212.32500000000002,720.8779296875,221.175,818.3359375,225.6C915.7939453125,230.02499999999998,1110.7099609375,244.77499999999998,1208.16796875,249.2C1305.6259765625,253.625,1500.5419921875,258.05,1598,261" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><circle cx="38.671875" cy="237.4" r="4" fill="#008000" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="428.50390625" cy="213.8" r="4" fill="#008000" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="818.3359375" cy="225.6" r="4" fill="#008000" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="1208.16796875" cy="249.2" r="4" fill="#008000" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="1598" cy="261" r="4" fill="#008000" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><path fill="#f4b33d" stroke="none" d="M38.671875,178.39999999999998C136.1298828125,178.39999999999998,331.0458984375,182.825,428.50390625,178.39999999999998C525.9619140625,173.97499999999997,720.8779296875,141.525,818.3359375,143C915.7939453125,144.475,1110.7099609375,178.39999999999998,1208.16796875,190.2C1305.6259765625,202,1500.5419921875,225.6,1598,237.4L1598,261L38.671875,261Z" fill-opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 0;"></path><path fill="none" stroke="#ffa500" d="M38.671875,178.39999999999998C136.1298828125,178.39999999999998,331.0458984375,182.825,428.50390625,178.39999999999998C525.9619140625,173.97499999999997,720.8779296875,141.525,818.3359375,143C915.7939453125,144.475,1110.7099609375,178.39999999999998,1208.16796875,190.2C1305.6259765625,202,1500.5419921875,225.6,1598,237.4" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><circle cx="38.671875" cy="178.39999999999998" r="4" fill="#ffa500" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="428.50390625" cy="178.39999999999998" r="4" fill="#ffa500" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="818.3359375" cy="143" r="4" fill="#ffa500" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="1208.16796875" cy="190.2" r="4" fill="#ffa500" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="1598" cy="237.4" r="4" fill="#ffa500" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><path fill="#63a1c6" stroke="none" d="M38.671875,190.2C136.1298828125,190.2,331.0458984375,196.1,428.50390625,190.2C525.9619140625,184.29999999999998,720.8779296875,143,818.3359375,143C915.7939453125,143,1110.7099609375,178.39999999999998,1208.16796875,190.2C1305.6259765625,202,1500.5419921875,225.6,1598,237.4L1598,261L38.671875,261Z" fill-opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 0;"></path><path fill="none" stroke="#3c8dbc" d="M38.671875,190.2C136.1298828125,190.2,331.0458984375,196.1,428.50390625,190.2C525.9619140625,184.29999999999998,720.8779296875,143,818.3359375,143C915.7939453125,143,1110.7099609375,178.39999999999998,1208.16796875,190.2C1305.6259765625,202,1500.5419921875,225.6,1598,237.4" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><circle cx="38.671875" cy="190.2" r="4" fill="#3c8dbc" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="428.50390625" cy="190.2" r="4" fill="#3c8dbc" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="818.3359375" cy="143" r="4" fill="#3c8dbc" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="1208.16796875" cy="190.2" r="4" fill="#3c8dbc" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="1598" cy="237.4" r="4" fill="#3c8dbc" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><path fill="#f3a397" stroke="none" d="M38.671875,249.2C136.1298828125,249.2,331.0458984375,247.725,428.50390625,249.2C525.9619140625,250.67499999999998,720.8779296875,259.525,818.3359375,261C915.7939453125,261,1110.7099609375,261,1208.16796875,261C1305.6259765625,261,1500.5419921875,261,1598,261L1598,261L38.671875,261Z" fill-opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 0;"></path><path fill="none" stroke="#f56954" d="M38.671875,249.2C136.1298828125,249.2,331.0458984375,247.725,428.50390625,249.2C525.9619140625,250.67499999999998,720.8779296875,259.525,818.3359375,261C915.7939453125,261,1110.7099609375,261,1208.16796875,261C1305.6259765625,261,1500.5419921875,261,1598,261" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><circle cx="38.671875" cy="249.2" r="4" fill="#f56954" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="428.50390625" cy="249.2" r="4" fill="#f56954" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="818.3359375" cy="261" r="4" fill="#f56954" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="1208.16796875" cy="261" r="4" fill="#f56954" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="1598" cy="261" r="4" fill="#f56954" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><path fill="#fcf8cf" stroke="none" d="M38.671875,261C136.1298828125,261,331.0458984375,261,428.50390625,261C525.9619140625,261,720.8779296875,261,818.3359375,261C915.7939453125,261,1110.7099609375,261,1208.16796875,261C1305.6259765625,261,1500.5419921875,261,1598,261L1598,261L38.671875,261Z" fill-opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 0;"></path><path fill="none" stroke="#fff380" d="M38.671875,261C136.1298828125,261,331.0458984375,261,428.50390625,261C525.9619140625,261,720.8779296875,261,818.3359375,261C915.7939453125,261,1110.7099609375,261,1208.16796875,261C1305.6259765625,261,1500.5419921875,261,1598,261" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><circle cx="38.671875" cy="261" r="4" fill="#fff380" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="428.50390625" cy="261" r="4" fill="#fff380" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="818.3359375" cy="261" r="4" fill="#fff380" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="1208.16796875" cy="261" r="4" fill="#fff380" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="1598" cy="261" r="4" fill="#fff380" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle></svg><div class="morris-hover morris-default-style" style="left: 1076.67px; top: 80px; display: none;"><div class="morris-hover-row-label">2018-10-18</div><div class="morris-hover-point" style="color: #a0d0e0">
  Поступили:
  7
</div><div class="morris-hover-point" style="color: #008000">
  Отвеченные:
  1
</div><div class="morris-hover-point" style="color: #FFA500">
  Пропущенные:
  6
</div><div class="morris-hover-point" style="color: #3c8dbc">
  Пропущенные, но обработанные АТС:
  6
</div><div class="morris-hover-point" style="color: #f56954">
  Пропущенные сотрудниками:
  0
</div><div class="morris-hover-point" style="color: #FFF380">
  Пропущенные до 3с:
  0
</div></div></div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

            <script type="text/javascript">

                                $(function () {
                    // AREA CHART
                    var area = new Morris.Area({
                        element: 'revenue-chart',
                        resize: true,
                        data: [
                                                                                                                {
                                y: '2018-10-15',
                                item1: 9,
                                item2: 2,
                                item3: 7,
                                item4: 6,
                                item5: 1,
                                item6: 0 },
                                                                                                                {
                                y: '2018-10-16',
                                item1: 11,
                                item2: 4,
                                item3: 7,
                                item4: 6,
                                item5: 1,
                                item6: 0 },
                                                                                                                {
                                y: '2018-10-17',
                                item1: 13,
                                item2: 3,
                                item3: 10,
                                item4: 10,
                                item5: 0,
                                item6: 0 },
                                                                                                                {
                                y: '2018-10-18',
                                item1: 7,
                                item2: 1,
                                item3: 6,
                                item4: 6,
                                item5: 0,
                                item6: 0 },
                                                                                                                {
                                y: '2018-10-19',
                                item1: 2,
                                item2: 0,
                                item3: 2,
                                item4: 2,
                                item5: 0,
                                item6: 0 },
                                                    ],
                        xkey: 'y',
                        xLabels: 'day',

                        ykeys: ['item1', 'item2', 'item3', 'item4', 'item5', 'item6'],
                        labels: ['Поступили', 'Отвеченные', 'Пропущенные', 'Пропущенные, но обработанные АТС', 'Пропущенные сотрудниками', 'Пропущенные до 3с'],
                        lineColors: ['#a0d0e0', "#008000", "#FFA500", "#3c8dbc", "#f56954", "#FFF380", "#FFF380"],
                        hideHover: 'auto',
                        fillOpacity: 0,
                        behaveLikeLine: true
                    });


                });

            </script>
        </div>
    </div>

</section>