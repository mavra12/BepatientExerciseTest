<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default animated fadeIn">
            <div class="panel-heading">
                DailyMotion Video Results
            </div>
            <div class="panel-body">
                <div class="table-responsive" id="VideoContentPlaceholder">
                @foreach($searchString as $k)
                    <?php var_dump($k);
              ?>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

