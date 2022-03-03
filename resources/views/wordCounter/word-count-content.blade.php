<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default animated fadeIn">
            <div class="panel-heading">
                Letter Occurences
            </div>
            <div class="panel-body">
                <div class="table-responsive" id="WordOccurencesPlaceholder">
                @foreach($output as $char => $number)
                    {{ $char }}:{{ $number }},
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

